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
        $kelasId = $request->kelas_id; // Ditangkap dari tombol "Detail & Pesan" di Beranda
        $checkin = $request->filter_checkin ?? date('Y-m-d\TH:i');
        $checkout = $request->filter_checkout ?? date('Y-m-d\TH:i', strtotime('+1 day'));

        $kelasKamars = KelasKamar::all();

        // Mengambil riwayat reservasi aktif milik user ini untuk ditampilkan di Sidebar
        $reservasiAktif = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', $user->name . '%')
                    ->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('landing_page.hreservasi', compact('kelasKamars', 'kelasId', 'checkin', 'checkout', 'user', 'reservasiAktif'));
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
        ], [
            'umur.min' => 'Maaf, Anda harus berusia minimal 17 tahun untuk melakukan reservasi.'
        ]);

        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');

        $kamarId = $request->kamar_id;

        // LOGIKA RUANGAN ACAK (RANDOM)
        if ($kamarId === 'random') {
            // Cari semua ID kamar yang sedang terpakai/dibooking di rentang waktu tersebut
            $reservedIds = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
                ->where(function ($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '<', $checkOut)
                        ->where('check_out', '>', $checkIn);
                })
                ->pluck('kamar_id');

            // Ambil SATU kamar yang lolos dari ID terpakai
            $kamarBebas = Kamar::where('kelas_kamar_id', $request->kelas_kamar_id)
                ->where('status', '!=', 'Maintenance')
                ->whereNotIn('id', $reservedIds)
                ->first();

            if (!$kamarBebas) {
                return back()->withInput()->with('error', 'Maaf, seluruh ruangan di kelas ini sudah penuh pada tanggal tersebut.');
            }
            $kamarId = $kamarBebas->id;
        }

        // Menggabungkan array nama tamu menjadi string (Misal: "Budi & Andi & Caca")
        $namaGabungan = implode(' & ', array_filter($request->nama_tamu));

        // Menyimpan opsi pembayaran ke dalam kolom JSON 'ekstra'
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
            'tipe_reservasi' => 'Online', // Ditandai sebagai Online
            'status_reservasi' => 'Menunggu Konfirmasi' // Menunggu di-ACC Admin
        ]);

        return redirect()->route('reservasi.tamu')->with('success', "Reservasi $noReservasi berhasil dibuat! Silakan cek sidebar untuk memantau statusnya.");
    }
    public function riwayat()
    {
        // 1. KONDISI JIKA BELUM LOGIN
        if (!Auth::check()) {
            return view('landing_page.hriwayat', [
                'isLoggedIn' => false,
                'pesananAktif' => null,
                'arsipReservasi' => collect()
            ]);
        }

        $user = Auth::user();

        // 2. AMBIL SATU PESANAN AKTIF TERBARU (Untuk memicu Progression Bar)
        $pesananAktif = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', $user->name . '%')
                    ->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In'])
            ->orderBy('created_at', 'desc')
            ->first();

        // 3. AMBIL SEMUA ARSIP RESERVASI MASA LALU
        $arsipReservasi = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', $user->name . '%')
                    ->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Selesai', 'Batal', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('landing_page.hriwayat', [
            'isLoggedIn' => true,
            'pesananAktif' => $pesananAktif,
            'arsipReservasi' => $arsipReservasi
        ]);
    }

    public function batal($id)
    {
        $res = Reservasi::findOrFail($id);
        $res->update(['status_reservasi' => 'Dibatalkan']);
        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
    //
}
