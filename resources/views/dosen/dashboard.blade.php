@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('page-title', 'Dashboard Dosen')
@section('page-subtitle', 'Ringkasan Kinerja & Aktivitas Mengajar')
@section('user-name', 'Dr. Budi Hartono, M.Kom.')
@section('user-role', 'Dosen - Teknik Informatika')
@section('user-initial', 'BH')

@section('sidebar-menu')
    <a class="nav-link active" href="/dosen"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="/dosen/profile"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="/dosen/kpi"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="/dosen/kelas"><i class="bi bi-pencil-square"></i> Kelas</a>
    <a class="nav-link" href="/dosen/penilaian_mahasiswa"><i class="bi bi-people"></i> Penilaian Mahasiswa</a>
    <a class="nav-link" href="/dosen/penilaian_fasilitas"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="/dosen/penilaian_unit"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="/dosen/laporan"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kinerja</a>
    <a class="nav-link" href="/dosen/feedback"><i class="bi bi-chat-left-text"></i> Feedback</a>
    <form action="{{ route('logout') }}" method="POST" style="float: right;">
      @csrf
      <span style="color: white; margin-right: 10px;">Halo, {{ Auth::user()->name }}!</span>
      <button type="submit">Logout</button>
   </form>
@endsection

@section('content')
    <!-- Dosen Statistics Cards -->
    <div class="row">
        <div class="col-md-6">
            <div class="stat-card text-center">
                <div class="icon text-primary"><i class="bi bi-trophy-fill"></i></div>
                <h3 class="fw-bold">4.75</h3>
                <p class="text-muted mb-0">Skor Kinerja Mengajar</p>
                <small class="text-success"><i class="bi bi-arrow-up"></i> Naik 0.2 dari semester lalu</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card text-center">
                <div class="icon text-success"><i class="bi bi-people-fill"></i></div>
                <h3 class="fw-bold">12</h3>
                <p class="text-muted mb-0">Mahasiswa Bimbingan</p>
                 <small class="text-info">2 Belum dinilai</small>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mt-4">
        <div class="col-md-7">
            <div class="card-custom">
                <div class="card-header"><i class="bi bi-graph-up"></i> Tren Skor Kinerja Mengajar</div>
                <div class="card-body">
                    <canvas id="teachingScoreChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card-custom">
                <div class="card-header"><i class="bi bi-pie-chart-fill"></i> Rating dari Mahasiswa (Rata-rata)</div>
                <div class="card-body">
                    <canvas id="studentRatingChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Assessments -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card-custom">
                <div class="card-header bg-warning text-white"><i class="bi bi-exclamation-triangle-fill"></i> Penilaian Mahasiswa Bimbingan Pending</div>
                <div class="card-body">
                     <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Semester</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Rina Wulandari</td>
                                    <td>2021010015</td>
                                    <td>7</td>
                                    <td><button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Beri Penilaian</button></td>
                                </tr>
                                <tr>
                                    <td>Agus Setiawan</td>
                                    <td>2022010008</td>
                                    <td>5</td>
                                    <td><button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Beri Penilaian</button></td>
                                </tr>
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
    // Teaching Score Chart
    const teachingScoreCtx = document.getElementById('teachingScoreChart').getContext('2d');
    new Chart(teachingScoreCtx, {
        type: 'line',
        data: {
            labels: ['Gasal 22/23', 'Genap 22/23', 'Gasal 23/24', 'Genap 23/24', 'Gasal 24/25'],
            datasets: [{
                label: 'Skor Kinerja',
                data: [4.2, 4.4, 4.3, 4.5, 4.75],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: false } } }
    });

    // Student Rating Chart
    const studentRatingCtx = document.getElementById('studentRatingChart').getContext('2d');
    new Chart(studentRatingCtx, {
        type: 'doughnut',
        data: {
            labels: ['Penguasaan Materi', 'Penyampaian', 'Motivasi', 'Kedisiplinan'],
            datasets: [{
                data: [4.8, 4.7, 4.6, 4.9],
                backgroundColor: ['#667eea', '#764ba2', '#3498db', '#2ecc71'],
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endpush
