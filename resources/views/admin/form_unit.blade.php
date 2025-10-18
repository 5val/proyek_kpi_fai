@extends('layouts.app')

@section('title', 'Formulir Unit')

@section('page-title', 'Formulir Unit')
@section('page-subtitle', 'Tambah atau edit data unit layanan/akademik')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="#"><i class="bi bi-person-rolodex"></i> Manajemen Dosen</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link active" href="#"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link" href="#"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
    <a class="nav-link" href="#"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="#"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="#"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header">
        <i class="bi bi-plus-circle-fill"></i> Tambah Unit Baru
    </div>
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="unitName" class="form-label">Nama Unit</label>
                    <input type="text" class="form-control" id="unitName" placeholder="Contoh: Biro Administrasi Akademik">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="unitType" class="form-label">Tipe Unit</label>
                    <select id="unitType" class="form-select">
                        <option selected>Pilih tipe...</option>
                        <option value="layanan">Layanan</option>
                        <option value="akademik">Akademik (Prodi/Jurusan)</option>
                        <option value="ukm">UKM/Organisasi</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="personInCharge" class="form-label">Penanggung Jawab</label>
                    <input type="text" class="form-control" id="personInCharge" placeholder="Masukkan nama penanggung jawab">
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="#" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
