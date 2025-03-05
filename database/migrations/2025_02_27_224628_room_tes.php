<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_tes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_lomba');
            
            // Ganti uuid menjadi unsignedBigInteger jika id pada tabel users adalah bigint
            $table->unsignedBigInteger('id_siswa'); 
            
            $table->string('nama_room');
            $table->timestamp('waktu_selesai')->nullable();
            $table->integer('durasi')->comment('Durasi dalam menit');
            $table->json('peserta')->nullable(); 
            $table->enum('status', ['draft', 'selesai'])->default('draft'); 
            $table->json('soal_terjawab')->nullable(); 
            $table->integer('nilai')->nullable()->default(0);
            $table->timestamps();

            // Relasi ke tabel lomba
            $table->foreign('id_lomba')->references('id')->on('lomba')->onDelete('cascade');

            // Relasi ke tabel users (sebagai siswa/peserta)
            $table->foreign('id_siswa')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_tes');
    }
};
