<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Konten;
use Illuminate\Http\Request;

class KontenGuruController extends Controller
{
     public function index()
    {
        $konten = Konten::all();
        return view('guru.konten_guru.konten_guru', compact('konten'));
    }

    public function create()
    {
        return view('guru.konten_guru.konten_guru_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_konten' => 'required',
            'kategori_konten' => 'required',
            'isi_konten' => 'required',
            'video_konten' => 'required|url',
            'ppt_konten' => 'required|url',
        ]);

        Konten::create($request->all());

        return redirect()->route('guru.konten.index')->with('success', 'Konten berhasil ditambahkan');
    }

    public function edit($id)
    {
        $konten = Konten::findOrFail($id);
        return view('guru.konten_guru.konten_guru_edit', compact('konten'));
    }

    public function update(Request $request, $id)
    {
        $konten = Konten::findOrFail($id);

        $request->validate([
            'judul_konten' => 'required',
            'kategori_konten' => 'required',
            'isi_konten' => 'required',
            'video_konten' => 'required|url',
            'ppt_konten' => 'required|url',
        ]);

        $konten->update($request->all());

        return redirect()->route('guru.konten.index')->with('success', 'Konten berhasil diubah');
    }

    public function destroy($id)
    {
        $konten = Konten::findOrFail($id);
        $kuisCount = $konten->has('kuis') ? $konten->kuis()->count() : 0;

        if ($kuisCount > 0) {
            return redirect()->route('guru.konten.index')
                ->with('error', 'Mohon hapus kuis yang terkait dengan konten "' . $konten->judul_konten . '" terlebih dahulu.');
        }

        $konten->delete();
        return redirect()->route('guru.konten.index')->with('success', 'Konten berhasil dihapus');
    }
}
