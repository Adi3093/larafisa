<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\KelasKamar;
use Illuminate\Support\Str;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->tab ?? 'aktif';
        $query = Reservasi::query();

        // MENGGUNAKAN NAMA KOLOM YANG BENAR: status_reservasi
        if ($tab === 'aktif') {
            $query->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In']);
        } else {
            $query->whereIn('status_reservasi', ['Selesai', 'Batal', 'Dibatalkan']);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_tamu', 'like', "%{$search}%")
                ->orWhere('no_reservasi', 'like', "%{$search}%");
        }
        $kamars = Kamar::where('status', 'Tersedia')->get();
        $reservasis = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());
        $kelasKamars = KelasKamar::all();

        return view('dashboard.reservasi', compact('reservasis', 'kelasKamars', 'kamars', 'tab'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:45',
            'no_ktp' => 'nullable|string|max:16', // Diubah menjadi nullable untuk walk-in cepat
            'no_hp' => 'required|string|max:15',
            'kamar_id' => 'required|exists:kamars,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
            'ekstra' => 'nullable|array'
        ]);

        $noReservasi = 'RSV-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        Reservasi::create([
            'no_reservasi' => $noReservasi,
            'nama_tamu' => $request->nama_tamu,
            'no_ktp' => $request->no_ktp ?? '-',
            'no_hp' => $request->no_hp,
            'kamar_id' => $request->kamar_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'ekstra' => $request->ekstra ?? [],
            'tipe_reservasi' => 'Walk-in',
            // Pastikan ini menggunakan 'Terkonfirmasi'
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
        ]);

        $reservasi->update($request->all());
        return back()->with('success', 'Data reservasi ' . $reservasi->no_reservasi . ' berhasil diupdate!');
    }

    // FUNGSI BARU: Menerima Pesanan Online
    public function konfirmasi($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status_reservasi' => 'Terkonfirmasi']);

        return back()->with('success', 'Pesanan Online diterima! Data telah diteruskan ke Meja Resepsionis.');
    }

    // FUNGSI BARU: Menolak Pesanan Online
    public function batal($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status_reservasi' => 'Dibatalkan']);

        return back()->with('success', 'Pesanan ditolak dan dipindahkan ke Riwayat.');
    }

    // Ekspor (Bisa dikembangkan nanti)
    public function exportCsv()
    {
        return "Fitur CSV belum dibuat";
    }
    public function exportPdf()
    {
        return "Fitur PDF belum dibuat";
    }
}
