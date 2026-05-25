<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing_page.home');
});
Route::get('dashboard', function () {
    return view('/dashboard.dashboard');
});
Route::get('reservasi', function () {
    return view('dashboard.reservasi');
});
Route::get('kamar', function () {
    return view('dashboard.kamar');
});
