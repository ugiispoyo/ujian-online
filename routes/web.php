<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman dashboard (dengan proteksi middleware auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard'); // Redirect ke dashboard
    });

    Route::get('/dashboard', function () {
        return view('dashboard/dashboard');
    })->name('dashboard');

    Route::get('/daftar-lomba', function () {
        return view('dashboard/daftar-lomba');
    })->name('daftar-lomba');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Halaman login dan register (tanpa proteksi)
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
