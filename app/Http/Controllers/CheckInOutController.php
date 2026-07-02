<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kamar;
use App\Models\KelasKamar;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckInOutController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->with(['kamar.kelasKamar']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")
                    ->orWhere('no_reservasi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('filter_kelas')) {
            $query->whereHas('kamar', function ($q) use ($request) {
                $q->where('kelas_kamar_id', $request->filter_kelas);
            });
        }

        if ($request->filled('filter_kamar')) {
            $query->where('kamar_id', $request->filter_kamar);
        }

        $query->orderBy('check_in', 'asc');

        $perPage = $request->input('per_page', 10);
        $reservasis = $query->paginate($perPage)->appends($request->query());

        $kelasKamars = KelasKamar::all();
        $kamars = Kamar::orderBy('nomor_ruangan', 'asc')->get();

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

    // FUNGSI BARU: PERPANJANG DURASI INAP
    public function extend(Request $request, $id)
    {
        $request->validate([
            'new_check_out' => 'required|date'
        ]);

        $reservasi = Reservasi::findOrFail($id);

        $newCheckOut = Carbon::parse($request->new_check_out)->format('Y-m-d H:i:s');
        $checkIn = Carbon::parse($reservasi->check_in);

        // Pastikan tgl baru tidak lebih kecil dari tgl check-in
        if (Carbon::parse($newCheckOut)->lt($checkIn)) {
            return back()->with('error', 'Gagal memperpanjang! Tanggal Check-Out baru tidak boleh lebih awal dari waktu Check-In.');
        }

        // Pastikan tidak tabrakan dengan pesanan tamu lain di kamar yang sama
        $isTabrakan = Reservasi::where('kamar_id', $reservasi->kamar_id)
            ->where('id', '!=', $id)
            ->whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->where(function ($q) use ($checkIn, $newCheckOut) {
                $q->where('check_in', '<', $newCheckOut)
                    ->where('check_out', '>', $checkIn);
            })->exists();

        if ($isTabrakan) {
            return back()->with('error', 'Gagal memperpanjang waktu! Kamar ini sudah di-booking oleh tamu lain pada tanggal/jam tersebut.');
        }

        $reservasi->update(['check_out' => $newCheckOut]);
        return back()->with('success', 'Berhasil memperpanjang durasi inap. Sistem telah menyesuaikan kalkulasi total biaya.');
    }

    public function checkout(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // JIKA RESEPSIONIS MENGUBAH TANGGAL CHECK-OUT DI DALAM MODAL DETAIL
        if ($request->filled('tanggal_checkout')) {
            $reservasi->check_out = \Carbon\Carbon::parse($request->tanggal_checkout)->format('Y-m-d H:i:s');
        }

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

        return back()->with('success', 'Proses Check-Out berhasil! Perubahan durasi menginap dan riwayat transaksi telah diperbarui.');
    }

    public function printStruk($id)
    {
        $reservasi = Reservasi::with('kamar.kelasKamar')->findOrFail($id);

        $checkIn = Carbon::parse($reservasi->check_in);
        $checkOut = Carbon::parse($reservasi->check_out);
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
