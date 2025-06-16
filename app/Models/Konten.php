<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    use HasFactory;

    protected $table = 'konten';

    protected $fillable = [
        'judul_konten',
        'kategori_konten',
        'isi_konten',
        'video_konten',
        'ppt_konten',
    ];

    public function kuis()
    {
        return $this->hasMany(\App\Models\Kuis::class, 'konten_id');
    }
}
