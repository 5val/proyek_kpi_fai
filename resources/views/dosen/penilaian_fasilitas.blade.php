@extends('layouts.app')

@section('title', 'Penilaian Fasilitas')

@section('page-title', 'Penilaian Fasilitas')
@section('page-subtitle', 'Beri penilaian terhadap kualitas fasilitas kampus')
@section('user-name', 'Dr. Budi Hartono, M.Kom.')
@section('user-role', 'Dosen - Teknik Informatika')
@section('user-initial', 'BH')

@section('sidebar-menu')
    <a class="nav-link" href="/dosen"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="/dosen/profile"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="/dosen/kpi"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="/dosen/mata_kuliah"><i class="bi bi-pencil-square"></i> Mata Kuliah</a>
    <a class="nav-link" href="/dosen/penilaian_mahasiswa"><i class="bi bi-people"></i> Penilaian Mahasiswa</a>
    <a class="nav-link active" href="/dosen/penilaian_fasilitas"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="/dosen/penilaian_unit"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="/dosen/laporan"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kinerja</a>
    <a class="nav-link" href="/dosen/feedback"><i class="bi bi-chat-left-text"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header"><i class="bi bi-building"></i> Daftar Fasilitas untuk Dinilai</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Fasilitas</th>
                        <th>Lokasi</th>
                        <th>Status Penilaian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Perpustakaan Pusat</td>
                        <td>Gedung Rektorat Lt. 3</td>
                        <td><span class="badge bg-success">Sudah Dinilai</span></td>
                        <td><button class="btn btn-secondary btn-sm" disabled><i class="bi bi-check-circle"></i> Nilai</button></td>
                    </tr>
                    <tr>
                        <td>Laboratorium Komputer Jaringan</td>
                        <td>Gedung A Lt. 2</td>
                        <td><span class="badge bg-danger">Belum Dinilai</span></td>
                        <td><button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Nilai</button></td>
                    </tr>
                    <tr>
                        <td>Ruang Dosen</td>
                        <td>Gedung B Lt. 1</td>
                        <td><span class="badge bg-danger">Belum Dinilai</span></td>
                        <td><button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Nilai</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
