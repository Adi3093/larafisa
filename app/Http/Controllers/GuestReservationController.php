<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasKamar;
use App\Models\Kamar;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class GuestReservationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $kelasId = $request->kelas_id;
        $checkin = $request->filter_checkin ?? date('Y-m-d\TH:i');
        $checkout = $request->filter_checkout ?? date('Y-m-d\TH:i', strtotime('+1 day'));
        $kelasKamars = KelasKamar::all();

        $reservasiAktif = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', $user->name . '%')->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('landing_page.hreservasi', compact('kelasKamars', 'kelasId', 'checkin', 'checkout', 'user', 'reservasiAktif'));
    }

    public function riwayat()
    {
        // 1. KONDISI JIKA BELUM LOGIN
        if (!Auth::check()) {
            return view('landing_page.hriwayat', [
                'isLoggedIn' => false,
                'pesananAktif' => null,
                'arsipReservasi' => collect(),
                'kelasKamars' => collect()
            ]);
        }

        $user = Auth::user();

        // 2. PESANAN AKTIF TERBARU (Untuk Step Bar)
        $pesananAktif = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', $user->name . '%')->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In'])
            ->orderBy('created_at', 'desc')
            ->first();

        // 3. ARSIP RESERVASI
        $arsipReservasi = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', $user->name . '%')->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Selesai', 'Batal', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Dibutuhkan untuk form Modal Ubah Jadwal
        $kelasKamars = KelasKamar::all();

        return view('landing_page.hriwayat', [
            'isLoggedIn' => true,
            'pesananAktif' => $pesananAktif,
            'arsipReservasi' => $arsipReservasi,
            'kelasKamars' => $kelasKamars
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|array',
            'no_ktp' => 'required|string|max:16',
            'no_hp' => 'required|string|max:15',
            'kelas_kamar_id' => 'required|exists:kelas_kamars,id',
            'kamar_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'umur' => 'required|numeric|min:17'
        ], ['umur.min' => 'Maaf, Anda harus berusia minimal 17 tahun untuk melakukan reservasi.']);

        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');
        $kamarId = $request->kamar_id;

        if ($kamarId === 'random') {
            $reservedIds = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
                ->where(function ($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '<', $checkOut)->where('check_out', '>', $checkIn);
                })->pluck('kamar_id');

            $kamarBebas = Kamar::where('kelas_kamar_id', $request->kelas_kamar_id)
                ->where('status', '!=', 'Maintenance')
                ->whereNotIn('id', $reservedIds)->first();

            if (!$kamarBebas) return back()->withInput()->with('error', 'Seluruh ruangan di kelas ini sudah penuh pada tanggal tersebut.');
            $kamarId = $kamarBebas->id;
        }

        $namaGabungan = implode(' & ', array_filter($request->nama_tamu));
        $ekstra = [
            'Extra Bed' => (int) $request->extra_bed,
            'Extra Selimut' => (int) $request->extra_selimut,
            'Metode Pembayaran' => $request->metode_pembayaran,
            'Detail Pembayaran' => $request->detail_pembayaran ?? '-'
        ];

        $noReservasi = 'RSV-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        Reservasi::create([
            'no_reservasi' => $noReservasi,
            'nama_tamu' => $namaGabungan,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'kamar_id' => $kamarId,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'ekstra' => $ekstra,
            'tipe_reservasi' => 'Online',
            'status_reservasi' => 'Menunggu Konfirmasi'
        ]);

        return redirect()->route('riwayat.tamu')->with('success', "Reservasi $noReservasi berhasil dibuat!");
    }

    // FUNGSI UBAH JADWAL OLEH TAMU
    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');

        // Jika form disabled (Transfer/QRIS), input kamar_id tidak terkirim, maka ambil ID lama dari DB
        $kamarId = $request->kamar_id ?? $reservasi->kamar_id;

        $isTabrakan = Reservasi::where('kamar_id', $kamarId)
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
            'check_out' => $checkOut,
            'kamar_id' => $kamarId
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
