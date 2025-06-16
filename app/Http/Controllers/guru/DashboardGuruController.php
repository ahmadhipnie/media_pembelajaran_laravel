<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardGuruController extends Controller
{
    public function dashboardGuru()
    {
        return view('guru.dashboard.dashboard_guru');
    }
}
