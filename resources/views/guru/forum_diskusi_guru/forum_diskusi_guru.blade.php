{{-- filepath: resources/views/guru/forum_diskusi_guru/forum_diskusi_guru.blade.php --}}
@extends('guru.layout.sidebar')

@section('title', 'Forum Diskusi')

@section('content')
<div class="container" style="max-width:100%;">
    <div class="card mb-3" style="min-height:600px;">
        <div class="card-header bg-primary text-white">Forum Diskusi</div>
        <div class="card-body" id="chatBody" style="height:500px; overflow-y:auto; background:#f8f9fa;">
            @foreach($chats as $chat)
                @if($chat->user_id == Auth::id())
                    <!-- Bubble chat kanan (punya sendiri) -->
                    <div class="d-flex justify-content-end mb-2">
                        <div>
                            <div class="small text-muted text-right">{{ $chat->user->email }} • {{ $chat->created_at->format('H:i') }}</div>
                            <div class="bg-primary text-white rounded px-3 py-2" style="display:inline-block; max-width:400px; word-break:break-word;">
                                {{ $chat->chat }}
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Bubble chat kiri (orang lain) -->
                    <div class="d-flex justify-content-start mb-2">
                        <div>
                            <div class="small text-muted">{{ $chat->user->email }} • {{ $chat->created_at->format('H:i') }}</div>
                            <div class="bg-light border rounded px-3 py-2" style="display:inline-block; max-width:400px; word-break:break-word;">
                                {{ $chat->chat }}
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="card-footer">
            <form action="{{ route('guru.forum_diskusi.store') }}" method="POST" class="d-flex">
                @csrf
                <input type="text" name="chat" class="form-control mr-2" placeholder="Tulis pesan..." required autocomplete="off">
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto scroll ke bawah saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        var chatBody = document.getElementById('chatBody');
        if(chatBody){
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    });
</script>
@endpush
