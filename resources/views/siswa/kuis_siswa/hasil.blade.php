{{-- filepath: resources/views/siswa/kuis_siswa/hasil.blade.php --}}
@extends('siswa.layout.sidebar')

@section('title', 'Hasil Kuis')

@section('content')
<div class="card mb-4">
    <div class="card-body text-center">
        <h4 class="mb-3">Hasil Kuis: {{ $kuis->nama_kuis }}</h4>
        <h5>Nilai Anda: <span class="badge badge-success" style="font-size:1.5em;">{{ $nilai }}</span></h5>
        <p>Jawaban Benar: {{ $benar }} dari {{ $total }} soal</p>
        <a href="{{ route('siswa.kuis.riwayat', $kuis->id) }}" class="btn btn-info mt-3">Lihat Riwayat Jawaban</a>
        <form action="{{ route('siswa.kuis.ulang', $kuis->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning mt-3" onclick="return confirm('apakah anda yakin untuk mengerjakan ulang?. Lanjutkan?')">Kerjakan Ulang</button>
        </form>
        <a href="{{ route('siswa.konten.show', $kuis->konten_id) }}" class="btn btn-secondary mt-3">Kembali ke Konten</a>
    </div>
</div>
@endsection
