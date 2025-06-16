{{-- filepath: resources/views/guru/konten_guru/konten_guru.blade.php --}}
@extends('guru.layout.sidebar')

@section('title', 'Konten')

@section('content')
    <a href="{{ route('guru.konten.create') }}" class="btn btn-primary mb-3">Tambah Konten</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Isi</th>
                <th>Video</th>
                <th>PPT</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($konten as $item)
                <tr>
                    <td>{{ $item->judul_konten }}</td>
                    <td>{{ $item->kategori_konten }}</td>
                    <td>{!! Str::limit(strip_tags($item->isi_konten), 20) !!}</td>
                    <td>
                        <iframe width="200" height="113" src="{{ $item->video_konten }}" frameborder="0" allowfullscreen></iframe>
                    </td>
                    <td>
                        <iframe src="{{ $item->ppt_konten }}" width="200" height="113" frameborder="0" allowfullscreen></iframe>
                    </td>
                    <td>
                        <a href="{{ route('guru.konten.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('guru.konten.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus konten ini?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
