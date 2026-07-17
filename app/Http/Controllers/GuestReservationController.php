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
        $checkin = $request->filter_checkin ?? date('Y-m-d\TH:i');
        $checkout = $request->filter_checkout ?? date('Y-m-d\TH:i', strtotime('+1 day'));
        $kelasKamars = KelasKamar::all();

        // LOGIKA PENGECEKAN MAINTENANCE
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
                'isMaintenance' => $isMaintenance
            ]);
        }

        $user = Auth::user();
        $reservasiAktif = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', '%' . $user->name . '%')->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('landing_page.hreservasi', [
            'isLoggedIn' => true,
            'user' => $user,
            'kelasKamars' => $kelasKamars,
            'kelasId' => $kelasId,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'reservasiAktif' => $reservasiAktif,
            'isMaintenance' => $isMaintenance
        ]);
    }

    public function riwayat()
    {
        if (!Auth::check()) {
            return view('landing_page.hriwayat', [
                'isLoggedIn' => false,
                'pesananAktif' => null,
                'arsipReservasi' => collect(),
                'kelasKamars' => collect()
            ]);
        }

        $user = Auth::user();
        // Pastikan memuat relasi 'pembayaran' jika sudah ditambahkan di Model Reservasi
        $pesananAktif = Reservasi::with(['kamar.kelasKamar']) // Tambahkan 'pembayaran' di dalam array with() jika ada relasinya
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', '%' . $user->name . '%')->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In'])
            ->orderBy('created_at', 'desc')
            ->first();

        // Ambil data pembayaran aktif jika metode QRIS
        $pembayaranAktif = null;
        if ($pesananAktif && isset($pesananAktif->ekstra['Metode Pembayaran']) && $pesananAktif->ekstra['Metode Pembayaran'] === 'QRIS') {
            // Mencari data pembayaran berdasarkan ID reservasi yang berelasi
            $pembayaranAktif = Pembayaran::where('reservasi_id', $pesananAktif->id)->first();
        }

        $arsipReservasi = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('nama_tamu', 'like', '%' . $user->name . '%')->orWhere('no_ktp', $user->no_ktp);
            })
            ->whereIn('status_reservasi', ['Selesai', 'Batal', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->get();

        $kelasKamars = KelasKamar::all();

        return view('landing_page.hriwayat', [
            'isLoggedIn' => true,
            'pesananAktif' => $pesananAktif,
            'pembayaranAktif' => $pembayaranAktif,
            'arsipReservasi' => $arsipReservasi,
            'kelasKamars' => $kelasKamars
        ]);
    }

    public function store(Request $request, PakasirPaymentService $pakasirService)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:16',
            'no_hp' => 'required|string|max:15',
            'kelas_kamar_id' => 'required|exists:kelas_kamars,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');

        // 1. Logika Pencarian Kamar Acak Secara Otomatis
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

        // 2. Hitung Total Bayar
        $diffTime = strtotime($checkOut) - strtotime($checkIn);
        $diffDays = ceil($diffTime / (60 * 60 * 24));
        if ($diffDays <= 0) $diffDays = 1;

        $kelasKamar = KelasKamar::find($request->kelas_kamar_id);
        $hargaKamar = $kelasKamar->harga * $diffDays;
        $hargaEkstra = ((int)$request->extra_bed * 100000) + ((int)$request->extra_selimut * 25000);
        $totalBayar = $hargaKamar + $hargaEkstra;

        // 3. Susun Data Ekstra Baru
        $ekstra = [
            'Jumlah Anggota' => (int) $request->jumlah_anggota,
            'Extra Bed' => (int) $request->extra_bed,
            'Extra Selimut' => (int) $request->extra_selimut,
            'Pesan Tambahan' => $request->pesan_tambahan ?? '-',
            'Metode Pembayaran' => $request->metode_pembayaran,
            'Total Bayar' => $totalBayar,
            'Detail Pembayaran' => $request->metode_pembayaran === 'QRIS' ? 'Menunggu Pembayaran QRIS' : 'Bayar di Tempat'
        ];

        // 4. Simpan Reservasi ke Database
        $id = Reservasi::create([
            'no_reservasi' => $noReservasi,
            'nama_tamu' => $request->nama_tamu,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
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
            'expired_at' => $checkIn,
        ]);

        // QRIS Code
        if ($request->metode_pembayaran === 'QRIS') {
            $pakasirService->createQrisPayment($noInvoice, $totalBayar);
        }

        $userSaatIni = Auth::user();
        if ($userSaatIni) {
            $userSaatIni->notify(new ReservasiBerhasil(
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

        // 1. Jika sudah ada QR Image
        if ($pembayaran && $pembayaran->qr_image) {
            return response()->json([
                'success'  => true,
                'qr_image' => $pembayaran->qr_image,
                'status'   => $pembayaran->status,
                'invoice'  => $pembayaran->invoice, // <-- Tambahan ini
                'expired_at' => $pembayaran->expired_at,
            ]);
        }

        $totalBayar = $reservasi->ekstra['Total Bayar'] ?? 0;

        $pembayaranBaru = $pakasirService->createQrisPayment($pembayaran->invoice, $totalBayar);

        // 2. Jika baru saja dibuat
        if ($pembayaranBaru && $pembayaranBaru->qr_image) {
            return response()->json([
                'success'  => true,
                'qr_image' => $pembayaranBaru->qr_image,
                'status'   => $pembayaranBaru->status,
                'invoice'  => $pembayaranBaru->invoice, // <-- Tambahan ini
                'expired_at' => $reservasi->check_in,
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
