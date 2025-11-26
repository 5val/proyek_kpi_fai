@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Selamat Datang di Panel Kontrol Sistem KPI')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon text-primary"><i class="bi bi-people-fill"></i></div>
                <h3 class="fw-bold">{{ number_format($total_pengguna) }}</h3>
                <p class="text-muted mb-0">Total Pengguna</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon text-success"><i class="bi bi-person-video3"></i></div>
                <h3 class="fw-bold">{{ number_format($total_dosen) }}</h3>
                <p class="text-muted mb-0">Total Dosen</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon text-info"><i class="bi bi-person-check-fill"></i></div>
                <h3 class="fw-bold">{{ number_format($total_mahasiswa) }}</h3>
                <p class="text-muted mb-0">Total Mahasiswa</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon text-warning"><i class="bi bi-clipboard2-data-fill"></i></div>
                <h3 class="fw-bold">{{ number_format($total_penilaian) }}</h3>
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
                <canvas id="kpiTrendChart" height="200"></canvas>
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
                <canvas id="kpiOverviewChart" height="200"></canvas>
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
                           @foreach ($feedbacks as $feedback)
                              <tr>
                                 <td>
                                    <p class="mb-1">"{{ $feedback->isi }}"</p>
                                    <small class="text-muted">Untuk: <strong>{{ $feedback->kategori->name }}</strong> - oleh {{ $feedback->is_anonymous == 1 ? 'Anonim' : $feedback->pengirim->name }} ({{ $feedback->pengirim->role == 'dosen' ? 'Dosen' : 'Mahasiswa' }})</small>
                                 </td>
                              </tr>
                           @endforeach
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
    const chart_bulan = {!! json_encode($chart_bulan) !!}
    const chart_bulan_labels = chart_bulan.map(item => item.bulan); 
    const chart_bulan_values = chart_bulan.map(item => item.rata_rata_skor);
    console.log(chart_bulan_labels);
    console.log(chart_bulan_values);
    
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
                    ticks: {
                        stepSize: 0.5
                    }
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
    const chart_kategori = {!! $chart_kategori->values()->toJson() !!};
    const chart_kategori_labels = chart_kategori.map(item => item.nama_kategori); 
    const chart_kategori_values = chart_kategori.map(item => item.rata_rata_skor);
    const kpiOverviewCtx = document.getElementById('kpiOverviewChart').getContext('2d');
    new Chart(kpiOverviewCtx, {
        type: 'bar',
        data: {
            labels: chart_kategori_labels,
            datasets: [{
                label: 'Skor Rata-rata (skala 5)',
                data: chart_kategori_values,
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