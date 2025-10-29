<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('loginData');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login', function () {
    return view('login');
});

Route::get('/', function () {
    return redirect('/login');
});


Route::prefix("mahasiswa")->name('mahasiswa.')->group(function() {
   Route::get('/', function() {
      return view('mahasiswa.dashboard');
   })->name('dashboard');

   Route::get('/profile', function() {
      return view('mahasiswa.profile');
   })->name('profile');

   Route::get('/kpi', function() {
      return view('mahasiswa.kpi');
   })->name('kpi');

   Route::get('/penilaian_dosen', function() {
      return view('mahasiswa.penilaian_dosen');
   })->name('penilaian_dosen');

   Route::get('/penilaian_fasilitas', function() {
      return view('mahasiswa.penilaian_fasilitas');
   })->name('penilaian_fasilitas');

   Route::get('/penilaian_unit', function() {
      return view('mahasiswa.penilaian_unit');
   })->name('penilaian_unit');
   
   Route::get('/penilaian_praktikum', function() {
      return view('mahasiswa.penilaian_praktikum');
   })->name('penilaian_praktikum');

   Route::get('/feedback', function() {
      return view('mahasiswa.feedback');
   })->name('feedback');

   Route::get('/laporan', function() {
      return view('mahasiswa.laporan');
   })->name('laporan');
});

Route::prefix("dosen")->name('dosen.')->group(function() {
   Route::get('/', function() {
      return view('dosen.dashboard');
   })->name('dashboard');

   Route::get('/profile', function() {
      return view('dosen.profile');
   })->name('profile');

   Route::get('/kpi', function() {
      return view('dosen.kpi');
   })->name('kpi');
   
   Route::get('/mata_kuliah', function() {
      return view('dosen.mata_kuliah');
   })->name('mata_kuliah');
   
   Route::get('/mata_kuliah/kehadiran/create', function() {
      return view('dosen.form_kehadiran');
   })->name('form_kehadiran');

   Route::get('/penilaian_mahasiswa', function() {
      return view('dosen.penilaian_mahasiswa');
   })->name('penilaian_mahasiswa');

   Route::get('/penilaian_fasilitas', function() {
      return view('dosen.penilaian_fasilitas');
   })->name('penilaian_fasilitas');

   Route::get('/penilaian_unit', function() {
      return view('dosen.penilaian_unit');
   })->name('penilaian_unit');

   Route::get('/laporan', function() {
      return view('dosen.laporan');
   })->name('laporan');

   Route::get('/feedback', function() {
      return view('dosen.feedback');
   })->name('feedback');
});

Route::prefix("admin")->name('admin.')->group(function() {
   Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

   Route::get('/user', [AdminController::class, 'user'])->name('user');

   Route::get('/user/create', [AdminController::class, 'form_user'])->name('form_user');

   Route::get('/fasilitas', [AdminController::class, 'fasilitas'])->name('fasilitas');

   Route::get('/fasilitas/create', [AdminController::class, 'form_fasilitas'])->name('form_fasilitas');

   Route::get('/unit', [AdminController::class, 'unit'])->name('unit');

   Route::get('/unit/create', [AdminController::class, 'form_unit'])->name('form_unit');

   Route::get('/periode', [AdminController::class, 'periode'])->name('periode');

   Route::get('/mata_kuliah', [AdminController::class, 'mata_kuliah'])->name('mata_kuliah');
   
   Route::get('/mata_kuliah/create', [AdminController::class, 'form_mata_kuliah'])->name('form_mata_kuliah');

   Route::get('/kelas', [AdminController::class, 'kelas'])->name('kelas');

   Route::get('/kelas/create', [AdminController::class, 'form_kelas'])->name('form_kelas');

   Route::get('/kelas/enrollment', [AdminController::class, 'enrollment'])->name('enrollment');

   Route::get('/kelas/enrollment/create', [AdminController::class, 'form_enrollment'])->name('form_enrollment');

   Route::get('/kategori_kpi', [AdminController::class, 'kategori_kpi'])->name('kategori_kpi');

   Route::get('/kategori_kpi/indikator', [AdminController::class, 'list_indikator'])->name('list_indikator');

   Route::get('/indikator_kpi/create', [AdminController::class, 'form_indikator'])->name('form_indikator');

   Route::get('/penilaian', [AdminController::class, 'penilaian'])->name('penilaian');

   Route::get('/penilaian/detail', [AdminController::class, 'detail_penilaian'])->name('detail_penilaian');

   Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');

   Route::get('/feedback', [AdminController::class, 'feedback'])->name('feedback');
});

Route::get('/penilaian', function() {
    return view('penilaian');
})->name('penilaian');