<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Jawaban;
use App\Models\Kuis;
use App\Models\Soal;
use Illuminate\Http\Request;

class SoalGuruController extends Controller
{
    public function index($kuisId)
    {
        $kuis = Kuis::findOrFail($kuisId);
        $soal = Soal::with('jawaban')->where('kuis_id', $kuisId)->get();
        return view('guru.soal_guru.soal_guru', compact('kuis', 'soal'));
    }

    public function store(Request $request, $kuisId)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'url_video_soal' => 'nullable|url',
            'url_gambar_soal' => 'nullable|url',
        ]);

        Soal::create([
            'pertanyaan' => $request->pertanyaan,
            'url_video_soal' => $request->url_video_soal,
            'url_gambar_soal' => $request->url_gambar_soal,
            'kuis_id' => $kuisId,
        ]);

        return back()->with('success', 'Soal berhasil ditambahkan');
    }

    public function update(Request $request, $kuisId, $soalId)
    {
        $soal = Soal::findOrFail($soalId);
        $request->validate([
            'pertanyaan' => 'required',
            'url_video_soal' => 'nullable|url',
            'url_gambar_soal' => 'nullable|url',
        ]);
        $soal->update($request->only('pertanyaan', 'url_video_soal', 'url_gambar_soal'));
        return back()->with('success', 'Soal berhasil diubah');
    }

    public function destroy($kuisId, $soalId)
    {
        $soal = Soal::findOrFail($soalId);
        $soal->delete();
        return back()->with('success', 'Soal berhasil dihapus');
    }

    // Jawaban
    public function storeJawaban(Request $request, $kuisId, $soalId)
    {
        $request->validate([
            'jawaban' => 'required',
            'is_benar' => 'nullable|boolean',
        ]);
        Jawaban::create([
            'jawaban' => $request->jawaban,
            'id_soal' => $soalId,
            'is_benar' => $request->is_benar ? 1 : 0,
        ]);
        return back()->with('success', 'Jawaban berhasil ditambahkan');
    }

    public function updateJawaban(Request $request, $kuisId, $soalId, $jawabanId)
    {
        $jawaban = Jawaban::findOrFail($jawabanId);
        $request->validate([
            'jawaban' => 'required',
            'is_benar' => 'nullable|boolean',
        ]);
        $jawaban->update([
            'jawaban' => $request->jawaban,
            'is_benar' => $request->is_benar ? 1 : 0,
        ]);
        return back()->with('success', 'Jawaban berhasil diubah');
    }

    public function destroyJawaban($kuisId, $soalId, $jawabanId)
    {
        $jawaban = Jawaban::findOrFail($jawabanId);
        $jawaban->delete();
        return back()->with('success', 'Jawaban berhasil dihapus');
    }
}
