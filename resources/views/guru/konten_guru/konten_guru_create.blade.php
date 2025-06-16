{{-- filepath: resources/views/guru/konten_guru/create.blade.php --}}
@extends('guru.layout.sidebar')

@section('title', 'Tambah Konten')

@section('content')
    <form action="{{ route('guru.konten.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Judul Konten</label>
            <input type="text" name="judul_konten" class="form-control" required>
            @error('judul_konten') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Kategori Konten</label>
            <input type="text" name="kategori_konten" class="form-control" required>
            @error('kategori_konten') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Isi Konten</label>
            <textarea name="isi_konten" id="summernote" class="form-control" required></textarea>
            @error('isi_konten') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>URL Embed Video (YouTube)</label>
            <input type="url" name="video_konten" class="form-control" required placeholder="https://www.youtube.com/embed/xxxx">
            @error('video_konten') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>URL Embed PPT (Google Slide)</label>
            <input type="url" name="ppt_konten" class="form-control" required placeholder="https://docs.google.com/presentation/d/e/xxx/embed">
            @error('ppt_konten') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
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
