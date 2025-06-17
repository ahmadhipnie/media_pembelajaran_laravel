<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiGuruController extends Controller
{
    public function index()
    {
        $nilai = Nilai::with(['siswa', 'kuis'])->get();
        return view('guru.nilai_guru.nilai_guru', compact('nilai'));
    }
}
