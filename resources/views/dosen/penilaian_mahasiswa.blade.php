@extends('layouts.app')

@section('title', 'Penilaian Mahasiswa')

@section('page-title', 'Penilaian Mahasiswa Bimbingan')
@section('page-subtitle', 'Berikan penilaian kinerja untuk mahasiswa bimbingan Anda')
@section('user-name', 'Dr. Budi Hartono, M.Kom.')
@section('user-role', 'Dosen - Teknik Informatika')
@section('user-initial', 'BH')

@section('sidebar-menu')
    <a class="nav-link" href="/dosen"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="/dosen/profile"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="/dosen/kpi"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="/dosen/kelas"><i class="bi bi-pencil-square"></i> Kelas</a>
    <a class="nav-link active" href="/dosen/penilaian_mahasiswa"><i class="bi bi-people"></i> Penilaian Mahasiswa</a>
    <a class="nav-link" href="/dosen/penilaian_fasilitas"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="/dosen/penilaian_unit"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="/dosen/laporan"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kinerja</a>
    <a class="nav-link" href="/dosen/feedback"><i class="bi bi-chat-left-text"></i> Feedback</a>
    <form action="{{ route('logout') }}" method="POST" style="float: right;">
      @csrf
      <div style="align-items: center; justify-content: center; display: flex;">
        <button class="btn btn-danger" type="submit">Logout</button>
      </div>
   </form>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header"><i class="bi bi-list-check"></i> Daftar Mahasiswa Bimbingan</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <th>NRP</th>
                        <th>Semester</th>
                        <th>Status Penilaian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Rina Wulandari</td>
                        <td>2021010015</td>
                        <td>7</td>
                        <td><span class="badge bg-danger">Belum Dinilai</span></td>
                        <td><button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Nilai</button></td>
                    </tr>
                     <tr>
                        <td>Agus Setiawan</td>
                        <td>2022010008</td>
                        <td>5</td>
                        <td><span class="badge bg-danger">Belum Dinilai</span></td>
                        <td><button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Nilai</button></td>
                    </tr>
                     <tr>
                        <td>Dewi Lestari</td>
                        <td>2021010002</td>
                        <td>7</td>
                        <td><span class="badge bg-success">Sudah Dinilai</span></td>
                        <td><button class="btn btn-secondary btn-sm" disabled><i class="bi bi-pencil-square"></i> Nilai</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
