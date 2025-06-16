<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\ForumDiskusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumDiskusiGuruController extends Controller
{
    public function index()
    {
        $chats = ForumDiskusi::with('user')->orderBy('created_at', 'asc')->get();
        return view('guru.forum_diskusi_guru.forum_diskusi_guru', compact('chats'));
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

        return redirect()->route('guru.forum_diskusi.index');
    }
}
