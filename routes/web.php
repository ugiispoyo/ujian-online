<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranLombaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\RoomTesController;
use App\Http\Controllers\UjianController;

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::post('/auth/google/check-email', [AuthController::class, 'checkEmailExists'])->name('google.check-email');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:web', 'App\Http\Middleware\AuthenticateRole:web'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');

    Route::get('/edit-profile', [\App\Http\Controllers\SiswaController::class, 'edit'])->name('edit-profile');
    Route::post('/edit-profile', [\App\Http\Controllers\SiswaController::class, 'update'])->name('update-profile');

    // Halaman daftar lomba untuk siswa
    Route::get('/daftar-lomba', [\App\Http\Controllers\LombaSiswaController::class, 'index'])->name('daftar-lomba');
    Route::get('/pendaftaran-lomba/{id}', [PendaftaranLombaController::class, 'create'])->name('pendaftaran-lomba.create');
    Route::post('/pendaftaran-lomba', [PendaftaranLombaController::class, 'store'])->name('pendaftaran-lomba.store');
    Route::get('/status-pembayaran', [\App\Http\Controllers\SiswaController::class, 'daftarPembayaran'])->name('status-pembayaran');

    Route::get('/events', [\App\Http\Controllers\LombaSiswaController::class, 'list'])->name('events-siswa');

    Route::post('/lomba/{id}/start', [RoomTesController::class, 'startTest'])->name('lomba.start');
    Route::get('/room-tes/{id}', [RoomTesController::class, 'show'])->name('room.tes.show');

    Route::get('/ujian-selesai/{id}', [UjianController::class, 'ujianSelesai'])->name('ujian.selesai');

    Route::get('/lomba/{id}/detail', [\App\Http\Controllers\LombaSiswaController::class, 'detail'])->name('lomba.detail');

    Route::get('/lomba/sertifikat/{id}/download', [\App\Http\Controllers\LombaSiswaController::class, 'downloadSertifikat'])->name('lomba.download.sertifikat');
});

Route::middleware(['auth:admin', 'App\Http\Middleware\AuthenticateRole:admin'])->prefix("admin")->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.admin.dashboard');
    })->name('dashboard-admin');

    // Lomba
    Route::get('/lomba', [LombaController::class, 'index'])->name('admin.lomba');
    Route::get('/lomba/create', [LombaController::class, 'create'])->name('admin.lomba.create');
    Route::post('/lomba', [LombaController::class, 'store'])->name('admin.lomba.store');
    Route::get('/lomba/{id}/edit', [LombaController::class, 'edit'])->name('admin.lomba.edit');
    Route::put('/lomba/{id}', [LombaController::class, 'update'])->name('admin.lomba.update');
    Route::delete('/lomba/{id}', [LombaController::class, 'destroy'])->name('admin.lomba.destroy');
    Route::put('/lomba/{id}/start', [LombaController::class, 'startLomba'])->name('admin.lomba.start');
    Route::put('/lomba/{id}/complete', [LombaController::class, 'complete'])->name('admin.lomba.complete');
    Route::get('/lomba/{id}/detail', [LombaController::class, 'detail'])->name('admin.lomba.detail');

    // Monitoring Lomba
    Route::get('/lomba/{id}/monitoring', [LombaController::class, 'monitoring'])->name('admin.lomba.monitoring');

    // Pendaftaran Lomba
    Route::get('/admin/pendaftaran-lomba', [\App\Http\Controllers\PendaftaranLombaController::class, 'index'])->name('admin.pendaftaran-lomba.index');
    Route::post('/admin/pendaftaran-lomba/{id}/confirm', [\App\Http\Controllers\PendaftaranLombaController::class, 'confirm'])->name('admin.pendaftaran-lomba.confirm');

    // Soal
    Route::get('/soal/create', [SoalController::class, 'create'])->name('admin.soal.create');
    Route::post('/soal', [SoalController::class, 'store'])->name('admin.soal.store');
    Route::get('/soal', [SoalController::class, 'index'])->name('admin.soal.index');
    Route::get('/soal/edit', [SoalController::class, 'edit'])->name('admin.soal.edit');

    Route::post('/lomba/{id}/generate-sertifikat', [LombaController::class, 'generateSertifikat'])->name('admin.lomba.generate.sertifikat');
});
