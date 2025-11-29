@extends('layouts.app')

@section('title', 'KPI Saya')

@section('page-title', 'Key Performance Indicator (KPI) Saya')
@section('page-subtitle', 'Detail capaian kinerja Anda semester ini')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
<div class="row g-4"> <div class="col-12 col-lg-7">
        <div class="card card-custom h-100 shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-clipboard-data me-2"></i> Detail Indikator Kinerja
                <div class="small fw-normal mt-1 text-light">Semester Gasal 2024/2025</div>
            </div>
            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap: Agar tabel rapi scroll ke samping di HP --}}
                    <table class="table table-hover align-middle w-100 text-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Indikator Kinerja</th>
                                <th>Target</th>
                                <th>Capaian</th>
                                <th class="text-center">Skor</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="bi bi-book text-primary me-2"></i> IPK Semester</td>
                                <td class="text-muted">≥ 3.50</td>
                                <td class="fw-bold">3.75</td>
                                <td class="text-center"><span class="badge bg-success rounded-pill px-3">3.65</span></td>
                                <td class="text-center"><span class="badge bg-success bg-opacity-10 text-success border border-success">Melebihi Target</span></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar-check text-info me-2"></i> Kehadiran</td>
                                <td class="text-muted">≥ 80%</td>
                                <td class="fw-bold">94%</td>
                                <td class="text-center"><span class="badge bg-success rounded-pill px-3">4.0</span></td>
                                <td class="text-center"><span class="badge bg-success bg-opacity-10 text-success border border-success">Melebihi Target</span></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-trophy text-warning me-2"></i> Prestasi</td>
                                <td class="text-muted">≥ 2 Item</td>
                                <td class="fw-bold">3 Item</td>
                                <td class="text-center"><span class="badge bg-success rounded-pill px-3">3.8</span></td>
                                <td class="text-center"><span class="badge bg-success bg-opacity-10 text-success border border-success">Melebihi Target</span></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-people text-success me-2"></i> Organisasi</td>
                                <td class="text-muted">Min 1</td>
                                <td class="fw-bold">2 Org</td>
                                <td class="text-center"><span class="badge bg-primary rounded-pill px-3">3.5</span></td>
                                <td class="text-center"><span class="badge bg-primary bg-opacity-10 text-primary border border-primary">Tercapai</span></td>
                            </tr>
                            <tr class="table-danger bg-opacity-10">
                                <td><i class="bi bi-laptop text-danger me-2"></i> Tugas Tepat Waktu</td>
                                <td class="text-muted">≥ 85%</td>
                                <td class="fw-bold text-danger">72%</td>
                                <td class="text-center"><span class="badge bg-warning text-dark rounded-pill px-3">2.9</span></td>
                                <td class="text-center"><span class="badge bg-warning bg-opacity-10 text-dark border border-warning">Perlu Peningkatan</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card card-custom h-100 shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-chat-quote-fill me-2"></i> Komentar Dosen
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                    <div class="list-group-item p-3">
                        <div class="d-flex w-100 justify-content-between mb-1">
                            <h6 class="mb-0 fw-bold text-primary">Dr. Budi Hartono, M.Kom.</h6>
                            <small class="text-muted">2 hari lalu</small>
                        </div>
                        <p class="mb-1 text-secondary fst-italic">"Andi menunjukkan inisiatif yang sangat baik dalam bimbingan skripsi. Progresnya konsisten."</p>
                    </div>
                    
                    <div class="list-group-item p-3 bg-light">
                        <div class="d-flex w-100 justify-content-between mb-1">
                            <h6 class="mb-0 fw-bold text-primary">Prof. Dr. Indah Lestari</h6>
                            <small class="text-muted">5 hari lalu</small>
                        </div>
                        <p class="mb-1 text-secondary fst-italic">"Keaktifannya di kelas Algoritma Lanjut patut diapresiasi."</p>
                    </div>
                    
                    <div class="list-group-item p-3">
                        <div class="d-flex w-100 justify-content-between mb-1">
                            <h6 class="mb-0 fw-bold text-primary">Ahmad Maulana, S.Kom.</h6>
                            <small class="text-muted">1 minggu lalu</small>
                        </div>
                        <p class="mb-1 text-secondary fst-italic">"Perlu sedikit peningkatan dalam manajemen waktu pengumpulan tugas praktikum."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card card-custom shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-graph-up me-2"></i> Visualisasi Capaian KPI
            </div>
            <div class="card-body">
                {{-- Container Relatif untuk Chart Responsif --}}
                <div style="position: relative; height: 350px; width: 100%;">
                    <canvas id="kpiChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Konfigurasi Font
    Chart.defaults.font.family = "'Segoe UI', 'Helvetica', 'Arial', sans-serif";

    const kpiCtx = document.getElementById('kpiChart').getContext('2d');
    new Chart(kpiCtx, {
        type: 'bar',
        data: {
            labels: ['IPK', 'Kehadiran', 'Prestasi', 'Organisasi', 'Tugas'],
            datasets: [{
                label: 'Skor Capaian',
                data: [4.5, 5.0, 4.8, 4.0, 3.2],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // PENTING: Agar chart menyesuaikan container div
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    title: { display: true, text: 'Skor (0-5)' }
                }
            }
        }
    });
</script>
@endpush