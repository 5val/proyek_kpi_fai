@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Monitoring Kinerja & Area Perlu Perbaikan')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')

<!-- SECTION 1: STATUS PENILAIAN (BELUM DINILAI) -->
<div class="row mb-4">
    <div class="col-12">
        <h6 class="text-uppercase text-muted fw-bold mb-3"><i class="bi bi-exclamation-circle"></i> Status: Belum Ada Penilaian</h6>
    </div>
    <div class="col">
      <a href="{{ route('admin.dashboard.detail.card', 'belum_dinilai_dosen') }}" class="text-decoration-none">
        <div class="card-custom bg-danger text-white h-100">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $belum_dinilai_count['dosen'] }}</h2>
                <small>Dosen</small>
            </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="{{ route('admin.dashboard.detail.card', 'belum_dinilai_mahasiswa') }}" class="text-decoration-none">
        <div class="card-custom bg-warning text-dark h-100">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $belum_dinilai_count['mahasiswa'] }}</h2>
                <small>Mahasiswa</small>
            </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="{{ route('admin.dashboard.detail.card', 'belum_dinilai_fasilitas') }}" class="text-decoration-none">
        <div class="card-custom bg-secondary text-white h-100">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $belum_dinilai_count['fasilitas'] }}</h2>
                <small>Fasilitas</small>
            </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="{{ route('admin.dashboard.detail.card', 'belum_dinilai_unit') }}" class="text-decoration-none">
        <div class="card-custom bg-info text-white h-100">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $belum_dinilai_count['unit'] }}</h2>
                <small>Unit</small>
            </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="{{ route('admin.dashboard.detail.card', 'belum_dinilai_praktikum') }}" class="text-decoration-none">
        <div class="card-custom bg-dark text-white h-100">
            <div class="card-body text-center p-3">
                <h2 class="fw-bold mb-0">{{ $belum_dinilai_count['praktikum'] }}</h2>
                <small>Praktikum</small>
            </div>
        </div>
      </a>
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
                    @forelse($feedbacks as $feedback)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $feedback->name }}</strong>
                            <br><small class="text-muted">{{ $feedback->type }}</small>
                        </div>
                        <a href="{{ route('admin.dashboard.detail.feedback', [$feedback->kategori_id, $feedback->target_id]) }}" class="btn btn-sm btn-outline-danger rounded-pill">
                            {{ $feedback->count }} Feedback <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted">
                        <i class="bi bi-check-circle fs-1 d-block mb-2 opacity-25"></i>
                        <small>Tidak ada keluhan signifikan</small>
                    </li>
                    @endforelse
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
                    @forelse($low_kpi['dosen'] as $dosen)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-truncate" style="max-width: 60%;">
                            {{ $dosen->user->name }}
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">{{ number_format($dosen->avg_kpi, 1) }}</span>
                            <a href="{{ route('admin.dashboard.detail.list', ['dosen', $dosen->user->id]) }}" class="btn btn-xs btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted">
                        <i class="bi bi-emoji-smile fs-1 d-block mb-2 opacity-25"></i>
                        <small>Semua kinerja dosen baik</small>
                    </li>
                    @endforelse
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
                    @forelse($low_kpi['mahasiswa'] as $mahasiswa)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-truncate" style="max-width: 60%;">
                            {{ $mahasiswa->user->name }}
                            <br><small class="text-muted">{{ $mahasiswa->nrp }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">{{ number_format($mahasiswa->avg_kpi, 1) }}</span>
                            <a href="{{ route('admin.dashboard.detail.list', ['mahasiswa', $mahasiswa->user->id]) }}" class="btn btn-xs btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted">
                        <i class="bi bi-emoji-smile fs-1 d-block mb-2 opacity-25"></i>
                        <small>Semua kinerja mahasiswa baik</small>
                    </li>
                    @endforelse
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
                    @forelse($low_kpi['fasilitas'] as $fasilitas)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>{{ $fasilitas->name }}</div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">{{ number_format($fasilitas->avg_kpi, 1) }}</span>
                            <a href="{{ route('admin.dashboard.detail.list', ['fasilitas', $fasilitas->id]) }}" class="btn btn-xs btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted">
                        <i class="bi bi-check2-circle fs-1 d-block mb-2 opacity-25"></i>
                        <small>Fasilitas dalam kondisi baik</small>
                    </li>
                    @endforelse
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
                    @forelse($low_kpi['unit'] as $unit)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>{{ $unit->name }}</div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">{{ number_format($unit->avg_kpi, 1) }}</span>
                            <a href="{{ route('admin.dashboard.detail.list', ['unit', $unit->id]) }}" class="btn btn-xs btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted">
                        <i class="bi bi-check2-circle fs-1 d-block mb-2 opacity-25"></i>
                        <small>Layanan unit optimal</small>
                    </li>
                    @endforelse
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
                    @forelse($low_kpi['praktikum'] as $praktikum)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                           {{ $praktikum->kelas->mataKuliah->name }}
                           <br><small class="text-muted">{{ $praktikum->kelas->program_studi->name }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">{{ number_format($praktikum->avg_kpi, 1) }}</span>
                            <a href="{{ route('admin.dashboard.detail.list', ['praktikum', $praktikum->id]) }}" class="btn btn-xs btn-light border"><i class="bi bi-eye"></i></a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted">
                        <i class="bi bi-check2-circle fs-1 d-block mb-2 opacity-25"></i>
                        <small>Pelaksanaan praktikum baik</small>
                    </li>
                    @endforelse
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