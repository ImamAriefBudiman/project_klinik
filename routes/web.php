<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\LaporanDaftarController;
use App\Http\Controllers\LaporanPasienController;

Route::resource('laporan-pasien', LaporanPasienController::class);
Route::resource('laporan-daftar', LaporanDaftarController::class);
Route::resource('pasien',PasienController::class);
Route::get('/', function () {
    return view('home');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware([Authenticate::class])->group(function () {
    Route::resource('pasien', PasienController::class);
    Route::resource('daftar', DaftarController::class);
    });
