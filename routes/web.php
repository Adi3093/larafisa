<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Middleware\UpdateLastSeen;
use App\Http\Controllers\KamarController;

// Area Public
Route::get('/', function () {
    $kelasKamars = \App\Models\KelasKamar::all();
    return view('landing_page.home', compact('kelasKamars'));
});

// Test Database
Route::get('/cek-database', function () {
    $user = \App\Models\User::where('username', 'admin')->first();
    if (!$user) return 'GAWAT: Akun admin tidak ditemukan di database! Seeder Anda belum berhasil.';

    $cekPassword = \Illuminate\Support\Facades\Hash::check('admin123', $user->password);
    return [
        'Status Akun' => 'Ditemukan!',
        'Data Asli di Database' => $user,
        'Apakah sandi admin123 cocok?' => $cekPassword ? 'YA, COCOK!' : 'TIDAK COCOK!'
    ];
});

// Guest Area no login
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register Tamu
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'register_store'])->name('register.store');
});

//Auth area
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Area
Route::middleware(['auth', 'role:admin', UpdateLastSeen::class])->group(function () {

    // Dashboard Utama
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');

    //Kelola Kamar
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar');

    // Kelas Kamar
    Route::post('/kelas-kamar', [KamarController::class, 'storeKelas'])->name('kelas.store');
    Route::put('/kelas-kamar/{id}', [KamarController::class, 'updateKelas'])->name('kelas.update');
    Route::delete('/kelas-kamar/{id}', [KamarController::class, 'destroyKelas'])->name('kelas.destroy');

    // Nomor Kamar
    Route::post('/kamar', [KamarController::class, 'storeKamar'])->name('kamar.store');
    Route::put('/kamar/{id}', [KamarController::class, 'updateKamar'])->name('kamar.update');
    Route::delete('/kamar/{id}', [KamarController::class, 'destroyKamar'])->name('kamar.destroy');

    // MODUL RESERVASI TERPADU (Walk-in, Online & Riwayat)
    Route::get('/reservasi', [App\Http\Controllers\ReservasiController::class, 'index'])->name('reservasi');
    Route::post('/reservasi', [App\Http\Controllers\ReservasiController::class, 'store'])->name('reservasi.store');
    Route::put('/reservasi/{id}', [App\Http\Controllers\ReservasiController::class, 'update'])->name('reservasi.update');
    // API Javascript Fetch
    Route::get('/api/kamar-tersedia', [App\Http\Controllers\ReservasiController::class, 'getKamarTersedia'])->name('api.kamar.tersedia');
    // Aksi Status (Diterima atau Dibatalkan)
    Route::post('/reservasi/{id}/konfirmasi', [App\Http\Controllers\ReservasiController::class, 'konfirmasi'])->name('reservasi.konfirmasi');
    Route::post('/reservasi/{id}/batal', [App\Http\Controllers\ReservasiController::class, 'batal'])->name('reservasi.batal');

    // Export Riwayat
    Route::get('/reservasi/export/csv', [App\Http\Controllers\ReservasiController::class, 'exportCsv'])->name('reservasi.csv');
    Route::get('/reservasi/export/pdf', [App\Http\Controllers\ReservasiController::class, 'exportPdf'])->name('reservasi.pdf');

    // MODUL RESEPSIONIS (Check-In & Check-Out)
    Route::get('/checkinout', [App\Http\Controllers\CheckInOutController::class, 'index'])->name('checkinout');
    Route::post('/checkinout/{id}/checkin', [App\Http\Controllers\CheckInOutController::class, 'checkin'])->name('checkinout.checkin');
    Route::post('/checkinout/{id}/checkout', [App\Http\Controllers\CheckInOutController::class, 'checkout'])->name('checkinout.checkout');

    //Kelola Akun
    Route::get('/akun', [AccountController::class, 'index'])->name('akun');
    Route::post('/akun', [AccountController::class, 'store'])->name('akun.store');
    Route::put('/akun/{id}', [AccountController::class, 'update'])->name('akun.update');

    Route::get('/dtamu', function () {
        return view('dashboard.dtamu');
    });

    //Pengaturan dan Laporan
    Route::get('/settings', function () {
        return view('dashboard.settings');
    })->name('settings');

    Route::get('/settings/profil', [ProfileController::class, 'index'])->name('settings.profil');
    Route::put('/settings/profil', [ProfileController::class, 'update'])->name('settings.profil.update');

    Route::get('/pendapatan', function () {
        return view('dashboard.pendapatan');
    });
});

//Landing Page Profile
Route::get('/profil-tamu', function () {
    return view('landing_page.hprofile');
})->name('profil.tamu');
