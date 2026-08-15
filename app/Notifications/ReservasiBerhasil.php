<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservasiBerhasil extends Notification
{
    use Queueable;

    protected $noReservasi;
    protected $namaKelas;
    protected $jumlahTamu;

    /**
     * Create a new notification instance.
     */
    public function __construct($noReservasi, $namaKelas, $jumlahTamu)
    {
        $this->noReservasi = $noReservasi;
        $this->namaKelas = $namaKelas;
        $this->jumlahTamu = $jumlahTamu;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     * Format array ini akan langsung terbaca oleh desain hnotif.blade.php kita.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'success',
            'title' => 'Reservasi Berhasil Dibuat!',
            'message' => "Pesanan untuk tipe " . $this->namaKelas . " (" . $this->jumlahTamu . " Tamu) dengan nomor tiket #" . $this->noReservasi . " telah berhasil masuk ke sistem kami. \n\nSilakan cek tab Riwayat secara berkala untuk melihat instruksi pembayaran dan status konfirmasi dari Resepsionis.",
        ];
    }
}
