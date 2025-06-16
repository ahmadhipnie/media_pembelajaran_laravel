@extends('siswa.layout.sidebar')

@section('title', 'Konten Siswa')

@section('content')
<div class="row">
    @foreach($konten as $item)
        <div class="col-12 mb-4">
            <div class="card flex-row">
                <div class="card-body d-flex align-items-center">
                    <div style="width: 200px; min-width:200px;">
                        <iframe width="200" height="113" src="{{ $item->video_konten }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="ml-4 flex-grow-1">
                        <h5 class="card-title">{{ $item->judul_konten }}</h5>
                        <p class="card-text mb-1"><b>Kategori:</b> {{ $item->kategori_konten }}</p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit(strip_tags($item->isi_konten), 100) }}</p>
                        <a href="{{ route('siswa.konten.show', $item->id) }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection


