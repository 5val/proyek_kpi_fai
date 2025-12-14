    @extends('layouts.app')

    @section('title', 'Laporan Kinerja')

    @section('page-title', 'Laporan Kinerja Dosen')
    @section('page-subtitle', 'Rangkuman dan arsip performa Anda')

    @section('content')

    <style>
        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        .card-modern:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .section-title {
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: -0.5px;
        }
        .bg-soft-primary {
            background-color: #eef2ff;
            color: #4e73df;
        }
        .table-modern thead th {
            background-color: #f8f9fa;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom: 2px solid #eaecf4;
        }
    </style>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-body p-4">
                    <div class="row align-items-end justify-content-between g-3">
                        <div class="col-md-5">
                            <form method="GET" action="{{ route('dosen.laporan') }}">
                                <label for="periode" class="form-label fw-bold text-secondary small text-uppercase">
                                    <i class="bi bi-funnel me-1"></i> Pilih Periode Laporan
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted">
                                        <i class="bi bi-calendar-range"></i>
                                    </span>
                                    <select id="periode" class="form-select border-start-0 ps-0 bg-light" name="periode_id" onchange="this.form.submit()" style="cursor: pointer;">
                                        @foreach ($allPeriode as $p)
                                            <option value="{{ $p->id }}" {{ $periode_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-7 text-md-end">
                    <div class="d-flex flex-wrap gap-2">
<a href="{{ route('dosen.laporan.export.excel',  ['kategori' => $curKategori->id, 'periode' => $periode_id]) }}" 
    class="btn btn-success btn-sm d-flex align-items-center">
    <i class="bi bi-file-earmark-excel-fill me-2"></i> Export Excel
</a>

<a href="{{ route('dosen.laporan.export.pdf',  ['kategori' => $curKategori->id, 'periode' => $periode_id]) }}" 
    class="btn btn-danger btn-sm d-flex align-items-center">
    <i class="bi bi-file-earmark-pdf-fill me-2"></i> Export PDF
</a>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-modern">
                
                <div class="card-header bg-white py-3 border-bottom-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-soft-primary p-2 rounded me-3">
                            <i class="bi bi-file-earmark-bar-graph fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 section-title">Hasil Laporan Kinerja</h5>
                            <small class="text-muted">Ringkasan performa akademik Anda</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">

                    <div class="p-4 mb-5 rounded-3 border border-light" style="background: linear-gradient(to right, #f8f9fa, #ffffff);">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="fw-bold text-dark mb-2">{{ $user->name }}</h3>
                                <div class="d-flex flex-wrap gap-3 text-muted mt-2">
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal">
                                        <i class="bi bi-card-heading me-1 text-primary"></i> NIDN: <strong>{{ $dosen->nidn }}</strong>
                                    </span>
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal">
                                        <i class="bi bi-award me-1 text-primary"></i> Status: 
                                        @if($dosen->is_certified)
                                            <span class="text-success fw-bold">Tersertifikasi</span>
                                        @else
                                            <span class="text-secondary fw-bold">Belum Tersertifikasi</span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4 text-md-end mt-3 mt-md-0 border-start-md ps-md-4">
                                <h6 class="text-uppercase text-muted small fw-bold ls-1">Skor Akhir KPI</h6>
                                <h2 class="display-5 fw-bold mb-0 {{ $skorAkhir >= 3.5 ? 'text-success' : 'text-primary' }}">
                                    {{ number_format($skorAkhir, 2) }}
                                </h2>

                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="section-title mb-0">Rincian Capaian Indikator</h5>
                        </div>

                        <div class="table-responsive rounded-3 border">
    <table class="table table-hover table-modern align-middle mb-0">
        <thead>
            <tr>
                <th class="py-3 ps-4">Indikator Kinerja</th>
                <th class="py-3 text-center" style="width: 150px;">Skor Capaian</th>
                <th class="py-3 text-center" style="width: 150px;">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($indikator as $i)
            <tr>
                {{-- NAMA INDIKATOR --}}
                <td class="ps-4 py-3 fw-medium text-dark">
                    {{ $i['nama_indikator'] }}
                </td>

                {{-- SKOR --}}
                <td class="text-center fw-bold text-secondary">
                    {{ number_format($i['avg_score'], 2) ?? '-' }}
                </td>

                {{-- STATUS --}}
                <td class="text-center">
                    @php
                        if (is_null($i['avg_score'])) {
                            $status = '-';
                            $badge = 'bg-light text-secondary';
                        } elseif ($i['avg_score'] >= 4) {
                            $status = 'Baik';
                            $badge = 'bg-success text-white';
                        } elseif ($i['avg_score'] >= 2.5) {
                            $status = 'Sedang';
                            $badge = 'bg-warning text-dark';
                        } else {
                            $status = 'Tidak Baik';
                            $badge = 'bg-danger text-white';
                        }
                    @endphp

                    <span class="badge {{ $badge }} border rounded-pill px-3 py-2">
                        {{ $status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center py-4 text-muted fst-italic">
                    Tidak ada data indikator.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


                    <div>
                        <h5 class="section-title mb-3">Grafik Performa Semester Ini</h5>
                        <div class="card border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <div style="height: 400px; position: relative;">
                                    <canvas id="reportChart"></canvas>
                                </div>
                            </div>
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
        document.addEventListener("DOMContentLoaded", function() {
            // Data dari PHP ke JS
            const labels = {!! json_encode($indikator->pluck('nama_indikator')->toArray()) !!};
            // Pastikan logic pengambilan data nilainya aman dari null
            const dataValues = {!! json_encode($indikator->pluck('avg_score')->map(fn($v) => round($v, 2))->toArray()) !!};

            const ctx = document.getElementById('reportChart').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Skor Capaian (Skala 0-5)',
                        data: dataValues,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 99, 132, 0.7)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 4, // Sedikit radius pada bar chart
                        barPercentage: 0.6 // Membuat bar tidak terlalu gemuk
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5,
                            grid: {
                                color: '#f0f0f0',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                font: { size: 12 }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                autoSkip: false,
                                maxRotation: 25, // Sedikit dimiringkan agar rapi
                                minRotation: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush