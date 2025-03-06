<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable(); // Nullable
            $table->date('tanggal_lahir')->nullable(); // Nullable
            $table->text('alamat')->nullable(); // Nullable
            $table->string('sekolah')->nullable(); // Nullable
            $table->string('kelas')->nullable(); // Nullable
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin',
                'tanggal_lahir',
                'alamat',
                'sekolah',
                'kelas'
            ]);
        });
    }
};
