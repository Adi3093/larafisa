<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kamar;
use App\Models\KelasKamar;
use App\Models\Pembayaran;
use App\Services\PakasirPaymentService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CheckInOutController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->with(['kamar.kelasKamar', 'pembayaran']);

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

        $reservasi->update([
            'status_reservasi' => 'Check-In',
            'check_in' => Carbon::now()
        ]);

        if ($reservasi->kamar_id) {
            Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Terpakai']);
        }

        return back()->with('success', 'Tamu berhasil Check-In! Waktu kedatangan aktual tercatat: ' . Carbon::now()->format('H:i') . ' WIB.');
    }

    public function checkout(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $ekstra = is_array($reservasi->ekstra) ? $reservasi->ekstra : json_decode($reservasi->ekstra, true) ?? [];
        if ($request->has('extra_bed_qty')) {
            $ekstra['Extra Bed'] = (int) $request->extra_bed_qty;
        }

        if ($request->action_type === 'simpan') {
            $newCheckOut = $reservasi->check_out;
            if ($request->filled('tanggal_checkout')) {
                $newCheckOut = Carbon::parse($request->tanggal_checkout)->format('Y-m-d H:i:s');
            }

            $reservasi->update([
                'check_out' => $newCheckOut,
                'ekstra' => $ekstra
            ]);
            return back()->with('success', 'Perubahan jadwal & ekstra berhasil disimpan.');
        }

        $reservasi->update([
            'status_reservasi' => 'Selesai',
            'check_out' => Carbon::now(),
            'ekstra' => $ekstra
        ]);

        if ($reservasi->kamar_id) {
            Kamar::where('id', $reservasi->kamar_id)->update(['status' => 'Tersedia']);
        }

        // PERUBAHAN: Flash Session untuk Trigger Auto-Print Pop-Up
        if ($request->has('print_struk') && $request->print_struk == '1') {
            session()->flash('print_struk_id', $reservasi->id);
        }

        return back()->with('success', 'Proses Check-Out berhasil! Waktu pulang aktual tercatat: ' . Carbon::now()->format('d M Y H:i') . ' WIB.');
    }

    public function generateQrisTambahan(Request $request, $id, \App\Services\PakasirPaymentService $pakasirService)
    {
        $reservasi = Reservasi::findOrFail($id);
        $totalTambahan = (int) $request->total_tambahan;

        if ($totalTambahan <= 0) {
            return response()->json(['success' => false, 'message' => 'Tidak ada tagihan tambahan.']);
        }

        $pembayaranExisting = \App\Models\Pembayaran::where('reservasi_id', $reservasi->id)
            ->where('invoice', 'like', 'ADD-%')
            ->latest()
            ->first();

        if ($pembayaranExisting && $pembayaranExisting->total == $totalTambahan && $pembayaranExisting->qr_image) {
            return response()->json([
                'success' => true,
                'qr_image' => $pembayaranExisting->qr_image,
                'status' => $pembayaranExisting->status,
                'invoice' => $pembayaranExisting->invoice
            ]);
        }

        $invoiceTambahan = 'ADD-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $pembayaran = \App\Models\Pembayaran::create([
            'reservasi_id' => $reservasi->id,
            'invoice'      => $invoiceTambahan,
            'total'        => $totalTambahan,
            'status'       => 'pending'
        ]);

        $pembayaranBaru = $pakasirService->createQrisPayment($invoiceTambahan, $totalTambahan);

        if ($pembayaranBaru && $pembayaranBaru->qr_image) {
            return response()->json([
                'success' => true,
                'qr_image' => $pembayaranBaru->qr_image,
                'status' => $pembayaranBaru->status,
                'invoice' => $pembayaranBaru->invoice
            ]);
        }

        $pembayaran->delete();
        return response()->json(['success' => false, 'message' => 'Gagal terhubung ke Gateway.']);
    }

    public function extend(Request $request, $id)
    {
        $request->validate([
            'new_check_out' => 'required|date'
        ]);

        $reservasi = Reservasi::findOrFail($id);

        $newCheckOut = Carbon::parse($request->new_check_out)->format('Y-m-d H:i:s');
        $checkIn = Carbon::parse($reservasi->check_in);

        if (Carbon::parse($newCheckOut)->lt($checkIn)) {
            return back()->with('error', 'Gagal memperpanjang! Tanggal Check-Out baru tidak boleh lebih awal dari waktu Check-In.');
        }

        $isTabrakan = Reservasi::where('kamar_id', $reservasi->kamar_id)
            ->where('id', '!=', $id)
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In'])
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

    public function printStruk($id)
    {
        $reservasi = Reservasi::with('kamar.kelasKamar')->findOrFail($id);

        $checkIn = Carbon::parse($reservasi->check_in)->startOfDay();
        $checkOut = Carbon::parse($reservasi->check_out)->startOfDay();
        $diffDays = max(1, (int) $checkIn->diffInDays($checkOut));

        $hargaKamar = $reservasi->kamar->kelasKamar->harga ?? 0;
        $totalKamar = $hargaKamar * $diffDays;

        $ekstra = is_array($reservasi->ekstra) ? $reservasi->ekstra : json_decode($reservasi->ekstra, true);
        $qtyBed = $ekstra['Extra Bed'] ?? 0;

        $totalBed = $qtyBed * 50000;
        $totalAkhir = $totalKamar + $totalBed;
        $kasir = Auth::user()->name;

        return view('dashboard.strukthermal', compact('reservasi', 'diffDays', 'hargaKamar', 'totalKamar', 'qtyBed', 'totalBed', 'totalAkhir', 'kasir', 'ekstra'));
    }
}