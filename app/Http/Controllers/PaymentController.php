<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Services\PakasirPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function checkStatus($invoice, PakasirPaymentService $service)
    {
        $pembayaran = Pembayaran::where('invoice', $invoice)->first();

        // Keamanan: Jika invoice tidak ada di database kita, hentikan
        if (!$pembayaran) {
            return response()->json(['status' => 'error', 'message' => 'Invoice tidak ditemukan'], 404);
        }

        if ($pembayaran->status === 'pending' && $pembayaran->expired_at && now()->greaterThan($pembayaran->expired_at)) {

            // 1. Tembak API Cancel ke Pakasir agar tagihan benar-benar HANGUS di sistem mereka
            $service->cancelPayment($invoice);

            // 2. Update status di database kita menjadi gagal
            $pembayaran->update(['status' => 'gagal']);
            $service->recordHistory($pembayaran->id, 'gagal', 'Waktu batas check-in terlampaui. Tagihan dibatalkan otomatis dari sistem dan Gateway.');

            // 3. UBAH STATUS RESERVASI MENJADI DIBATALKAN (Ini yang membuatnya pindah ke arsip)
            $pembayaran->reservasi()->update(['status_reservasi' => 'Dibatalkan']);

            return response()->json(['status' => 'gagal']);
        }

        // 1. Tembak API Pakasir untuk cek status terbaru
        $result = $service->checkPayment($invoice);

        // 2. MENCATAT LOG (Sangat penting untuk debugging)
        // Ini akan menulis respon asli dari Pakasir ke dalam storage/logs/laravel.log
        Log::info("Cek API Pakasir untuk Invoice {$invoice}: ", $result ?? []);

        // 3. Mencari status dari berbagai kemungkinan struktur JSON Pakasir
        // Gunakan null coalescing (??) agar tidak error jika key 'transaction' tidak ada
        $statusPakasir = $result['transaction']['status']
            ?? $result['status']
            ?? $result['data']['status']
            ?? 'pending';

        // 4. Daftar kata kunci yang biasa digunakan gateway untuk status Lunas
        $statusSukses = ['completed', 'paid', 'success', 'settlement', 'berhasil'];

        // 5. Cek apakah status dari Pakasir ada di dalam daftar status sukses
        if (in_array(strtolower($statusPakasir), $statusSukses)) {

            // Update database HANYA jika status sebelumnya belum 'berhasil'
            if ($pembayaran->status !== 'berhasil') {
                $pembayaran->update(['status' => 'berhasil']);

                // Catat riwayat
                $service->recordHistory($pembayaran->id, 'berhasil', 'Pembayaran otomatis dikonfirmasi oleh sistem Gateway');
            }
        } elseif (strtolower($statusPakasir) === 'failed' || strtolower($statusPakasir) === 'expired') {
            // Opsional: Tangani juga jika kedaluwarsa atau gagal
            if ($pembayaran->status !== 'gagal' && $pembayaran->status !== 'dibatalkan') {
                $pembayaran->update(['status' => 'gagal']);
                $service->recordHistory($pembayaran->id, 'gagal', 'Pembayaran dibatalkan/kedaluwarsa dari Gateway');
            }
        }

        // Kembalikan status dari database kita ke tampilan (JavaScript)
        return response()->json(['status' => $pembayaran->status]);
    }
}
