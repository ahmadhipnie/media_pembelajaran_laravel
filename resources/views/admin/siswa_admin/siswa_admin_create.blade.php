@extends('admin.layout.sidebar')

@section('title', 'Tambah Siswa')

@section('content')
    <form action="{{ route('admin.siswa.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>NISN</label>
            <input type="text" name="nisn" class="form-control" required>
            @error('nisn') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Nama Siswa</label>
            <input type="text" name="nama_siswa" class="form-control" required>
            @error('nama_siswa') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
            @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">Pilih</option>
                <option value="pria">Pria</option>
                <option value="wanita">Wanita</option>
            </select>
            @error('jenis_kelamin') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <select name="kelas_id" class="form-control" required>
                <option value="">Pilih</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
            @error('kelas_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection


