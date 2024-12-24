<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranLombaTable extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_lomba', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_lomba'); // Ubah menjadi UUID
            $table->unsignedBigInteger('id_siswa'); // Tetap sebagai unsignedBigInteger
            $table->string('bukti_transfer')->nullable();
            $table->date('tanggal_transfer')->nullable();
            $table->enum('status', ['verified', 'unverified', 'rejected'])->default('unverified');
            $table->timestamps();

            // Relasi dengan tabel lomba dan users (siswa)
            $table->foreign('id_lomba')->references('id')->on('lomba')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_lomba');
    }
}
