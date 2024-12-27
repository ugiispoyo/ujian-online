<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToLombaTable extends Migration
{
    public function up()
    {
        Schema::table('lomba', function (Blueprint $table) {
            $table->enum('status', ['not_started', 'in_progress', 'completed'])
                  ->default('not_started')
                  ->after('nama_lomba'); // Tambahkan kolom setelah nama_lomba
        });
    }

    public function down()
    {
        Schema::table('lomba', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
