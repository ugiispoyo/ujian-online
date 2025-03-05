<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\RoomTesController;

Route::prefix('soal')->group(function () {
    Route::post('/store', [SoalController::class, 'store'])->name('api.soal.store');
    Route::get('/{id_lomba}', [SoalController::class, 'getByLomba'])->name('api.soal.get');
    Route::post('/delete-soal', [SoalController::class, 'deleteSoal'])->name('api.soal.delete_soal');

    Route::post('/upload-image', [UploadController::class, 'uploadImage']);
});

Route::get('/room-tes/{id}', [RoomTesController::class, 'getSoal'])->name('api.room-tes.getSoal');
Route::post('/room-tes/{id}/update-jawaban', [RoomTesController::class, 'updateJawaban']);