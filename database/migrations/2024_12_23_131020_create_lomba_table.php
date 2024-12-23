<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLombaTable extends Migration
{
    public function up(): void
    {
        Schema::create('lomba', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_lomba');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->timestamp('waktu_lomba');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lomba');
    }
}
