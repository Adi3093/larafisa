<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\LandingProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\UpdateLastSeen;
use Illuminate\Support\Facades\Route;



Route::get('/', [KamarController::class, 'landingPage']);
Route::get('/reservasi-online', [App\Http\Controllers\GuestReservationController::class, 'index'])->name('reservasi.tamu');
Route::get('/riwayat-tamu', [App\Http\Controllers\GuestReservationController::class, 'riwayat'])->name('riwayat.tamu');
Route::get('/api/kamar-tersedia', [App\Http\Controllers\ReservasiController::class, 'getKamarTersedia'])->name('api.kamar.tersedia');

// TEST DATABASE
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

// Public Area (no login)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register Tamu
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'register_store'])->name('register.store');
});

// Auth Area
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route Profil Tamu
    Route::get('/profil-tamu', [LandingProfileController::class, 'index'])->name('profil.tamu');
    Route::get('/profil-tamu/edit', [LandingProfileController::class, 'edit'])->name('profil.tamu.edit');
    Route::put('/profil-tamu/update', [LandingProfileController::class, 'update'])->name('profil.tamu.update');

    // Reservasi Online Tamu (Simpan & Batal)
    Route::post('/reservasi-online', [App\Http\Controllers\GuestReservationController::class, 'store'])->name('reservasi.tamu.store');
    Route::put('/reservasi-online/{id}/update', [App\Http\Controllers\GuestReservationController::class, 'update'])->name('reservasi.tamu.update');
    Route::put('/reservasi-online/{id}/batal', [App\Http\Controllers\GuestReservationController::class, 'batal'])->name('reservasi.tamu.batal');
    Route::get('/reservasi-online/{id}/generate-qris', [App\Http\Controllers\GuestReservationController::class, 'generateQris'])->name('reservasi.qris.generate');
    Route::get('/payment/check/{invoice}', [PaymentController::class, 'checkStatus']);
    // Route::post('/reservasi-online/{id}/generate-qris', [App\Http\Controllers\GuestReservationController::class, 'generateQris'])->name('reservasi.qris.generate');
});


// ADMIN AREA
Route::middleware(['auth', 'role:admin', UpdateLastSeen::class])->group(function () {

    // Dashboard Utama
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/jadwal-harian', [App\Http\Controllers\DashboardController::class, 'getJadwalHarian'])->name('api.jadwal.harian');

    // Kelola Kamar & Ruangan
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar');
    Route::post('/kelas-kamar', [KamarController::class, 'storeKelas'])->name('kelas.store');
    Route::put('/kelas-kamar/{id}', [KamarController::class, 'updateKelas'])->name('kelas.update');
    Route::delete('/kelas-kamar/{id}', [KamarController::class, 'destroyKelas'])->name('kelas.destroy');
    Route::post('/kamar', [KamarController::class, 'storeKamar'])->name('kamar.store');
    Route::put('/kamar/{id}', [KamarController::class, 'updateKamar'])->name('kamar.update');
    Route::delete('/kamar/{id}', [KamarController::class, 'destroyKamar'])->name('kamar.destroy');

    // Reservasi (Walk-in/online)
    Route::get('/reservasi', [App\Http\Controllers\ReservasiController::class, 'index'])->name('reservasi');
    Route::post('/reservasi', [App\Http\Controllers\ReservasiController::class, 'store'])->name('reservasi.store');
    Route::put('/reservasi/{id}', [App\Http\Controllers\ReservasiController::class, 'update'])->name('reservasi.update');
    Route::post('/reservasi/{id}/konfirmasi', [App\Http\Controllers\ReservasiController::class, 'konfirmasi'])->name('reservasi.konfirmasi');
    Route::post('/reservasi/{id}/batal', [App\Http\Controllers\ReservasiController::class, 'batal'])->name('reservasi.batal');

    // Export Riwayat
    Route::get('/reservasi/export/csv', [App\Http\Controllers\ReservasiController::class, 'exportCsv'])->name('reservasi.csv');
    Route::get('/reservasi/export/pdf', [App\Http\Controllers\ReservasiController::class, 'exportPdf'])->name('reservasi.pdf');

    // Check-In & Check-Out
    Route::get('/checkinout', [App\Http\Controllers\CheckInOutController::class, 'index'])->name('checkinout');
    Route::post('/checkinout/{id}/checkin', [App\Http\Controllers\CheckInOutController::class, 'checkin'])->name('checkinout.checkin');
    Route::post('/checkinout/{id}/checkout', [App\Http\Controllers\CheckInOutController::class, 'checkout'])->name('checkinout.checkout');
    Route::get('/checkinout/{id}/print', [App\Http\Controllers\CheckInOutController::class, 'printStruk'])->name('checkinout.print');
    Route::put('/checkinout/{id}/extend', [App\Http\Controllers\CheckInOutController::class, 'extend'])->name('checkinout.extend');
    // (Letakkan di area Route Admin)
    Route::post('/checkinout/{id}/qris-tambahan', [App\Http\Controllers\CheckInOutController::class, 'generateQrisTambahan'])->name('checkinout.qris.tambahan');

    // Kelola Akun
    Route::get('/akun', [AccountController::class, 'index'])->name('akun');
    Route::post('/akun', [AccountController::class, 'store'])->name('akun.store');
    Route::put('/akun/{id}', [AccountController::class, 'update'])->name('akun.update');

    // Letakkan di bawah rute Check-in & Check-Out yang sudah ada
    Route::post('/checkinout/{id}/generate-qris-tambahan', [App\Http\Controllers\CheckInOutController::class, 'generateQrisTambahan'])->name('checkinout.qris.tambahan');

    // Pengaturan dan Laporan
    Route::get('/settings', function () {
        return view('dashboard.settings');
    })->name('settings');

    Route::get('/settings/profil', [ProfileController::class, 'index'])->name('settings.profil');
    Route::put('/settings/profil', [ProfileController::class, 'update'])->name('settings.profil.update');

    //Laporan Pendapatan
    Route::get('/pendapatan', [App\Http\Controllers\PendapatanController::class, 'index'])->name('pendapatan');
    Route::get('/pendapatan/export/{format}', [App\Http\Controllers\PendapatanController::class, 'export'])->name('pendapatan.export');
    // Rute API untuk menyimpan status Maintenance ke Server
    Route::post('/settings/maintenance', [App\Http\Controllers\ProfileController::class, 'updateMaintenance'])->name('settings.maintenance');
});
