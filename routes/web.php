<?php

use App\Http\Controllers\admin\DashboardAdminController;
use App\Http\Controllers\admin\GuruAdminController;
use App\Http\Controllers\admin\KelasAdminController;
use App\Http\Controllers\admin\SiswaAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\guru\DashboardGuruController;
use App\Http\Controllers\guru\ForumDiskusiGuruController;
use App\Http\Controllers\guru\KontenGuruController;
use App\Http\Controllers\guru\KuisGuruController;
use App\Http\Controllers\guru\NilaiGuruController;
use App\Http\Controllers\guru\SoalGuruController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\siswa\DashboardSiswaController;
use App\Http\Controllers\siswa\ForumDiskusiSiswaController;
use App\Http\Controllers\siswa\KontenSiswaController;
use App\Http\Controllers\siswa\KuisSiswaController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});


Route::get('/showLoginForm', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/dashboardSiswa', [DashboardSiswaController::class, 'dashboardSiswa'])->name('siswa.dashboard');
Route::get('/dashboardGuru', [DashboardGuruController::class, 'dashboardGuru'])->name('guru.dashboard');
Route::get('/dashboardAdmin', [DashboardAdminController::class, 'dashboardAdmin'])->name('admin.dashboard');


//route admin
Route::prefix('admin/siswa')->name('admin.siswa.')->group(function () {
    Route::get('/', [SiswaAdminController::class, 'index'])->name('index');
    Route::get('/create', [SiswaAdminController::class, 'create'])->name('create');
    Route::post('/store', [SiswaAdminController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [SiswaAdminController::class, 'edit'])->name('edit');
    Route::put('/{id}', [SiswaAdminController::class, 'update'])->name('update');
    Route::delete('/{id}', [SiswaAdminController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin/guru')->name('admin.guru.')->group(function () {
    Route::get('/', [GuruAdminController::class, 'index'])->name('index');
    Route::get('/create', [GuruAdminController::class, 'create'])->name('create');
    Route::post('/store', [GuruAdminController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [GuruAdminController::class, 'edit'])->name('edit');
    Route::put('/{id}', [GuruAdminController::class, 'update'])->name('update');
    Route::delete('/{id}', [GuruAdminController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin/kelas')->name('admin.kelas.')->group(function () {
    Route::get('/', [KelasAdminController::class, 'index'])->name('index');
    Route::post('/store', [KelasAdminController::class, 'store'])->name('store');
    Route::put('/{id}', [KelasAdminController::class, 'update'])->name('update');
    Route::delete('/{id}', [KelasAdminController::class, 'destroy'])->name('destroy');
});


//route guru
Route::prefix('guru/konten')->name('guru.konten.')->group(function () {
    Route::get('/', [KontenGuruController::class, 'index'])->name('index');
    Route::get('/create', [KontenGuruController::class, 'create'])->name('create');
    Route::post('/store', [KontenGuruController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [KontenGuruController::class, 'edit'])->name('edit');
    Route::put('/{id}', [KontenGuruController::class, 'update'])->name('update');
    Route::delete('/{id}', [KontenGuruController::class, 'destroy'])->name('destroy');
});


Route::prefix('guru/kuis')->name('guru.kuis.')->group(function () {
    Route::get('/', [KuisGuruController::class, 'index'])->name('index');
    Route::post('/store', [KuisGuruController::class, 'store'])->name('store');
    Route::put('/{id}', [KuisGuruController::class, 'update'])->name('update');
    Route::delete('/{id}', [KuisGuruController::class, 'destroy'])->name('destroy');
});


Route::prefix('guru/kuis/{kuis}/soal')->name('guru.soal.')->group(function () {
    Route::get('/', [SoalGuruController::class, 'index'])->name('index');
    Route::post('/store', [SoalGuruController::class, 'store'])->name('store');
    Route::put('/{soal}', [SoalGuruController::class, 'update'])->name('update');
    Route::delete('/{soal}', [SoalGuruController::class, 'destroy'])->name('destroy');

    // Jawaban
    Route::post('/{soal}/jawaban/store', [SoalGuruController::class, 'storeJawaban'])->name('jawaban.store');
    Route::put('/{soal}/jawaban/{jawaban}', [SoalGuruController::class, 'updateJawaban'])->name('jawaban.update');
    Route::delete('/{soal}/jawaban/{jawaban}', [SoalGuruController::class, 'destroyJawaban'])->name('jawaban.destroy');
});


Route::get('guru/forum-diskusi', [ForumDiskusiGuruController::class, 'index'])->name('guru.forum_diskusi.index');
Route::post('guru/forum-diskusi', [ForumDiskusiGuruController::class, 'store'])->name('guru.forum_diskusi.store');

Route::get('guru/Nilai-siswa', [NilaiGuruController::class, 'index'])->name('guru.nilai_guru.index');

//route siswa

Route::get('siswa/konten', [KontenSiswaController::class, 'index'])->name('siswa.konten.index');
Route::get('siswa/konten/{id}', [KontenSiswaController::class, 'show'])->name('siswa.konten.show');

Route::get('siswa/kuis/{kuis}/mulai', [KuisSiswaController::class, 'mulai'])->name('siswa.kuis.mulai');
Route::post('siswa/kuis/{kuis}/jawab', [KuisSiswaController::class, 'jawab'])->name('siswa.kuis.jawab');
Route::get('siswa/kuis/{kuis}/hasil', [KuisSiswaController::class, 'hasil'])->name('siswa.kuis.hasil');

Route::get('siswa/kuis/{kuis}/riwayat', [KuisSiswaController::class, 'riwayat'])->name('siswa.kuis.riwayat');
Route::post('siswa/kuis/{kuis}/ulang', [KuisSiswaController::class, 'ulang'])->name('siswa.kuis.ulang');


Route::post('siswa/kuis/{kuis}/cek-jawaban', [KuisSiswaController::class, 'cekJawaban'])->name('siswa.kuis.cek_jawaban');
Route::post('siswa/kuis/{kuis}/submit-jawaban', [KuisSiswaController::class, 'submitJawaban'])->name('siswa.kuis.submit_jawaban');

Route::get('siswa/forum-diskusi', [ForumDiskusiSiswaController::class, 'index'])->name('siswa.forum_diskusi.index');
Route::post('siswa/forum-diskusi', [ForumDiskusiSiswaController::class, 'store'])->name('siswa.forum_diskusi.store');
