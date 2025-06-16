@extends('siswa.layout.sidebar')

@section('title', 'Riwayat Jawaban Kuis')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="mb-3">Riwayat Jawaban: {{ $kuis->nama_kuis }}</h4>
        @foreach($kuis->soal as $no => $soal)
            <div class="mb-4">
                <b>Soal {{ $no+1 }}:</b> {{ $soal->pertanyaan }}
                <ul class="mt-2">
                    @foreach($soal->jawaban as $jawaban)
                        <li
                            @if(isset($jawabanSiswa[$soal->id]) && $jawabanSiswa[$soal->id]->jawaban_id == $jawaban->id)
                                style="font-weight:bold; color:{{ $jawaban->is_benar ? 'green' : 'red' }}"
                            @elseif($jawaban->is_benar)
                                style="color:green"
                            @endif
                        >
                            {{ $jawaban->jawaban }}
                            @if($jawaban->is_benar)
                                <span class="badge badge-success">Kunci</span>
                            @endif
                            @if(isset($jawabanSiswa[$soal->id]) && $jawabanSiswa[$soal->id]->jawaban_id == $jawaban->id)
                                <span class="badge badge-info">Jawaban Anda</span>
                            @endif
                        </li>
                    @endforeach
                    @if(!isset($jawabanSiswa[$soal->id]))
                        <li class="text-danger"><i>Anda tidak menjawab soal ini.</i></li>
                    @endif
                </ul>
            </div>
        @endforeach
        <a href="{{ route('siswa.kuis.hasil', $kuis->id) }}" class="btn btn-secondary">Kembali ke Hasil</a>
    </div>
</div>
@endsection
