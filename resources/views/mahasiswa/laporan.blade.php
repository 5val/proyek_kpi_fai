@extends('layouts.app')

@section('title', 'Laporan KPI')

@section('page-title', 'Laporan Kinerja Mahasiswa')
@section('page-subtitle', 'Rangkuman dan arsip performa Anda')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-star"></i> Penilaian Dosen</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text"></i> Feedback</a>
    <a class="nav-link active" href="#"><i class="bi bi-bar-chart"></i> Laporan KPI</a>
@endsection

@section('content')
<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <label for="periode" class="form-label">Pilih Periode Laporan</label>
                        <select class="form-select" id="periode">
                            <option selected>Semester Gasal 2024/2025</option>
                            <option>Semester Genap 2023/2024</option>
                            <option>Semester Gasal 2023/2024</option>
                            <option>Semester Genap 2022/2023</option>
                        </select>
                    </div>
                    <div class="col-md-7 d-flex justify-content-start align-items-end">
                        <button class="btn btn-primary me-2"><i class="bi bi-filter"></i> Tampilkan Laporan</button>
                        <button class="btn btn-success me-2"><i class="bi bi-file-earmark-excel"></i> Export Excel</button>
                        <button class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="card-header">
                <i class="bi bi-file-earmark-text"></i> Hasil Laporan Kinerja - Semester Gasal 2024/2025
            </div>
            <div class="card-body">
                <!-- Report Summary -->
                <div class="p-3 mb-4 rounded" style="background-color: #f8f9fa;">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Andi Pratama</h5>
                            <p class="mb-1"><strong>NIM:</strong> 2021010001</p>
                            <p class="mb-0"><strong>Program Studi:</strong> Teknik Informatika</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <h5 class="mb-1">Skor Akhir KPI</h5>
                            <h1 class="display-5 fw-bold text-success mb-0">3.70</h1>
                            <p class="mb-0">Kategori: Sangat Baik</p>
                        </div>
                    </div>
                </div>

                <!-- Report Details Table -->
                <h5 class="mt-4">Rincian Capaian Indikator</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Indikator Kinerja</th>
                                <th>Skor (1-4)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Kemajuan Studi & IPK</td>
                                <td class="text-center">3.5</td>
                                <td class="text-center"><span class="badge bg-success">Baik</span></td>
                            </tr>
                            <tr>
                                <td>Keaktifan dalam Bimbingan</td>
                                <td class="text-center">4.0</td>
                                <td class="text-center"><span class="badge bg-success">Sangat Baik</span></td>
                            </tr>
                            <tr>
                                <td>Inisiatif & Kemandirian</td>
                                <td class="text-center">3.8</td>
                                <td class="text-center"><span class="badge bg-success">Sangat Baik</span></td>
                            </tr>
                            <tr>
                                <td>Pengumpulan Tugas Tepat Waktu</td>
                                <td class="text-center">3.2</td>
                                <td class="text-center"><span class="badge bg-warning">Baik</span></td>
                            </tr>
                            <tr>
                                <td>Etika & Sikap</td>
                                <td class="text-center">4.0</td>
                                <td class="text-center"><span class="badge bg-primary">Sangat Baik</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Chart Visualization -->
                <h5 class="mt-5">Grafik Performa</h5>
                <canvas id="reportChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const reportCtx = document.getElementById('reportChart').getContext('2d');
    new Chart(reportCtx, {
        type: 'bar',
        data: {
            labels: ['Kemajuan Studi & IPK', 'Keaktifan dalam Bimbingan', 'Inisiatif & Kemandirian', 'Pengumpulan Tugas Tepat Waktu', 'Etika & Sikap'],
            datasets: [{
                label: 'Skor Capaian',
                data: [4.5, 5.0, 4.8, 4.0, 3.2],
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Grafik Skor KPI Semester Gasal 2024/2025' }
            },
            scales: {
                y: { beginAtZero: true, max: 5, title: { display: true, text: 'Skor' } }
            }
        }
    });
</script>
@endpush
