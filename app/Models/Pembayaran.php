<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $fillable = [
        'reservasi_id',
        'invoice',
        'total',
        'qr_image',
        'raw_response',
        'status'
    ];
    // Casting raw_response agar otomatis menjadi array/JSON di Laravel
    protected $casts = [
        'raw_response' => 'array',
        'total' => 'decimal:2',
    ];

    public function riwayat()
    {
        return $this->hasMany(RiwayatPembayaran::class, 'pembayaran_id');
    }
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id');
    }
}
