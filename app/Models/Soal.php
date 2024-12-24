<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soal';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'id_lomba',
        'soal',
    ];

    protected $casts = [
        'soal' => 'array',
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

    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba');
    }
}
