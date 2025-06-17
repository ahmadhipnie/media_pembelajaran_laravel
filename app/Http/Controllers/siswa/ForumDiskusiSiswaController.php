<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\ForumDiskusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumDiskusiSiswaController extends Controller
{
    public function index()
    {
        $chats = ForumDiskusi::with('user')->orderBy('created_at', 'asc')->get();
        return view('siswa.forum_diskusi_siswa.forum_diskusi_siswa', compact('chats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chat' => 'required|string|max:1000',
        ]);

        ForumDiskusi::create([
            'user_id' => Auth::id(),
            'chat' => $request->chat,
        ]);

        return redirect()->route('siswa.forum_diskusi.index');
    }
}
