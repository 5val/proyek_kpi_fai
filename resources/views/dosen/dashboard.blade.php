@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('page-title', 'Dashboard Dosen')
@section('page-subtitle', 'Ringkasan Kinerja & Aktivitas Mengajar')


@section('content')
    <div class="row">
        {{-- Card 1: Skor Kinerja --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <div class="icon text-primary mb-2 fs-1"><i class="bi bi-trophy-fill"></i></div>
                    <h3 class="fw-bold display-6">{{ number_format($currentScore, 2) }}</h3>
                    <p class="text-muted mb-1">Skor Kinerja Mengajar</p>
                    
                    @if($scoreDiff > 0)
                        <small class="text-success fw-bold">
                            <i class="bi bi-arrow-up"></i> Naik {{ number_format($scoreDiff, 2) }} dari periode lalu
                        </small>
                    @elseif($scoreDiff < 0)
                        <small class="text-danger fw-bold">
                            <i class="bi bi-arrow-down"></i> Turun {{ number_format(abs($scoreDiff), 2) }} dari periode lalu
                        </small>
                    @else
                        <small class="text-secondary">
                            <i class="bi bi-dash"></i> Stabil dari periode lalu
                        </small>
                    @endif
                </div>
            </div>
        </div>

        {{-- Card 2: Jumlah Mahasiswa --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <div class="icon text-success mb-2 fs-1"><i class="bi bi-people-fill"></i></div>
                    <h3 class="fw-bold display-6">{{ $studentCount }}</h3>
                    <p class="text-muted mb-0">Total Mahasiswa Aktif (Semester Ini)</p>
                    <small class="text-info">Diampu dalam kelas Anda</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        {{-- Chart 1 --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-graph-up me-2"></i> Tren Skor Kinerja Mengajar
                </div>
                <div class="card-body">
                    <canvas id="teachingScoreChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
        
        {{-- Chart 2 --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-pie-chart-fill me-2"></i> Top 5 Indikator Penilaian (Rata-rata)
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 250px;">
                        <canvas id="studentRatingChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3 fw-bold">
                    <i class="bi bi-person-lines-fill me-2"></i> Daftar Mahasiswa di Kelas Anda
                </div>
                <div class="card-body p-0">
                     <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama Mahasiswa</th>
                                    <th>NRP</th>
                                    <th>Semester</th> {{-- UBAH HEADER DISINI --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($studentsList as $mhs)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $mhs->name }}</td>
                                    <td>{{ $mhs->nrp }}</td>
                                    
                                    {{-- UBAH DATA DISINI --}}
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ ucfirst($mhs->semester) }} {{ $mhs->tahun }}
                                        </span>
                                    </td>

                                    <td>
                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Tidak ada data mahasiswa ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <a href="#" class="text-decoration-none fw-bold small">Lihat Semua Mahasiswa <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- Data dari Controller (Blade to JS) ---
    const chartLabels = @json($chartLabels); // Label Periode (Sumbu X)
    const chartValues = @json($chartValues); // Nilai Skor (Sumbu Y)
    
    const ratingLabels = @json($ratingLabels); // Label Indikator
    const ratingValues = @json($ratingValues); // Nilai Rata-rata

    // --- 1. Teaching Score Chart (Line) ---
    const teachingScoreCtx = document.getElementById('teachingScoreChart').getContext('2d');
    new Chart(teachingScoreCtx, {
        type: 'line',
        data: {
            labels: chartLabels.length ? chartLabels : ['Data Kosong'],
            datasets: [{
                label: 'Skor Kinerja',
                data: chartValues.length ? chartValues : [0],
                borderColor: '#0d6efd', // Bootstrap Primary Color
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0d6efd',
                pointRadius: 4,
                fill: true,
                tension: 0.3 // Garis melengkung halus
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5, // Karena skala KPI biasanya 1-5
                    grid: { borderDash: [2, 4] }
                },
                x: {
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Skor: ' + context.parsed.y;
                        }
                    }
                }
            }
        }
    });

    // --- 2. Student Rating Chart (Doughnut) ---
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
                borderWidth: 2,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: { boxWidth: 12, font: { size: 11 } }
                }
            },
            cutout: '70%', // Membuat lubang tengah lebih besar
        }
    });
</script>
@endpush