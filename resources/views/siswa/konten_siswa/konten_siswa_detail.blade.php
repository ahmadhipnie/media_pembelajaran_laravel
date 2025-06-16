{{-- filepath: resources/views/siswa/konten_siswa/konten_siswa_detail.blade.php --}}
@extends('siswa.layout.sidebar')

@section('title', 'Detail Konten')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="mb-3">{{ $konten->judul_konten }}</h4>
            <div class="mb-3 d-flex justify-content-center">
                <iframe width="560" height="315" src="{{ $konten->video_konten }}" frameborder="0"
                    allowfullscreen></iframe>
            </div>
            <div class="mb-3">
                {!! $konten->isi_konten !!}
            </div>
            <div>
                <iframe src="{{ $konten->ppt_konten }}" width="100%" height="400" frameborder="0"
                    allowfullscreen></iframe>
            </div>

            {{-- Tampilkan Kuis yang Berelasi dalam bentuk card horizontal --}}
            @if ($konten->kuis->count())
                <hr>
                <h5 class="mt-4">Daftar Kuis Terkait:</h5>
                <div class="row">
                    @foreach ($konten->kuis as $kuis)
                        <div class="col-12 mb-3">
                            <div class="card flex-row align-items-center">
                                <div class="card-body d-flex align-items-center">
                                    <div style="min-width: 60px;">
                                        <i class="fas fa-question-circle fa-2x text-primary"></i>
                                    </div>
                                    <div class="ml-4 flex-grow-1">
                                        <h6 class="mb-1">{{ $kuis->nama_kuis }}</h6>
                                        <div class="mb-1 text-muted">Durasi: {{ $kuis->durasi_kuis }} menit</div>
                                        <a href="{{ route('siswa.kuis.mulai', $kuis->id) }}" class="btn btn-sm btn-primary">Kerjakan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <a href="{{ route('siswa.konten.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
@endsection
