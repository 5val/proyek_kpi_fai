<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
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
   Route::get('/', function() {
      return view('admin.dashboard');
   })->name('dashboard');

   Route::get('/user', function() {
      return view('admin.user');
   })->name('user');

   Route::get('/user/create', function() {
      return view('admin.form_user');
   })->name('form_user');

   Route::get('/fasilitas', function() {
      return view('admin.fasilitas');
   })->name('fasilitas');

   Route::get('/fasilitas/create', function() {
      return view('admin.form_fasilitas');
   })->name('form_fasilitas');

   Route::get('/unit', function() {
      return view('admin.unit');
   })->name('unit');

   Route::get('/unit/create', function() {
      return view('admin.form_unit');
   })->name('form_unit');

   Route::get('/periode', function() {
      return view('admin.periode');
   })->name('periode');

   Route::get('/mata_kuliah', function() {
      return view('admin.mata_kuliah');
   })->name('mata_kuliah');
   
   Route::get('/mata_kuliah/create', function() {
      return view('admin.form_mata_kuliah');
   })->name('form_mata_kuliah');

   Route::get('/kelas', function() {
      return view('admin.kelas');
   })->name('kelas');

   Route::get('/kelas/create', function() {
      return view('admin.form_kelas');
   })->name('form_kelas');

   Route::get('/kelas/enrollment', function() {
      return view('admin.enrollment');
   })->name('enrollment');

   Route::get('/kelas/enrollment/create', function() {
      return view('admin.form_enrollment');
   })->name('form_enrollment');

   Route::get('/kategori_kpi', function() {
      return view('admin.kategori_kpi');
   })->name('kategori_kpi');

   Route::get('/kategori_kpi/indikator', function() {
      return view('admin.list_indikator');
   })->name('list_indikator');

   Route::get('/indikator_kpi/create', function() {
      return view('admin.form_indikator');
   })->name('form_indikator');

   Route::get('/penilaian', function() {
      return view('admin.penilaian');
   })->name('penilaian');

   Route::get('/laporan', function() {
      return view('admin.laporan');
   })->name('laporan');

   Route::get('/feedback', function() {
      return view('admin.feedback');
   })->name('feedback');
});

Route::get('/penilaian', function() {
   return view('penilaian');
});