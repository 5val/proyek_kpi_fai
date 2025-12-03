@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Monitoring Kinerja & Area Perlu Perbaikan')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-12">
        <h6 class="text-uppercase text-muted fw-bold mb-1"><i class="bi bi-exclamation-circle"></i> Status: Belum Ada Penilaian</h6>
    </div>

    {{-- 
       PERUBAHAN GRID: 
       col-6   : Di HP jadi 2 kolom (sebelahan)
       col-md-4: Di Tablet jadi 3 kolom
       col-xl  : Di Desktop jadi rata satu baris (auto)
    --}}
    
    <div class="col-6 col-md-4 col-xl">
      <a href="{{ route('admin.dashboard.detail.card', 'belum_dinilai_dosen') }}" class="text-decoration-none">
        <div class="card card-custom bg-danger text-white h-100 shadow-sm border-0">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $belum_dinilai_count['dosen'] }}</h2>
                <small>Dosen</small>
            </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-xl">
      <a href="{{ route('admin.dashboard.detail.card', 'belum_dinilai_fasilitas') }}" class="text-decoration-none">
        <div class="card card-custom bg-secondary text-white h-100 shadow-sm border-0">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $belum_dinilai_count['fasilitas'] }}</h2>
                <small>Fasilitas</small>
            </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-xl">
      <a href="{{ route('admin.dashboard.detail.card', 'belum_dinilai_unit') }}" class="text-decoration-none">
        <div class="card card-custom bg-info text-white h-100 shadow-sm border-0">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $belum_dinilai_count['unit'] }}</h2>
                <small>Unit</small>
            </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-xl">
      <a href="{{ route('admin.dashboard.detail.card', 'belum_dinilai_praktikum') }}" class="text-decoration-none">
        <div class="card card-custom bg-dark text-white h-100 shadow-sm border-0">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $belum_dinilai_count['praktikum'] }}</h2>
                <small>Praktikum</small>
            </div>
        </div>
      </a>
    </div>
</div>

<div class="row g-4"> <div class="col-12">
        <h6 class="text-uppercase text-muted fw-bold mb-0"><i class="bi bi-search"></i> Area Perlu Perhatian (Low Performance)</h6>
    </div>

    <div class="col-12 col-md-6 col-xl-4"> <div class="card card-custom h-100 border-danger border-start border-4 shadow-sm">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-chat-square-quote-fill me-2"></i> Keluhan Terbanyak
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($feedbacks as $feedback)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="me-2 overflow-hidden">
                            <div class="fw-bold text-truncate">{{ $feedback->name }}</div>
                            <small class="text-muted text-uppercase" style="font-size: 0.75rem;">{{ $feedback->type }}</small>
                        </div>
                        <a href="{{ route('admin.dashboard.detail.feedback', [$feedback->kategori_id, $feedback->target_id]) }}" class="btn btn-sm btn-outline-danger rounded-pill flex-shrink-0" style="font-size: 0.8rem;">
                            {{ $feedback->count }} <span class="d-none d-sm-inline">Feedback</span> <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-5 text-muted">
                        <i class="bi bi-check-circle fs-1 d-block mb-2 opacity-25"></i>
                        <small>Tidak ada keluhan signifikan</small>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-custom h-100 shadow-sm">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-person-video3 me-2"></i> Dosen (Bottom 3)
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($low_kpi['dosen'] as $dosen)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="me-2 overflow-hidden">
                            <div class="text-truncate fw-bold">{{ $dosen->user->name }}</div>
                            <small class="text-muted">NIDN: {{ $dosen->nidn ?? '-' }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <span class="badge bg-danger">{{ number_format($dosen->avg_kpi, 1) }}</span>
                            <a href="{{ route('admin.dashboard.detail.list', ['dosen', $dosen->user->id]) }}" class="btn btn-sm btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-5 text-muted">
                        <i class="bi bi-emoji-smile fs-1 d-block mb-2 opacity-25"></i>
                        <small>Semua kinerja dosen baik</small>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-custom h-100 shadow-sm">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-building me-2"></i> Fasilitas (Bottom 3)
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($low_kpi['fasilitas'] as $fasilitas)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="me-2 overflow-hidden">
                             <div class="fw-bold text-truncate">{{ $fasilitas->name }}</div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <span class="badge bg-danger">{{ number_format($fasilitas->avg_kpi, 1) }}</span>
                            <a href="{{ route('admin.dashboard.detail.list', ['fasilitas', $fasilitas->id]) }}" class="btn btn-sm btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-5 text-muted">
                        <i class="bi bi-check2-circle fs-1 d-block mb-2 opacity-25"></i>
                        <small>Fasilitas dalam kondisi baik</small>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-custom h-100 shadow-sm">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-bank2 me-2"></i> Unit Layanan (Bottom 3)
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($low_kpi['unit'] as $unit)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="me-2 overflow-hidden">
                            <div class="fw-bold text-truncate">{{ $unit->name }}</div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <span class="badge bg-danger">{{ number_format($unit->avg_kpi, 1) }}</span>
                            <a href="{{ route('admin.dashboard.detail.list', ['unit', $unit->id]) }}" class="btn btn-sm btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-5 text-muted">
                        <i class="bi bi-check2-circle fs-1 d-block mb-2 opacity-25"></i>
                        <small>Layanan unit optimal</small>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-custom h-100 shadow-sm">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-pc-display-horizontal me-2"></i> Praktikum (Bottom 3)
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($low_kpi['praktikum'] as $praktikum)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="me-2 overflow-hidden">
                           <div class="fw-bold text-truncate">{{ $praktikum->kelas->mataKuliah->name }}</div>
                           <small class="text-muted d-block text-truncate">{{ $praktikum->kelas->program_studi->name }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <span class="badge bg-danger">{{ number_format($praktikum->avg_kpi, 1) }}</span>
                            <a href="{{ route('admin.dashboard.detail.list', ['praktikum', $praktikum->id]) }}" class="btn btn-sm btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-5 text-muted">
                        <i class="bi bi-check2-circle fs-1 d-block mb-2 opacity-25"></i>
                        <small>Pelaksanaan praktikum baik</small>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-12">
        <h6 class="text-uppercase text-muted fw-bold mb-0"><i class="bi bi-bar-chart-line"></i> Analitik Kampus</h6>
    </div>
    
    <div class="col-12 col-xl-8"> <div class="card card-custom h-100 shadow-sm">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-graph-up me-2"></i> Tren Skor KPI Keseluruhan
            </div>
            <div class="card-body">
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="kpiTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-xl-4">
        <div class="card card-custom h-100 shadow-sm">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-pie-chart me-2"></i> Rata-rata per Kategori
            </div>
            <div class="card-body">
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="kpiOverviewChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Konfigurasi Chart agar font responsif dan enak dilihat
    Chart.defaults.font.family = "'Segoe UI', 'Helvetica', 'Arial', sans-serif";
    
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
                backgroundColor: 'rgba(54, 162, 235, 0.1)', // Transparan agar rapi
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                pointRadius: 4, // Titik lebih besar agar mudah di-tap di HP
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // PENTING: Agar chart menyesuaikan container
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
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // PENTING
            indexAxis: 'y', // Horizontal Bar lebih baik untuk label panjang di mobile
            scales: { x: { beginAtZero: true, max: 5 } },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush