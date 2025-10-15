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

   Route::get('/feedback', function() {
      return view('mahasiswa.feedback');
   })->name('feedback');
});
