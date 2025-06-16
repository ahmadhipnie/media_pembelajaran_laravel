<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function dashboardAdmin()
    {

        $countGuru = User::where('role', 'guru')->count();
        $countSiswa = User::where('role', 'siswa')->count();
        $countKelas = Kelas::count();
        return view('admin.dashboard.dashboard_admin', compact('countGuru', 'countSiswa', 'countKelas'));
    }
}
