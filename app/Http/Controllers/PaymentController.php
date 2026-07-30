<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Services\PakasirPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    // Tambahkan Request $request di parameter
    public function checkStatus(Request $request, $invoice, PakasirPaymentService $service)
    {
        $pembayaran = Pembayaran::where('invoice', $invoice)->first();

        if (!$pembayaran) {
            return response()->json(['status' => 'error', 'message' => 'Invoice tidak ditemukan'], 404);
        }

        // DETEKSI CERDAS: Cek apakah frontend mengirim sinyal "timeout=1" ATAU waktu di DB sudah kelewat
        $isTimeUp = $request->query('timeout') == '1' || ($pembayaran->expired_at && now()->greaterThan($pembayaran->expired_at));

        if ($pembayaran->status === 'pending' && $isTimeUp) {

            // 1. Tembak API Cancel ke Pakasir agar tagihan benar-benar HANGUS di sistem mereka
            $service->cancelPayment($invoice);

            // 2. Update status di database kita menjadi gagal
            $pembayaran->update(['status' => 'gagal']);
            $service->recordHistory($pembayaran->id, 'gagal', 'Waktu habis. Tagihan otomatis dibatalkan di sistem dan Gateway.');

            // 3. Batalkan reservasi (Hanya jika ini tagihan utama, bukan tagihan Tambahan Check-out)
            if (!Str::startsWith($invoice, 'ADD-')) {
                $pembayaran->reservasi()->update(['status_reservasi' => 'Dibatalkan']);
            }

            return response()->json(['status' => 'gagal']);
        }

        // --- PROSES CEK NORMAL ---
        $result = $service->checkPayment($invoice);
        Log::info("Cek API Pakasir untuk Invoice {$invoice}: ", $result ?? []);

        $statusPakasir = $result['transaction']['status']
            ?? $result['status']
            ?? $result['data']['status']
            ?? 'pending';

        $statusSukses = ['completed', 'paid', 'success', 'settlement', 'berhasil'];

        if (in_array(strtolower($statusPakasir), $statusSukses)) {
            if ($pembayaran->status !== 'berhasil') {
                $pembayaran->update(['status' => 'berhasil']);
                $service->recordHistory($pembayaran->id, 'berhasil', 'Pembayaran otomatis dikonfirmasi oleh sistem Gateway');
            }
        } elseif (strtolower($statusPakasir) === 'failed' || strtolower($statusPakasir) === 'expired') {
            if ($pembayaran->status !== 'gagal' && $pembayaran->status !== 'dibatalkan') {
                $pembayaran->update(['status' => 'gagal']);
                $service->recordHistory($pembayaran->id, 'gagal', 'Pembayaran dibatalkan/kedaluwarsa dari Gateway');

                if (!Str::startsWith($invoice, 'ADD-')) {
                    $pembayaran->reservasi()->update(['status_reservasi' => 'Dibatalkan']);
                }
            }
        }

        return response()->json(['status' => $pembayaran->status]);
    }
}
