@extends('admin.layout.sidebar')

@section('title', 'Edit Siswa')

@section('content')
    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $siswa->user->email }}" class="form-control" required>
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Password (isi jika ingin diubah)</label>
            <input type="password" name="password" class="form-control">
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>NISN</label>
            <input type="text" name="nisn" value="{{ $siswa->nisn }}" class="form-control" required>
            @error('nisn') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Nama Siswa</label>
            <input type="text" name="nama_siswa" value="{{ $siswa->nama_siswa }}" class="form-control" required>
            @error('nama_siswa') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ $siswa->alamat }}</textarea>
            @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="pria" {{ $siswa->jenis_kelamin == 'pria' ? 'selected' : '' }}>Pria</option>
                <option value="wanita" {{ $siswa->jenis_kelamin == 'wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
            @error('jenis_kelamin') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <select name="kelas_id" class="form-control" required>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
            @error('kelas_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection


