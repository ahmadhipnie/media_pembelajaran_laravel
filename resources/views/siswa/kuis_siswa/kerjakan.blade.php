{{-- filepath: resources/views/siswa/kuis_siswa/kerjakan.blade.php --}}
@extends('siswa.layout.sidebar')

@section('title', 'Kerjakan Kuis')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div><b>Kuis:</b> {{ $kuis->nama_kuis }}</div>
            <div id="timer" class="badge badge-danger p-2" style="font-size:1.2em;"></div>
        </div>
        <h5>Soal {{ $no }} dari {{ $kuis->soal->count() }}</h5>
        <div class="mb-3 mt-2">
            <b>{{ $soal->pertanyaan }}</b>
        </div>
        @if($soal->url_video_soal)
            <div class="mb-2 d-flex justify-content-center">
                <iframe width="400" height="225" src="{{ $soal->url_video_soal }}" frameborder="0" allowfullscreen></iframe>
            </div>
        @endif
        @if($soal->url_gambar_soal)
            <div class="mb-2 d-flex justify-content-center">
                <img src="{{ $soal->url_gambar_soal }}" width="200" alt="gambar soal">
            </div>
        @endif

        <form id="formJawab">
            @csrf
            <input type="hidden" name="soal_id" value="{{ $soal->id }}">
            <input type="hidden" name="no" value="{{ $no }}">
            <div class="row">
                @foreach($soal->jawaban as $jawaban)
                    <div class="col-md-6 mb-3">
                        <label class="w-100">
                            <div class="card pilihan-jawaban" style="cursor:pointer;">
                                <div class="card-body d-flex align-items-center">
                                    <input type="radio" name="jawaban_id" value="{{ $jawaban->id }}" class="mr-3" required>
                                    <span>{{ $jawaban->jawaban }}</span>
                                </div>
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>
            <button type="button" id="btnCekJawaban" class="btn btn-info mt-2">Cek Jawaban</button>
            <button type="submit" id="btnSoalSelanjutnya" class="btn btn-primary mt-2 float-right" disabled>Soal Selanjutnya</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let sisa = {{ $sisa }};
    let timerInterval;

    // Fungsi update timer
    function updateTimer() {
        if (sisa <= 0) {
            clearInterval(timerInterval);
            window.location.href = "{{ route('siswa.kuis.hasil', $kuis->id) }}";
        } else {
            let m = Math.floor(sisa / 60);
            let s = sisa % 60;
            document.getElementById('timer').innerText = m + ':' + (s < 10 ? '0' + s : s);
            sisa--;
        }
    }

    updateTimer();
    timerInterval = setInterval(updateTimer, 1000);

    // Referensi elemen
    const form = document.getElementById('formJawab');
    const btnCek = document.getElementById('btnCekJawaban');
    const btnNext = document.getElementById('btnSoalSelanjutnya');

    // Pilihan highlight
    form.querySelectorAll('.pilihan-jawaban').forEach(card => {
        card.addEventListener('click', function () {
            document.querySelectorAll('.pilihan-jawaban').forEach(c => c.classList.remove('border-primary'));
            card.classList.add('border-primary');
        });
    });

    // Tombol cek jawaban
    btnCek.addEventListener('click', function () {
        const selected = form.querySelector('input[name="jawaban_id"]:checked');
        if (!selected) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Jawaban!',
                text: 'Silakan pilih jawaban terlebih dahulu.'
            });
            return;
        }

        fetch("{{ route('siswa.kuis.cek_jawaban', $kuis->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `jawaban_id=${selected.value}`
        })
        .then(res => res.json())
        .then(res => {
            if(res.benar){
                Swal.fire({
                    title: 'Jawaban Anda BENAR!',
                    imageUrl: '{{ asset('img/benar.jpeg') }}',
                    imageWidth: 120,
                    imageHeight: 120,
                    imageAlt: 'Benar',
                    confirmButtonText: 'Lanjut'
                });
            } else {
                Swal.fire({
                    title: 'Jawaban Anda SALAH!',
                    imageUrl: '{{ asset('img/salah.jpeg') }}',
                    imageWidth: 120,
                    imageHeight: 120,
                    imageAlt: 'Salah',
                    confirmButtonText: 'Lanjut'
                });
            }
            btnCek.disabled = true;
            btnNext.disabled = false;
        })
        .catch(() => Swal.fire('Gagal', 'Gagal mengecek jawaban.', 'error'));
    });

    // Submit jawaban (Soal Selanjutnya)
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        btnNext.disabled = true;

        const data = new FormData(form);

        fetch("{{ route('siswa.kuis.submit_jawaban', $kuis->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: data
        })
        .then(res => res.json())
        .then(res => {
            window.location.href = res.selesai ? res.redirect : res.next;
        })
        .catch(() => {
            alert("Terjadi kesalahan saat mengirim jawaban.");
            btnNext.disabled = false;
        });
    });

    // Auto-submit jawaban kosong saat menutup browser
    window.addEventListener('beforeunload', function () {
        const selected = form.querySelector('input[name="jawaban_id"]:checked');
        if (!selected) {
            fetch("{{ route('siswa.kuis.submit_jawaban', $kuis->id) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `soal_id={{ $soal->id }}&jawaban_id=&no={{ $no }}`
            });
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush

