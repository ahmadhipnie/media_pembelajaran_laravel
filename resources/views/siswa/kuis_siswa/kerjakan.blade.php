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
            <button type="submit" class="btn btn-primary mt-2 float-right">Soal Selanjutnya</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Timer countdown
    let sisa = {{ $sisa }};
    function updateTimer() {
        if (sisa <= 0) {
            window.location.href = "{{ route('siswa.kuis.hasil', $kuis->id) }}";
            return;
        }
        let m = Math.floor(sisa / 60);
        let s = sisa % 60;
        document.getElementById('timer').innerText = m + ' : ' + (s < 10 ? '0' : '') + s;
        sisa--;
    }
    updateTimer();
    setInterval(updateTimer, 1000);

    // Pilihan card highlight
    document.querySelectorAll('.pilihan-jawaban').forEach(function(card){
        card.addEventListener('click', function(){
            document.querySelectorAll('.pilihan-jawaban').forEach(function(c){ c.classList.remove('border-primary'); });
            card.classList.add('border-primary');
        });
    });

    // Submit jawaban via AJAX
    document.getElementById('formJawab').addEventListener('submit', function(e){
        e.preventDefault();
        let form = this;
        let data = new FormData(form);
        fetch("{{ route('siswa.kuis.jawab', $kuis->id) }}", {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: data
        })
        .then(res => res.json())
        .then(res => {
            if(res.benar !== undefined){
                alert(res.benar ? 'Jawaban Anda BENAR!' : 'Jawaban Anda SALAH!');
            }
            if(res.selesai){
                window.location.href = res.redirect;
            }else{
                window.location.href = res.next;
            }
        })
        .catch(function(error){
            alert('Terjadi kesalahan saat mengirim jawaban!');
        });
    });

    // Jika browser ditutup, submit otomatis jawaban kosong
    window.addEventListener('beforeunload', function (e) {
        let radio = document.querySelector('input[name="jawaban_id"]:checked');
        if (!radio) {
            fetch("{{ route('siswa.kuis.jawab', $kuis->id) }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: new URLSearchParams({
                    soal_id: '{{ $soal->id }}',
                    jawaban_id: '', // kosong
                    no: '{{ $no }}'
                })
            });
        }
    });
});
</script>
@endpush
