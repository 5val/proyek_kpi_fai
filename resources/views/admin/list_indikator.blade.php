@extends('layouts.app')

@section('title', 'Daftar Indikator KPI')

@section('page-title', 'Indikator KPI - Kinerja Dosen')
@section('page-subtitle', 'Kelola semua indikator penilaian untuk kategori Kinerja Dosen')
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
    <a class="nav-link active" href="#"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="#"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-arrow-left"></i> Kembali</a>
            <i class="bi bi-list-task"></i> Daftar Indikator untuk <strong>Kinerja Dosen</strong>
        </div>
        <a href="{{-- route('admin.indikator.create') --}}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Indikator</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Indikator</th>
                        <th>Skala Penilaian</th>
                        <th>Bobot (%)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Penguasaan Materi</td>
                        <td>1 - 5</td>
                        <td>25</td>
                        <td>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i> Edit</button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i> Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Kejelasan dalam Menyampaikan Materi</td>
                        <td>1 - 5</td>
                        <td>20</td>
                        <td>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i> Edit</button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i> Hapus</button>
                        </td>
                    </tr>
                     <tr>
                        <td>3</td>
                        <td>Kemampuan Memberi Motivasi</td>
                        <td>1 - 5</td>
                        <td>15</td>
                        <td>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i> Edit</button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i> Hapus</button>
                        </td>
                    </tr>
                     <tr>
                        <td>4</td>
                        <td>Kedisiplinan Waktu</td>
                        <td>1 - 5</td>
                        <td>15</td>
                        <td>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i> Edit</button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i> Hapus</button>
                        </td>
                    </tr>
                     <tr>
                        <td>5</td>
                        <td>Keadilan dalam Penilaian</td>
                        <td>1 - 5</td>
                        <td>25</td>
                        <td>
                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i> Edit</button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i> Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
