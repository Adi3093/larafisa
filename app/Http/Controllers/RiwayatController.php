<?php

namespace App\Http\Controllers;

use App\Models\KelasKamar;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    // Fungsi bantuan agar logika pencarian/filter tidak ditulis berulang-ulang
    private function filterQuery(Request $request)
    {
        $query = Reservasi::with('kamar.kelasKamar')->whereIn('status_reservasi', ['Selesai', 'Batal']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_tamu', 'like', '%' . $request->search . '%')
                    ->orWhere('no_reservasi', 'like', '%' . $request->search . '%')
                    ->orWhere('no_ktp', 'like', '%' . $request->search . '%');
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

        return $query;
    }

    // 1. TAMPILAN HALAMAN INDEX
    public function index(Request $request)
    {
        $query = $this->filterQuery($request);

        $perPage = $request->per_page ?? 10;
        $riwayats = $query->latest('updated_at')->paginate($perPage)->appends($request->all());

        return view('dashboard.reservasilog', compact('riwayats'));
    }

    // 2. FUNGSI EXPORT CSV (EXCEL)
    public function exportCsv(Request $request)
    {
        $riwayats = $this->filterQuery($request)->latest('updated_at')->get();

        $filename = "Laporan_Riwayat_FisaHotel_" . date('Ymd') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No Reservasi', 'Nama Tamu', 'No KTP', 'No HP', 'No Kamar', 'Tipe Kelas', 'Check-In', 'Check-Out', 'Status Akhir'];

        $callback = function () use ($riwayats, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis Header Kolom

            foreach ($riwayats as $log) {
                fputcsv($file, [
                    $log->no_reservasi,
                    $log->nama_tamu,
                    "'" . $log->no_ktp, // Pakai petik agar nomor panjang tidak jadi format E di Excel
                    "'" . $log->no_hp,
                    $log->kamar->nomor_ruangan,
                    $log->kamar->kelasKamar->nama_kelas,
                    $log->check_in,
                    $log->check_out,
                    $log->status_reservasi
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 3. FUNGSI EXPORT PDF
    public function exportPdf(Request $request)
    {
        // Ambil data yang sudah difilter
        $riwayats = $this->filterQuery($request)->latest('updated_at')->get();

        // Kirim ke view khusus cetak PDF
        $pdf = Pdf::loadView('dashboard.pdf_riwayat', compact('riwayats'))
            ->setPaper('a4', 'landscape'); // Format kertas A4 Memanjang

        return $pdf->download("Laporan_Riwayat_FisaHotel_" . date('Ymd') . ".pdf");
    }
}
