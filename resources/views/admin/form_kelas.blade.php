@extends('layouts.app')

@section('title', 'Form Kelas')

@section('page-title', 'Formulir Kelas')
@section('page-subtitle', 'Buka kelas baru untuk periode akademik')
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
    <div class="card-header"><i class="bi bi-pencil-square"></i> Form Kelas</div>
    <div class="card-body">
        <form>
            <div class="mb-3">
                <label for="matkul" class="form-label">Mata Kuliah</label>
                <select class="form-select" id="matkul">
                    <option selected disabled>Pilih mata kuliah...</option>
                    <option value="1">Algoritma & Pemrograman</option>
                    <option value="2">Struktur Data</option>
                    <option value="3">Pendidikan Kewarganegaraan</option>
                </select>
            </div>
             <div class="mb-3">
                <label for="periode" class="form-label">Periode Akademik</label>
                <select class="form-select" id="periode">
                    <option selected disabled>Pilih periode...</option>
                    <option value="1">Gasal 2024/2025</option>
                    <option value="2">Genap 2024/2025</option>
                </select>
            </div>
             <div class="mb-3">
                <label for="dosen" class="form-label">Dosen Pengampu</label>
                <select class="form-select" id="dosen">
                    <option selected disabled>Pilih dosen...</option>
                    <option value="1">Prof. Budi Santoso</option>
                    <option value="2">Dr. Citra Lestari</option>
                </select>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.kelas') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

