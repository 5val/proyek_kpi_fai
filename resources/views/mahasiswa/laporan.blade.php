@extends('layouts.app')

@section('title', 'Laporan KPI')

@section('page-title', 'Laporan Kinerja Mahasiswa')
@section('page-subtitle', 'Rangkuman dan arsip performa Anda')
@section('user-name', ucfirst($mahasiswa->user->name))
@section('user-role', 'Mahasiswa - '. ucfirst($mahasiswa->program_studi->name))
@section('user-initial', 'AP')

@section('content')

{{-- ===========================
    FILTER PERIODE
=========================== --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-custom shadow-sm border-0">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('mahasiswa.laporan') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-5">
                            <label for="periode" class="form-label fw-bold text-muted small text-uppercase">Pilih Periode Laporan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar-event"></i></span>
                                <select id="periode" class="form-select" name="periode_id">
                                    @foreach ($all_periode as $p)
                                        <option value="{{ $p->id }}" {{ $periode_id == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_periode }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-7 d-flex flex-column flex-md-row gap-2">
                           
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ===========================
    HEADER MAHASISWA
=========================== --}}
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
                            <h4 class="fw-bold text-dark mb-2">{{ ucfirst($mahasiswa->user->name) }}</h4>
                            <div class="text-muted">
                                <p class="mb-1"><i class="bi bi-card-text me-2"></i>{{ $mahasiswa->nrp }}</p>
                                <p class="mb-0"><i class="bi bi-mortarboard me-2"></i>{{ $mahasiswa->program_studi->name ?? '-' }}</p>
                                <p class="mb-0">IPK: {{ $mahasiswa->ipk ?? '-' }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ===========================
    DETAIL INDIKATOR + KOMENTAR
=========================== --}}
<div class="row g-4">

    {{-- ================== INDICATOR TABLE ================== --}}
    <div class="col-12 col-lg-7">
        <div class="card card-custom shadow-sm border-0 h-100">
            <div class="card-body p-4">

                <h5 class="fw-bold text-dark mb-3">Rincian Kehadiran</h5>

                <div class="table-responsive mb-5">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Mata Kuliah</th>
                                <th>Dosen</th>
                                <th class="text-center">SKS</th>
                                <th class="text-center">Kehadiran (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hasil as $h)
                                <tr>
                                    <td>{{ $h['kelas'] }}</td>
                                    <td>{{ $h['dosen'] }}</td>
                                    <td class="text-center">{{ $h['sks'] }}</td>
                                    <td class="text-center fw-bold">{{ $h['kehadiran'] }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Tidak ada data kelas untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- GRAFIK --}}
                <h5 class="fw-bold text-dark mb-3">Grafik Performa</h5>
                <div class="card border p-3 bg-light">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="reportChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ================== FEEDBACK KOMENTAR ================== --}}
    <div class="col-12 col-lg-5">
        <div class="card card-custom h-100 shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-chat-quote-fill me-2"></i> Keluhan Dosen
            </div>

            <div class="card-body p-0">
                <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">

                    @forelse ($feedback as $fb)
                        <div class="list-group-item p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-bold text-dark">{{ $fb->penilai->name }}</h6>
                                <small class="text-muted bg-light px-2 py-1 rounded">
                                    {{ $fb->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <p class="mb-0 text-secondary fst-italic lh-sm">"{{ $fb->isi }}"</p>
                        </div>
                    @empty
                        <div class="list-group-item p-4 text-center text-muted">
                            Tidak ada keluhan dari dosen.
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

{{-- ===========================
    CHART.JS
=========================== --}}
@push('scripts') 
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Konfigurasi Font Responsif
    Chart.defaults.font.family = "'Segoe UI', 'Helvetica', 'Arial', sans-serif";
    Chart.defaults.font.size = 11;

    // My KPI Chart
    const reportChart = document.getElementById('reportChart');
    new Chart(reportChart, {
        type: 'line',
        data: {
            labels: ['Kehadiran'],
            datasets: [{
                label: 'Skor Saya',
                data: [5.0],
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                borderColor: '#3498db',
                pointBackgroundColor: '#3498db',
                pointBorderColor: '#fff',
                borderWidth: 2
            }, {
                label: 'Target Minimum',
                data: [3.5],
                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                borderColor: '#e74c3c',
                pointBackgroundColor: '#e74c3c',
                pointBorderColor: '#fff',
                borderWidth: 2,
                borderDash: [5, 5]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // PENTING agar responsif di container
            scales: {
                r: {
                    beginAtZero: true,
                    max: 5,
                    ticks: { display: false, stepSize: 1 },
                    pointLabels: {
                        font: { size: 12, weight: 'bold' }
                    }
                }
            },
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush