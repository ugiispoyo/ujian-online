<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lomba;
use App\Models\User;

class RoomTes extends Model
{
    use HasFactory;

    protected $table = 'room_tes';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_lomba',
        'id_siswa',
        'nama_room',
        'waktu_selesai',
        'durasi',
        'peserta',
        'status',
        'soal_terjawab',
        'nilai'
    ];

    protected $casts = [
        'peserta' => 'array',
        'soal_terjawab' => 'array',
        'waktu_selesai' => 'datetime'
    ];

    // Relasi ke tabel Lomba
    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba', 'id');
    }

    // Relasi ke tabel Users (Siswa/Peserta)
    public function siswa()
    {
        return $this->belongsTo(User::class, 'id_siswa', 'id');
    }

    // Atribut akses untuk mendapatkan waktu_mulai dari lomba
    public function getWaktuMulaiAttribute()
    {
        return $this->lomba ? $this->lomba->waktu_lomba : null;
    }
}
