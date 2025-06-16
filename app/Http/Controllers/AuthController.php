<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Ambil data guru/siswa sesuai role, lalu simpan ke session
            if ($user->role === 'guru') {
                $guru = Guru::where('user_id', $user->id)->first();
                session(['guru' => $guru]);
                Alert::success('Login Berhasil', 'Selamat datang, ' . $guru->nama_guru);
                return redirect()->route('guru.dashboard');
            } elseif ($user->role === 'siswa') {
                $siswa = Siswa::where('user_id', $user->id)->first();
                session(['siswa' => $siswa]);
                Alert::success('Login Berhasil', 'Selamat datang, ' . $siswa->nama_siswa);
                return redirect()->route('siswa.dashboard');
            } elseif ($user->role === 'admin') {
                Alert::success('Login Berhasil', 'Selamat datang, Admin');
                return redirect()->route('admin.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        auth()->logout();
        session()->forget(['guru', 'siswa']);
        Alert::success('Logout Berhasil', 'Anda telah keluar dari sistem');
        return redirect()->route('login');
    }
}
