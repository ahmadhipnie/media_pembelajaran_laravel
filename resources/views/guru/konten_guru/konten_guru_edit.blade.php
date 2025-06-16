{{-- filepath: resources/views/guru/konten_guru/edit.blade.php --}}
@extends('guru.layout.sidebar')

@section('title', 'Edit Konten')

@section('content')
    <form action="{{ route('guru.konten.update', $konten->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Judul Konten</label>
            <input type="text" name="judul_konten" value="{{ $konten->judul_konten }}" class="form-control" required>
            @error('judul_konten')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Kategori Konten</label>
            <input type="text" name="kategori_konten" value="{{ $konten->kategori_konten }}" class="form-control"
                required>
            @error('kategori_konten')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Isi Konten</label>
            <textarea name="isi_konten" id="summernote" class="form-control" required>{{ $konten->isi_konten }}</textarea>
            @error('isi_konten')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>URL Embed Video (YouTube)</label>
            <input type="url" name="video_konten" value="{{ $konten->video_konten }}" class="form-control" required>
            @error('video_konten')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>URL Embed PPT (Google Slide)</label>
            <input type="url" name="ppt_konten" value="{{ $konten->ppt_konten }}" class="form-control" required>
            @error('ppt_konten')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('guru.konten.index') }}" class="btn btn-secondary">Kembali</a>
    </form>


    <script>
        $('#summernote').summernote({
            placeholder: 'isi konten di sini...',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
@endsection
