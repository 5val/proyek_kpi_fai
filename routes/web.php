<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('loginData')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [AuthController::class, 'redirectPathFor']);
Route::get('/profiles', [AuthController::class, 'redirectProfiles'])->middleware(['auth', 'active']);


/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/
// Route::prefix('mahasiswa')
//     ->name('mahasiswa.')
//     ->middleware(['login', 'role:mahasiswa'])
//     ->group(function () {
//         Route::get('/', fn() => view('mahasiswa.dashboard'))->name('dashboard');
//         Route::get('/profile', fn() => view('mahasiswa.profile'))->name('profile');
//         Route::get('/kpi', fn() => view('mahasiswa.kpi'))->name('kpi');
//         Route::get('/penilaian_dosen', fn() => view('mahasiswa.penilaian_dosen'))->name('penilaian_dosen');
//         Route::get('/penilaian_fasilitas', fn() => view('mahasiswa.penilaian_fasilitas'))->name('penilaian_fasilitas');
//         Route::get('/penilaian_unit', fn() => view('mahasiswa.penilaian_unit'))->name('penilaian_unit');
//         Route::get('/penilaian_praktikum', fn() => view('mahasiswa.penilaian_praktikum'))->name('penilaian_praktikum');
//         Route::get('/feedback', fn() => view('mahasiswa.feedback'))->name('feedback');
//         Route::get('/laporan', fn() => view('mahasiswa.laporan'))->name('laporan');
//     });

Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    // ->middleware(['login', 'role:mahasiswa', 'active'])
    ->group(function () {
        Route::get('/', [MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [MahasiswaController::class, 'profile'])->name('profile');
        Route::post('/profile/{id}/upload', [MahasiswaController::class, 'uploadProfpic'])->name('uploadProfpic');
        Route::post('/profile/{id}/password', [MahasiswaController::class, 'changePassword'])->name('changePassword');
        Route::get('/kpi', [MahasiswaController::class, 'kpi'])->name('kpi');
        Route::get('/penilaian_dosen', [MahasiswaController::class, 'penilaian_dosen'])->name('penilaian_dosen');
        Route::get('/penilaian_fasilitas', [MahasiswaController::class, 'penilaian_fasilitas'])->name('penilaian_fasilitas');
        Route::get('/penilaian_unit', [MahasiswaController::class, 'penilaian_unit'])->name('penilaian_unit');
        Route::get('/penilaian_praktikum', [MahasiswaController::class, 'penilaian_praktikum'])->name('penilaian_praktikum');
        Route::get('/feedback', [MahasiswaController::class, 'feedback'])->name('feedback');
        Route::get('/feedback/get_targets', [MahasiswaController::class, 'get_targets'])->name('feedback.get_targets');
        Route::post('/feedback', [MahasiswaController::class, 'insertFeedback'])->name('insertFeedback');
        Route::get('/laporan', [MahasiswaController::class, 'laporan'])->name('laporan');
        Route::get('/laporan/{periode_id}/export-excel', [MahasiswaController::class, 'laporan_export_excel'])->name('laporan.excel');
        Route::get('/laporan/{periode_id}/export-pdf', [MahasiswaController::class, 'laporan_export_pdf'])->name('laporan.pdf');

    });


/*
|--------------------------------------------------------------------------
| Dosen Routes
|--------------------------------------------------------------------------
*/
Route::prefix('dosen')
    ->name('dosen.')
    ->middleware(['auth', 'role:dosen', 'active'])
    ->group(function () {
        Route::get('/', [DosenController::class, 'dashboard'])->name('dashboard');

        Route::get('/profile', [DosenController::class, 'profile'])->name('profile');
        Route::put('/profile/update', [DosenController::class, 'updateProfile'])->name('updateProfile');
        Route::post('/profile/password', [DosenController::class, 'changePassword'])->name('changePassword');
        Route::post('/profile/{id}/upload', [DosenController::class, 'uploadProfpic'])->name('uploadProfpicDosen');
        
        // Route::get('/kpi', fn() => view('dosen.kpi'))->name('kpi');
        Route::get('/kpi',[DosenController::class, 'kpi'])->name('kpi');

        Route::get('/kelas', [DosenController::class, 'kelas'])->name('kelas');

        Route::get('/kelas/{id}/kehadiran/create', [DosenController::class, 'insert_kehadiran'])->name('form_kehadiran');
        Route::get('/kelas/{id}/kehadiran/download', [DosenController::class, 'download_kehadiran'])->name('kehadiran.download');
        Route::post('/kelas/{id}/kehadiran/upload', [DosenController::class, 'upload_kehadiran'])->name('kehadiran.upload');

        Route::get('/penilaian_manajemen', [DosenController::class, 'penilaianManajemen'])->name('penilaian_manajemen');

        Route::get('/penilaian_mahasiswa', [DosenController::class, 'penilaianMahasiswa'])->name('penilaian_mahasiswa');
        Route::get('/penilaian_mahasiswa/{id}/nilai', [DosenController::class, 'formNilaiMahasiswa'])->name('nilai_mahasiswa');

        // Route::get('/penilaian_mahasiswa', fn() => view('dosen.penilaian_mahasiswa'))->name('penilaian_mahasiswa');

        // Route::get('/penilaian_fasilitas', fn() => view('dosen.penilaian_fasilitas'))->name('penilaian_fasilitas');
        Route::get('/penilaian_fasilitas', [DosenController::class, 'penilaianFasilitas'])
            ->name('penilaian_fasilitas');
            
        Route::get('/penilaian_unit', [DosenController::class, 'penilaianUnit'])
            ->name('penilaian_unit');


        Route::get('/laporan', [DosenController::class, 'laporanKinerja'])
            ->name('laporan');    

        // Route::get('/laporan', fn() => view('dosen.laporan'))->name('laporan');
        Route::get('/feedback', [DosenController::class, 'feedback'])->name('feedback');
    });


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin', 'active'])
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard/detail/{type}', [AdminController::class, 'detail_dashboard_card'])->name('dashboard.detail.card');
        Route::get('/dashboard/detail/{type}/{id}', [AdminController::class, 'detail_dashboard_list'])->name('dashboard.detail.list');
        Route::get('/dashboard/feedback/{kategori_id}/{target_id}', [AdminController::class, 'detail_dashboard_feedback'])->name('dashboard.detail.feedback');
        
        Route::get('/user', [AdminController::class, 'user'])->name('user');
        Route::get('/user/create', [AdminController::class, 'form_user'])->name('form_user');
        Route::get('/user/delete/{id}', [AdminController::class, 'delete_user'])->name('user.delete');
        Route::get('/user/edit/{id}', [AdminController::class, 'form_user_edit'])->name('form_user_edit');
        Route::post('/user/insert', [AdminController::class, 'insert_user'])->name('user.insert');
        Route::post('/user/update/{id}', [AdminController::class, 'update_user'])->name('user.update');
        
        Route::get('/fasilitas', [AdminController::class, 'fasilitas'])->name('fasilitas');
        Route::get('/fasilitas/create', [AdminController::class, 'form_fasilitas'])->name('form_fasilitas');
        Route::get('/fasilitas/delete/{id}', [AdminController::class, 'delete_fasilitas'])->name('fasilitas.delete');
        Route::get('/fasilitas/edit/{id}', [AdminController::class, 'form_fasilitas_edit'])->name('form_fasilitas_edit');
        Route::post('/fasilitas/insert', [AdminController::class, 'insert_fasilitas'])->name('fasilitas.insert');
        Route::post('/fasilitas/update/{id}', [AdminController::class, 'update_fasilitas'])->name('fasilitas.update');
        
        Route::get('/unit', [AdminController::class, 'unit'])->name('unit');
        Route::get('/unit/create', [AdminController::class, 'form_unit'])->name('form_unit');
        Route::get('/unit/delete/{id}', [AdminController::class, 'delete_unit'])->name('unit.delete');
        Route::get('/unit/edit/{id}', [AdminController::class, 'form_unit_edit'])->name('form_unit_edit');
        Route::post('/unit/insert', [AdminController::class, 'insert_unit'])->name('unit.insert');
        Route::post('/unit/update/{id}', [AdminController::class, 'update_unit'])->name('unit.update');
        
        Route::get('/periode', [AdminController::class, 'periode'])->name('periode');
        Route::get('/periode/create', [AdminController::class, 'new_periode'])->name('periode.insert');
        Route::get('/periode/delete/{id}', [AdminController::class, 'delete_periode'])->name('periode.delete');
        
        Route::get('/mata_kuliah', [AdminController::class, 'mata_kuliah'])->name('mata_kuliah');
        Route::get('/mata_kuliah/create', [AdminController::class, 'form_mata_kuliah'])->name('form_mata_kuliah');
        Route::get('/mata_kuliah/delete/{id}', [AdminController::class, 'delete_mata_kuliah'])->name('mata_kuliah.delete');
        Route::get('/mata_kuliah/edit/{id}', [AdminController::class, 'form_mata_kuliah_edit'])->name('form_mata_kuliah_edit');
        Route::post('/mata_kuliah/insert', [AdminController::class, 'insert_mata_kuliah'])->name('mata_kuliah.insert');
        Route::post('/mata_kuliah/update/{id}', [AdminController::class, 'update_mata_kuliah'])->name('mata_kuliah.update');

        Route::get('/kelas', [AdminController::class, 'kelas'])->name('kelas');
        Route::get('/kelas/create', [AdminController::class, 'form_kelas'])->name('form_kelas');
        Route::get('/kelas/delete/{id}', [AdminController::class, 'delete_kelas'])->name('kelas.delete');
        Route::get('/kelas/edit/{id}', [AdminController::class, 'form_kelas_edit'])->name('form_kelas_edit');
        Route::post('/kelas/insert', [AdminController::class, 'insert_kelas'])->name('kelas.insert');
        Route::post('/kelas/update/{id}', [AdminController::class, 'update_kelas'])->name('kelas.update');
        Route::get('/kelas/enrollment/{id}', [AdminController::class, 'enrollment'])->name('enrollment');
        Route::get('/kelas/enrollment/{kelas_id}/delete/{id}', [AdminController::class, 'delete_enrollment'])->name('enrollment.delete');
        Route::get('/kelas/enrollment/{id}/create', [AdminController::class, 'form_enrollment'])->name('form_enrollment');
        Route::get('/kelas/enrollment/{id}/download', [AdminController::class, 'download_enrollment'])->name('enrollment.download');
        Route::post('/kelas/enrollment/{id}/upload', [AdminController::class, 'upload_enrollment'])->name('enrollment.upload');

        Route::get('/kategori_kpi', [AdminController::class, 'kategori_kpi'])->name('kategori_kpi');
        Route::get('/kategori_kpi/{id}/indikator', [AdminController::class, 'list_indikator'])->name('list_indikator');
        Route::get('/kategori_kpi/{id}/indikator/create', [AdminController::class, 'form_indikator'])->name('form_indikator');
        Route::get('/kategori_kpi/{kategori_id}/indikator/delete/{id}', [AdminController::class, 'delete_indikator'])->name('indikator.delete');
        Route::get('/kategori_kpi/{kategori_id}/indikator/edit/{id}', [AdminController::class, 'form_indikator_edit'])->name('form_indikator_edit');
        Route::post('/kategori_kpi/{kategori_id}/indikator/insert', [AdminController::class, 'insert_indikator'])->name('indikator.insert');
        Route::post('/kategori_kpi/{kategori_id}/indikator/update/{id}', [AdminController::class, 'update_indikator'])->name('indikator.update');

        Route::get('/penilaian', [AdminController::class, 'penilaian'])->name('penilaian');
        Route::get('/penilaian/detail/{id}', [AdminController::class, 'detail_penilaian'])->name('detail_penilaian');

        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
        Route::get('/laporan/{kategori_id}/{periode_id}/export/excel', [AdminController::class, 'laporan_export_excel'])->name('laporan.export.excel');
        Route::get('/laporan/{kategori_id}/{periode_id}/export/pdf', [AdminController::class, 'laporan_export_pdf'])->name('laporan.export.pdf');

        Route::get('/feedback', [AdminController::class, 'feedback'])->name('feedback');
        Route::get('/feedback/{id}', [AdminController::class, 'detail_feedback'])->name('feedback.detail');
        Route::get('/feedback/{id}/update', [AdminController::class, 'update_feedback'])->name('feedback.update');

        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [AdminController::class, 'update_profile'])->name('updateProfile');
        Route::post('/profile/password', [AdminController::class, 'change_password'])->name('changePassword');
        Route::post('/profile/{id}/upload', [AdminController::class, 'upload_prof_pic'])->name('uploadProfpic');
    });


Route::get('/penilaian/{tipe}/{id}', [PenilaianController::class, 'index'])
    ->name('penilaian.form');

Route::post('/penilaian/{tipe}/{id}', [PenilaianController::class, 'store'])
    ->name('penilaian.store');

