<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class GuruAdminController extends Controller
{
    public function index()
    {
        $guru = Guru::with('user')->get();
        return view('admin.guru_admin.guru_admin', compact('guru'));
    }

    public function create()
    {
        return view('admin.guru_admin.guru_admin_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nip' => 'required|unique:guru,nip',
            'nama_guru' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'jenis_kelamin' => 'required|in:pria,wanita',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        Guru::create([
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'user_id' => $user->id,
        ]);

        Alert::success('Berhasil', 'Guru berhasil ditambahkan');
        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('admin.guru_admin.guru_admin_edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $user = $guru->user;

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'nip' => 'required|unique:guru,nip,' . $guru->id,
            'nama_guru' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'jenis_kelamin' => 'required|in:pria,wanita',
        ]);

        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $guru->update([
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        Alert::success('Berhasil', 'Guru berhasil diubah');
        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil diubah');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $user = $guru->user;
        $guru->delete();
        if ($user) {
            $user->delete();
        }

        Alert::success('Berhasil', 'Guru berhasil dihapus');
        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus');
    }
}
