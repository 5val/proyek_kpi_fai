@extends('layouts.app')

@section('title', 'KPI Saya')

@section('page-title', 'Key Performance Indicator (KPI) Saya')
@section('page-subtitle', 'Detail capaian kinerja Anda sebagai Dosen')
@section('user-name', 'Dr. Budi Hartono, M.Kom.')
@section('user-role', 'Dosen - Teknik Informatika')
@section('user-initial', 'BH')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link active" href="#"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-pencil-square"></i> Mata Kuliah</a>
    <a class="nav-link" href="#"><i class="bi bi-pencil-square"></i> Penilaian Mahasiswa</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kinerja</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text"></i> Feedback</a>
@endsection

@section('content')
<div class="row">
    <!-- KPI Details Table -->
    <div class="col-md-7">
        <div class="card-custom">
            <div class="card-header">
                <i class="bi bi-clipboard-data"></i> Detail Indikator Kinerja Dosen (Semester Gasal 2024/2025)
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Indikator Kinerja</th>
                                <th>Skor (1-4)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Penguasaan Materi</td>
                                <td><span class="badge bg-success">4.0</span></td>
                                <td><span class="badge bg-success">Sangat Baik</span></td>
                            </tr>
                            <tr>
                                <td>Kejelasan dalam Menyampaikan Materi</td>
                                <td><span class="badge bg-success">4.0</span></td>
                                <td><span class="badge bg-success">Sangat Baik</span></td>
                            </tr>
                            <tr>
                                <td>Kemampuan Memberi Motivasi</td>
                                <td><span class="badge bg-success">4.0</span></td>
                                <td><span class="badge bg-success">Sangat Baik</span></td>
                            </tr>
                            <tr>
                                <td>Kedisiplinan Waktu</td>
                                <td><span class="badge bg-primary">3.0</span></td>
                                <td><span class="badge bg-primary">Baik</span></td>
                            </tr>
                            <tr>
                                <td>Keadilan dalam Penilaian</td>
                                <td><span class="badge bg-primary">3.0</span></td>
                                <td><span class="badge bg-primary">Baik</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
     <!-- Comments from Students -->
    <div class="col-md-5">
       <div class="card-custom">
            <div class="card-header"><i class="bi bi-chat-quote-fill"></i> Komentar & Feedback (Anonim)</div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <p class="mb-1">"Penjelasan beliau sangat mudah dipahami, contoh-contoh yang diberikan juga relevan dengan industri."</p>
                        <small class="text-muted">- Mahasiswa A, 2 hari lalu</small>
                    </div>
                     <div class="list-group-item">
                        <p class="mb-1">"Sangat disiplin waktu, tidak pernah telat masuk kelas. Kuisnya menantang tapi adil."</p>
                        <small class="text-muted">- Mahasiswa B, 3 hari lalu</small>
                    </div>
                    <div class="list-group-item">
                        <p class="mb-1">"Mungkin slide materi bisa dibuat lebih menarik secara visual. Selebihnya sudah sangat baik."</p>
                        <small class="text-muted">- Mahasiswa C, 5 hari lalu</small>
                    </div>
                     <div class="list-group-item">
                        <p class="mb-1">"Sesi bimbingan dengan Pak Budi sangat membantu progres skripsi saya. Beliau selalu memberikan arahan yang jelas."</p>
                        <small class="text-muted">- Mahasiswa D, 1 minggu lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KPI Chart -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="card-header">
                <i class="bi bi-graph-up"></i> Visualisasi Capaian KPI
            </div>
            <div class="card-body">
                <canvas id="kpiChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const kpiCtx = document.getElementById('kpiChart').getContext('2d');
    new Chart(kpiCtx, {
        type: 'bar',
        data: {
            labels: ['Penguasaan Materi', 'Kejelasan dalam Menyampaikan Materi', 'Kemampuan Memberi Motivasi', 'Kedisiplinan Waktu', 'Keadilan dalam Penilaian'],
            datasets: [{
                label: 'Skor Capaian',
                data: [4.6, 5.0, 4.5, 4.0, 4.0],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Grafik Skor KPI Dosen per Indikator', font: { size: 16 } }
            },
            scales: {
                y: { beginAtZero: true, max: 5, title: { display: true, text: 'Skor' } }
            }
        }
    });
</script>
@endpush

