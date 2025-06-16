<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\Jawaban;
use App\Models\JawabanSiswa;
use App\Models\Kuis;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuisSiswaController extends Controller
{
    public function mulai(Request $request, $kuisId)
    {
        $kuis = Kuis::with('soal.jawaban')->findOrFail($kuisId);
        $siswaId = Auth::user()->siswa->id;

        // Cek jika sudah pernah mengerjakan
        $sudah = JawabanSiswa::whereIn('soal_id', $kuis->soal->pluck('id'))
            ->where('siswa_id', $siswaId)->exists();
        if ($sudah) {
            return redirect()->route('siswa.kuis.hasil', $kuis->id);
        }

        // Soal ke (mulai dari 1)
        $no = $request->get('no', 1);
        $soal = $kuis->soal->skip($no - 1)->first();

        // Timer: waktu mulai simpan di session
        if (!session()->has("kuis_{$kuis->id}_start")) {
            session(["kuis_{$kuis->id}_start" => now()]);
        }
        $start = session("kuis_{$kuis->id}_start");
        $durasi = $kuis->durasi_kuis * 60; // detik
        $sisa = $durasi - now()->diffInSeconds($start);

        // Jika waktu habis, langsung ke hasil
        if ($sisa <= 0) {
            return redirect()->route('siswa.kuis.hasil', $kuis->id);
        }

        // Jika soal habis, ke hasil
        if (!$soal) {
            return redirect()->route('siswa.kuis.hasil', $kuis->id);
        }

        return view('siswa.kuis_siswa.kerjakan', compact('kuis', 'soal', 'no', 'sisa'));
    }

    public function jawab(Request $request, $kuisId)
    {
        $kuis = Kuis::with('soal.jawaban')->findOrFail($kuisId);
        $siswaId = Auth::user()->siswa->id;

        $request->validate([
            'soal_id' => 'required|exists:soal,id',
            'jawaban_id' => 'nullable|exists:jawaban,id', // <-- ubah required jadi nullable
            'no' => 'required|integer',
        ]);

        // Cek sudah pernah jawab soal ini
        $sudah = JawabanSiswa::where('siswa_id', $siswaId)
            ->where('soal_id', $request->soal_id)
            ->exists();
        if (!$sudah) {
            JawabanSiswa::create([
                'siswa_id' => $siswaId,
                'jawaban_id' => $request->jawaban_id, // bisa null
                'soal_id' => $request->soal_id,
            ]);
        }

        // Cek benar/salah
        $isBenar = false;
        if ($request->jawaban_id) {
            $jawaban = Jawaban::find($request->jawaban_id);
            $isBenar = $jawaban && $jawaban->is_benar;
        }

        // Jika soal terakhir atau waktu habis, ke hasil
        $nextNo = $request->no + 1;
        $totalSoal = $kuis->soal->count();
        $start = session("kuis_{$kuis->id}_start");
        $durasi = $kuis->durasi_kuis * 60;
        $sisa = $durasi - now()->diffInSeconds($start);

        if ($nextNo > $totalSoal || $sisa <= 0) {
            return response()->json([
                'selesai' => true,
                'redirect' => route('siswa.kuis.hasil', $kuis->id),
                'benar' => $isBenar,
            ]);
        }

        return response()->json([
            'selesai' => false,
            'next' => route('siswa.kuis.mulai', [$kuis->id, 'no' => $nextNo]),
            'benar' => $isBenar,
        ]);
    }

    public function hasil($kuisId)
    {
        $kuis = Kuis::with('soal.jawaban')->findOrFail($kuisId);
        $siswaId = Auth::user()->siswa->id;

        // Hitung nilai
        $jawabanSiswa = JawabanSiswa::whereIn('soal_id', $kuis->soal->pluck('id'))
            ->where('siswa_id', $siswaId)->get();

        $benar = 0;
        foreach ($jawabanSiswa as $js) {
            if ($js->jawaban && $js->jawaban->is_benar) {
                $benar++;
            }
        }
        $total = $kuis->soal->count();
        $nilai = $total > 0 ? round(($benar / $total) * 100) : 0;

        // Simpan nilai jika belum ada
        if (!Nilai::where('siswa_id', $siswaId)->where('kuis_id', $kuisId)->exists()) {
            Nilai::create([
                'siswa_id' => $siswaId,
                'kuis_id' => $kuisId,
                'nilai' => $nilai,
            ]);
        }

        // Hapus session timer
        session()->forget("kuis_{$kuis->id}_start");

        return view('siswa.kuis_siswa.hasil', compact('kuis', 'benar', 'total', 'nilai'));
    }


    public function riwayat($kuisId)
    {
        $kuis = Kuis::with('soal.jawaban')->findOrFail($kuisId);
        $siswaId = Auth::user()->siswa->id;

        $jawabanSiswa = JawabanSiswa::whereIn('soal_id', $kuis->soal->pluck('id'))
            ->where('siswa_id', $siswaId)
            ->get()
            ->keyBy('soal_id');

        return view('siswa.kuis_siswa.riwayat', compact('kuis', 'jawabanSiswa'));
    }

    public function ulang(Request $request, $kuisId)
    {
        $siswaId = Auth::user()->siswa->id;

        // Hapus jawaban siswa dan nilai untuk kuis ini
        $kuis = Kuis::with('soal')->findOrFail($kuisId);
        JawabanSiswa::whereIn('soal_id', $kuis->soal->pluck('id'))
            ->where('siswa_id', $siswaId)
            ->delete();
        Nilai::where('siswa_id', $siswaId)->where('kuis_id', $kuisId)->delete();

        // Hapus session timer jika ada
        session()->forget("kuis_{$kuis->id}_start");

        return redirect()->route('siswa.kuis.mulai', $kuisId);
    }
}
