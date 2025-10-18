@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Selamat Datang di Panel Kontrol Sistem KPI')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link active" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
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
<!-- Admin Statistics Cards -->

    <div class="row">

        <div class="col-md-3">

            <div class="stat-card text-center">

                <div class="icon text-primary"><i class="bi bi-people-fill"></i></div>

                <h3 class="fw-bold">1,250</h3>

                <p class="text-muted mb-0">Total Pengguna</p>

            </div>

        </div>

        <div class="col-md-3">

            <div class="stat-card text-center">

                <div class="icon text-success"><i class="bi bi-person-video3"></i></div>

                <h3 class="fw-bold">150</h3>

                <p class="text-muted mb-0">Total Dosen</p>

            </div>

        </div>

        <div class="col-md-3">

            <div class="stat-card text-center">

                <div class="icon text-info"><i class="bi bi-person-check-fill"></i></div>

                <h3 class="fw-bold">1,050</h3>

                <p class="text-muted mb-0">Total Mahasiswa</p>

            </div>

        </div>

        <div class="col-md-3">

            <div class="stat-card text-center">

                <div class="icon text-warning"><i class="bi bi-clipboard2-data-fill"></i></div>

                <h3 class="fw-bold">25,480</h3>

                <p class="text-muted mb-0">Penilaian Masuk</p>

            </div>

        </div>

    </div>

<!-- Charts -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="card-header">
                <i class="bi bi-graph-up"></i> Tren Skor KPI Keseluruhan (6 Bulan Terakhir)
            </div>
            <div class="card-body">
                <canvas id="kpiTrendChart" height="90"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- KPI Overview & Recent Feedback -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="card-header"><i class="bi bi-bar-chart-line-fill"></i> Rata-rata Skor KPI per Kategori</div>
            <div class="card-body">
                <canvas id="kpiOverviewChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="card-header">
                <i class="bi bi-chat-left-text-fill"></i> Feedback Terbaru
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>
                                    <p class="mb-1">"Layanan di BAA sangat cepat dan membantu proses KRS saya."</p>
                                    <small class="text-muted">Untuk: <strong>Unit BAA</strong> - oleh Mahasiswa (Anonim)</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="mb-1">"Perpustakaan butuh lebih banyak koleksi buku untuk jurusan Teknik Informatika."</p>
                                    <small class="text-muted">Untuk: <strong>Perpustakaan</strong> - oleh Andi Pratama (Mahasiswa)</small>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                    <p class="mb-1">"Penjelasan Prof. Budi sangat mudah dipahami. Terima kasih, Pak."</p>
                                    <small class="text-muted">Untuk: <strong>Prof. Budi Santoso</strong> - oleh Mahasiswa (Anonim)</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="mb-1">"Koneksi WiFi di Gedung C sering terputus, mohon diperbaiki."</p>
                                    <small class="text-muted">Untuk: <strong>Fasilitas IT</strong> - oleh Rina Wijaya (Dosen)</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // KPI Trend Chart
    const kpiTrendCtx = document.getElementById('kpiTrendChart').getContext('2d');
    new Chart(kpiTrendCtx, {
        type: 'line',
        data: {
            labels: ['Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober'],
            datasets: [{
                label: 'Skor KPI Rata-rata',
                data: [3.8, 3.9, 4.0, 4.2, 4.1, 4.15],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false,
                    min: 3.5,
                    max: 4.5
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // KPI Overview Chart
    const kpiOverviewCtx = document.getElementById('kpiOverviewChart').getContext('2d');
    new Chart(kpiOverviewCtx, {
        type: 'bar',
        data: {
            labels: ['Dosen', 'Mahasiswa', 'Fasilitas', 'Unit Layanan'],
            datasets: [{
                label: 'Skor Rata-rata (skala 5)',
                data: [4.5, 4.2, 3.8, 4.1],
                backgroundColor: 'rgba(102, 126, 234, 0.7)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, max: 5 } }
        }
    });
</script>
@endpush