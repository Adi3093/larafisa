<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasKamar;
use App\Models\Kamar;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Pembayaran;
use App\Services\PakasirPaymentService;
use App\Notifications\ReservasiBerhasil;

class GuestReservationController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->kelas_id;

        $checkin = $request->filter_checkin ?? Carbon::now()->format('Y-m-d\TH:i');
        $checkout = $request->filter_checkout ?? Carbon::now()->addDays(1)->setTime(11, 0)->format('Y-m-d\TH:i');

        $kelasKamars = KelasKamar::all();

        $isMaintenance = false;
        if (Cache::get('maintenance_mode') === 'true' && Cache::get('main_online') === 'true') {
            $isMaintenance = true;
        }
        if (Cache::get('jadwal_maintenance') === 'true' && Cache::get('auto_maintenance') === 'true' && Cache::get('check_jadwal_online') === 'true') {
            $savedDates = json_decode(Cache::get('jadwal_tersimpan'), true) ?? [];
            $hariIni = \Carbon\Carbon::today()->format('Y-m-d');
            if (in_array($hariIni, $savedDates)) {
                $isMaintenance = true;
            }
        }

        if (!Auth::check()) {
            return view('landing_page.hreservasi', [
                'isLoggedIn' => false,
                'user' => null,
                'kelasKamars' => $kelasKamars,
                'kelasId' => $kelasId,
                'checkin' => $checkin,
                'checkout' => $checkout,
                'reservasiAktif' => collect(),
                'pesananAktifs' => collect(),
                'pembayaranAktifs' => collect(),
                'arsipReservasi' => Reservasi::where('id', 0)->paginate(10),
                'isMaintenance' => $isMaintenance
            ]);
        }

        $user = Auth::user();

        $pesananAktifs = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', '%' . $user->name . '%')->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pembayaranAktifs = Pembayaran::whereIn('reservasi_id', $pesananAktifs->pluck('id'))
            ->get()
            ->keyBy('reservasi_id');

        $perPage = $request->input('per_page', 10);
        $arsipReservasi = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', '%' . $user->name . '%')->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Selesai', 'Batal', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)->appends($request->query());

        return view('landing_page.hreservasi', [
            'isLoggedIn' => true,
            'user' => $user,
            'kelasKamars' => $kelasKamars,
            'kelasId' => $kelasId,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'reservasiAktif' => $pesananAktifs,
            'pesananAktifs' => $pesananAktifs,
            'pembayaranAktifs' => $pembayaranAktifs,
            'arsipReservasi' => $arsipReservasi,
            'isMaintenance' => $isMaintenance
        ]);
    }

    // FUNGSI RIWAYAT DIHILANGKAN KARENA SUDAH PUNYA CONTROLLER SENDIRI DI SESI SEBELUMNYA
    public function riwayat(Request $request)
    {
        if (!Auth::check()) {
            return view('landing_page.hriwayat', [
                'isLoggedIn' => false,
                'pesananAktifs' => collect(),
                'pembayaranAktifs' => collect(),
                'arsipReservasi' => collect(),
                'kelasKamars' => collect()
            ]);
        }

        $user = Auth::user();
        // 1. PERBAIKAN: Menggunakan get() agar bisa mengambil lebih dari 1 kamar (Maks. 4 kamar)
        $pesananAktifs = Reservasi::with(['kamar.kelasKamar'])
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', '%' . $user->name . '%')->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In'])
            ->orderBy('created_at', 'desc')
            ->get();
        // 2. PERBAIKAN: Tarik semua invoice/pembayaran milik pesanan-pesanan yang sedang aktif
        $pembayaranAktifs = Pembayaran::whereIn('reservasi_id', $pesananAktifs->pluck('id'))
            ->get()
            ->keyBy('reservasi_id');

        $perPage = $request->input('per_page', 10);

        $arsipReservasi = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', '%' . $user->name . '%')->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Selesai', 'Batal', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)->appends($request->query());

        $kelasKamars = KelasKamar::all();
        return view('landing_page.hriwayat', [
            'isLoggedIn' => true,
            'pesananAktifs' => $pesananAktifs,
            'pembayaranAktifs' => $pembayaranAktifs,
            'arsipReservasi' => $arsipReservasi,
            'kelasKamars' => $kelasKamars,
            'perPage' => $perPage

        ]);
    }

    public function store(Request $request, PakasirPaymentService $pakasirService)
    {
        $user = Auth::user();

        $rules = [
            'kelas_kamar_id' => 'required|exists:kelas_kamars,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ];

        if (empty($user->no_ktp) || empty($user->no_hp)) {
            $rules['no_ktp'] = 'required|regex:/^[0-9]+$/|min:16|max:16';
            $rules['no_hp'] = 'required|regex:/^[0-9]+$/|min:10|max:15';
        }

        $request->validate($rules);

        $noKtp = $request->no_ktp ?? $user->no_ktp;
        $noHp = $request->no_hp ?? $user->no_hp;

        if (substr($noHp, 0, 1) === '0') {
            $noHp = '62' . substr($noHp, 1);
        }

        if (empty($user->no_ktp) || empty($user->no_hp)) {
            $user->no_ktp = $noKtp;
            $user->no_hp = $noHp;
            $user->save();
        }

        $activeReservationsCount = Reservasi::where(function ($q) use ($user, $noKtp) {
            $q->where('nama_tamu', 'like', '%' . $user->name . '%')
                ->orWhere('no_ktp', $noKtp);
        })
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In'])
            ->count();

        if ($activeReservationsCount >= 4) {
            return back()->withInput()->with('error', 'Batas maksimal tercapai! Anda hanya dapat memiliki 4 reservasi kamar aktif secara bersamaan.');
        }

        $namaTamu = $user->name;
        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');

        $reservedIds = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut)->where('check_out', '>', $checkIn);
            })->pluck('kamar_id');

        $kamarBebas = Kamar::where('kelas_kamar_id', $request->kelas_kamar_id)
            ->where('status', '!=', 'Maintenance')
            ->whereNotIn('id', $reservedIds)
            ->inRandomOrder()
            ->first();

        if (!$kamarBebas) {
            return back()->withInput()->with('error', 'Mohon maaf, seluruh ruangan di kelas ini sudah penuh pada tanggal yang Anda pilih.');
        }

        $noReservasi = 'RSV-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $noInvoice = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $diffTime = strtotime($checkOut) - strtotime($checkIn);
        $diffDays = ceil($diffTime / (60 * 60 * 24));
        if ($diffDays <= 0) $diffDays = 1;

        $kelasKamar = KelasKamar::find($request->kelas_kamar_id);
        $hargaKamar = $kelasKamar->harga * $diffDays;

        // PERUBAHAN LOGIKA HARGA: Hanya Ekstra Bed (Rp 50.000)
        $hargaEkstra = ((int)$request->extra_bed * 50000);
        $totalBayar = $hargaKamar + $hargaEkstra;

        // PERUBAHAN ARRAY EKSTRA: Selimut dihapus
        $ekstra = [
            'Jumlah Anggota' => (int) $request->jumlah_anggota,
            'Extra Bed' => (int) $request->extra_bed,
            'Pesan Tambahan' => $request->pesan_tambahan ?? '-',
            'Metode Pembayaran' => $request->metode_pembayaran,
            'Total Bayar' => $totalBayar,
            'Detail Pembayaran' => $request->metode_pembayaran === 'QRIS' ? 'Menunggu Pembayaran QRIS' : 'Bayar di Tempat'
        ];

        $id = Reservasi::create([
            'no_reservasi' => $noReservasi,
            'nama_tamu' => $namaTamu,
            'no_ktp' => $noKtp,
            'no_hp' => $noHp,
            'kamar_id' => $kamarBebas->id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'ekstra' => $ekstra,
            'tipe_reservasi' => 'Online',
            'status_reservasi' => 'Menunggu Konfirmasi'
        ]);

        Pembayaran::create([
            'reservasi_id' => $id->id,
            'invoice' => $noInvoice,
            'total' => $totalBayar,
            'status' => 'pending',
            'expired_at' => $checkIn, // Sesuai logika H-1 aslinya
        ]);

        if ($request->metode_pembayaran === 'QRIS') {
            $pakasirService->createQrisPayment($noInvoice, $totalBayar);
        }

        if ($user) {
            $user->notify(new ReservasiBerhasil(
                $noReservasi,
                $kelasKamar->nama_kelas,
                $request->jumlah_anggota
            ));
        }

        return redirect()->route('riwayat.tamu')->with('success', "Reservasi $noReservasi berhasil dibuat! Silakan cek detail reservasi untuk rincian pembayaran.");
    }

    public function generateQris($id, \App\Services\PakasirPaymentService $pakasirService)
    {
        $reservasi = Reservasi::with('kamar.kelasKamar')->findOrFail($id);
        $pembayaran = \App\Models\Pembayaran::where('reservasi_id', $reservasi->id)->first();

        if ($pembayaran && $pembayaran->qr_image) {
            return response()->json([
                'success'  => true,
                'qr_image' => $pembayaran->qr_image,
                'status'   => $pembayaran->status,
                'invoice'  => $pembayaran->invoice,
                'expired_at' => $pembayaran->expired_at,
            ]);
        }

        $totalBayar = $reservasi->ekstra['Total Bayar'] ?? 0;
        $pembayaranBaru = $pakasirService->createQrisPayment($pembayaran->invoice, $totalBayar);

        if ($pembayaranBaru && $pembayaranBaru->qr_image) {
            return response()->json([
                'success'  => true,
                'qr_image' => $pembayaranBaru->qr_image,
                'status'   => $pembayaranBaru->status,
                'invoice'  => $pembayaranBaru->invoice,
                'expired_at' => $pembayaranBaru->expired_at,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal terhubung ke server Payment Gateway. Silakan coba lagi.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');

        $isTabrakan = Reservasi::where('kamar_id', $reservasi->kamar_id)
            ->where('id', '!=', $id)
            ->whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            })->exists();

        if ($isTabrakan) {
            return back()->with('error', 'Gagal merubah! Kamar pilihan sudah terisi oleh jadwal tamu lain pada jam tersebut.');
        }

        $reservasi->update([
            'check_in' => $checkIn,
            'check_out' => $checkOut
        ]);

        return back()->with('success', 'Jadwal menginap Anda berhasil diperbarui!');
    }

    public function batal($id)
    {
        $res = Reservasi::findOrFail($id);
        $res->update(['status_reservasi' => 'Dibatalkan']);
        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
