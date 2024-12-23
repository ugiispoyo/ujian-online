<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaPendaftaranToLombaTable extends Migration
{
    public function up(): void
    {
        Schema::table('lomba', function (Blueprint $table) {
            $table->decimal('harga_pendaftaran', 10, 2)->default(0)->after('gambar');
        });
    }

    public function down(): void
    {
        Schema::table('lomba', function (Blueprint $table) {
            $table->dropColumn('harga_pendaftaran');
        });
    }
}
