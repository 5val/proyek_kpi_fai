@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('page-title', 'Manajemen Kelas')
@section('page-subtitle', 'Kelola kelas yang dibuka setiap periode')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="{{ route('admin.user') }}"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="{{ route('admin.fasilitas') }}"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="{{ route('admin.unit') }}"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="{{ route('admin.periode') }}"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link" href="{{ route('admin.mata_kuliah') }}"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
    <a class="nav-link active" href="{{ route('admin.kelas') }}"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-easel-fill"></i> Daftar Kelas</div>
        
        <div class="d-flex align-items-center">
            <!-- Form untuk Filter Periode -->
            <form action="{{ route('admin.kelas') }}" method="GET" class="d-flex align-items-center">
                <select class="form-select form-select-sm me-2" name="periode_id" id="periodeFilter" onchange="this.form.submit()" style="width: auto;">
                    {{-- Asumsi $periodes (dari controller) berisi ID dan nama_periode --}}
                    {{-- Dan $currentPeriodeId adalah ID periode yang sedang aktif/dipilih --}}
                    <option value="">Semua Periode</option>
                    
                    {{-- Contoh data statis, ganti dengan loop Blade --}}
                    <option value="1" {{ request('periode_id') == 1 ? 'selected' : '' }}>Gasal 2024/2025</option>
                    <option value="2" {{ request('periode_id') == 2 ? 'selected' : '' }}>Genap 2023/2024</option>
                    <option value="3" {{ request('periode_id') == 3 ? 'selected' : '' }}>Gasal 2023/2024</option>
                </select>
                <button type="submit" class="d-none">Filter</button>
            </form>

            <a href="{{ route('admin.form_kelas') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle-fill"></i> Buka Kelas Baru</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen Pengampu</th>
                        <th>Periode</th>
                        <th>Jumlah Mahasiswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data tabel di sini akan difilter oleh controller berdasarkan request('periode_id') --}}
                    <tr>
                        <td>1</td>
                        <td>Algoritma & Pemrograman</td>
                        <td>Prof. Budi Santoso</td>
                        <td>Gasal 2024/2025</td>
                        <td>45</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                            <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
                            <a href="{{ route('admin.enrollment') }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</a>
                        </td>
                    </tr>
                     <tr>
                        <td>2</td>
                        <td>Struktur Data</td>
                        <td>Dr. Citra Lestari</td>
                        <td>Gasal 2024/2025</td>
                        <td>42</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                            <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
                            <a href="#" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

