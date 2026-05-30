<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservasi extends Model
{
    use HasFactory;
    protected $fillable = ['no_reservasi', 'nama_tamu', 'no_ktp', 'no_hp', 'kamar_id', 'ekstra', 'check_in', 'check_out', 'tipe_reservasi', 'status_reservasi'];
    protected $casts = [
        'ekstra' => 'array'
    ];
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
    //
}
