@extends('layouts.app')

@section('title', 'Mata Kuliah Dosen')

@section('page-title', 'Mata Kuliah')
@section('page-subtitle', 'Daftar mata kuliah yang Anda ampu')
@section('user-name', 'Dr. Citra Lestari')
@section('user-role', 'Dosen - Teknik Informatika')
@section('user-initial', 'CL')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-star"></i> Penilaian Mahasiswa</a>
    <a class="nav-link" href="#"><i class="bi bi-graph-up"></i> Rating dari Mahasiswa</a>
    <a class="nav-link active" href="#"><i class="bi bi-book-fill"></i> Mata Kuliah</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kinerja</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text"></i> Feedback</a>
@endsection

@section('content')

<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <label for="periode" class="form-label">Pilih Periode</label>
                        <select class="form-select" id="periode">
                            <option selected>Semester Gasal 2024/2025</option>
                            <option>Semester Genap 2023/2024</option>
                            <option>Semester Gasal 2023/2024</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary"><i class="bi bi-filter"></i> Tampilkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="card-custom">
    <div class="card-header"><i class="bi bi-book-fill"></i> Mata Kuliah yang Diampu (Gasal 2024/2025)</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Program Studi</th>
                        <th>SKS</th>
                        <th>Jml Mhs</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>IF201</td>
                        <td>Struktur Data</td>
                        <td>Teknik Informatika</td>
                        <td class="text-center">4</td>
                        <td class="text-center">42</td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm"><i class="bi bi-calendar-plus-fill"></i> Input Kehadiran</a>
                            <a href="#" class="btn btn-info btn-sm" title="Laporan KPI Praktikum"><i class="bi bi-clipboard-data"></i> Laporan Praktikum</a>
                        </td>
                    </tr>
                    <tr>
                        <td>IF302</td>
                        <td>Kecerdasan Buatan</td>
                        <td>Teknik Informatika</td>
                        <td class="text-center">3</td>
                        <td class="text-center">38</td>
                         <td>
                            <a href="#" class="btn btn-primary btn-sm"><i class="bi bi-calendar-plus-fill"></i> Input Kehadiran</a>
                            <a href="#" class="btn btn-secondary btn-sm disabled" title="Tidak ada praktikum"><i class="bi bi-clipboard-data"></i> Laporan Praktikum</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

