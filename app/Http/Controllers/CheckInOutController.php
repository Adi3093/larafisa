<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kamar;
use Illuminate\Support\Facades\Auth;

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

    public function checkout(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Simpan perubahan metode pembayaran jika kasir/admin merubahnya saat check-out
        if ($request->has('detail_pembayaran')) {
            $ekstra = is_array($reservasi->ekstra) ? $reservasi->ekstra : json_decode($reservasi->ekstra, true);
            $ekstra['Detail Pembayaran'] = $request->detail_pembayaran;
            $reservasi->update(['ekstra' => $ekstra]);
        }

        $reservasi->update(['status_reservasi' => 'Selesai']);

        if ($reservasi->kamar_id) {
            Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Tersedia']);
        }

        // Cek apakah Checkbox Print dicentang
        if ($request->has('print_struk') && $request->print_struk == '1') {
            return redirect()->route('checkinout.print', $reservasi->id);
        }

        return back()->with('success', 'Proses Check-Out berhasil! Kamar kembali kosong dan riwayat tersimpan.');
    }

    // FUNGSI KHUSUS UNTUK HALAMAN CETAK STRUK THERMAL
    public function printStruk($id)
    {
        $reservasi = Reservasi::with('kamar.kelasKamar')->findOrFail($id);

        // Kalkulasi
        $checkIn = \Carbon\Carbon::parse($reservasi->check_in);
        $checkOut = \Carbon\Carbon::parse($reservasi->check_out);
        $diffDays = $checkIn->diffInDays($checkOut);
        if ($diffDays == 0) $diffDays = 1;

        $hargaKamar = $reservasi->kamar->kelasKamar->harga ?? 0;
        $totalKamar = $hargaKamar * $diffDays;

        $ekstra = is_array($reservasi->ekstra) ? $reservasi->ekstra : json_decode($reservasi->ekstra, true);
        $qtyBed = $ekstra['Extra Bed'] ?? 0;
        $qtySelimut = $ekstra['Extra Selimut'] ?? 0;

        $totalBed = $qtyBed * 100000;
        $totalSelimut = $qtySelimut * 25000;

        $totalAkhir = $totalKamar + $totalBed + $totalSelimut;
        $kasir = Auth::user()->name;

        // Render HTML Raw khusus untuk Struk Printer Thermal
        return view('dashboard.strukthermal', compact('reservasi', 'diffDays', 'hargaKamar', 'totalKamar', 'qtyBed', 'totalBed', 'qtySelimut', 'totalSelimut', 'totalAkhir', 'kasir', 'ekstra'));
    }
}
