<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_kamar_id',
        'nomor_ruangan',
        'status'
    ];

    // INI DIA FUNGSI YANG DICARI OLEH CONTROLLER ANDA:
    public function kelasKamar()
    {
        // Ingat, K-nya huruf besar (kelasKamar)
        return $this->belongsTo(KelasKamar::class);
    }
    //
}
