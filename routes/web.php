<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('loginData');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect('/login');
});


/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/
Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['login', 'role:mahasiswa'])
    ->group(function () {
        Route::get('/', fn() => view('mahasiswa.dashboard'))->name('dashboard');
        Route::get('/profile', fn() => view('mahasiswa.profile'))->name('profile');
        Route::get('/kpi', fn() => view('mahasiswa.kpi'))->name('kpi');
        Route::get('/penilaian_dosen', fn() => view('mahasiswa.penilaian_dosen'))->name('penilaian_dosen');
        Route::get('/penilaian_fasilitas', fn() => view('mahasiswa.penilaian_fasilitas'))->name('penilaian_fasilitas');
        Route::get('/penilaian_unit', fn() => view('mahasiswa.penilaian_unit'))->name('penilaian_unit');
        Route::get('/penilaian_praktikum', fn() => view('mahasiswa.penilaian_praktikum'))->name('penilaian_praktikum');
        Route::get('/feedback', fn() => view('mahasiswa.feedback'))->name('feedback');
        Route::get('/laporan', fn() => view('mahasiswa.laporan'))->name('laporan');
    });


/*
|--------------------------------------------------------------------------
| Dosen Routes
|--------------------------------------------------------------------------
*/
Route::prefix('dosen')
    ->name('dosen.')
    ->middleware(['login', 'role:dosen'])
    ->group(function () {
        Route::get('/', fn() => view('dosen.dashboard'))->name('dashboard');
        Route::get('/profile', fn() => view('dosen.profile'))->name('profile');
        Route::get('/kpi', fn() => view('dosen.kpi'))->name('kpi');
        Route::get('/kelas', fn() => view('dosen.kelas'))->name('kelas');
        Route::get('/kelas/kehadiran/create', fn() => view('dosen.form_kehadiran'))->name('form_kehadiran');
        Route::get('/penilaian_mahasiswa', fn() => view('dosen.penilaian_mahasiswa'))->name('penilaian_mahasiswa');
        Route::get('/penilaian_fasilitas', fn() => view('dosen.penilaian_fasilitas'))->name('penilaian_fasilitas');
        Route::get('/penilaian_unit', fn() => view('dosen.penilaian_unit'))->name('penilaian_unit');
        Route::get('/laporan', fn() => view('dosen.laporan'))->name('laporan');
        Route::get('/feedback', fn() => view('dosen.feedback'))->name('feedback');
    });


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['login', 'role:admin'])
    ->group(function () {
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


/*
|--------------------------------------------------------------------------
| Halaman umum (tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/penilaian', fn() => view('penilaian'))->name('penilaian');
