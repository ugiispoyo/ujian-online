<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;

    protected $fillable = ['id_lomba', 'id_room', 'id_siswa', 'nilai'];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba');
    }

    public function roomTes()
    {
        return $this->belongsTo(RoomTes::class, 'id_room');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'id_siswa');
    }
}
