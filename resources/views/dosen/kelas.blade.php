@extends('layouts.app')

@section('title', 'Mata Kuliah Dosen')
@section('page-title', 'Mata Kuliah')
@section('page-subtitle', 'Daftar mata kuliah yang Anda ampu')

@section('user-name', $user->name)
@section('user-role', $user->role)

@section('sidebar-menu')
    <a class="nav-link" href="/dosen"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="/dosen/profile"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="/dosen/kpi"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link active" href="/dosen/kelas"><i class="bi bi-pencil-square"></i> Kelas</a>
    <a class="nav-link" href="/dosen/penilaian_mahasiswa"><i class="bi bi-people"></i> Penilaian Mahasiswa</a>
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
@if(session('success'))
   <div class="alert alert-success">{{ session('success') }}</div>
@endif
<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <label for="periode" class="form-label">Pilih Periode</label>
                        <select class="form-select" id="periode">
                            <option selected>Semester Gasal 2024/2025</option>
                            <option>Semester Genap 2023/2024</option>
                            <option>Semester Gasal 2023/2024</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary"><i class="bi bi-filter"></i> Tampilkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="card-custom">
    <div class="card-header"><i class="bi bi-book-fill"></i> Mata Kuliah yang Diampu (Gasal 2024/2025)</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <!-- <th>Kode MK</th> -->
                        <th>Nama Mata Kuliah</th>
                        <th>Program Studi</th>
                        <th>SKS</th>
                        <th>Jml Mhs</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
            @forelse($kelasList as $kelas)
                <tr>
                    <!-- <td>{{ $kelas->mataKuliah->code }}</td> -->
                    <td>{{ $kelas->mataKuliah->name }}</td>
                    <td>{{ $kelas->program_studi->name }}</td>
                    <td class="text-center">{{ $kelas->sks }}</td>
                    <td class="text-center">{{ $kelas->enrollment_count }}</td>
                    <td>
                        <a href="{{ route('dosen.form_kehadiran', $kelas->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-calendar-plus-fill"></i> Input Kehadiran
                        </a>
                        @if($kelas->punya_praktikum ?? false)
                            <a href="#" class="btn btn-info btn-sm">
                                <i class="bi bi-clipboard-data"></i> Laporan Praktikum
                            </a>
                        @else
                            <a href="#" class="btn btn-secondary btn-sm disabled">
                                <i class="bi bi-clipboard-data"></i> Laporan Praktikum
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada mata kuliah yang Anda ampu.</td>
                </tr>
            @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

