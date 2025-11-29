@extends('layouts.app')

@section('title', 'Laporan KPI')

@section('page-title', 'Laporan Kinerja Mahasiswa')
@section('page-subtitle', 'Rangkuman dan arsip performa Anda')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-custom shadow-sm border-0">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-5">
                        <label for="periode" class="form-label fw-bold text-muted small text-uppercase">Pilih Periode Laporan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-calendar-range"></i></span>
                            <select class="form-select" id="periode">
                                <option selected>Semester Gasal 2024/2025</option>
                                <option>Semester Genap 2023/2024</option>
                                <option>Semester Gasal 2023/2024</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <button class="btn btn-primary shadow-sm"><i class="bi bi-filter me-2"></i> Tampilkan</button>
                            <button class="btn btn-success shadow-sm"><i class="bi bi-file-earmark-excel me-2"></i> Export Excel</button>
                            <button class="btn btn-danger shadow-sm"><i class="bi bi-file-earmark-pdf me-2"></i> Export PDF</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card card-custom shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-file-earmark-text me-2"></i> Hasil Laporan Kinerja
            </div>
            <div class="card-body p-4">
                <div class="p-4 rounded bg-light border border-start border-primary">
                    <div class="row align-items-center text-center text-md-start">
                        <div class="col-12 col-md-8 mb-3 mb-md-0">
                            <h4 class="fw-bold text-dark mb-2">Andi Pratama</h4>
                            <div class="text-muted">
                                <p class="mb-1"><i class="bi bi-card-text me-2"></i> 2021010001</p>
                                <p class="mb-0"><i class="bi bi-mortarboard me-2"></i> Teknik Informatika</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 text-center text-md-end border-top border-md-top-0 pt-3 pt-md-0 mt-2 mt-md-0">
                            <h6 class="text-uppercase text-muted small fw-bold mb-1">Skor Akhir KPI</h6>
                            <h1 class="display-4 fw-bold text-success mb-0">3.70</h1>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill mt-2">Sangat Baik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    
    <div class="col-12 col-lg-7">
        <div class="card card-custom shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3">Rincian Capaian Indikator</h5>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered table-hover align-middle w-100 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>Indikator Kinerja</th>
                                <th class="text-center" width="100">Skor</th>
                                <th class="text-center" width="150">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Kemajuan Studi & IPK</td>
                                <td class="text-center fw-bold">3.5</td>
                                <td class="text-center"><span class="badge bg-success rounded-pill px-3">Baik</span></td>
                            </tr>
                            <tr>
                                <td>Keaktifan Bimbingan</td>
                                <td class="text-center fw-bold">4.0</td>
                                <td class="text-center"><span class="badge bg-primary rounded-pill px-3">Excellent</span></td>
                            </tr>
                            <tr>
                                <td>Inisiatif</td>
                                <td class="text-center fw-bold">3.8</td>
                                <td class="text-center"><span class="badge bg-primary rounded-pill px-3">Excellent</span></td>
                            </tr>
                            <tr>
                                <td>Pengumpulan Tugas</td>
                                <td class="text-center fw-bold text-warning">3.2</td>
                                <td class="text-center"><span class="badge bg-warning text-dark rounded-pill px-3">Cukup</span></td>
                            </tr>
                            <tr>
                                <td>Etika & Sikap</td>
                                <td class="text-center fw-bold">4.0</td>
                                <td class="text-center"><span class="badge bg-primary rounded-pill px-3">Excellent</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="fw-bold text-dark mb-3">Grafik Performa</h5>
                <div class="card border p-3 bg-light">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="reportChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card card-custom h-100 shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-chat-quote-fill me-2"></i> Komentar Dosen
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">
                    
                    {{-- Item 1 --}}
                    <div class="list-group-item p-4">
                        <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-bold text-dark">Dr. Budi Hartono, M.Kom.</h6>
                            <small class="text-muted bg-light px-2 py-1 rounded">2 hari lalu</small>
                        </div>
                        <p class="mb-0 text-secondary fst-italic lh-sm">
                            "Andi menunjukkan inisiatif yang sangat baik dalam bimbingan skripsi. Progresnya konsisten."
                        </p>
                    </div>
                    
                    {{-- Item 2 --}}
                    <div class="list-group-item p-4 bg-light bg-opacity-50">
                        <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-bold text-dark">Prof. Dr. Indah Lestari</h6>
                            <small class="text-muted bg-white border px-2 py-1 rounded">5 hari lalu</small>
                        </div>
                        <p class="mb-0 text-secondary fst-italic lh-sm">
                            "Keaktifannya di kelas Algoritma Lanjut patut diapresiasi. Sering membantu teman yang kesulitan."
                        </p>
                    </div>
                    
                    {{-- Item 3 --}}
                    <div class="list-group-item p-4">
                        <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-bold text-dark">Ahmad Maulana, S.Kom.</h6>
                            <small class="text-muted bg-light px-2 py-1 rounded">1 minggu lalu</small>
                        </div>
                        <p class="mb-0 text-secondary fst-italic lh-sm">
                            "Perlu sedikit peningkatan dalam manajemen waktu pengumpulan tugas praktikum Jaringan Komputer."
                        </p>
                    </div>

                    {{-- Item Tambahan (Agar list terlihat penuh) --}}
                    <div class="list-group-item p-4 bg-light bg-opacity-50">
                        <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-bold text-dark">Siti Aminah, M.Pd.</h6>
                            <small class="text-muted bg-white border px-2 py-1 rounded">2 minggu lalu</small>
                        </div>
                        <p class="mb-0 text-secondary fst-italic lh-sm">
                            "Etika komunikasi sangat sopan. Pertahankan attitude ini di dunia kerja nanti."
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Segoe UI', 'Helvetica', 'Arial', sans-serif";

    const reportCtx = document.getElementById('reportChart').getContext('2d');
    new Chart(reportCtx, {
        type: 'bar',
        data: {
            labels: ['IPK', 'Bimbingan', 'Inisiatif', 'Tugas', 'Etika'],
            datasets: [{
                label: 'Skor Capaian',
                data: [3.5, 4.0, 3.8, 3.2, 4.0],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)'
                ],
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, max: 5 }
            }
        }
    });
</script>
@endpush