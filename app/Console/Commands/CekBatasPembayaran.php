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
        // HANYA jika QRIS sudah tergenerate (qr_image tidak null)
        // ================================================================
        $pembayaranIngatkan = Pembayaran::where('status', 'pending')
            ->whereNotNull('qr_image') // <-- FIX: Harus yang sudah minta QRIS
            ->where('expired_at', '<=', $sekarang->copy()->addMinutes(30))
            ->where('expired_at', '>', $sekarang)
            ->get();

        foreach ($pembayaranIngatkan as $bayar) {
            $reservasi = $bayar->reservasi;

            if ($reservasi && $reservasi->tipe_reservasi === 'Online') {
                $user = User::where('no_ktp', $reservasi->no_ktp)->first();

                if ($user) {
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
        // HANYA batal otomatis jika dia sudah klik 'Generate QRIS'
        // dan waktunya habis.
        // (Jika belum generate, biarkan Controller yang urus jadi 'Terlewat')
        // ================================================================
        $pembayaranExpired = Pembayaran::where('status', 'pending')
            ->whereNotNull('qr_image') // <-- FIX: Kunci utamanya di sini!
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

        // ================================================================
        // KASUS 3: PEMBATALAN 3 HARI (SAFETY NET BACKUP)
        // Membatalkan reservasi yang belum generate QRIS tapi sudah 
        // lewat batas toleransi 3 hari dari check-in.
        // ================================================================
        $batasTigaHari = $sekarang->copy()->subDays(3);

        $reservasiHangus = \App\Models\Reservasi::whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terlewat'])
            ->where('check_in', '<=', $batasTigaHari)
            ->get();

        foreach ($reservasiHangus as $resHangus) {
            $resHangus->update(['status_reservasi' => 'Dibatalkan']);
            if ($resHangus->pembayaran) {
                $resHangus->pembayaran->update(['status' => 'dibatalkan']);
            }

            // Kirim Notif Kadaluarsa (karena hangus 3 hari)
            if ($resHangus->tipe_reservasi === 'Online') {
                $user = User::where('no_ktp', $resHangus->no_ktp)->first();
                if ($user) {
                    $sudahDibatalkanNotif = $user->notifications()
                        ->where('type', PembayaranKadaluarsa::class)
                        ->get()
                        ->contains(function ($notif) use ($resHangus) {
                            return ($notif->data['no_reservasi'] ?? '') === $resHangus->no_reservasi;
                        });

                    if (!$sudahDibatalkanNotif) {
                        $user->notify(new PembayaranKadaluarsa($resHangus->no_reservasi));
                    }
                }
            }
        }

        $this->info('Pemeriksaan batas waktu pembayaran selesai dijalankan.');
    }
}
