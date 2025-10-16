@extends('layouts.app')

@section('title', 'Data Penilaian')

@section('page-title', 'Data Penilaian Masuk')
@section('page-subtitle', 'Monitoring semua data penilaian yang telah diinput')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link active" href="#"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header"><i class="bi bi-star-fill"></i> Log Penilaian Terbaru</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Penilai</th>
                        <th>Objek yang Dinilai</th>
                        <th>Kategori</th>
                        <th>Skor Rata-rata</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Andi Pratama</td>
                        <td>Dr. Budi Hartono, M.Kom.</td>
                        <td>Kinerja Dosen</td>
                        <td>4.8 / 5.0</td>
                        <td>2024-10-15 14:30</td>
                        <td><button class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</button></td>
                    </tr>
                    <tr>
                        <td>Siti Aminah</td>
                        <td>Perpustakaan Pusat</td>
                        <td>Fasilitas</td>
                        <td>4.2 / 5.0</td>
                        <td>2024-10-15 13:05</td>
                        <td><button class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
