@extends('layouts.app')

@section('title', 'Kategori KPI')

@section('page-title', 'Kategori Key Performance Indicator (KPI)')
@section('page-subtitle', 'Kelola kategori utama untuk penilaian')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link active" href="#"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="#"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-tags-fill"></i> Daftar Kategori KPI</div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Indikator</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Kinerja Dosen</td>
                        <td>Penilaian performa mengajar dosen oleh mahasiswa.</td>
                        <td>8</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i> Indikator</a>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Kinerja Mahasiswa</td>
                        <td>Penilaian performa akademik dan non-akademik mahasiswa.</td>
                        <td>5</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i> Indikator</a>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Kinerja Fasilitas</td>
                        <td>Penilaian performa fasilitas.</td>
                        <td>5</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i> Indikator</a>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Kinerja Unit</td>
                        <td>Penilaian performa unit layanan, seperti BAU, BAK, BAA, UKM, UKK.</td>
                        <td>5</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i> Indikator</a>
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
