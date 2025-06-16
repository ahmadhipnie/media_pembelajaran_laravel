<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\Konten;
use Illuminate\Http\Request;

class KontenSiswaController extends Controller
{
    public function index()
    {
        $konten = Konten::all();
        return view('siswa.konten_siswa.konten_siswa', compact('konten'));
    }

    public function show($id)
    {
        $konten = Konten::findOrFail($id);
        return view('siswa.konten_siswa.konten_siswa_detail', compact('konten'));
    }
}
