<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pembayaran;
use App\Models\User;
use App\Notifications\PengingatPembayaran;
use App\Notifications\PembayaranKadaluarsa;
use Carbon\Carbon;

class CekBatasPembayaran extends Command
{
    protected $signature = 'fisa:cek-pembayaran';
    protected $description = 'Memeriksa pembayaran pending untuk mengirim pengingat 30 menit atau membatalkan reservasi jika expired';

    public function handle()
    {
        $sekarang = Carbon::now();

        // ================================================================
        // KASUS 1: SISA WAKTU <= 30 MENIT (KIRIM PENGINGAT)
        // ================================================================
        $pembayaranIngatkan = Pembayaran::where('status', 'pending')
            ->where('expired_at', '<=', $sekarang->copy()->addMinutes(30))
            ->where('expired_at', '>', $sekarang)
            ->get();

        foreach ($pembayaranIngatkan as $bayar) {
            $reservasi = $bayar->reservasi;

            if ($reservasi && $reservasi->tipe_reservasi === 'Online') {
                $user = User::where('no_ktp', $reservasi->no_ktp)->first();

                if ($user) {
                    // Filter berbasis PHP murni untuk menghindari error type data JSON di MySQL
                    $sudahDiingatkan = $user->notifications()
                        ->where('type', PengingatPembayaran::class)
                        ->get()
                        ->contains(function ($notif) use ($reservasi) {
                            return ($notif->data['no_reservasi'] ?? '') === $reservasi->no_reservasi;
                        });

                    if (!$sudahDiingatkan) {
                        $namaKelas = $reservasi->kamar?->kelasKamar?->nama_kelas ?? 'Tipe Kamar';
                        $user->notify(new PengingatPembayaran($reservasi->no_reservasi, $namaKelas));
                    }
                }
            }
        }

        // ================================================================
        // KASUS 2: WAKTU HABIS / KADALUARSA (BATALKAN OTOMATIS)
        // ================================================================
        $pembayaranExpired = Pembayaran::where('status', 'pending')
            ->where('expired_at', '<', $sekarang)
            ->get();

        foreach ($pembayaranExpired as $bayar) {
            $bayar->update(['status' => 'dibatalkan']);

            $reservasi = $bayar->reservasi;
            if ($reservasi) {
                $reservasi->update(['status_reservasi' => 'Dibatalkan']);

                if ($reservasi->tipe_reservasi === 'Online') {
                    $user = User::where('no_ktp', $reservasi->no_ktp)->first();
                    if ($user) {
                        // Cek duplikasi pembatalan via PHP murni
                        $sudahDibatalkanNotif = $user->notifications()
                            ->where('type', PembayaranKadaluarsa::class)
                            ->get()
                            ->contains(function ($notif) use ($reservasi) {
                                return ($notif->data['no_reservasi'] ?? '') === $reservasi->no_reservasi;
                            });

                        if (!$sudahDibatalkanNotif) {
                            $user->notify(new PembayaranKadaluarsa($reservasi->no_reservasi));
                        }
                    }
                }
            }
        }

        $this->info('Pemeriksaan batas waktu pembayaran selesai dijalankan.');
    }
}
