<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\UploadController;

Route::prefix('soal')->group(function () {
    Route::post('/store', [SoalController::class, 'store'])->name('api.soal.store');
    Route::get('/{id_lomba}', [SoalController::class, 'getByLomba'])->name('api.soal.get');

    Route::post('/upload-image', [UploadController::class, 'uploadImage']);
});