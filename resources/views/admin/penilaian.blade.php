@extends('layouts.app')

@section('title', 'Data Penilaian')

@section('page-title', 'Data Penilaian Masuk')
@section('page-subtitle', 'Monitoring semua data penilaian yang telah diinput')
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
    <a class="nav-link active" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-star-fill"></i> Log Penilaian Terbaru</div>
        
        <div class="d-flex align-items-center">
            <!-- Form untuk Filter Kategori -->
            <form action="{{-- route('admin.penilaian') --}}" method="GET" class="d-flex align-items-center">
                <select class="form-select form-select-sm me-2" name="kategori_id" id="kategoriFilter" onchange="this.form.submit()" style="width: auto;">
                    <option value="">Semua Kategori</option>
                    {{-- Ganti dengan loop Blade dari $kategori --}}
                    <option value="1" {{ request('kategori_id') == 1 ? 'selected' : '' }}>Kinerja Dosen</option>
                    <option value="2" {{ request('kategori_id') == 2 ? 'selected' : '' }}>Kinerja Mahasiswa</option>
                    <option value="3" {{ request('kategori_id') == 3 ? 'selected' : '' }}>Fasilitas</option>
                    <option value="4" {{ request('kategori_id') == 4 ? 'selected' : '' }}>Unit Layanan</option>
                    <option value="5" {{ request('kategori_id') == 5 ? 'selected' : '' }}>Praktikum</option>
                </select>
                <button type="submit" class="d-none">Filter</button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Penilai</th>
                        <th>Objek yang Dinilai</th>
                        <th>Kategori</th>
                        <th>Skor Rata-rata</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Andi Pratama</td>
                        <td>Dr. Budi Hartono, M.Kom.</td>
                        <td>Kinerja Dosen</td>
                        <td><span class="badge bg-primary">4.8 / 5.0</span></td>
                        <td>2024-10-15 14:30</td>
                        <td><a href="{{ route('admin.detail_penilaian') }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</a></td>
                    </tr>
                    <tr class="table-danger">
                        <td>Siti Aminah</td>
                        <td>Perpustakaan Pusat</td>
                        <td>Fasilitas</td>
                        <td><span class="badge bg-danger">1.8 / 5.0</span></td>
                        <td>2024-10-15 13:05</td>
                        <td><a href="{{-- route('admin.penilaian.detail', 2) --}}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</a></td>
                    </tr>
                    <tr>
                        <td>Dr. Budi Hartono, M.Kom.</td>
                        <td>Andi Pratama</td>
                        <td>Kinerja Mahasiswa</td>
                        <td><span class="badge bg-primary">4.5 / 5.0</span></td>
                        <td>2024-10-15 12:00</td>
                        <td><a href="{{-- route('admin.penilaian.detail', 3) --}}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

