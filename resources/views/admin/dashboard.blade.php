@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="row g-3 mb-4">
    <!-- Stat Cards -->
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <i class="fas fa-users fa-2x mb-2"></i>
            <!-- <h3>{{ $totalUsers ?? 0 }}</h3> -->
            <h3>10</h3>
            <p>Total Pengguna</p>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <i class="fas fa-list fa-2x mb-2"></i>
            <!-- <h3>{{ $totalCategories ?? 0 }}</h3> -->
            <h3>10</h3>
            <p>Kategori KPI</p>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <i class="fas fa-clipboard-list fa-2x mb-2"></i>
            <!-- <h3>{{ $totalIndicators ?? 0 }}</h3> -->
            <h3>10</h3>
            <p>Indikator KPI</p>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <i class="fas fa-star fa-2x mb-2"></i>
            <!-- <h3>{{ $totalAssessments ?? 0 }}</h3> -->
            <h3>10</h3>
            <p>Total Penilaian</p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Chart KPI per Kategori -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="fas fa-chart-bar me-2 text-primary"></i>
                    Skor KPI per Kategori
                </h5>
                <canvas id="categoryChart" height="80"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Top Performers -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="fas fa-trophy me-2 text-warning"></i>
                    Top Performers
                </h5>
                <div class="list-group list-group-flush">
                    <!-- @forelse($topPerformers ?? [] as $index => $performer) -->
                        <!-- <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px; font-size: 0.9rem;">
                                    #{{ $index + 1 }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $performer->name }}</div>
                                    <small class="text-muted">{{ $performer->category }}</small>
                                </div>
                            </div>
                            <span class="badge bg-success">{{ number_format($performer->score, 2) }}</span>
                        </div> -->
                    <!-- @empty
                        <p class="text-muted text-center my-3">Belum ada data</p>
                    @endforelse -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Tren Penilaian -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="fas fa-chart-line me-2 text-success"></i>
                    Tren Penilaian Bulanan
                </h5>
                <canvas id="trendChart" height="80"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Feedback Terbaru -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="fas fa-comments me-2 text-info"></i>
                    Feedback Terbaru
                </h5>
                <div class="list-group list-group-flush" style="max-height: 350px; overflow-y: auto;">
                    @forelse($recentFeedback ?? [] as $feedback)
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="fw-bold">{{ $feedback->user->name }}</div>
                                <small class="text-muted">{{ $feedback->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1 small">{{ Str::limit($feedback->message, 80) }}</p>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-2">{{ $feedback->category }}</span>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 0.75rem;"></i>
                                @endfor
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center my-3">Belum ada feedback</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Aktivitas Terkini -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="fas fa-history me-2 text-primary"></i>
                    Aktivitas Terkini
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Aktivitas</th>
                                <th>Kategori</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities ?? [] as $activity)
                                <tr>
                                    <td>{{ $activity->created_at->format('d M Y H:i') }}</td>
                                    <td>{{ $activity->user->name }}</td>
                                    <td>{{ $activity->description }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $activity->category }}</span>
                                    </td>
                                    <td>
                                        @if($activity->status == 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($activity->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Gagal</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada aktivitas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
   const categoryLabels = ['Mahasiswa', 'Dosen', 'BAU', 'BAK', 'BAA', 'UKM', 'Fasilitas'];
    const categoryScores = [4.2, 4.5, 3.8, 4.0, 4.3, 3.9, 4.1];
    // Chart KPI per Kategori
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Skor Rata-rata',
                data: categoryScores,
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(118, 75, 162, 0.8)',
                    'rgba(240, 147, 251, 0.8)',
                    'rgba(79, 172, 254, 0.8)',
                    'rgba(67, 233, 123, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    
    const trendLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
    const trendData = [45, 52, 61, 58, 70, 85];
    // Chart Tren Bulanan
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Jumlah Penilaian',
                data: trendData,
                borderColor: 'rgb(37, 99, 235)',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush