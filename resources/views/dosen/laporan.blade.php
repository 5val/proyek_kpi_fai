@extends('layouts.app')

@section('title', 'Laporan Kinerja')

@section('page-title', 'Laporan Kinerja Dosen')
@section('page-subtitle', 'Rangkuman dan arsip performa Anda')

@section('content')
<!-- Filter -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <label class="form-label">Pilih Periode Laporan</label>
                        <select class="form-select">
                            <option selected>Semester Gasal 2024/2025</option>
                            <option>Semester Genap 2023/2024</option>
                            <option>Semester Gasal 2023/2024</option>
                        </select>
                    </div>
                    <div class="col-md-7 d-flex align-items-end mt-3 mt-md-0">
                        <button class="btn btn-primary me-2">
                            <i class="bi bi-filter"></i> Tampilkan Laporan
                        </button>
                        <button class="btn btn-success me-2">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </button>
                        <button class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report -->
<div class="row">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-text me-2 text-primary"></i> Hasil Laporan Kinerja
                </h5>
            </div>

            <div class="card-body">

                <!-- Summary -->
                <div class="p-4 mb-4 rounded border" style="background:#f8f9fa;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-2 text-dark">{{ $dosen->name }}</h4>
                            <div class="d-flex flex-column flex-md-row gap-md-4 text-muted">
                                <p class="mb-1"><i class="bi bi-card-heading me-1"></i> <strong>NIDN:</strong> {{ $dosen->nidn }}</p>
                                <p class="mb-0"><i class="bi bi-award me-1"></i> <strong>Sertifikasi:</strong> 
                                    @if($dosen->is_certified)
                                        <span class="text-success fw-bold">Tersertifikasi</span>
                                    @else
                                        <span class="text-secondary">Belum Tersertifikasi</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4 text-md-end mt-3 mt-md-0 border-start-md ps-md-4">
                            <h6 class="text-muted mb-1">Skor Akhir KPI</h6>

                            {{-- <h1 class="display-4 fw-bold mb-0 
                                {{ $skorAkhir >= 3.5 ? 'text-success' : ($skorAkhir >= 3 ? 'text-primary' : 'text-danger') }}">
                                {{ number_format($skorAkhir, 2) }}
                            </h1>

                            <span class="badge rounded-pill mt-2 px-3 py-2 
                                {{ $skorAkhir >= 3.5 ? 'bg-success' : ($skorAkhir >= 3 ? 'bg-primary' : 'bg-danger') }}">
                                {{ $kategori }}
                            </span> --}}
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <h5 class="mt-5 mb-3">Rincian Capaian Indikator</h5>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 ps-3">Indikator Kinerja</th>
                                <th class="py-3 text-center" style="width: 150px;">Skor Capaian</th>
                                <th class="py-3 text-center" style="width: 200px;">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                                <tr>
                                    @foreach ($indikator as $i)
                                        
                                    <td class="ps-3 fw-medium">{{ $i->name }}</td>
                                    
                                    {{-- <td class="text-center fw-bold fs-5">{{ number_format($skor, 2) }}</td> --}}
                                    
                                    {{-- <td class="text-center">
                                        <span class="badge rounded-pill {{ $badgeClass }} px-3">
                                            {{ $status }}
                                        </span>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Chart -->
                <h5 class="mt-5 mb-3">Grafik Performa Semester Ini</h5>
                <div class="border rounded p-3">
                    <canvas id="reportChart" style="max-height: 400px;"></canvas>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Data dari PHP ke JS
        const labels = {!! json_encode($indikator->pluck('name')->toArray()) !!};
        const dataValues = {!! json_encode($indikator->map(fn($i) => $nilai[$i->id]->skor ?? 0)->toArray()) !!};

        const ctx = document.getElementById('reportChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor Capaian (Skala 0-5)',
                    data: dataValues,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5,
                        grid: {
                            color: '#f0f0f0'
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush