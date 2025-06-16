<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Konten;
use App\Models\Kuis;
use Illuminate\Http\Request;

class KuisGuruController extends Controller
{
    public function index()
    {
        $kuis = Kuis::with(['konten', 'soal', 'nilai'])->get();
        $konten = Konten::all();
        return view('guru.kuis_guru.kuis_guru', compact('kuis', 'konten'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kuis' => 'required',
            'durasi_kuis' => 'required|integer|min:1',
            'konten_id' => 'required|exists:konten,id',
        ]);

        Kuis::create($request->all());

        return redirect()->route('guru.kuis.index')->with('success', 'Kuis berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kuis = Kuis::findOrFail($id);

        $request->validate([
            'nama_kuis' => 'required',
            'durasi_kuis' => 'required|integer|min:1',
            'konten_id' => 'required|exists:konten,id',
        ]);

        $kuis->update($request->all());

        return redirect()->route('guru.kuis.index')->with('success', 'Kuis berhasil diubah');
    }

    public function destroy($id)
    {
        $kuis = Kuis::with(['soal', 'nilai'])->findOrFail($id);

        if ($kuis->soal()->count() > 0 || $kuis->nilai()->count() > 0) {
            return redirect()->route('guru.kuis.index')
                ->with('error', 'Mohon hapus soal dan nilai pada kuis "' . $kuis->nama_kuis . '" terlebih dahulu.');
        }

        $kuis->delete();
        return redirect()->route('guru.kuis.index')->with('success', 'Kuis berhasil dihapus');
    }
}
