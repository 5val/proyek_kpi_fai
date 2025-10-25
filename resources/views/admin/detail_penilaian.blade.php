@extends('layouts.app')

@section('title', 'Detail Penilaian')

@section('page-title', 'Detail Penilaian')
@section('page-subtitle', 'Rincian skor dan komentar dari penilaian')
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
<a href="{{ route('admin.penilaian') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
<div class="row">
    <!-- Kolom Kiri: Ringkasan & Komentar -->
    <div class="col-md-5">
        <div class="card-custom mb-4">
             <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="bi bi-info-circle-fill"></i> Ringkasan Penilaian</div>
                <a href="{{-- route('admin.penilaian') --}}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Penilai:</strong>
                        <span>Andi Pratama (Mahasiswa)</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Objek Dinilai:</strong>
                        <span>Dr. Budi Hartono, M.Kom.</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Kategori:</strong>
                        <span>Kinerja Dosen</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Periode:</strong>
                        <span>Gasal 2024/2025</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Waktu Penilaian:</strong>
                        <span>2024-10-15 14:30</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Skor Rata-rata:</strong>
                        <span class="badge bg-primary fs-6">4.8 / 5.0</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-custom">
            <div class="card-header"><i class="bi bi-chat-quote-fill"></i> Komentar Penilai</div>
            <div class="card-body">
                <p class="fst-italic">"Secara keseluruhan sudah sangat baik. Penguasaan materi dan cara penyampaian sangat jelas. Mungkin slide materi bisa dibuat lebih menarik secara visual."</p>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Rincian Skor -->
    <div class="col-md-7">
        <div class="card-custom">
            <div class="card-header"><i class="bi bi-list-stars"></i> Rincian Skor per Indikator</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Indikator Penilaian</th>
                                <th class="text-center">Skor (1-5)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Penguasaan Materi</td>
                                <td class="text-center"><span class="badge bg-success">5.0</span></td>
                            </tr>
                            <tr>
                                <td>Kejelasan Penyampaian Materi</td>
                                <td class="text-center"><span class="badge bg-success">5.0</span></td>
                            </tr>
                            <tr>
                                <td>Kesesuaian Materi dengan RPS</td>
                                <td class="text-center"><span class="badge bg-primary">4.0</span></td>
                            </tr>
                            <tr>
                                <td>Penggunaan Media Pembelajaran</td>
                                <td class="text-center"><span class="badge bg-warning">3.0</span></td>
                            </tr>
                            <tr>
                            <tr>
                                <td>Ketepatan Waktu & Disiplin</td>
                                <td class="text-center"><span class="badge bg-success">5.0</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
