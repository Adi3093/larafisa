<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//Landing page public
Route::get('/', function () {
    return view('landing_page.home');
});
//landing page guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

//dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');
    Route::get('/reservasi', function () {
        return view('dashboard.reservasi');
    })->name('dashboard');
    Route::get('/kamar', function () {
        return view('dashboard.kamar');
    })->name('dashboard');

    //logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/cek-database', function () {
    $user = \App\Models\User::where('username', 'admin')->first();

    if (!$user) {
        return 'GAWAT: Akun admin tidak ditemukan di database! Seeder Anda belum berhasil.';
    }

    $cekPassword = \Illuminate\Support\Facades\Hash::check('admin123', $user->password);

    return [
        'Status Akun' => 'Ditemukan!',
        'Data Asli di Database' => $user,
        'Apakah sandi admin123 cocok?' => $cekPassword ? 'YA, COCOK!' : 'TIDAK COCOK!'
    ];
});
