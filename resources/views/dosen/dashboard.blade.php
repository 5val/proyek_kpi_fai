@extends('layouts.app')

@section('title', 'Dashboard Dosen')
@section('page-title', 'Dashboard Dosen')
@section('page-subtitle', 'Ringkasan Kinerja Akademik')

@section('content')
    {{-- BARIS 1: SKOR UTAMA --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white;">
                <div class="card-body p-5 text-center">
                    <h5 class="text-white-50 text-uppercase ls-1 mb-2">Skor Kinerja Periode Ini</h5>
                    <h1 class="display-3 fw-bold mb-3">{{ number_format($currentScore, 2) }}</h1>
                    
                    <div class="d-inline-block bg-white bg-opacity-25 rounded-pill px-4 py-2">
                        @if($scoreDiff > 0)
                            <span class="text-white fw-bold">
                                <i class="bi bi-arrow-up-circle-fill me-1"></i> Naik {{ number_format($scoreDiff, 2) }}
                            </span>
                            <small class="text-white-50 ms-1">dari periode lalu</small>
                        @elseif($scoreDiff < 0)
                            <span class="text-white fw-bold">
                                <i class="bi bi-arrow-down-circle-fill me-1"></i> Turun {{ number_format(abs($scoreDiff), 2) }}
                            </span>
                            <small class="text-white-50 ms-1">dari periode lalu</small>
                        @else
                            <span class="text-white">
                                <i class="bi bi-dash-circle-fill me-1"></i> Stabil
                            </span>
                            <small class="text-white-50 ms-1">dari periode lalu</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS 2: GRAFIK --}}
    <div class="row">
        {{-- Chart 1: Line Chart (Tren) --}}
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold py-3 border-bottom-0">
                    <i class="bi bi-graph-up me-2"></i> Tren Performa (5 Periode Terakhir)
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="teachingScoreChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Chart 2: Doughnut Chart (Indikator) --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold py-3 border-bottom-0">
                    <i class="bi bi-pie-chart-fill me-2"></i> Top 5 Indikator
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div style="position: relative; width: 100%; height: 250px;">
                        <canvas id="studentRatingChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- Data dari Controller ---
    const chartLabels = @json($chartLabels); 
    const chartValues = @json($chartValues); 
    
    const ratingLabels = @json($ratingLabels); 
    const ratingValues = @json($ratingValues); 

    // --- 1. Line Chart (Tren) ---
    const teachingScoreCtx = document.getElementById('teachingScoreChart').getContext('2d');
    new Chart(teachingScoreCtx, {
        type: 'line',
        data: {
            labels: chartLabels.length ? chartLabels : ['Data Kosong'],
            datasets: [{
                label: 'Skor Kinerja',
                data: chartValues.length ? chartValues : [0],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4e73df',
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                tension: 0.4 // Lebih melengkung
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5, 
                    grid: { borderDash: [2, 2] }
                },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // --- 2. Doughnut Chart (Indikator) ---
    const studentRatingCtx = document.getElementById('studentRatingChart').getContext('2d');
    new Chart(studentRatingCtx, {
        type: 'doughnut',
        data: {
            labels: ratingLabels.length ? ratingLabels : ['Belum ada data'],
            datasets: [{
                data: ratingValues.length ? ratingValues : [1],
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                ],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 10, font: { size: 10 } }
                }
            },
            cutout: '75%', 
        }
    });
</script>
@endpush