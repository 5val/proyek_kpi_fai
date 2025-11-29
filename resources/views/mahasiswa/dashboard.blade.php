@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('page-title', 'Dashboard Mahasiswa')
@section('page-subtitle', 'Monitoring & Penilaian KPI')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-custom border-0 text-white shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4">
                    {{-- Flexbox Responsive: Column di Mobile, Row di Desktop --}}
                    <div class="d-flex flex-column flex-md-row align-items-center text-center text-md-start">
                        
                        {{-- Avatar --}}
                        <div class="mb-3 mb-md-0 me-md-4">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold shadow-sm" 
                                 style="width: 100px; height: 100px; font-size: 2.5rem; color: #667eea;">
                                AP
                            </div>
                        </div>
                        
                        {{-- Info Mahasiswa --}}
                        <div class="flex-grow-1 mb-3 mb-md-0">
                            <h3 class="fw-bold mb-2">Andi Pratama</h3>
                            <div class="d-flex flex-column gap-1 opacity-75">
                                <span><i class="bi bi-card-text me-2"></i> NIM: 2021010001</span>
                                <span><i class="bi bi-book me-2"></i> Teknik Informatika</span>
                                <span><i class="bi bi-calendar-check me-2"></i> Sem 7 (Gasal 2024/2025)</span>
                            </div>
                        </div>
                        
                        {{-- IPK Badge --}}
                        <div class="bg-white bg-opacity-10 p-3 rounded-3 text-center" style="min-width: 140px;">
                            <h1 class="display-5 fw-bold mb-0">3.75</h1>
                            <small class="text-uppercase text-white-50 fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">IPK Kumulatif</small>
                            <div class="mt-2">
                                <span class="badge bg-white text-primary rounded-pill px-3">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card card-custom h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="icon text-success mb-2 fs-1">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-0">4.2</h3>
                    <p class="text-muted small text-uppercase fw-bold mb-1">Skor KPI</p>
                    <small class="text-success fw-bold"><i class="bi bi-arrow-up"></i> Excellent</small>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-custom h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="icon text-primary mb-2 fs-1">
                        <i class="bi bi-journal-check"></i>
                    </div>
                    <h3 class="fw-bold mb-0">3.85</h3>
                    <p class="text-muted small text-uppercase fw-bold mb-1">IPK Semester</p>
                    <small class="text-info fw-bold">Gasal 2024</small>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-custom h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="icon text-warning mb-2 fs-1">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-0">8</h3>
                    <p class="text-muted small text-uppercase fw-bold mb-1">Pending</p>
                    <small class="text-danger fw-bold">Perlu diisi</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card card-custom h-100 shadow-sm border-0">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-graph-up me-2"></i> Performa KPI Saya
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="myKpiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card card-custom h-100 shadow-sm border-0">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-list-check me-2"></i> Status Penilaian
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small fw-bold">Penilaian Dosen</span>
                            <span class="badge bg-success rounded-pill">5/5</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small fw-bold">Penilaian Fasilitas</span>
                            <span class="badge bg-warning text-dark rounded-pill">6/10</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: 60%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small fw-bold">Penilaian Unit</span>
                            <span class="badge bg-danger rounded-pill">2/6</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: 33%"></div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <button class="btn btn-primary w-100 shadow-sm">
                            <i class="bi bi-pencil-square me-2"></i> Lanjutkan Penilaian
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-custom shadow-sm border-0">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-clipboard-data me-2"></i> Detail Indikator KPI Saya
                </div>
                <div class="card-body p-0 p-md-3">
                    <div class="table-responsive">
                        {{-- text-nowrap: Agar tabel rapi horizontal scroll di HP --}}
                        <table class="table table-hover align-middle w-100 text-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Indikator</th>
                                    <th>Target</th>
                                    <th>Capaian</th>
                                    <th>Skor</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="bi bi-book text-primary me-2"></i> IPK Semester</td>
                                    <td class="text-muted">≥ 3.50</td>
                                    <td class="fw-bold text-dark">3.75</td>
                                    <td><span class="badge bg-light text-dark border">3.5 / 4</span></td>
                                    <td class="text-center"><span class="badge bg-success rounded-pill">Excellent</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-check text-info me-2"></i> Kehadiran</td>
                                    <td class="text-muted">≥ 80%</td>
                                    <td class="fw-bold text-dark">94%</td>
                                    <td><span class="badge bg-light text-dark border">4.0 / 4</span></td>
                                    <td class="text-center"><span class="badge bg-success rounded-pill">Excellent</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-trophy text-warning me-2"></i> Prestasi</td>
                                    <td class="text-muted">≥ 2 item</td>
                                    <td class="fw-bold text-dark">3 item</td>
                                    <td><span class="badge bg-light text-dark border">3.8 / 4</span></td>
                                    <td class="text-center"><span class="badge bg-success rounded-pill">Excellent</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-people text-success me-2"></i> Organisasi</td>
                                    <td class="text-muted">Min 1</td>
                                    <td class="fw-bold text-dark">2 Org</td>
                                    <td><span class="badge bg-light text-dark border">3.0 / 4</span></td>
                                    <td class="text-center"><span class="badge bg-primary rounded-pill">Good</span></td>
                                </tr>
                                <tr class="table-danger bg-opacity-10">
                                    <td><i class="bi bi-laptop text-danger me-2"></i> Tugas & Prak</td>
                                    <td class="text-muted">≥ 85%</td>
                                    <td class="fw-bold text-danger">72%</td>
                                    <td><span class="badge bg-white text-danger border border-danger">2.9 / 4</span></td>
                                    <td class="text-center"><span class="badge bg-warning text-dark rounded-pill">Improve</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4 g-4">
        
        {{-- Pending Assessments --}}
        <div class="col-12 col-lg-6">
            <div class="card card-custom h-100 shadow-sm border-0">
                <div class="card-header bg-warning py-3 fw-bold">
                    <i class="bi bi-exclamation-circle me-2"></i> Penilaian Belum Diisi
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        {{-- Item 1 --}}
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="me-3 overflow-hidden">
                                <strong class="text-truncate d-block">Perpustakaan Pusat</strong>
                                <small class="text-muted"><i class="bi bi-building me-1"></i> Fasilitas</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">Isi</a>
                        </div>
                        
                        {{-- Item 2 --}}
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="me-3 overflow-hidden">
                                <strong class="text-truncate d-block">Lab Komputer Dasar</strong>
                                <small class="text-muted"><i class="bi bi-pc-display me-1"></i> Fasilitas</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">Isi</a>
                        </div>

                        {{-- Item 3 --}}
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="me-3 overflow-hidden">
                                <strong class="text-truncate d-block">Biro Administrasi Akademik</strong>
                                <small class="text-muted"><i class="bi bi-bank2 me-1"></i> Unit Layanan</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">Isi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Quick Actions --}}
        <div class="col-12 col-lg-6">
            <div class="card card-custom h-100 shadow-sm border-0">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-lightning-charge-fill me-2"></i> Menu Cepat
                </div>
                <div class="card-body">
                    {{-- Grid 2 kolom di Mobile (col-6), 2 kolom di desktop (col-lg-6) --}}
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('mahasiswa.penilaian_dosen') }}" class="btn btn-outline-primary w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center gap-2">
                                <i class="bi bi-person-video3 fs-1"></i>
                                <span class="small fw-bold">Nilai Dosen</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('mahasiswa.penilaian_fasilitas') }}" class="btn btn-outline-success w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center gap-2">
                                <i class="bi bi-building fs-1"></i>
                                <span class="small fw-bold">Nilai Fasilitas</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('mahasiswa.feedback') }}" class="btn btn-outline-warning w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center gap-2 text-dark">
                                <i class="bi bi-chat-dots fs-1"></i>
                                <span class="small fw-bold">Feedback</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('mahasiswa.laporan') }}" class="btn btn-outline-info w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center gap-2 text-dark">
                                <i class="bi bi-file-earmark-text fs-1"></i>
                                <span class="small fw-bold">Laporan</span>
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
    // Konfigurasi Font Responsif
    Chart.defaults.font.family = "'Segoe UI', 'Helvetica', 'Arial', sans-serif";
    Chart.defaults.font.size = 11;

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
                borderWidth: 2
            }, {
                label: 'Target Minimum',
                data: [3.5, 4.0, 3.5, 3.0, 3.5],
                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                borderColor: '#e74c3c',
                pointBackgroundColor: '#e74c3c',
                pointBorderColor: '#fff',
                borderWidth: 2,
                borderDash: [5, 5]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // PENTING agar responsif di container
            scales: {
                r: {
                    beginAtZero: true,
                    max: 5,
                    ticks: { display: false, stepSize: 1 },
                    pointLabels: {
                        font: { size: 12, weight: 'bold' }
                    }
                }
            },
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush