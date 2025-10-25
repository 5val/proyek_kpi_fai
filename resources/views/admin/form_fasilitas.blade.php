@extends('layouts.app')

@section('title', 'Formulir Fasilitas')

@section('page-title', 'Formulir Fasilitas')
@section('page-subtitle', 'Tambah atau edit data fasilitas kampus')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="{{ route('admin.user') }}"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link active" href="{{ route('admin.fasilitas') }}"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="{{ route('admin.unit') }}"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="{{ route('admin.periode') }}"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link" href="{{ route('admin.mata_kuliah') }}"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
    <a class="nav-link" href="{{ route('admin.kelas') }}"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header">
        <i class="bi bi-plus-circle-fill"></i> Tambah Fasilitas Baru
    </div>
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="facilityName" class="form-label">Nama Fasilitas</label>
                    <input type="text" class="form-control" id="facilityName" placeholder="Contoh: Perpustakaan Pusat">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="facilityCategory" class="form-label">Kategori</label>
                    <select id="facilityCategory" class="form-select">
                        <option selected>Pilih kategori...</option>
                        <option value="umum">Umum</option>
                        <option value="laboratorium">Laboratorium</option>
                        <option value="ruang_kelas">Ruang Kelas</option>
                        <option value="area_mahasiswa">Area Mahasiswa</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="location" placeholder="Contoh: Gedung A Lantai 2">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="condition" class="form-label">Kondisi</label>
                    <select id="condition" class="form-select">
                        <option selected>Pilih kondisi...</option>
                        <option value="baik">Baik</option>
                        <option value="perlu_perbaikan">Perlu Perbaikan</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('admin.fasilitas') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
