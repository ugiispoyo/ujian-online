<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_lomba');
            $table->uuid('id_room');
            $table->uuid('id_siswa');
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sertifikats');
    }
};
