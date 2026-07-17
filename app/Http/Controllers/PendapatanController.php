<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PendapatanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', 'mingguan');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $query = Reservasi::with(['kamar.kelasKamar', 'pembayaran'])->where('status_reservasi', 'Selesai');

        if ($startDate && $endDate) {
            $query->whereDate('updated_at', '>=', $startDate)
                ->whereDate('updated_at', '<=', $endDate);
            $teksPeriode = "Kustom (" . Carbon::parse($startDate)->format('d M') . " - " . Carbon::parse($endDate)->format('d M') . ")";
        } else {
            if ($periode === 'bulanan') {
                $query->whereMonth('updated_at', Carbon::now()->month)
                    ->whereYear('updated_at', Carbon::now()->year);
                $teksPeriode = "Bulan Ini (" . Carbon::now()->translatedFormat('F Y') . ")";
            } else {
                $query->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $teksPeriode = "Minggu Ini";
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")
                    ->orWhere('no_reservasi', 'like', "%{$search}%");
            });
        }

        $allData = $query->get();
        $totalPendapatan = 0;

        foreach ($allData as $res) {
            $in = Carbon::parse($res->check_in)->startOfDay();
            $out = Carbon::parse($res->check_out)->startOfDay();
            $diffDays = max(1, (int) $in->diffInDays($out));

            $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;

            $ekstra = is_string($res->ekstra) ? json_decode($res->ekstra, true) : $res->ekstra;
            $bed = ($ekstra['Extra Bed'] ?? 0) * 100000;
            $selimut = ($ekstra['Extra Selimut'] ?? 0) * 25000;

            $totalPendapatan += ($hargaKamar * $diffDays) + $bed + $selimut;
        }

        $totalTamu = $allData->count();
        $persentaseKunjungan = $totalTamu > 0 ? "+12.5%" : "0%";

        $reservasis = $query->orderBy('updated_at', 'desc')->paginate($perPage)->appends($request->query());

        return view('dashboard.pendapatan', compact(
            'reservasis',
            'totalPendapatan',
            'totalTamu',
            'persentaseKunjungan',
            'periode',
            'teksPeriode',
            'perPage'
        ));
    }

    public function export(Request $request, $format)
    {
        $periode = $request->input('periode', 'mingguan');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        $query = Reservasi::with(['kamar.kelasKamar', 'pembayaran'])->where('status_reservasi', 'Selesai');

        if ($startDate && $endDate) {
            $query->whereDate('updated_at', '>=', $startDate)->whereDate('updated_at', '<=', $endDate);
            $teksPeriode = "Kustom (" . Carbon::parse($startDate)->format('d-M-Y') . " s.d " . Carbon::parse($endDate)->format('d-M-Y') . ")";
        } else {
            if ($periode === 'bulanan') {
                $query->whereMonth('updated_at', Carbon::now()->month)->whereYear('updated_at', Carbon::now()->year);
                $teksPeriode = "Bulan Ini (" . Carbon::now()->translatedFormat('F Y') . ")";
            } else {
                $query->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $teksPeriode = "Minggu Ini";
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")->orWhere('no_reservasi', 'like', "%{$search}%");
            });
        }

        $reservasis = $query->orderBy('updated_at', 'desc')->get();

        $totalPendapatan = 0;
        foreach ($reservasis as $res) {
            $in = Carbon::parse($res->check_in)->startOfDay();
            $out = Carbon::parse($res->check_out)->startOfDay();
            $diffDays = max(1, (int) $in->diffInDays($out));

            $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;

            $ekstra = is_array($res->ekstra) ? $res->ekstra : (json_decode($res->ekstra, true) ?? []);
            $bed = ($ekstra['Extra Bed'] ?? 0) * 100000;
            $selimut = ($ekstra['Extra Selimut'] ?? 0) * 25000;

            $totalPendapatan += ($hargaKamar * $diffDays) + $bed + $selimut;
        }

        if ($format === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.pendapatanpdf', compact('reservasis', 'totalPendapatan', 'teksPeriode'));
            return $pdf->download('Laporan_Pendapatan_FisaHotel.pdf');
        } elseif ($format === 'csv') {
            $fileName = 'Laporan_Pendapatan_FisaHotel.csv';
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            // Header yang sudah dipisah rapi untuk Microsoft Excel
            $columns = [
                'ID Reservasi',
                'Tanggal Pelunasan',
                'Nama Tamu',
                'Tipe Kamar',
                'Durasi (Malam)',
                'Biaya Kamar',
                'Metode Bayar Kamar',
                'Biaya Ekstra',
                'Metode Bayar Ekstra',
                'Total Pemasukan'
            ];

            $callback = function () use ($reservasis, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($reservasis as $res) {
                    $in = Carbon::parse($res->check_in)->startOfDay();
                    $out = Carbon::parse($res->check_out)->startOfDay();
                    $diffDays = max(1, (int) $in->diffInDays($out));

                    $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;
                    $kamarTotal = $hargaKamar * $diffDays;

                    $ekstra = is_array($res->ekstra) ? $res->ekstra : (json_decode($res->ekstra, true) ?? []);
                    $bed = ($ekstra['Extra Bed'] ?? 0) * 100000;
                    $selimut = ($ekstra['Extra Selimut'] ?? 0) * 25000;
                    $ekstraTotal = $bed + $selimut;

                    $totalBaris = $kamarTotal + $ekstraTotal;

                    // CARI PEMBAYARAN
                    $pembayaranUtama = \App\Models\Pembayaran::where('reservasi_id', $res->id)
                        ->where('invoice', 'not like', 'ADD-%')
                        ->first();

                    $pembayaranTambahan = \App\Models\Pembayaran::where('reservasi_id', $res->id)
                        ->where('invoice', 'like', 'ADD-%')
                        ->latest()
                        ->first();

                    $metodeKamar = $pembayaranUtama ? 'QRIS (' . $pembayaranUtama->invoice . ')' : 'Tunai';

                    $metodeEkstra = '-';
                    if ($ekstraTotal > 0) {
                        $metodeEkstra = $pembayaranTambahan ? 'QRIS (' . $pembayaranTambahan->invoice . ')' : 'Tunai';
                    }

                    $kamarText = 'Kamar ' . ($res->kamar->nomor_ruangan ?? '-') . ' (' . ($res->kamar->kelasKamar->nama_kelas ?? 'Dihapus') . ')';

                    fputcsv($file, [
                        $res->no_reservasi,
                        \Carbon\Carbon::parse($res->updated_at)->format('Y-m-d'),
                        $res->nama_tamu,
                        $kamarText,
                        $diffDays,
                        $kamarTotal,
                        $metodeKamar,
                        $ekstraTotal,
                        $metodeEkstra,
                        $totalBaris
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return back()->with('error', 'Format ekspor tidak dikenali.');
    }
}
