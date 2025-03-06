<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurasiToLombaTable extends Migration
{
    public function up(): void
    {
        Schema::table('lomba', function (Blueprint $table) {
            $table->integer('durasi')->default(60)->comment('Durasi lomba dalam menit');
        });
    }

    public function down(): void
    {
        Schema::table('lomba', function (Blueprint $table) {
            $table->dropColumn('durasi');
        });
    }
}
