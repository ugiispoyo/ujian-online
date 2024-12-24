<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('soal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_lomba');
            $table->json('soal');
            $table->timestamps();

            $table->foreign('id_lomba')->references('id')->on('lomba')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soal');
    }
};
