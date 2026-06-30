<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kamar;
use App\Models\KelasKamar;
use Illuminate\Support\Facades\Auth;

class CheckInOutController extends Controller
{
    public function index(Request $request)
    {
        // Setup Query Dasar
        $query = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->with(['kamar.kelasKamar']);

        // Filter 1: Pencarian Nama atau No Reservasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")
                    ->orWhere('no_reservasi', 'like', "%{$search}%");
            });
        }

        // Filter 2: Kelas Kamar
        if ($request->filled('filter_kelas')) {
            $query->whereHas('kamar', function ($q) use ($request) {
                $q->where('kelas_kamar_id', $request->filter_kelas);
            });
        }

        // Filter 3: Nomor Ruangan
        if ($request->filled('filter_kamar')) {
            $query->where('kamar_id', $request->filter_kamar);
        }

        // Urutkan berdasarkan waktu Check-In terdekat
        $query->orderBy('check_in', 'asc');

        // Paginasi Dinamis (Default 10)
        $perPage = $request->input('per_page', 10);
        $reservasis = $query->paginate($perPage)->appends($request->query());

        // Data untuk Dropdown Filter
        $kelasKamars = KelasKamar::all();
        $kamars = Kamar::orderBy('nomor_ruangan', 'asc')->get();

        // Data Statistik Atas
        $kamarTersedia = Kamar::where('status', 'Tersedia')->count();
        $kamarTerpakai = Kamar::whereIn('status', ['Terpakai', 'Dibooking'])->count();
        $kamarPerbaikan = Kamar::where('status', 'Maintenance')->count();

        return view('dashboard.checkinout', compact(
            'reservasis',
            'kamarTersedia',
            'kamarTerpakai',
            'kamarPerbaikan',
            'kelasKamars',
            'kamars',
            'perPage'
        ));
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

        if ($request->has('detail_pembayaran')) {
            $ekstra = is_array($reservasi->ekstra) ? $reservasi->ekstra : json_decode($reservasi->ekstra, true);
            $ekstra['Detail Pembayaran'] = $request->detail_pembayaran;
            $reservasi->update(['ekstra' => $ekstra]);
        }

        $reservasi->update(['status_reservasi' => 'Selesai']);

        if ($reservasi->kamar_id) {
            Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Tersedia']);
        }

        if ($request->has('print_struk') && $request->print_struk == '1') {
            return redirect()->route('checkinout.print', $reservasi->id);
        }

        return back()->with('success', 'Proses Check-Out berhasil! Kamar kembali kosong dan riwayat tersimpan.');
    }

    public function printStruk($id)
    {
        $reservasi = Reservasi::with('kamar.kelasKamar')->findOrFail($id);

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

        return view('dashboard.strukthermal', compact('reservasi', 'diffDays', 'hargaKamar', 'totalKamar', 'qtyBed', 'totalBed', 'qtySelimut', 'totalSelimut', 'totalAkhir', 'kasir', 'ekstra'));
    }
}
