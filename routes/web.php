<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\LombaController;
use App\Http\Controllers\PendaftaranLombaController;
use App\Http\Controllers\SoalController;

// Halaman login dan register (tanpa proteksi middleware)
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Proteksi untuk siswa
Route::middleware(['auth'])->group(function () {
    // Redirect default
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/edit-profile', [\App\Http\Controllers\SiswaController::class, 'edit'])->name('edit-profile');
    Route::post('/edit-profile', [\App\Http\Controllers\SiswaController::class, 'update'])->name('update-profile');

    // Dashboard siswa
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');

    // Halaman daftar lomba untuk siswa
    Route::get('/daftar-lomba', [\App\Http\Controllers\LombaSiswaController::class, 'index'])->name('daftar-lomba');
    Route::get('/pendaftaran-lomba/{id}', [PendaftaranLombaController::class, 'create'])->name('pendaftaran-lomba.create');
    Route::post('/pendaftaran-lomba', [PendaftaranLombaController::class, 'store'])->name('pendaftaran-lomba.store');
    Route::get('/status-pembayaran', [\App\Http\Controllers\SiswaController::class, 'daftarPembayaran'])->name('status-pembayaran');
});

// Proteksi untuk admin
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', function () {
        return view('dashboard.admin.dashboard');
    })->name('dashboard-admin');

    // CRUD lomba
    Route::get('/lomba', [LombaController::class, 'index'])->name('admin.lomba');
    Route::get('/lomba/create', [LombaController::class, 'create'])->name('admin.lomba.create');
    Route::post('/lomba', [LombaController::class, 'store'])->name('admin.lomba.store');
    Route::get('/lomba/{id}/edit', [LombaController::class, 'edit'])->name('admin.lomba.edit');
    Route::put('/lomba/{id}', [LombaController::class, 'update'])->name('admin.lomba.update');
    Route::delete('/lomba/{id}', [LombaController::class, 'destroy'])->name('admin.lomba.destroy');

    Route::get('/admin/pendaftaran-lomba', [\App\Http\Controllers\PendaftaranLombaController::class, 'index'])->name('admin.pendaftaran-lomba.index');
    Route::post('/admin/pendaftaran-lomba/{id}/confirm', [\App\Http\Controllers\PendaftaranLombaController::class, 'confirm'])->name('admin.pendaftaran-lomba.confirm');

    // CRUD soal
    Route::get('/soal/create', [SoalController::class, 'create'])->name('admin.soal.create');
    Route::post('/soal', [SoalController::class, 'store'])->name('admin.soal.store');
});
