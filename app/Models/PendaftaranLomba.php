<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranLomba extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_lomba';

    protected $fillable = [
        'id_lomba',
        'id_siswa',
        'bukti_transfer',
        'tanggal_transfer',
        'status',
    ];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'id_siswa');
    }
}
