<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Reservasi;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Card Informasi Kamar
        $kamarTersedia = Kamar::where('status', 'Tersedia')->count();
        $kamarTerpakai = Kamar::whereIn('status', ['Terpakai', 'Dibooking'])->count();
        $kamarPerbaikan = Kamar::where('status', 'Maintenance')->count();
        $jumlahTamu = Reservasi::where('status_reservasi', 'Check-In')->count();
        $jadwalReservasi = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Menunggu Konfirmasi'])
            ->select('check_in', 'id')
            ->get()
            ->map(function ($res) {
                return \Carbon\Carbon::parse($res->check_in)->format('Y-m-d');
            })
            ->unique()
            ->values();
        $listJadwalMendatang = Reservasi::with('kamar.kelasKamar')
            ->whereIn('status_reservasi', ['Terkonfirmasi', 'Menunggu Konfirmasi'])
            ->whereDate('check_in', \Carbon\Carbon::today())
            ->orderBy('check_in', 'asc')
            ->get();

        return view('dashboard.dashboard', compact(
            'kamarTersedia',
            'kamarTerpakai',
            'kamarPerbaikan',
            'jumlahTamu',
            'jadwalReservasi',
            'listJadwalMendatang'
        ));
    }

    //KALENDER
    public function getJadwalHarian(Request $request)
    {
        $tanggal = $request->tanggal;
        $jadwal = Reservasi::with('kamar')
            ->whereIn('status_reservasi', ['Terkonfirmasi', 'Menunggu Konfirmasi'])
            ->whereDate('check_in', $tanggal)
            ->orderBy('check_in', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'no_reservasi' => $item->no_reservasi,
                    'nama_tamu' => $item->nama_tamu,
                    'waktu_in' => \Carbon\Carbon::parse($item->check_in)->translatedFormat('d M Y, H:i') . ' WIB',
                    'kamar' => $item->kamar ? $item->kamar->nomor_ruangan : 'Belum Set'
                ];
            });

        return response()->json($jadwal);
    }
    //
}
