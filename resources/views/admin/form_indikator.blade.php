@extends('layouts.app')

@section('title', 'Formulir Indikator KPI')

@section('page-title', 'Formulir Indikator KPI')
@section('page-subtitle', 'Tambah atau edit indikator untuk sebuah kategori')
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
    <a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header">
        <i class="bi bi-plus-circle-fill"></i> Tambah Indikator untuk Kategori: <strong>Kinerja Dosen</strong>
    </div>
    <div class="card-body">
        <form>
            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <input type="text" class="form-control" id="category" value="Kinerja Dosen" readonly>
            </div>
            <div class="mb-3">
                <label for="indicatorName" class="form-label">Nama Indikator</label>
                <input type="text" class="form-control" id="indicatorName" placeholder="Contoh: Penguasaan Materi">
            </div>
             <div class="mb-3">
                <label for="scale" class="form-label">Skala Penilaian</label>
                <input type="text" class="form-control" id="scale" value="1 - 4" placeholder="Contoh: 1 - 4 atau Persentase">
            </div>
            <div class="mb-3">
                <label for="weight" class="form-label">Bobot (%)</label>
                <input type="number" class="form-control" id="weight" placeholder="Masukkan bobot dalam persen (contoh: 20)">
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="#" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
