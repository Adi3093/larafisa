<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\KelasKamar;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use App\Services\PakasirPaymentService;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->tab ?? 'aktif';
        $query = Reservasi::query()->with(['kamar.kelasKamar', 'pembayaran']);

        if ($tab === 'aktif') {
            $query->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In']);
        } else {
            $query->whereIn('status_reservasi', ['Selesai', 'Batal', 'Dibatalkan']);
        }

        if ($request->has('search') && $request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")
                    ->orWhere('no_reservasi', 'like', "%{$search}%")
                    ->orWhereDate('check_in', $search);
            });
        }

        if ($request->filled('filter_kelas') && $request->filter_kelas !== 'semua') {
            $query->whereHas('kamar', function ($q) use ($request) {
                $q->where('kelas_kamar_id', $request->filter_kelas);
            });
        }

        if ($request->filled('filter_mingguan') && $request->filter_mingguan == '1') {
            $query->whereBetween('check_in', [Carbon::now(), Carbon::now()->addDays(7)]);
        }

        if ($request->filled('sorting')) {
            switch ($request->sorting) {
                case 'waktu_terdekat':
                    $query->orderBy('check_in', 'asc');
                    break;
                case 'waktu_terlama':
                    $query->orderBy('check_in', 'desc');
                    break;
                case 'harga_tertinggi':
                    $query->join('kamars', 'reservasis.kamar_id', '=', 'kamars.id')
                        ->join('kelas_kamars', 'kamars.kelas_kamar_id', '=', 'kelas_kamars.id')
                        ->orderBy('kelas_kamars.harga', 'desc')->select('reservasis.*');
                    break;
                case 'harga_terendah':
                    $query->join('kamars', 'reservasis.kamar_id', '=', 'kamars.id')
                        ->join('kelas_kamars', 'kamars.kelas_kamar_id', '=', 'kelas_kamars.id')
                        ->orderBy('kelas_kamars.harga', 'asc')->select('reservasis.*');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $reservasis = $query->paginate(10)->appends($request->query());
        $kelasKamars = KelasKamar::all();

        $kamarTersedia = Kamar::where('status', 'Tersedia')->count();
        $kamarTerpakai = Kamar::whereIn('status', ['Terpakai', 'Dibooking'])->count();
        $kamarPerbaikan = Kamar::where('status', 'Maintenance')->count();

        return view('dashboard.reservasi', compact('reservasis', 'kelasKamars', 'tab', 'kamarTersedia', 'kamarTerpakai', 'kamarPerbaikan'));
    }

    public function getKamarTersedia(Request $request)
    {
        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');
        $kelasId = $request->kelas_id;

        // BUG 1 FIX: Masukkan 'Menunggu Konfirmasi' ke array agar kamar terkunci saat pending pembayaran
        $reservedKamarIds = Reservasi::whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In'])
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut)->where('check_out', '>', $checkIn);
            })->pluck('kamar_id');

        $availableKamars = Kamar::where('kelas_kamar_id', $kelasId)
            ->where('status', '!=', 'Maintenance')
            ->whereNotIn('id', $reservedKamarIds)->get();

        return response()->json($availableKamars);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:45',
            'no_ktp' => 'nullable|string|max:16',
            'no_hp' => 'required|string|max:15',
            'kamar_id' => 'required|exists:kamars,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'metode_pembayaran' => 'required|string',
        ]);

        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');
        $kamarId = $request->kamar_id;

        // BUG 1 FIX: Pengecekan Tabrakan saat membuat reservasi
        $isTabrakan = Reservasi::where('kamar_id', $kamarId)
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In'])
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut)->where('check_out', '>', $checkIn);
            })->exists();

        if ($isTabrakan) return back()->withInput()->with('error', 'Kamar sudah terpesan pada rentang waktu tersebut!');

        $kamar = Kamar::with('kelasKamar')->find($kamarId);

        $cin = Carbon::parse($checkIn)->startOfDay();
        $cout = Carbon::parse($checkOut)->startOfDay();
        $diffDays = max(1, $cin->diffInDays($cout));

        $hargaKamar = $kamar->kelasKamar->harga * $diffDays;
        $extraBedQty = (int) $request->input('extra_bed', 0);
        $totalBayar = $hargaKamar + ($extraBedQty * 50000);

        $ekstra = [
            'Extra Bed' => $extraBedQty,
            'Metode Pembayaran' => $request->metode_pembayaran,
            'Total Bayar' => $totalBayar
        ];

        if ($request->metode_pembayaran === 'QRIS') {
            $statusReservasi = 'Menunggu Konfirmasi';
        } else {
            $actionType = $request->input('action_type', 'simpan');
            $statusReservasi = ($actionType === 'simpan_checkin') ? 'Check-In' : 'Terkonfirmasi';
        }

        $noReservasi = 'RSV-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $noInvoice = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $reservasi = Reservasi::create([
            'no_reservasi' => $noReservasi,
            'dibuat_oleh_user_id' => Auth::id(),
            'nama_tamu' => $request->nama_tamu,
            'no_ktp' => $request->no_ktp ?? '-',
            'no_hp' => $request->no_hp,
            'kamar_id' => $kamarId,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'ekstra' => $ekstra,
            'tipe_reservasi' => 'Walk-in',
            'status_reservasi' => $statusReservasi
        ]);

        Pembayaran::create([
            'reservasi_id' => $reservasi->id,
            'invoice' => $noInvoice,
            'total' => $totalBayar,
            'status' => ($request->metode_pembayaran === 'QRIS') ? 'pending' : 'berhasil',
            'expired_at' => $checkIn,
        ]);

        if ($statusReservasi === 'Check-In') {
            $kamar->update(['status' => 'Terpakai']);
            return back()->with('success', "Tamu berhasil Check-In dengan metode Tunai!");
        }

        return back()->with('success', "Reservasi Walk-in $noReservasi berhasil disimpan.");
    }

    public function generateQrisWalkin($id, PakasirPaymentService $pakasirService)
    {
        $reservasi = Reservasi::with('kamar.kelasKamar')->findOrFail($id);
        $pembayaran = Pembayaran::where('reservasi_id', $reservasi->id)->first();

        if ($pembayaran && $pembayaran->qr_image) {
            return response()->json([
                'success' => true,
                'qr_image' => $pembayaran->qr_image,
                'status' => $pembayaran->status,
                'invoice' => $pembayaran->invoice,
                'expired_at' => $pembayaran->expired_at,
                'reservasi' => $reservasi
            ]);
        }

        $ekstra = is_array($reservasi->ekstra) ? $reservasi->ekstra : json_decode($reservasi->ekstra, true);
        $totalBayar = $ekstra['Total Bayar'] ?? 0;

        $pembayaranBaru = $pakasirService->createQrisPayment($pembayaran->invoice, $totalBayar);

        if ($pembayaranBaru && $pembayaranBaru->qr_image) {
            return response()->json([
                'success' => true,
                'qr_image' => $pembayaranBaru->qr_image,
                'status' => $pembayaranBaru->status,
                'invoice' => $pembayaranBaru->invoice,
                'expired_at' => $pembayaranBaru->expired_at,
                'reservasi' => $reservasi
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal memuat QRIS.']);
    }

    public function batal($id, PakasirPaymentService $pakasirService)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status_reservasi' => 'Dibatalkan']);

        $pembayaran = Pembayaran::where('reservasi_id', $id)->first();
        if ($pembayaran) {
            if ($pembayaran->status === 'pending' && $pembayaran->invoice) {
                $pakasirService->cancelPayment($pembayaran->invoice);
                $pakasirService->recordHistory($pembayaran->id, 'gagal', 'Dibatalkan manual oleh Resepsionis. Tagihan di Gateway telah dihapus.');
            }
            $pembayaran->update(['status' => 'gagal']);
        }

        return back()->with('success', 'Reservasi berhasil dibatalkan dan tagihan di Gateway telah dihapus.');
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $request->validate([
            'nama_tamu' => 'required|string|max:45',
            'no_hp' => 'required|string|max:15',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');

        // BUG 1 FIX: Pengecekan Tabrakan di fitur Update
        $isTabrakan = Reservasi::where('kamar_id', $request->kamar_id)
            ->where('id', '!=', $id)
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In'])
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            })->exists();

        if ($isTabrakan) {
            return back()->with('error', 'Gagal update! Kamar sudah terisi oleh jadwal tamu lain pada jam tersebut.');
        }

        $dataToUpdate = $request->all();
        $dataToUpdate['check_in'] = $checkIn;
        $dataToUpdate['check_out'] = $checkOut;

        $reservasi->update($dataToUpdate);
        return back()->with('success', 'Data reservasi ' . $reservasi->no_reservasi . ' berhasil diupdate!');
    }

    public function konfirmasi(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $ekstra = is_array($reservasi->ekstra) ? $reservasi->ekstra : json_decode($reservasi->ekstra, true);

        if ($request->has('detail_pembayaran')) {
            $ekstra['Detail Pembayaran'] = $request->detail_pembayaran;
        }

        $reservasi->update([
            'status_reservasi' => 'Terkonfirmasi',
            'ekstra' => $ekstra
        ]);

        return back()->with('success', 'Reservasi berhasil dikonfirmasi! Data telah diteruskan ke menu Check-In/Out.');
    }

    public function cekNotifikasi()
    {
        $latestReservasi = \App\Models\Reservasi::where('tipe_reservasi', 'Online')
            ->where('status_reservasi', 'Menunggu Konfirmasi')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json([
            'latest_id' => $latestReservasi ? $latestReservasi->id : 0,
            'nama_tamu' => $latestReservasi ? $latestReservasi->nama_tamu : '',
        ]);
    }

    public function exportCsv()
    {
        return "Fitur CSV";
    }
    public function exportPdf()
    {
        return "Fitur PDF";
    }
}
