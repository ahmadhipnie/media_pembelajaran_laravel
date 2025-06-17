{{-- filepath: resources/views/guru/nilai_guru/nilai_guru.blade.php --}}
@extends('guru.layout.sidebar')

@section('title', 'Nilai Siswa')

@section('content')
    <h4 class="mb-3">Daftar Nilai Siswa</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Kuis</th>
                <th>Nilai</th>
                <th>Waktu Dikerjakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilai as $item)
                <tr>
                    <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                    <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $item->kuis->nama_kuis ?? '-' }}</td>
                    <td><span class="badge badge-success">{{ $item->nilai }}</span></td>
                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada nilai siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
