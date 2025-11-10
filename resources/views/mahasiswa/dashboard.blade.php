@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('page-title', 'Dashboard Mahasiswa')
@section('page-subtitle', 'Monitoring & Penilaian KPI')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('sidebar-menu')
    <a class="nav-link active" href="{{ route('mahasiswa.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="{{ route('mahasiswa.profile') }}"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="{{ route('mahasiswa.kpi') }}"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="{{ route('mahasiswa.penilaian_dosen') }}"><i class="bi bi-star"></i> Penilaian Dosen</a>
    <a class="nav-link" href="{{ route('mahasiswa.penilaian_fasilitas') }}"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="{{ route('mahasiswa.penilaian_unit') }}"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="{{ route('mahasiswa.penilaian_praktikum') }}"><i class="bi bi-person-workspace"></i> Penilaian Praktikum</a>
    <a class="nav-link" href="{{ route('mahasiswa.feedback') }}"><i class="bi bi-chat-left-text"></i> Feedback</a>
    <a class="nav-link" href="{{ route('mahasiswa.laporan') }}"><i class="bi bi-bar-chart"></i> Laporan KPI</a>
    <form action="{{ route('logout') }}" method="POST" style="float: right;">
      @csrf
      <div style="align-items: center; justify-content: center; display: flex;">
        <button class="btn btn-danger" type="submit">Logout</button>
      </div>
   </form>
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
        <div class="col-md-4">
            <div class="stat-card text-center">
                <div class="icon text-success">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <h3 class="fw-bold">4.2</h3>
                <p class="text-muted mb-0">Skor KPI Saya</p>
                <small class="text-success"><i class="bi bi-arrow-up"></i> Excellent</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center">
                <div class="icon text-primary">
                    <i class="bi bi-journal-check"></i>
                </div>
                <h3 class="fw-bold">3.85</h3>
                <p class="text-muted mb-0">IPK Semester</p>
                <small class="text-info">Gasal 2024/2025</small>
            </div>
        </div>
        <div class="col-md-4">
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
    
    <!-- My KPI Performance -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card-custom">
                <div class="card-header">
                    <i class="bi bi-graph-up"></i> Performa KPI Saya
                </div>
                <div class="card-body">
                    <canvas id="myKpiChart" height="80"></canvas>
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
    
    <!-- Detailed KPI Breakdown -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card-custom">
                <div class="card-header">
                    <i class="bi bi-clipboard-data"></i> Detail Indikator KPI Saya
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Indikator</th>
                                    <th>Target</th>
                                    <th>Capaian</th>
                                    <th>Skor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="bi bi-book text-primary"></i> IPK Semester</td>
                                    <td>≥ 3.50</td>
                                    <td><strong>3.75</strong></td>
                                    <td><span class="badge bg-success">3.5/4</span></td>
                                    <td><span class="badge bg-success">Excellent</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-check text-info"></i> Kehadiran Perkuliahan</td>
                                    <td>≥ 80%</td>
                                    <td><strong>94%</strong></td>
                                    <td><span class="badge bg-success">4.0/4</span></td>
                                    <td><span class="badge bg-success">Excellent</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-trophy text-warning"></i> Prestasi Akademik</td>
                                    <td>≥ 2 prestasi</td>
                                    <td><strong>3 prestasi</strong></td>
                                    <td><span class="badge bg-success">3.8/4</span></td>
                                    <td><span class="badge bg-success">Excellent</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-people text-success"></i> Keaktifan Organisasi</td>
                                    <td>Minimal 1 organisasi</td>
                                    <td><strong>2 organisasi</strong></td>
                                    <td><span class="badge bg-primary">3.0/4</span></td>
                                    <td><span class="badge bg-primary">Good</span></td>
                                </tr>
                                <tr class="table-danger">
                                    <td><i class="bi bi-laptop text-danger"></i> Tugas & Praktikum</td>
                                    <td>≥ 85% tepat waktu</td>
                                    <td><strong>72%</strong></td>
                                    <td><span class="badge bg-warning">2.9/4</span></td>
                                    <td><span class="badge bg-warning">Needs Improvement</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pending Assessments -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card-custom">
                <div class="card-header bg-warning text-white">
                    <i class="bi bi-exclamation-triangle"></i> Penilaian yang Perlu Diisi
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Penilaian Perpustakaan</strong>
                                <p class="mb-0 text-muted small">Kategori: Fasilitas</p>
                            </div>
                                <a href="{{ route('penilaian') }}" class="btn btn-primary btn-sm">
                                    Isi
                                </a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Penilaian Lab Komputer</strong>
                                <p class="mb-0 text-muted small">Kategori: Fasilitas</p>
                            </div>
                                <a href="{{ route('penilaian') }}" class="btn btn-primary btn-sm">
                                    Isi
                                </a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Penilaian BAA</strong>
                                <p class="mb-0 text-muted small">Layanan Akademik</p>
                            </div>
                            <a href="{{ route('penilaian') }}" class="btn btn-primary btn-sm">
                                Isi
                            </a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Penilaian BAK</strong>
                                <p class="mb-0 text-muted small">Layanan Kemahasiswaan</p>
                            </div>
                            <a href="{{ route('penilaian') }}" class="btn btn-primary btn-sm">
                                Isi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card-custom">
                <div class="card-header">
                    <i class="bi bi-lightning-charge"></i> Menu Cepat
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('mahasiswa.penilaian_dosen') }}"class="btn btn-outline-primary btn-custom w-100">
                                <i class="bi bi-star" style="font-size: 2rem;"></i><br>
                                Nilai Dosen
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('mahasiswa.penilaian_fasilitas') }}" class="btn btn-outline-success btn-custom w-100">
                                <i class="bi bi-building" style="font-size: 2rem;"></i><br>
                                Nilai Fasilitas
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('mahasiswa.feedback') }}" class="btn btn-outline-warning btn-custom w-100">
                                <i class="bi bi-chat-left-dots" style="font-size: 2rem;"></i><br>
                                Kirim Feedback
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('mahasiswa.laporan') }}" class="btn btn-outline-info btn-custom w-100">
                                <i class="bi bi-file-earmark-text" style="font-size: 2rem;"></i><br>
                                Lihat Laporan
                            </a>
                        </div>
                    </div>
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
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                borderColor: '#3498db',
                pointBackgroundColor: '#3498db',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#3498db'
            }, {
                label: 'Target Minimum',
                data: [3.5, 4.0, 3.5, 3.0, 3.5],
                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                borderColor: '#e74c3c',
                pointBackgroundColor: '#e74c3c',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#e74c3c'
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush