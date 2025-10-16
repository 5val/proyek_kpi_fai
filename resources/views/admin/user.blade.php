@extends('layouts.app')

@section('title', 'Manajemen User')

@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Kelola semua akun pengguna sistem')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link active" href="#"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="#"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-people-fill"></i> Daftar Pengguna</div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Pengguna</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Andi Pratama</td>
                        <td>andi.pratama@example.com</td>
                        <td><span class="badge bg-info">Mahasiswa</span></td>
                        <td>2024-01-15</td>
                        <td>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Dr. Budi Hartono, M.Kom.</td>
                        <td>budi.hartono@example.com</td>
                        <td><span class="badge bg-success">Dosen</span></td>
                        <td>2024-01-10</td>
                        <td>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>
                     <tr>
                        <td>Administrator</td>
                        <td>admin@example.com</td>
                        <td><span class="badge bg-danger">Admin</span></td>
                        <td>2024-01-01</td>
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
