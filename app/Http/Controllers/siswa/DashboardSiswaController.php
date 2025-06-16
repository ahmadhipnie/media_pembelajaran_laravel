<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardSiswaController extends Controller
{
    public function dashboardSiswa()
    {
        return view('siswa.dashboard.dashboard_siswa');
    }
}
