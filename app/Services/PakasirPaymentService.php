<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Pembayaran;

class PakasirPaymentService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        // Menggunakan URL default yang benar sesuai dokumentasi jika .env kosong
        $this->apiUrl = env('PAKASIR_API_URL', 'https://pakasir.com/api/');
        $this->apiKey = env('PAKASIR_API_KEY');
    }

    /**
     * Membuat request QRIS ke Pakasir dan menyimpan ke database
     */
    public function createQrisPayment($invoiceNumber, $amount)
    {

        // 1. Tembak API Pakasir (Sesuai Bagian C.1 Dokumentasi)
        $response = Http::withHeaders([])->post($this->apiUrl . 'transactioncreate/qris', [
            'project' => env('PAKASIR_PROJECT', 'XXXX'),
            'api_key' => env('PAKASIR_API_KEY', 'XXXXX'),
            'amount'   => (int) $amount,
            'order_id' => $invoiceNumber,
        ]);

        $responseData = $response->json();
        // dd($response);

        // Validasi jika API gagal memproses (status: false)
        if (!$response->successful() || !isset($responseData['payment'])) {
            return null;
        }

        // 2. Simpan Data Pembayaran ke Database
        // Mengambil URL QRIS dari response JSON: data -> qris_url
        $pembayaran = Pembayaran::where('invoice', $invoiceNumber)->first();
        $pembayaran->update([
            'qr_image' => $responseData['payment']['payment_number'] ?? null,
            // 'total' => $responseData['payment']['payment_number'] ?? null,
            'raw_response' => $responseData,
        ]);
        $this->recordHistory($pembayaran->id, 'pending', 'QRIS berhasil dibuat');

        return $pembayaran;
    }

    public function createQrisTambahan($reservasiId, $invoiceNumber, $amount)
    {
        // 1. Tembak API Pakasir
        $response = Http::post($this->apiUrl . 'transactioncreate/qris', [
            'project'  => env('PAKASIR_PROJECT', 'XXXX'),
            'api_key'  => env('PAKASIR_API_KEY', 'XXXXX'),
            'amount'   => (int) $amount,
            'order_id' => $invoiceNumber,
        ]);

        $responseData = $response->json();

        if (!$response->successful() || !isset($responseData['payment'])) {
            return null; // Gagal terhubung atau format API salah
        }

        // 2. SIMPAN DATA BARU ke Database (Menggunakan create, bukan update)
        $pembayaran = Pembayaran::create([
            'reservasi_id' => $reservasiId,
            'invoice'      => $invoiceNumber,
            'total'        => $amount,
            'qr_image'     => $responseData['payment']['payment_number'] ?? null,
            'raw_response' => $responseData,
            'status'       => 'pending',
        ]);

        // 3. Catat riwayat
        $this->recordHistory($pembayaran->id, 'pending', 'QRIS Tambahan berhasil dibuat');

        return $pembayaran;
    }

    public function checkPayment($invoice)
    {
        $pembayaran = Pembayaran::where('invoice', $invoice)->first();

        // 1. Paksa nilai decimal dari database (misal: 270000.00) menjadi integer murni (270000)
        $amountInt = (int) $pembayaran->total;

        // 2. Gunakan array di dalam Http::get agar Laravel otomatis menyusun dan meng-encode URL dengan rapi
        $response = Http::get($this->apiUrl . 'transactiondetail', [
            'project'  => env('PAKASIR_PROJECT'),
            'api_key'  => env('PAKASIR_API_KEY'),
            'order_id' => $pembayaran->invoice,
            'amount'   => $amountInt
        ]);

        return $response->json();
    }
    /**
     * Mencatat riwayat setiap ada perubahan status pembayaran
     */
    public function recordHistory($pembayaranId, $status, $keterangan)
    {
        $pembayaran = Pembayaran::find($pembayaranId);

        if ($pembayaran) {
            $pembayaran->update(['status' => $status]);

            $pembayaran->riwayat()->create([
                'status'     => $status,
                'keterangan' => $keterangan,
            ]);
        }
    }

    public function cancelPayment($invoice)
    {
        $pembayaran = Pembayaran::where('invoice', $invoice)->first();
        if (!$pembayaran) return null;

        // Paksa menjadi integer murni seperti saat pembuatan
        $amountInt = (int) $pembayaran->total;

        // Tembak endpoint transactioncancel milik Pakasir
        $response = Http::post($this->apiUrl . 'transactioncancel', [
            'project'  => env('PAKASIR_PROJECT'),
            'api_key'  => env('PAKASIR_API_KEY'),
            'order_id' => $pembayaran->invoice,
            'amount'   => $amountInt
        ]);

        return $response->json();
    }
}
