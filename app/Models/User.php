<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'username',
    'email',
    'password',
    'avatar',
    'role',
    'last_seen',
    'no_ktp',
    'no_hp',
])]
#[Hidden([
    'password',
    'remember_token'
])]
class User extends Authenticatable
{
    public function riwayatReservasi()
    {
        return $this->hasMany(Reservasi::class, 'user_id');
    }

    public function reservasiDibuat()
    {
        return $this->hasMany(Reservasi::class, 'dibuat_oleh_user_id');
    }

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
