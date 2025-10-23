@extends('layouts.app')

@section('title', 'Laporan Kinerja')

@section('page-title', 'Laporan Kinerja Dosen')
@section('page-subtitle', 'Rangkuman dan arsip performa Anda')
@section('user-name', 'Prof. Budi Santoso')
@section('user-role', 'Dosen - Teknik Informatika')
@section('user-initial', 'BS')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-pencil-square"></i> Penilaian Mahasiswa</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link active" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kinerja</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text"></i> Feedback</a>
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
                            <h5>Prof. Budi Santoso</h5>
                            <p class="mb-1"><strong>NIP:</strong> 198001102005011001</p>
                            <p class="mb-0"><strong>Program Studi:</strong> Teknik Informatika</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <h5 class="mb-1">Skor Akhir KPI</h5>
                            <h1 class="display-5 fw-bold text-success mb-0">3.55</h1>
                            <p class="mb-0">Kategori: Baik</p>
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
                                <td>Penguasaan Materi</td>
                                <td class="text-center">3.65</td>
                                <td class="text-center"><span class="badge bg-success">Baik</span></td>
                            </tr>
                            <tr>
                                <td>Kejelasan dalam Menyampaikan Materi</td>
                                <td class="text-center">4.00</td>
                                <td class="text-center"><span class="badge bg-success">Sangat Baik</span></td>
                            </tr>
                            <tr>
                                <td>Kemampuan Memberi Motivasi</td>
                                <td class="text-center">3.20</td>
                                <td class="text-center"><span class="badge bg-primary">Baik</span></td>
                            </tr>
                            <tr>
                                <td>Kedisiplinan Waktu</td>
                                <td class="text-center">3.50</td>
                                <td class="text-center"><span class="badge bg-primary">Baik</span></td>
                            </tr>
                            <tr class="table-danger">
                                <td>Keadilan dalam Penilaian</td>
                                <td class="text-center">2.20</td>
                                <td class="text-center"><span class="badge bg-warning text-dark">Buruk</span></td>
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
            labels: ['Penguasaan Materi', 'Kejelasan dalam Menyampaikan Materi', 'Kemampuan Memberi Motivasi', 'Kedisiplinan Waktu', 'Keadilan dalam Penilaian'],
            datasets: [{
                label: 'Skor Capaian',
                data: [4.65, 4.8, 4.2, 3.5, 3.5],
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

