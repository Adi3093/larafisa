<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\KelasKamar;

class OngoingController extends Controller
{
    public function index(Request $request)
    {
        // 1. Data untuk Summary Cards
        $statusCounts = Kamar::selectRaw("status,count(*) as total")->groupBy('status')->pluck('total', 'status');
        $cards = [
            'Tersedia' => $statusCounts['Tersedia'] ?? 0,
            'Terpakai' => $statusCounts['Terpakai'] ?? 0,
            'Maintenance' => $statusCounts['Maintenance'] ?? 0,
        ];

        // 2. Filter khusus Reservasi ONLINE yang belum selesai/batal
        $query = Reservasi::with('kamar.kelasKamar')
            ->where('tipe_reservasi', 'Online')
            ->where('status_reservasi', 'Aktif');

        // Fitur Pencarian (Sangat cocok untuk Scanner Barcode yang langsung melakukan 'Enter')
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('no_reservasi', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_tamu', 'like', '%' . $request->search . '%')
                    ->orWhere('no_ktp', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Lanjutan
        if ($request->filled('filter_kelas')) {
            $query->whereHas('kamar', function ($q) use ($request) {
                $q->where('kelas_kamar_id', $request->filter_kelas);
            });
        }
        if ($request->filled('filter_nomor')) {
            $query->whereHas('kamar', function ($q) use ($request) {
                $q->where('nomor_ruangan', 'like', '%' . $request->filter_nomor . '%');
            });
        }
        if ($request->filled('filter_checkin')) {
            $query->whereDate('check_in', $request->filter_checkin);
        }
        if ($request->filled('filter_checkout')) {
            $query->whereDate('check_out', $request->filter_checkout);
        }

        $perPage = $request->per_page ?? 10;
        $ongoing = $query->latest()->paginate($perPage)->appends($request->all());
        $semuaKelas = KelasKamar::all();

        return view('dashboard.ongoing', compact('cards', 'ongoing', 'semuaKelas'));
    }

    // FUNGSI AKSI: Konfirmasi Tamu Datang (Check-In)
    public function konfirmasi($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Saat dikonfirmasi, kamar yang tadinya dipesan (Dibooking) resmi menjadi Terpakai
        Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Terpakai']);

        return back()->with('success', 'Reservasi ' . $reservasi->no_reservasi . ' berhasil dikonfirmasi! Status kamar kini Terpakai.');
    }

    // FUNGSI AKSI: Tamu Tidak Datang / Batal
    public function batal($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Batalkan reservasi dan bebaskan kamar
        $reservasi->update(['status_reservasi' => 'Batal']);
        Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Tersedia']);

        return back()->with('success', 'Reservasi online ' . $reservasi->no_reservasi . ' dibatalkan secara sistem. Kamar kembali Tersedia.');
    }
}
