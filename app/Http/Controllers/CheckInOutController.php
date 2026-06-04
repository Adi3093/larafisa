<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kamar;

class CheckInOutController extends Controller
{
    public function index(Request $request)
    {
        // 1. Menggunakan kolom status_reservasi dan check_in yang benar
        $reservasis = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->orderBy('check_in', 'asc')
            ->paginate(10);

        return view('dashboard.checkinout', compact('reservasis'));
    }

    public function checkin($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // 2. Ubah status reservasi menjadi Check-In
        $reservasi->update(['status_reservasi' => 'Check-In']);

        // 3. Ubah status fisik kamar menjadi 'Terpakai'
        if ($reservasi->kamar_id) {
            Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Terpakai']);
        }

        return back()->with('success', 'Tamu berhasil Check-In! Status kamar otomatis menjadi Terpakai.');
    }

    public function checkout($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // 4. Ubah status reservasi menjadi Selesai (Agar pindah ke Riwayat)
        $reservasi->update(['status_reservasi' => 'Selesai']);

        // 5. Ubah status fisik kamar menjadi 'Tersedia' kembali
        if ($reservasi->kamar_id) {
            Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Tersedia']);
        }

        return back()->with('success', 'Proses Check-Out berhasil! Kamar kembali kosong dan riwayat tersimpan.');
    }
}
