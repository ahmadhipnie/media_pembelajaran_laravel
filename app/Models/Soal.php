<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soal';

    protected $fillable = [
        'pertanyaan',
        'url_video_soal',
        'url_gambar_soal',
        'kuis_id',
    ];

    // Relasi ke model Kuis
    public function kuis()
    {
        return $this->belongsTo(Kuis::class);
    }
    // Relasi ke model Jawaban
    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'id_soal');
    }
}
