@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('page-title', 'Dashboard Mahasiswa')
@section('page-subtitle', 'Monitoring & Penilaian KPI')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('sidebar-menu')
    <a class="nav-link active" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-star"></i> Penilaian Dosen</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text"></i> Feedback</a>
    <a class="nav-link" href="#"><i class="bi bi-bar-chart"></i> Laporan KPI</a>
@endsection

@section('content')
    <!-- Student Info Card -->
    <div class="row">
        <div class="col-md-12">
            <div class="card-custom mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <div style="width: 100px; height: 100px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-size: 2.5rem; color: #667eea; font-weight: bold;">
                                AP
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h3 class="mb-2">Andi Pratama</h3>
                            <p class="mb-1"><i class="bi bi-card-text"></i> NIM: 2021010001</p>
                            <p class="mb-1"><i class="bi bi-book"></i> Program Studi: Teknik Informatika</p>
                            <p class="mb-0"><i class="bi bi-calendar-check"></i> Semester: 7 (Gasal 2024/2025)</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="mb-3">
                                <h1 class="display-4 fw-bold mb-0">3.75</h1>
                                <p class="mb-0">IPK Kumulatif</p>
                            </div>
                            <span class="badge bg-light text-dark px-3 py-2">Status: Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- KPI Statistics -->
    <div class="row">
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon text-success">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <h3 class="fw-bold">4.2</h3>
                <p class="text-muted mb-0">Skor KPI Saya</p>
                <small class="text-success"><i class="bi bi-arrow-up"></i> Excellent</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon text-primary">
                    <i class="bi bi-award-fill"></i>
                </div>
                <h3 class="fw-bold">12</h3>
                <p class="text-muted mb-0">Total Prestasi</p>
                <small class="text-info">Semester ini: 3</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon text-warning">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h3 class="fw-bold">94%</h3>
                <p class="text-muted mb-0">Kehadiran</p>
                <small class="text-success"><i class="bi bi-check-circle"></i> Sangat Baik</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon text-info">
                    <i class="bi bi-star-fill"></i>
                </div>
                <h3 class="fw-bold">8</h3>
                <p class="text-muted mb-0">Penilaian Pending</p>
                <small class="text-danger">Perlu diisi</small>
            </div>
        </div>
    </div>
    
    <!-- My KPI Performance & Assessment Status -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card-custom">
                <div class="card-header">
                    <i class="bi bi-graph-up"></i> Performa KPI Saya
                </div>
                <div class="card-body">
                    <canvas id="myKpiChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-custom">
                <div class="card-header">
                    <i class="bi bi-list-check"></i> Status Penilaian
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Penilaian Dosen</span>
                            <span class="badge bg-success">5/5 Selesai</span>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Penilaian Fasilitas</span>
                            <span class="badge bg-warning">6/10 Selesai</span>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-warning" style="width: 60%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Penilaian Unit</span>
                            <span class="badge bg-danger">2/6 Selesai</span>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-danger" style="width: 33%"></div>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-primary btn-custom w-100">
                        <i class="bi bi-pencil-square"></i> Lanjutkan Penilaian
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts') 
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // My KPI Chart
    const myKpiCtx = document.getElementById('myKpiChart').getContext('2d');
    new Chart(myKpiCtx, {
        type: 'radar',
        data: {
            labels: ['IPK', 'Kehadiran', 'Prestasi', 'Organisasi', 'Tugas'],
            datasets: [{
                label: 'Skor Saya',
                data: [4.5, 5.0, 4.8, 4.0, 3.2],
                backgroundColor: 'rgba(102, 126, 234, 0.2)',
                borderColor: 'rgba(102, 126, 234, 1)',
                pointBackgroundColor: 'rgba(102, 126, 234, 1)',
                pointBorderColor: '#fff',
            }, {
                label: 'Target Minimum',
                data: [3.5, 4.0, 3.5, 3.0, 3.5],
                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                borderColor: '#e74c3c',
                pointBackgroundColor: '#e74c3c',
                pointBorderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 5,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
