{{-- filepath: resources/views/admin/guru_admin/index.blade.php --}}
@extends('admin.layout.sidebar')

@section('title', 'Manajemen Guru')

@section('content')
    <a href="{{ route('admin.guru.create') }}" class="btn btn-primary mb-3">Tambah Guru</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telp</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guru as $item)
                <tr>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->nama_guru }}</td>
                    <td>{{ $item->user->email }}</td>
                    <td>{{ $item->no_telp }}</td>
                    <td>{{ ucfirst($item->jenis_kelamin) }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>
                        <a href="{{ route('admin.guru.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.guru.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection


