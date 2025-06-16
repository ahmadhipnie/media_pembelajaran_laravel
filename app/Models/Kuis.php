<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    use HasFactory;

    protected $table = 'kuis';

    protected $fillable = [
        'nama_kuis',
        'durasi_kuis',
        'konten_id',
    ];

    // Relasi ke model Konten
    public function konten()
    {
        return $this->belongsTo(Konten::class);
    }

    public function soal()
    {
        return $this->hasMany(Soal::class, 'kuis_id');
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'kuis_id');
    }
}
