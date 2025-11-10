@extends('layouts.app')

@section('title', 'Daftar Feedback')

@section('page-title', 'Daftar Feedback')
@section('page-subtitle', 'Kelola semua feedback yang masuk dari pengguna')
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
    <a class="nav-link" href="{{ route('admin.kelas') }}"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link active" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
    <form action="{{ route('logout') }}" method="POST" style="float: right;">
      @csrf
      <div style="align-items: center; justify-content: center; display: flex;">
        <button class="btn btn-danger" type="submit">Logout</button>
      </div>
   </form>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-chat-left-text-fill"></i> Daftar Feedback Masuk</span>
        <div class="filter-options">
            <select class="form-select form-select-sm">
                <option selected>Semua Status</option>
                <option value="1">Belum Ditanggapi</option>
                <option value="2">Sudah Ditanggapi</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Pengirim</th>
                        <th>Isi Feedback</th>
                        <th>Target</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Andi Pratama</td>
                        <td>AC di Ruang Kelas R.301 tidak dingin, mohon segera diperbaiki.</td>
                        <td>Fasilitas</td>
                        <td>15 Okt 2025</td>
                        <td><span class="badge bg-warning text-dark">Belum Ditanggapi</span></td>
                        <td class="text-center">
                            <button class="btn btn-success btn-sm" title="Tandai Sudah Ditanggapi"><i class="bi bi-check-circle-fill"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Anonim</td>
                        <td>Saran agar jam operasional perpustakaan diperpanjang hingga jam 8 malam.</td>
                        <td>Fasilitas</td>
                        <td>14 Okt 2025</td>
                        <td><span class="badge bg-success">Sudah Ditanggapi</span></td>
                        <td class="text-center">
                             <button class="btn btn-danger btn-sm" title="Tandai Belum Ditanggapi"><i class="bi bi-x-circle-fill"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Rina Wijaya (Dosen)</td>
                        <td>Apresiasi untuk kebersihan dan kerapian taman di area depan kampus.</td>
                        <td>Lainnya</td>
                        <td>13 Okt 2025</td>
                         <td><span class="badge bg-success">Sudah Ditanggapi</span></td>
                        <td class="text-center">
                           <button class="btn btn-danger btn-sm" title="Tandai Belum Ditanggapi"><i class="bi bi-x-circle-fill"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Anonim</td>
                        <td>Proses pengambilan Kartu Rencana Studi (KRS) di BAA terlalu lambat.</td>
                        <td>Unit Layanan</td>
                        <td>12 Okt 2025</td>
                        <td><span class="badge bg-warning text-dark">Belum Ditanggapi</span></td>
                        <td class="text-center">
                            <button class="btn btn-success btn-sm" title="Tandai Sudah Ditanggapi"><i class="bi bi-check-circle-fill"></i></button>
                        </td>
                    </tr>
                     <tr>
                        <td>5</td>
                        <td>Anonim</td>
                        <td>Penjelasan Prof. Budi Santoso sangat mudah dipahami. Terima kasih, Pak.</td>
                        <td>Dosen</td>
                        <td>11 Okt 2025</td>
                        <td><span class="badge bg-success">Sudah Ditanggapi</span></td>
                        <td class="text-center">
                             <button class="btn btn-danger btn-sm" title="Tandai Belum Ditanggapi"><i class="bi bi-x-circle-fill"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

