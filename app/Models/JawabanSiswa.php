<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    use HasFactory;

    protected $table = 'jawaban_siswa';

    protected $fillable = [
        'siswa_id',
        'jawaban_id',
        'soal_id',
    ];

    // Relasi ke model Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke model Jawaban
    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class);
    }

    // Relasi ke model Soal
    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
