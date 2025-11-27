@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Monitoring Kinerja & Area Perlu Perbaikan')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@php
    // --- MOCK DATA (SIMULASI CONTROLLER) ---
    // Nanti data ini dikirim dari AdminController
    
    // 1. Count Belum Dinilai
    $unassessed = [
        'dosen' => 5,
        'mahasiswa' => 120,
        'fasilitas' => 3,
        'unit' => 1,
        'praktikum' => 4
    ];

    // 2. Top Feedback (Objek Paling Banyak Dikomentari)
    $top_feedbacks = collect([
        (object)['type' => 'Fasilitas', 'name' => 'AC Ruang 301', 'count' => 15, 'id' => 1],
        (object)['type' => 'Unit', 'name' => 'Layanan BAA', 'count' => 12, 'id' => 1],
        (object)['type' => 'Fasilitas', 'name' => 'WiFi Gedung C', 'count' => 9, 'id' => 2],
    ]);

    // 3. Low KPI Lists (Top 3 Terendah)
    $low_kpi_dosen = collect([
        (object)['name' => 'Dr. Budi Santoso', 'avg_kpi' => 2.5, 'id' => 1],
        (object)['name' => 'Siti Aminah, M.T.', 'avg_kpi' => 3.1, 'id' => 2],
        (object)['name' => 'Ahmad, M.Kom', 'avg_kpi' => 3.2, 'id' => 3],
    ]);

    $low_kpi_mhs = collect([
        (object)['name' => 'Andi Pratama', 'nim' => '2021001', 'avg_kpi' => 1.8, 'id' => 1],
        (object)['name' => 'Budi Setiawan', 'nim' => '2021002', 'avg_kpi' => 2.0, 'id' => 2],
        (object)['name' => 'Citra Kirana', 'nim' => '2021003', 'avg_kpi' => 2.2, 'id' => 3],
    ]);

    $low_kpi_fasilitas = collect([
        (object)['name' => 'Toilet Gedung B', 'avg_kpi' => 1.5, 'id' => 1],
        (object)['name' => 'Parkiran Motor', 'avg_kpi' => 2.1, 'id' => 2],
        (object)['name' => 'Kantin Pusat', 'avg_kpi' => 2.8, 'id' => 3],
    ]);

    $low_kpi_unit = collect([
        (object)['name' => 'Keamanan (Satpam)', 'avg_kpi' => 2.9, 'id' => 1],
        (object)['name' => 'Kebersihan', 'avg_kpi' => 3.0, 'id' => 2],
        (object)['name' => 'Poliklinik', 'avg_kpi' => 3.5, 'id' => 3],
    ]);

    $low_kpi_praktikum = collect([
        (object)['name' => 'Jaringan Komputer', 'avg_kpi' => 2.4, 'id' => 1],
        (object)['name' => 'Sistem Operasi', 'avg_kpi' => 3.1, 'id' => 2],
        (object)['name' => 'Basis Data', 'avg_kpi' => 3.3, 'id' => 3],
    ]);

    // Chart Data (Mock)
    $chart_bulan_labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
    $chart_bulan_values = [3.5, 3.6, 3.8, 3.7, 4.0, 4.2];
    
    $chart_kategori_labels = ['Dosen', 'Mhs', 'Fasilitas', 'Unit', 'Praktikum'];
    $chart_kategori_values = [4.2, 3.8, 3.5, 4.0, 3.9];
@endphp

@section('content')

<!-- SECTION 1: STATUS PENILAIAN (BELUM DINILAI) -->
<div class="row mb-4">
    <div class="col-12">
        <h6 class="text-uppercase text-muted fw-bold mb-3"><i class="bi bi-exclamation-circle"></i> Status: Belum Ada Penilaian</h6>
    </div>
    <div class="col">
        <div class="card-custom bg-danger text-white h-100">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $unassessed['dosen'] }}</h2>
                <small>Dosen</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card-custom bg-warning text-dark h-100">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $unassessed['mahasiswa'] }}</h2>
                <small>Mahasiswa</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card-custom bg-secondary text-white h-100">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $unassessed['fasilitas'] }}</h2>
                <small>Fasilitas</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card-custom bg-info text-white h-100">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $unassessed['unit'] }}</h2>
                <small>Unit</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card-custom bg-dark text-white h-100">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $unassessed['praktikum'] }}</h2>
                <small>Praktikum</small>
            </div>
        </div>
    </div>
</div>

<!-- SECTION 2: MONITORING MASALAH (FEEDBACK & LOW KPI) -->
<div class="row">
    <div class="col-12">
        <h6 class="text-uppercase text-muted fw-bold mb-3"><i class="bi bi-search"></i> Area Perlu Perhatian (Low Performance)</h6>
    </div>

    <!-- 2.1: Objek dengan Feedback Terbanyak -->
    <div class="col-md-4 mb-4">
        <div class="card-custom h-100 border-danger border-start border-4">
            <div class="card-header bg-white text-dark">
                <i class="bi bi-chat-square-quote-fill text-danger"></i> Keluhan Terbanyak
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($top_feedbacks as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $item->name }}</strong>
                            <br><small class="text-muted">{{ $item->type }}</small>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-danger rounded-pill">
                            {{ $item->count }} Feedback <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- 2.2: Dosen KPI Rendah -->
    <div class="col-md-4 mb-4">
        <div class="card-custom h-100">
            <div class="card-header">
                <i class="bi bi-person-video3"></i> Dosen (Bottom 3)
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($low_kpi_dosen as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-truncate" style="max-width: 60%;">
                            {{ $item->name }}
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">{{ $item->avg_kpi }}</span>
                            <a href="#" class="btn btn-xs btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- 2.3: Mahasiswa KPI Rendah -->
    <div class="col-md-4 mb-4">
        <div class="card-custom h-100">
            <div class="card-header">
                <i class="bi bi-people-fill"></i> Mahasiswa (Bottom 3)
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($low_kpi_mhs as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-truncate" style="max-width: 60%;">
                            {{ $item->name }}
                            <br><small class="text-muted">{{ $item->nim }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">{{ $item->avg_kpi }}</span>
                            <a href="#" class="btn btn-xs btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- 2.4: Fasilitas KPI Rendah -->
    <div class="col-md-4 mb-4">
        <div class="card-custom h-100">
            <div class="card-header">
                <i class="bi bi-building"></i> Fasilitas (Bottom 3)
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($low_kpi_fasilitas as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>{{ $item->name }}</div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">{{ $item->avg_kpi }}</span>
                            <a href="#" class="btn btn-xs btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- 2.5: Unit KPI Rendah -->
    <div class="col-md-4 mb-4">
        <div class="card-custom h-100">
            <div class="card-header">
                <i class="bi bi-bank2"></i> Unit Layanan (Bottom 3)
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($low_kpi_unit as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>{{ $item->name }}</div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">{{ $item->avg_kpi }}</span>
                            <a href="#" class="btn btn-xs btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- 2.6: Praktikum KPI Rendah -->
    <div class="col-md-4 mb-4">
        <div class="card-custom h-100">
            <div class="card-header">
                <i class="bi bi-pc-display-horizontal"></i> Praktikum (Bottom 3)
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($low_kpi_praktikum as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>{{ $item->name }}</div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">{{ $item->avg_kpi }}</span>
                            <a href="#" class="btn btn-xs btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- SECTION 3: ANALITIK UMUM (CHARTS) -->
<div class="row mt-4">
    <div class="col-12">
        <h6 class="text-uppercase text-muted fw-bold mb-3"><i class="bi bi-bar-chart-line"></i> Analitik Kampus</h6>
    </div>
    <!-- Chart 1: Trend -->
    <div class="col-md-8 mb-4">
        <div class="card-custom h-100">
            <div class="card-header">
                <i class="bi bi-graph-up"></i> Tren Skor KPI Keseluruhan
            </div>
            <div class="card-body">
                <canvas id="kpiTrendChart" height="220"></canvas>
            </div>
        </div>
    </div>
    <!-- Chart 2: Overview by Category -->
    <div class="col-md-4 mb-4">
        <div class="card-custom h-100">
            <div class="card-header"><i class="bi bi-pie-chart"></i> Rata-rata per Kategori</div>
            <div class="card-body">
                <canvas id="kpiOverviewChart" height="220"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // KPI Trend Chart
    const chart_bulan = {!! json_encode($chart_bulan) !!}
    const chart_bulan_labels = chart_bulan.map(item => item.bulan); 
    const chart_bulan_values = chart_bulan.map(item => item.rata_rata_skor);
    const kpiTrendCtx = document.getElementById('kpiTrendChart').getContext('2d');
    new Chart(kpiTrendCtx, {
        type: 'line',
        data: {
            labels: chart_bulan_labels,
            datasets: [{
                label: 'Skor KPI Rata-rata',
                data: chart_bulan_values,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false,
                    min: 0,
                    max: 5,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: { legend: { display: false } }
        }
    });

    // KPI Overview Chart
    const chart_kategori = {!! $chart_kategori->values()->toJson() !!};
    const chart_kategori_labels = chart_kategori.map(item => item.nama_kategori); 
    const chart_kategori_values = chart_kategori.map(item => item.rata_rata_skor);
    const kpiOverviewCtx = document.getElementById('kpiOverviewChart').getContext('2d');
    new Chart(kpiOverviewCtx, {
        type: 'bar',
        data: {
            labels: chart_kategori_labels,
            datasets: [{
                label: 'Skor Rata-rata',
                data: chart_kategori_values,
                backgroundColor: [
                    '#3498db', '#2ecc71', '#f1c40f', '#e67e22', '#9b59b6'
                ],
                borderWidth: 0,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y', // Horizontal Bar agar muat di kolom kecil
            scales: { x: { beginAtZero: true, max: 5 } },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush