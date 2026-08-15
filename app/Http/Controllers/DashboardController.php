<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Reservasi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistika Kamar
        $kamarTersedia = Kamar::where('status', 'Tersedia')->count();
        $kamarTerpakai = Kamar::whereIn('status', ['Terpakai', 'Dibooking'])->count();
        $kamarPerbaikan = Kamar::where('status', 'Maintenance')->count();
        $now = Carbon::now();
        $resSelesai = Reservasi::with('kamar.kelasKamar')->where('status_reservasi', 'Selesai')->get();

        $pendapatanBulan = 0;
        $tamuBulan = 0;
        $pendapatanMinggu = 0;
        $tamuMinggu = 0;

        $chartBulanTamu = array_fill(1, 12, 0);
        $chartBulanUang = array_fill(1, 12, 0);
        $chartMingguTamu = array_fill(1, 7, 0);
        $chartMingguUang = array_fill(1, 7, 0);

        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        foreach ($resSelesai as $res) {
            $outDate = Carbon::parse($res->check_out);
            $in = Carbon::parse($res->check_in);
            $diffDays = max(1, $in->diffInDays($outDate));
            $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;
            $ekstra = is_array($res->ekstra) ? $res->ekstra : (json_decode($res->ekstra, true) ?? []);
            $bed = ($ekstra['Extra Bed'] ?? 0) * 100000;
            $selimut = ($ekstra['Extra Selimut'] ?? 0) * 25000;
            $uang = ($hargaKamar * $diffDays) + $bed + $selimut;
            if ($outDate->year === $now->year) {
                $m = $outDate->month;
                $chartBulanTamu[$m] += 1;
                $chartBulanUang[$m] += $uang;

                if ($m === $now->month) {
                    $tamuBulan += 1;
                    $pendapatanBulan += $uang;
                }
            }

            if ($outDate->between($startOfWeek, $endOfWeek)) {
                $dayIndex = $outDate->dayOfWeekIso; // 1 = Senin, 7 = Minggu
                $chartMingguTamu[$dayIndex] += 1;
                $chartMingguUang[$dayIndex] += $uang;

                $tamuMinggu += 1;
                $pendapatanMinggu += $uang;
            }
        }

        $chartData = [
            'labels_bulan' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'data_tamu_bulan' => array_values($chartBulanTamu),
            'data_uang_bulan' => array_values($chartBulanUang),

            'labels_minggu' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            'data_tamu_minggu' => array_values($chartMingguTamu),
            'data_uang_minggu' => array_values($chartMingguUang),
        ];

        // Kalender dan Jadwal Mendatang
        $jadwalReservasi = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Menunggu Konfirmasi'])
            ->select('check_in', 'id')
            ->get()
            ->map(fn($res) => Carbon::parse($res->check_in)->format('Y-m-d'))
            ->unique()->values();

        // Diurutkan dari hari ini ke masa depan (bukan ke belakang)
        $listJadwalMendatang = Reservasi::with('kamar.kelasKamar')
            ->whereIn('status_reservasi', ['Terkonfirmasi', 'Menunggu Konfirmasi'])
            ->whereDate('check_in', '>=', Carbon::today())
            ->orderBy('check_in', 'asc')
            ->limit(10)
            ->get();

        return view('dashboard.dashboard', compact(
            'kamarTersedia',
            'kamarTerpakai',
            'kamarPerbaikan',
            'tamuBulan',
            'pendapatanBulan',
            'tamuMinggu',
            'pendapatanMinggu',
            'chartData',
            'jadwalReservasi',
            'listJadwalMendatang'
        ));
    }

    public function getJadwalHarian(Request $request)
    {
        $tanggal = $request->tanggal;
        $jadwal = Reservasi::with('kamar')
            ->whereIn('status_reservasi', ['Terkonfirmasi', 'Menunggu Konfirmasi'])
            ->whereDate('check_in', $tanggal)
            ->orderBy('check_in', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'no_reservasi' => $item->no_reservasi,
                    'nama_tamu' => $item->nama_tamu,
                    'waktu_in' => Carbon::parse($item->check_in)->translatedFormat('d M Y, H:i') . ' WIB',
                    'kamar' => $item->kamar ? $item->kamar->nomor_ruangan : 'Belum Set'
                ];
            });

        return response()->json($jadwal);
    }
}
