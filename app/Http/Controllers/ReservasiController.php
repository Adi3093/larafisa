<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\KelasKamar;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->tab ?? 'aktif';
        $query = Reservasi::query()->with(['kamar.kelasKamar']);

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
            $query->whereBetween('check_in', [
                Carbon::now(),
                Carbon::now()->addDays(7)
            ]);
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
                        ->orderBy('kelas_kamars.harga', 'desc')
                        ->select('reservasis.*');
                    break;
                case 'harga_terendah':
                    $query->join('kamars', 'reservasis.kamar_id', '=', 'kamars.id')
                        ->join('kelas_kamars', 'kamars.kelas_kamar_id', '=', 'kelas_kamars.id')
                        ->orderBy('kelas_kamars.harga', 'asc')
                        ->select('reservasis.*');
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

        // MENGHITUNG STATISTIK CARD INFORMASI KAMAR
        $kamarTersedia = Kamar::where('status', 'Tersedia')->count();
        $kamarTerpakai = Kamar::whereIn('status', ['Terpakai', 'Dibooking'])->count();
        $kamarPerbaikan = Kamar::where('status', 'Maintenance')->count();

        return view('dashboard.reservasi', compact('reservasis', 'kelasKamars', 'tab', 'kamarTersedia', 'kamarTerpakai', 'kamarPerbaikan'));
    }

    // AJAX FETCH
    public function getKamarTersedia(Request $request)
    {
        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');
        $kelasId = $request->kelas_id;
        $reservedKamarIds = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            })
            ->pluck('kamar_id');
        $availableKamars = Kamar::where('kelas_kamar_id', $kelasId)
            ->where('status', '!=', 'Maintenance')
            ->whereNotIn('id', $reservedKamarIds)
            ->get();

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
            'ekstra' => 'nullable|array'
        ]);

        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');

        $isTabrakan = Reservasi::where('kamar_id', $request->kamar_id)
            ->whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where(function ($sub) use ($checkIn, $checkOut) {
                    $sub->where('check_in', '<', $checkOut)
                        ->where('check_out', '>', $checkIn);
                });
            })->exists();

        if ($isTabrakan) {
            return back()->withInput()->with('error', 'Kamar tersebut sudah terpesan pada rentang jam dan tanggal yang Anda pilih!');
        }

        $noReservasi = 'RSV-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        Reservasi::create([
            'no_reservasi' => $noReservasi,
            'nama_tamu' => $request->nama_tamu,
            'no_ktp' => $request->no_ktp ?? '-',
            'no_hp' => $request->no_hp,
            'kamar_id' => $request->kamar_id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'ekstra' => $request->ekstra ?? [],
            'tipe_reservasi' => 'Walk-in',
            'status_reservasi' => 'Terkonfirmasi'
        ]);

        return back()->with('success', 'Reservasi Walk-in ' . $noReservasi . ' berhasil didaftarkan dan masuk ke Antrean Check-In!');
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

        $isTabrakan = Reservasi::where('kamar_id', $request->kamar_id)
            ->where('id', '!=', $id)
            ->whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
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

        return back()->with('success', 'Pesanan Online diterima! Data telah diteruskan ke Meja Resepsionis.');
    }

    public function batal($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status_reservasi' => 'Dibatalkan']);
        return back()->with('success', 'Pesanan ditolak dan dipindahkan ke Riwayat.');
    }

    public function exportCsv()
    {
        return "Fitur CSV belum dibuat";
    }
    public function exportPdf()
    {
        return "Fitur PDF belum dibuat";
    }
}
