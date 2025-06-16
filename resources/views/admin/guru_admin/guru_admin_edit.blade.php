{{-- filepath: resources/views/admin/guru_admin/edit.blade.php --}}
@extends('admin.layout.sidebar')

@section('title', 'Edit Guru')

@section('content')
    <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $guru->user->email }}" class="form-control" required>
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Password (isi jika ingin diubah)</label>
            <input type="password" name="password" class="form-control">
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>NIP</label>
            <input type="text" name="nip" value="{{ $guru->nip }}" class="form-control" required>
            @error('nip') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Nama Guru</label>
            <input type="text" name="nama_guru" value="{{ $guru->nama_guru }}" class="form-control" required>
            @error('nama_guru') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>No Telp</label>
            <input type="text" name="no_telp" value="{{ $guru->no_telp }}" class="form-control" required>
            @error('no_telp') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ $guru->alamat }}</textarea>
            @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="pria" {{ $guru->jenis_kelamin == 'pria' ? 'selected' : '' }}>Pria</option>
                <option value="wanita" {{ $guru->jenis_kelamin == 'wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
            @error('jenis_kelamin') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection


