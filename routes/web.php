<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Middleware\UpdateLastSeen;

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
Route::middleware(['auth', \App\Http\Middleware\UpdateLastSeen::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');
    Route::get('/reservasi', function () {
        return view('dashboard.reservasi');
    });
    Route::get('/kamar', function () {
        return view('dashboard.kamar');
    });
    // Pengaturan
    Route::get('/settings', function () {
        return view('dashboard.settings');
    });
    Route::get('/profile', function () {
        return view('dashboard.profile');
    });
    Route::get('/logs', function () {
        return view('dashboard.logs');
    });
    Route::get('/settings/profil', [ProfileController::class, 'index'])->name('settings.profil');
    Route::put('/settings/profil', [ProfileController::class, 'update'])->name('settings.profil.update');

    // Kelola Akun
    Route::get('/akun', [AccountController::class, 'index'])->name('akun');
    Route::put('/akun/{id}', [AccountController::class, 'update'])->name('akun.update');
    Route::post('/akun', [AccountController::class, 'store'])->name('akun.store');
    //status
    Route::middleware(['auth', UpdateLastSeen::class])->group(function () {});

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
