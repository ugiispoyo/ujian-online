<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lomba extends Model
{
    use HasFactory;

    protected $table = 'lomba';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama_lomba',
        'deskripsi',
        'gambar',
        'waktu_lomba',
        'harga_pendaftaran',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relasi dengan tabel pendaftaran_lomba
    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranLomba::class, 'id_lomba');
    }
}
