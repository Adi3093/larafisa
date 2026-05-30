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
        $statusCounts = Kamar::selectRaw("status,count(*) as total")->groupBy('status')->pluck('total', 'status');
        $cards = [
            'Tersedia' => $statusCounts['Tersedia'] ?? 0,
            'Terpakai' => $statusCounts['Terpakai'] ?? 0,
            'Maintenance' => $statusCounts['Maintenance'] ?? 0,
        ];

        $query = Reservasi::with('kamar.kelasKamar')
            ->where('tipe_reservasi', 'Walk-in')
            ->where('status_reservasi', 'Aktif');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_tamu', 'like', '%' . $request->search . '%')
                    ->orWhere('no_reservasi', 'like', '%' . $request->search . '%');
            });
        }
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

        $perPage = $request->per_page ?? 5;
        $reservasis = $query->latest()->paginate($perPage)->appends($request->all());

        $semuaKelas = KelasKamar::all();
        $kamarTersedia = Kamar::with('kelasKamar')->where('status', 'Tersedia')->get();
        $semuaKamar = Kamar::with('kelasKamar')->get();

        return view('dashboard.reservasi', compact('cards', 'reservasis', 'semuaKelas', 'kamarTersedia', 'semuaKamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:45',
            'no_ktp' => 'required|string|max:16',
            'no_hp' => 'required|string|max:15',
            'kamar_id' => 'required|exists:kamars,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
            'ekstra' => 'nullable|array' // Validasi tambahan ekstra
        ]);

        $noReservasi = 'RSV-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        Reservasi::create([
            'no_reservasi' => $noReservasi,
            'nama_tamu' => $request->nama_tamu,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'kamar_id' => $request->kamar_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'ekstra' => $request->ekstra ?? [], // Simpan array atau kosongkan jika tidak ada yang dicentang
            'tipe_reservasi' => 'Walk-in'
        ]);

        Kamar::where('id', $request->kamar_id)->update(['status' => 'Terpakai']);

        return back()->with('success', 'Reservasi ' . $noReservasi . ' berhasil didaftarkan!');
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $request->validate([
            'nama_tamu' => 'required|string|max:45',
            'no_ktp' => 'required|string|max:16',
            'no_hp' => 'required|string|max:15',
            'kamar_id' => 'required|exists:kamars,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
            'ekstra' => 'nullable|array'
        ]);

        if ($reservasi->kamar_id != $request->kamar_id) {
            Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Tersedia']);
            Kamar::where('id', $request->kamar_id)->update(['status' => 'Terpakai']);
        }

        $data = $request->all();
        $data['ekstra'] = $request->ekstra ?? []; // Perbarui fasilitas ekstra
        $reservasi->update($data);

        return back()->with('success', 'Data reservasi ' . $reservasi->no_reservasi . ' berhasil diupdate!');
    }

    // FUNGSI BARU: Check-out Mendadak / Selesai
    public function checkout($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Ubah tanggal check-out menjadi hari ini (saat tombol ditekan)
        $reservasi->update([
            'check_out' => now()->toDateString(),
            'status_reservasi' => 'Selesai'
        ]);

        // Bebaskan kembali ruangan
        Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Tersedia']);

        return back()->with('success', 'Tamu ' . $reservasi->nama_tamu . ' berhasil Check-Out. Data dipindahkan ke Riwayat.');
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status_reservasi' => 'Batal']);

        // Bebaskan ruangan
        Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Tersedia']);

        return back()->with('success', 'Reservasi dibatalkan dan dipindahkan ke Riwayat. Status kamar kembali Tersedia.');
    }
}
