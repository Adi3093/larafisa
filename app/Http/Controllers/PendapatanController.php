<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PendapatanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Parameter Filter
        $periode = $request->input('periode', 'mingguan');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        // 2. Query Dasar: Hanya ambil reservasi yang sudah "Selesai" (Lunas & Check-Out)
        $query = Reservasi::with('kamar.kelasKamar')->where('status_reservasi', 'Selesai');

        // 3. Logika Filter Waktu
        if ($startDate && $endDate) {
            $query->whereDate('check_out', '>=', $startDate)
                ->whereDate('check_out', '<=', $endDate);
            $teksPeriode = "Kustom (" . Carbon::parse($startDate)->format('d M') . " - " . Carbon::parse($endDate)->format('d M') . ")";
        } else {
            if ($periode === 'bulanan') {
                $query->whereMonth('check_out', Carbon::now()->month)
                    ->whereYear('check_out', Carbon::now()->year);
                $teksPeriode = "Bulan Ini (" . Carbon::now()->translatedFormat('F Y') . ")";
            } else {
                $query->whereBetween('check_out', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $teksPeriode = "Minggu Ini";
            }
        }

        // 4. Logika Pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")
                    ->orWhere('no_reservasi', 'like', "%{$search}%");
            });
        }

        // 5. Kalkulasi Rekapan (Tanpa Paginasi untuk Card Atas)
        $allData = $query->get();
        $totalPendapatan = 0;

        foreach ($allData as $res) {
            $in = Carbon::parse($res->check_in);
            $out = Carbon::parse($res->check_out);
            $diffDays = max(1, $in->diffInDays($out));
            $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;

            $ekstra = is_string($res->ekstra) ? json_decode($res->ekstra, true) : $res->ekstra;
            $bed = ($ekstra['Extra Bed'] ?? 0) * 100000;
            $selimut = ($ekstra['Extra Selimut'] ?? 0) * 25000;

            $totalPendapatan += ($hargaKamar * $diffDays) + $bed + $selimut;
        }

        $totalTamu = $allData->count();

        // Simulasi Persentase Kunjungan (Bisa dikembangkan membandingkan data bulan lalu)
        $persentaseKunjungan = $totalTamu > 0 ? "+12.5%" : "0%";

        // 6. Eksekusi Paginasi untuk Tabel
        $reservasis = $query->orderBy('check_out', 'desc')->paginate($perPage)->appends($request->query());

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
        // 1. Ambil ulang filter yang sedang aktif agar data export sama dengan tabel
        $periode = $request->input('periode', 'mingguan');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        $query = Reservasi::with('kamar.kelasKamar')->where('status_reservasi', 'Selesai');

        if ($startDate && $endDate) {
            $query->whereDate('check_out', '>=', $startDate)->whereDate('check_out', '<=', $endDate);
            $teksPeriode = "Kustom (" . Carbon::parse($startDate)->format('d-M-Y') . " s.d " . Carbon::parse($endDate)->format('d-M-Y') . ")";
        } else {
            if ($periode === 'bulanan') {
                $query->whereMonth('check_out', Carbon::now()->month)->whereYear('check_out', Carbon::now()->year);
                $teksPeriode = "Bulan Ini (" . Carbon::now()->translatedFormat('F Y') . ")";
            } else {
                $query->whereBetween('check_out', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $teksPeriode = "Minggu Ini";
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")->orWhere('no_reservasi', 'like', "%{$search}%");
            });
        }

        // Ambil semua data (tanpa paginasi)
        $reservasis = $query->orderBy('check_out', 'desc')->get();

        $totalPendapatan = 0;
        foreach ($reservasis as $res) {
            $in = Carbon::parse($res->check_in);
            $out = Carbon::parse($res->check_out);
            $diffDays = max(1, $in->diffInDays($out));
            $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;

            $ekstra = is_array($res->ekstra) ? $res->ekstra : (json_decode($res->ekstra, true) ?? []);
            $bed = ($ekstra['Extra Bed'] ?? 0) * 100000;
            $selimut = ($ekstra['Extra Selimut'] ?? 0) * 25000;

            $totalPendapatan += ($hargaKamar * $diffDays) + $bed + $selimut;
        }

        // 2. LOGIKA EXPORT PDF
        if ($format === 'pdf') {
            // Kita panggil facade dompdf secara mutlak agar tidak perlu 'use' di atas
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.pendapatanpdf', compact('reservasis', 'totalPendapatan', 'teksPeriode'));
            return $pdf->download('Laporan_Pendapatan_FisaHotel.pdf');
        }

        // 3. LOGIKA EXPORT CSV (EXCEL)
        elseif ($format === 'csv') {
            $fileName = 'Laporan_Pendapatan_FisaHotel.csv';
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            // Penamaan Kolom Header CSV
            $columns = ['ID Reservasi', 'Tanggal Keluar', 'Nama Tamu', 'Kamar', 'Durasi Inap (Malam)', 'Total Pemasukan', 'Metode Pembayaran'];

            $callback = function () use ($reservasis, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns); // Tulis Header

                foreach ($reservasis as $res) {
                    $in = Carbon::parse($res->check_in);
                    $out = Carbon::parse($res->check_out);
                    $diffDays = max(1, $in->diffInDays($out));
                    $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;

                    $ekstra = is_array($res->ekstra) ? $res->ekstra : (json_decode($res->ekstra, true) ?? []);
                    $bed = ($ekstra['Extra Bed'] ?? 0) * 100000;
                    $selimut = ($ekstra['Extra Selimut'] ?? 0) * 25000;

                    $totalBaris = ($hargaKamar * $diffDays) + $bed + $selimut;
                    $metode = $ekstra['Detail Pembayaran'] ?? '-';
                    $kamarText = 'Kamar ' . ($res->kamar->nomor_ruangan ?? '-') . ' (' . ($res->kamar->kelasKamar->nama_kelas ?? 'Dihapus') . ')';

                    fputcsv($file, [
                        $res->no_reservasi,
                        $out->format('Y-m-d'),
                        $res->nama_tamu,
                        $kamarText,
                        $diffDays,
                        $totalBaris,
                        $metode
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return back()->with('error', 'Format ekspor tidak dikenali.');
    }
    //
}
