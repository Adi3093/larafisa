<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kamar;

class CheckInOutController extends Controller
{
    public function index(Request $request)
    {
        $reservasis = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->orderBy('check_in', 'asc')
            ->paginate(10);

        // MENGHITUNG STATISTIK KARTU (3 CARD)
        $kamarTersedia = Kamar::where('status', 'Tersedia')->count();
        $kamarTerpakai = Kamar::whereIn('status', ['Terpakai', 'Dibooking'])->count();
        $kamarPerbaikan = Kamar::where('status', 'Maintenance')->count();

        return view('dashboard.checkinout', compact('reservasis', 'kamarTersedia', 'kamarTerpakai', 'kamarPerbaikan'));
    }

    public function checkin($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status_reservasi' => 'Check-In']);

        if ($reservasi->kamar_id) {
            Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Terpakai']);
        }

        return back()->with('success', 'Tamu berhasil Check-In! Status kamar otomatis menjadi Terpakai.');
    }

    public function checkout($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status_reservasi' => 'Selesai']);

        if ($reservasi->kamar_id) {
            Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Tersedia']);
        }

        return back()->with('success', 'Proses Check-Out berhasil! Kamar kembali kosong dan riwayat tersimpan.');
    }
}
