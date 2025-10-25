@extends('layouts.app')

@section('title', 'Manajemen Mata Kuliah')

@section('page-title', 'Manajemen Mata Kuliah')
@section('page-subtitle', 'Kelola data master mata kuliah')
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
        <div><i class="bi bi-book-fill"></i> Daftar Mata Kuliah</div>
        <a href="{{ route('admin.form_mata_kuliah') }}" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> Tambah Mata Kuliah</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>IF101</td>
                        <td>Algoritma & Pemrograman</td>
                        <td>3</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                            <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>IF102</td>
                        <td>Struktur Data</td>
                        <td>3</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                            <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    </tr>
                     <tr>
                        <td>3</td>
                        <td>KU201</td>
                        <td>Pendidikan Kewarganegaraan</td>
                        <td>2</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                            <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

