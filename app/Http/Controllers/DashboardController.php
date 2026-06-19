<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Reservasi;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik 4 Card Atas
        $kamarTersedia = Kamar::where('status', 'Tersedia')->count();
        $kamarTerpakai = Kamar::whereIn('status', ['Terpakai', 'Dibooking'])->count();
        $kamarPerbaikan = Kamar::where('status', 'Maintenance')->count();

        // Asumsi jumlah tamu adalah estimasi dari reservasi yang sedang Check-In (1 kamar = minimal 1 tamu)
        $jumlahTamu = Reservasi::where('status_reservasi', 'Check-In')->count();

        // Data untuk Kalender (Mencari hari yang ada jadwal check-in)
        $jadwalReservasi = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Menunggu Konfirmasi'])
            ->select('check_in', 'id')
            ->get()
            ->map(function ($res) {
                return \Carbon\Carbon::parse($res->check_in)->format('Y-m-d');
            })
            ->unique()
            ->values();

        // Data Jadwal Terdekat (Hari ini sampai 7 Hari ke depan) untuk List di bawah
        $listJadwalMendatang = Reservasi::with('kamar.kelasKamar')
            ->whereIn('status_reservasi', ['Terkonfirmasi', 'Menunggu Konfirmasi'])
            ->whereBetween('check_in', [\Carbon\Carbon::today(), \Carbon\Carbon::today()->addDays(7)])
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
    //
}
