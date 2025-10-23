@extends('layouts.app')

@section('title', 'Manajemen Fasilitas')

@section('page-title', 'Manajemen Fasilitas')
@section('page-subtitle', 'Kelola data fasilitas kampus')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="#"><i class="bi bi-person-rolodex"></i> Manajemen Dosen</a>
    <a class="nav-link active" href="#"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Manajemen Unit</a>
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
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-building"></i> Daftar Fasilitas</div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Fasilitas</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Fasilitas</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Perpustakaan Pusat</td>
                        <td>Umum</td>
                        <td>Gedung A Lantai 1-3</td>
                        <td><span class="badge bg-success">Baik</span></td>
                        <td>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>
                    <tr class="table-danger">
                        <td>Laboratorium Komputer C101</td>
                        <td>Laboratorium</td>
                        <td>Gedung C Lantai 1</td>
                        <td><span class="badge bg-warning text-dark">Perlu Perbaikan</span></td>
                        <td>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
