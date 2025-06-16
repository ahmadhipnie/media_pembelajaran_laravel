{{-- filepath: resources/views/guru/soal_guru/soal_guru.blade.php --}}
@extends('guru.layout.sidebar')

@section('title', 'Manajemen Soal & Jawaban')

@section('content')
    <h4>Kuis: <b>{{ $kuis->nama_kuis }}</b></h4>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahSoal">Tambah Soal</button>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Pertanyaan</th>
                <th>Video</th>
                <th>Gambar</th>
                <th>Jawaban</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($soal as $item)
                <tr>
                    <td>{{ $item->pertanyaan }}</td>
                    <td>
                        @if($item->url_video_soal)
                            <iframe width="150" height="84" src="{{ $item->url_video_soal }}" frameborder="0" allowfullscreen></iframe>
                        @endif
                    </td>
                    <td>
                        @if($item->url_gambar_soal)
                            <img src="{{ $item->url_gambar_soal }}" width="100" alt="gambar soal">
                        @endif
                    </td>
                    <td>
                        <ul>
                            @foreach($item->jawaban as $jawab)
                                <li>
                                    <form action="{{ route('guru.soal.jawaban.update', [$kuis->id, $item->id, $jawab->id]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="jawaban" value="{{ $jawab->jawaban }}" required>
                                        <label>
                                            <input type="checkbox" name="is_benar" value="1" {{ $jawab->is_benar ? 'checked' : '' }}> Benar
                                        </label>
                                        <button type="submit" class="btn btn-sm btn-success">Ubah</button>
                                    </form>
                                    <form action="{{ route('guru.soal.jawaban.destroy', [$kuis->id, $item->id, $jawab->id]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus jawaban ini?')">Hapus</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        <form action="{{ route('guru.soal.jawaban.store', [$kuis->id, $item->id]) }}" method="POST" class="mt-2">
                            @csrf
                            <input type="text" name="jawaban" placeholder="Jawaban baru" required>
                            <label>
                                <input type="checkbox" name="is_benar" value="1"> Benar
                            </label>
                            <button type="submit" class="btn btn-sm btn-primary">Tambah Jawaban</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditSoal{{ $item->id }}">Edit</button>
                        <form action="{{ route('guru.soal.destroy', [$kuis->id, $item->id]) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus soal ini?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit Soal -->
                <div class="modal fade" id="modalEditSoal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditSoalLabel{{ $item->id }}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <form action="{{ route('guru.soal.update', [$kuis->id, $item->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="modalEditSoalLabel{{ $item->id }}">Edit Soal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                                <div class="form-group">
                                    <label>Pertanyaan</label>
                                    <input type="text" name="pertanyaan" value="{{ $item->pertanyaan }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>URL Video (opsional)</label>
                                    <input type="url" name="url_video_soal" value="{{ $item->url_video_soal }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>URL Gambar (opsional)</label>
                                    <input type="url" name="url_gambar_soal" value="{{ $item->url_gambar_soal }}" class="form-control">
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

    <!-- Modal Tambah Soal -->
    <div class="modal fade" id="modalTambahSoal" tabindex="-1" role="dialog" aria-labelledby="modalTambahSoalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form action="{{ route('guru.soal.store', $kuis->id) }}" method="POST">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalTambahSoalLabel">Tambah Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <input type="text" name="pertanyaan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>URL Video (Embed YouTube, opsional)</label>
                        <input type="url" name="url_video_soal" class="form-control" placeholder="https://www.youtube.com/embed/xxxx">
                        <small class="text-muted">Contoh: https://www.youtube.com/embed/xxxx</small>
                    </div>
                    <div class="form-group">
                        <label>URL Gambar (opsional)</label>
                        <input type="url" name="url_gambar_soal" class="form-control" placeholder="https://.../gambar.jpg">
                        <small class="text-muted">Contoh: https://domain.com/gambar.jpg</small>
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
