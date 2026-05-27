<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kamar extends Model
{
    use HasFactory;
    protected $fillable = [
        'kelas_kamar',
        'nomor_ruangan',
        'harga',
        'fasilitas',
        'thumbnail',
        'foto_1',
        'foto_2',
        'foto_3'
    ];
    protected $casts = [
        'fasilitas' => 'array'
    ];
    //
}
