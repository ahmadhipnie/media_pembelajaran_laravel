<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KelasAdminController extends Controller
{
     public function index()
    {
        $kelas = Kelas::withCount('siswa')->get();
        return view('admin.kelas_admin.kelas_admin', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
        ]);

        Alert::success('Berhasil', 'Kelas berhasil ditambahkan');
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas,' . $kelas->id,
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        Alert::success('Berhasil', 'Kelas berhasil diubah');
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diubah');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $siswaCount = $kelas->siswa()->count();

        if ($siswaCount > 0) {
            Alert::error('Gagal', 'Kelas tidak dapat dihapus karena masih memiliki siswa.');
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Mohon hapus siswa di kelas ' . $kelas->nama_kelas . ' terlebih dahulu.');
        }

        $kelas->delete();
        Alert::success('Berhasil', 'Kelas berhasil dihapus');
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
