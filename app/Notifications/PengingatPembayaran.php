<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengingatPembayaran extends Notification
{
    use Queueable;

    // Deklarasi properti secara eksplisit
    public $noReservasi;
    public $namaKelas;

    /**
     * Create a new notification instance.
     */
    public function __construct($noReservasi, $namaKelas)
    {
        $this->noReservasi = $noReservasi;
        $this->namaKelas = $namaKelas;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'warning',
            'title' => 'Segera Selesaikan Pembayaran!',
            'no_reservasi' => $this->noReservasi, // Disimpan sebagai key pencarian
            'message' => "Batas waktu pembayaran untuk reservasi kamar " . $this->namaKelas . " dengan nomor tiket #" . $this->noReservasi . " tersisa kurang dari 30 menit lagi.\n\nHarap segera selesaikan pembayaran Anda agar pesanan tidak dibatalkan otomatis oleh sistem.",
        ];
    }
}
