<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class SiswaAdminController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['user', 'kelas'])->get();
        return view('admin.siswa_admin.siswa_admin', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa_admin.siswa_admin_create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nisn' => 'required|unique:siswa,nisn',
            'nama_siswa' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'nisn' => $request->nisn,
            'nama_siswa' => $request->nama_siswa,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $request->kelas_id,
            'user_id' => $user->id,
        ]);

        Alert::success('Berhasil', 'Siswa berhasil ditambahkan');
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.siswa_admin.siswa_admin_edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'nisn' => 'required|unique:siswa,nisn,' . $siswa->id,
            'nama_siswa' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $siswa->update([
            'nisn' => $request->nisn,
            'nama_siswa' => $request->nama_siswa,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $request->kelas_id,
        ]);

        Alert::success('Berhasil', 'Siswa berhasil diubah');
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diubah');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;
        $siswa->delete();
        if ($user) {
            $user->delete();
        }

        Alert::success('Berhasil', 'Siswa berhasil dihapus');
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
}
