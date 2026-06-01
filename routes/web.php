<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Middleware\UpdateLastSeen;
use App\Http\Controllers\KamarController;

//Landing page public
// Landing page public
Route::get('/', function () {
    // Tarik semua data Katalog Kelas Kamar
    $kelasKamars = \App\Models\KelasKamar::all();

    return view('landing_page.home', compact('kelasKamars'));
});
//landing page guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
//Register
Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register_store'])->name('register.store');

//dashboard
Route::middleware(['auth', 'role:admin', \App\Http\Middleware\UpdateLastSeen::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //Reservasi
    Route::get('/reservasi', function () {
        return view('dashboard.reservasi');
    });

    //Walk in Reservasi
    Route::get('/reservasi', [App\Http\Controllers\ReservasiController::class, 'index'])->name('reservasi');
    Route::post('/reservasi', [App\Http\Controllers\ReservasiController::class, 'store'])->name('reservasi.store');
    Route::put('/reservasi/{id}', [App\Http\Controllers\ReservasiController::class, 'update'])->name('reservasi.update');
    Route::delete('/reservasi/{id}', [App\Http\Controllers\ReservasiController::class, 'destroy'])->name('reservasi.destroy');
    Route::post('/reservasi/{id}/checkout', [App\Http\Controllers\ReservasiController::class, 'checkout'])->name('reservasi.checkout');

    //Jadwal Reservasi
    Route::get('/ongoing', [App\Http\Controllers\OngoingController::class, 'index'])->name('ongoing');
    Route::post('/ongoing/{id}/konfirmasi', [App\Http\Controllers\OngoingController::class, 'konfirmasi'])->name('ongoing.konfirmasi');
    Route::post('/ongoing/{id}/batal', [App\Http\Controllers\OngoingController::class, 'batal'])->name('ongoing.batal');

    //Riwayat Reservasi
    Route::get('/reservasilog', [App\Http\Controllers\RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat', [App\Http\Controllers\RiwayatController::class, 'index'])->name('riwayat');
    // Menu Riwayat Reservasi & Export
    Route::get('/riwayat', [App\Http\Controllers\RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/export/csv', [App\Http\Controllers\RiwayatController::class, 'exportCsv'])->name('riwayat.csv');
    Route::get('/riwayat/export/pdf', [App\Http\Controllers\RiwayatController::class, 'exportPdf'])->name('riwayat.pdf');

    //Daftar Tamu
    Route::get('/dtamu', function () {
        return view('dashboard.dtamu');
    });

    //kamar
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar');
    //Kelas Kamar
    Route::post('/kelas-kamar', [KamarController::class, 'storeKelas'])->name('kelas.store');
    Route::put('/kelas-kamar/{id}', [KamarController::class, 'updateKelas'])->name('kelas.update');
    Route::delete('/kelas-kamar/{id}', [KamarController::class, 'destroyKelas'])->name('kelas.destroy');
    Route::delete('/kelas-kamar/{id}', [KamarController::class, 'destroyKelas'])->name('kelas.destroy');
    //Fisik Kamar
    Route::post('/kamar', [KamarController::class, 'storeKamar'])->name('kamar.store');
    Route::put('/kamar/{id}', [KamarController::class, 'updateKamar'])->name('kamar.update');
    Route::delete('/kamar/{id}', [KamarController::class, 'destroyKamar'])->name('kamar.destroy');

    //Laporan Pendapatan
    Route::get('/pendapatan', function () {
        return view('dashboard.pendapatan');
    });
    // Pengaturan
    Route::get('/settings', function () {
        return view('dashboard.settings');
    })->name('settings');
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
