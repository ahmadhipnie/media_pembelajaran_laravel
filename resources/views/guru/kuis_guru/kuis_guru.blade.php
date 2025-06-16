{{-- filepath: resources/views/guru/kuis_guru/kuis_guru.blade.php --}}
@extends('guru.layout.sidebar')

@section('title', 'Manajemen Kuis')

@section('content')
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">Tambah Kuis</button>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Kuis</th>
                <th>Durasi (menit)</th>
                <th>Konten</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kuis as $item)
                <tr>
                    <td>{{ $item->nama_kuis }}</td>
                    <td>{{ $item->durasi_kuis }}</td>
                    <td>{{ $item->konten->judul_konten ?? '-' }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#modalEdit{{ $item->id }}">Edit</button>
                        <form action="{{ route('guru.kuis.destroy', $item->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus kuis ini?')"
                                class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        <a href="{{ route('guru.soal.index', $item->id) }}" class="btn btn-info btn-sm mt-1">Manajemen
                            Soal</a>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('guru.kuis.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditLabel{{ $item->id }}">Edit Kuis</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nama Kuis</label>
                                        <input type="text" name="nama_kuis" value="{{ $item->nama_kuis }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Durasi (menit)</label>
                                        <input type="number" name="durasi_kuis" value="{{ $item->durasi_kuis }}"
                                            class="form-control" min="1" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Konten</label>
                                        <select name="konten_id" class="form-control" required>
                                            <option value="">Pilih Konten</option>
                                            @foreach ($konten as $k)
                                                <option value="{{ $k->id }}"
                                                    {{ $item->konten_id == $k->id ? 'selected' : '' }}>
                                                    {{ $k->judul_konten }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('guru.kuis.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Kuis</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kuis</label>
                            <input type="text" name="nama_kuis" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Durasi (menit)</label>
                            <input type="number" name="durasi_kuis" class="form-control" min="1" required>
                        </div>
                        <div class="form-group">
                            <label>Konten</label>
                            <select name="konten_id" class="form-control" required>
                                <option value="">Pilih Konten</option>
                                @foreach ($konten as $k)
                                    <option value="{{ $k->id }}">{{ $k->judul_konten }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
