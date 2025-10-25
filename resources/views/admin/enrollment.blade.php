@extends('layouts.app')

@section('title', 'Detail Enrollment')

@section('page-title', 'Detail Enrollment Kelas')
@section('page-subtitle', 'Daftar mahasiswa terdaftar di kelas Algoritma & Pemrograman')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="{{ route('admin.user') }}"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="{{ route('admin.fasilitas') }}"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="{{ route('admin.unit') }}"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="{{ route('admin.periode') }}"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link active" href="{{ route('admin.mata_kuliah') }}"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
    <a class="nav-link" href="{{ route('admin.kelas') }}"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-people-fill"></i> Daftar Mahasiswa Kelas</div>
        <div>
           <a href="{{ route('admin.kelas') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Kelas</a>
           <a href="{{ route('admin.form_enrollment') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Enrollment</a>
        </div>
    </div>
    <div class="card-body">
        <!-- Class Info -->
        <div class="p-3 mb-4 rounded" style="background-color: #f8f9fa;">
            <div class="row">
                <div class="col-md-12">
                    <h5>Algoritma & Pemrograman</h5>
                    <p class="mb-1"><strong>Dosen Pengampu:</strong> Prof. Budi Santoso</p>
                    <p class="mb-0"><strong>Periode:</strong> Gasal 2024/2025</p>
                </div>
            </div>
        </div>

        <!-- Student List -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2021010001</td>
                        <td>Andi Pratama</td>
                        <td>Teknik Informatika</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>2021010002</td>
                        <td>Bunga Citra</td>
                        <td>Teknik Informatika</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>2021010003</td>
                        <td>Charlie Setiawan</td>
                        <td>Teknik Informatika</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
