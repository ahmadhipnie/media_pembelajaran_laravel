<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $table = 'jawaban';

    protected $fillable = [
        'jawaban',
        'id_soal',
        'is_benar',
    ];

    // Relasi ke model Soal
    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal');
    }
}
