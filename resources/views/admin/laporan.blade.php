@extends('layouts.app')

@section('title', 'Laporan KPI')

@section('page-title', 'Laporan Key Performance Indicator')
@section('page-subtitle', 'Generate dan export laporan KPI')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="#"><i class="bi bi-person-rolodex"></i> Manajemen Dosen</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link" href="#"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
    <a class="nav-link" href="#"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="#"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="#"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link active" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom mb-4">
    <div class="card-header"><i class="bi bi-filter"></i> Filter Laporan</div>
    <div class="card-body">
        <form class="row g-3">
            <div class="col-md-4">
                <label for="kategori" class="form-label">Kategori KPI</label>
                <select id="kategori" class="form-select">
                    <option selected>Semua Kategori</option>
                    <option>Kinerja Dosen</option>
                    <option>Fasilitas</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="periode" class="form-label">Periode</label>
                <select id="periode" class="form-select">
                    <option selected>Semester Gasal 2024/2025</option>
                    <option>Semester Genap 2023/2024</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Tampilkan Laporan</button>
            </div>
        </form>
    </div>
</div>

<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-file-earmark-text-fill"></i> Hasil Laporan: Kinerja Dosen</div>
        <div>
            <button class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel-fill"></i> Export Excel</button>
            <button class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf-fill"></i> Export PDF</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                 <thead class="table-light">
                    <tr>
                        <th>Nama Dosen</th>
                        <th>Skor Rata-rata</th>
                        <th>Jumlah Penilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Dr. Budi Hartono, M.Kom.</td>
                        <td>4.8</td>
                        <td>120</td>
                    </tr>
                    <tr>
                        <td>Siti Aminah, S.T., M.T.</td>
                        <td>4.6</td>
                        <td>115</td>
                    </tr>
                    <tr class="table-danger">
                        <td>Agung Pramana, S.T., M.T.</td>
                        <td>1.9</td>
                        <td>115</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
