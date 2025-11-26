@extends('layouts.app')

@section('title', 'KPI Saya')

@section('page-title', 'Key Performance Indicator (KPI) Saya')
@section('page-subtitle', 'Detail capaian kinerja Anda semester ini')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
<div class="row">
    <!-- KPI Details Table -->
    <div class="col-md-7">
        <div class="card-custom">
            <div class="card-header">
                <i class="bi bi-clipboard-data"></i> Detail Indikator Kinerja Saya (Semester Gasal 2024/2025)
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Indikator Kinerja</th>
                                <th>Target</th>
                                <th>Capaian</th>
                                <th>Skor (1-4)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="bi bi-book text-primary"></i> IPK Semester</td>
                                <td>≥ 3.50</td>
                                <td><strong>3.75</strong></td>
                                <td><span class="badge bg-success">3.65</span></td>
                                <td><span class="badge bg-success">Melebihi Target</span></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar-check text-info"></i> Kehadiran Perkuliahan</td>
                                <td>≥ 80%</td>
                                <td><strong>94%</strong></td>
                                <td><span class="badge bg-success">4.0</span></td>
                                <td><span class="badge bg-success">Melebihi Target</span></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-trophy text-warning"></i> Prestasi Akademik & Non-Akademik</td>
                                <td>≥ 2 Prestasi</td>
                                <td><strong>3 Prestasi</strong></td>
                                <td><span class="badge bg-success">3.8</span></td>
                                <td><span class="badge bg-success">Melebihi Target</span></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-people text-success"></i> Keaktifan Organisasi Kemahasiswaan</td>
                                <td>Mengikuti min. 1 UKM/Organisasi</td>
                                <td><strong>2 Organisasi</strong></td>
                                <td><span class="badge bg-primary">3.5</span></td>
                                <td><span class="badge bg-primary">Target Tercapai</span></td>
                            </tr>
                            <tr class="table-danger">
                                <td><i class="bi bi-laptop text-danger"></i> Pengumpulan Tugas Tepat Waktu</td>
                                <td>≥ 85% Tepat Waktu</td>
                                <td><strong>72%</strong></td>
                                <td><span class="badge bg-warning">2.9</span></td>
                                <td><span class="badge bg-warning">Perlu Peningkatan</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Comments from Lecturers -->
    <div class="col-md-5">
       <div class="card-custom">
            <div class="card-header"><i class="bi bi-chat-quote-fill"></i> Komentar dari Dosen</div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <p class="mb-1">"Andi menunjukkan inisiatif yang sangat baik dalam bimbingan skripsi. Progresnya konsisten dan selalu siap dengan materi diskusi."</p>
                        <small class="text-muted">- Dr. Budi Hartono, M.Kom., 2 hari lalu</small>
                    </div>
                     <div class="list-group-item">
                        <p class="mb-1">"Keaktifannya di kelas Algoritma Lanjut patut diapresiasi. Sering bertanya dan memberikan jawaban yang kritis."</p>
                        <small class="text-muted">- Prof. Dr. Indah Lestari, M.T., 5 hari lalu</small>
                    </div>
                    <div class="list-group-item">
                        <p class="mb-1">"Perlu sedikit peningkatan dalam manajemen waktu pengumpulan tugas praktikum Jaringan Komputer. Namun secara keseluruhan pemahamannya sudah baik."</p>
                        <small class="text-muted">- Ahmad Maulana, S.Kom., M.Cs., 1 minggu lalu</small>
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
            labels: ['IPK', 'Kehadiran', 'Prestasi', 'Organisasi', 'Tugas Tepat Waktu'],
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
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Grafik Skor KPI per Indikator',
                    font: {
                        size: 16
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    title: {
                        display: true,
                        text: 'Skor'
                    }
                }
            }
        }
    });
</script>
@endpush

