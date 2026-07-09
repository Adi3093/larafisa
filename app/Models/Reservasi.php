<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Pembayaran;

class Reservasi extends Model
{
    use HasFactory;
    protected $fillable = ['no_reservasi', 'dibuat_oleh_user_id', 'nama_tamu', 'no_ktp', 'no_hp', 'kamar_id', 'ekstra', 'check_in', 'check_out', 'tipe_reservasi', 'status_reservasi'];
    protected $casts = [
        'check-in' => 'datetime',
        'check-out' => 'datetime',
        'ekstra' => 'array'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function resepsionis()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh_user_id');
    }
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'reservasi_id');
    }
    //
}
