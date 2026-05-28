<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelasKamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
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

    public function kamars()
    {
        return $this->hasMany(Kamar::class);
    }
    //
}
