<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranKadaluarsa extends Notification
{
    use Queueable;

    public $noReservasi;

    /**
     * Create a new notification instance.
     */
    public function __construct($noReservasi)
    {
        $this->noReservasi = $noReservasi;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'warning',
            'title' => 'Reservasi Anda Dibatalkan (Kadaluarsa)',
            'no_reservasi' => $this->noReservasi,
            'message' => "Batas waktu pembayaran untuk tiket #" . $this->noReservasi . " telah habis. Sesuai dengan kebijakan Fisa Hotel, sistem telah membatalkan reservasi Anda secara otomatis.\n\nSilakan lakukan proses reservasi ulang jika Anda masih ingin memesan kamar.",
        ];
    }
}
