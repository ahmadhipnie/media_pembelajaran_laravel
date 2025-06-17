<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\Jawaban;
use App\Models\JawabanSiswa;
use App\Models\Kuis;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class KuisSiswaController extends Controller
{
    public function mulai(Request $request, $kuisId)
    {
        $kuis = Kuis::with(['soal' => function($q) {
            $q->orderBy('id');
        }, 'soal.jawaban'])->findOrFail($kuisId);

        $siswaId = Auth::user()->siswa->id;

        $soalIds = $kuis->soal->pluck('id');
        $jumlahJawaban = JawabanSiswa::whereIn('soal_id', $soalIds)
            ->where('siswa_id', $siswaId)
            ->count();

        if ($jumlahJawaban >= $kuis->soal->count()) {
            return redirect()->route('siswa.kuis.hasil', $kuis->id);
        }

        $no = (int)$request->get('no', 1);
        $soal = $kuis->soal->skip($no - 1)->first();

        if (!session()->has("kuis_{$kuis->id}_start")) {
            session(["kuis_{$kuis->id}_start" => now()]);
        }
        $start = session("kuis_{$kuis->id}_start");
        $durasi = $kuis->durasi_kuis * 60;
        $sisa = $durasi - now()->diffInSeconds($start);

        if ($sisa <= 0) {
            return redirect()->route('siswa.kuis.hasil', $kuis->id);
        }

        if (!$soal) {
            return redirect()->route('siswa.kuis.hasil', $kuis->id);
        }

        Alert::info('Kuis Dimulai', 'Silakan kerjakan soal berikut.');
        return view('siswa.kuis_siswa.kerjakan', compact('kuis', 'soal', 'no', 'sisa'));
    }

    public function submitJawaban(Request $request, $kuisId)
    {
        $kuis = Kuis::with(['soal' => function($q) {
            $q->orderBy('id');
        }, 'soal.jawaban'])->findOrFail($kuisId);

        $siswaId = Auth::user()->siswa->id;

        $request->validate([
            'soal_id' => 'required|exists:soal,id',
            'jawaban_id' => 'nullable|exists:jawaban,id',
            'no' => 'required|integer',
        ]);

        // Hindari jawaban ganda
        $sudah = JawabanSiswa::where('siswa_id', $siswaId)
            ->where('soal_id', $request->soal_id)
            ->exists();

        if (!$sudah) {
            JawabanSiswa::create([
                'siswa_id' => $siswaId,
                'jawaban_id' => $request->jawaban_id,
                'soal_id' => $request->soal_id,
            ]);
        }

        $nextNo = $request->no + 1;
        $totalSoal = $kuis->soal->count();

        $start = session("kuis_{$kuis->id}_start");
        $durasi = $kuis->durasi_kuis * 60;
        $sisa = $durasi - now()->diffInSeconds($start);

        if ($nextNo > $totalSoal || $sisa <= 0) {
            return response()->json([
                'selesai' => true,
                'redirect' => route('siswa.kuis.hasil', $kuis->id),
            ]);
        }

        return response()->json([
            'selesai' => false,
            'next' => route('siswa.kuis.mulai', [$kuis->id, 'no' => $nextNo]),
        ]);
    }

    public function cekJawaban(Request $request, $kuisId)
    {
        $request->validate([
            'jawaban_id' => 'required|exists:jawaban,id',
        ]);

        $jawaban = Jawaban::find($request->jawaban_id);


        // Alert::image('Image Title!','Image Description','Image URL','Image Width','Image Height', 'Image Alt');


        return response()->json([
            'benar' => $jawaban->is_benar ? true : false,
        ]);
    }

    public function hasil($kuisId)
    {
        $kuis = Kuis::with(['soal.jawaban'])->findOrFail($kuisId);
        $siswaId = Auth::user()->siswa->id;

        $jawabanSiswa = JawabanSiswa::whereIn('soal_id', $kuis->soal->pluck('id'))
            ->where('siswa_id', $siswaId)->get();

        $benar = $jawabanSiswa->filter(function ($jawab) {
            return $jawab->jawaban && $jawab->jawaban->is_benar;
        })->count();

        $total = $kuis->soal->count();
        $nilai = $total > 0 ? round(($benar / $total) * 100) : 0;

        Nilai::updateOrCreate(
            ['siswa_id' => $siswaId, 'kuis_id' => $kuisId],
            ['nilai' => $nilai]
        );

        session()->forget("kuis_{$kuis->id}_start");

        return view('siswa.kuis_siswa.hasil', compact('kuis', 'benar', 'total', 'nilai'));
    }

    public function ulang(Request $request, $kuisId)
    {
        $siswaId = Auth::user()->siswa->id;

        $kuis = Kuis::with('soal')->findOrFail($kuisId);
        JawabanSiswa::whereIn('soal_id', $kuis->soal->pluck('id'))
            ->where('siswa_id', $siswaId)
            ->delete();

        Nilai::where('siswa_id', $siswaId)->where('kuis_id', $kuisId)->delete();
        session()->forget("kuis_{$kuis->id}_start");

        return redirect()->route('siswa.kuis.mulai', $kuisId);
    }

    public function riwayat($kuisId)
    {
        $kuis = Kuis::with(['soal.jawaban'])->findOrFail($kuisId);
        $siswaId = Auth::user()->siswa->id;

        $jawabanSiswa = JawabanSiswa::whereIn('soal_id', $kuis->soal->pluck('id'))
            ->where('siswa_id', $siswaId)
            ->get()
            ->keyBy('soal_id');

        return view('siswa.kuis_siswa.riwayat', compact('kuis', 'jawabanSiswa'));
    }
}
