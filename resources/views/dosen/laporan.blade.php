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
                        </select>
                    </div>
                    <div class="col-md-7 d-flex align-items-end">
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
            <div class="card-header">
                <i class="bi bi-file-earmark-text"></i> Hasil Laporan Kinerja
            </div>

            <div class="card-body">

                <!-- Summary -->
                <div class="p-3 mb-4 rounded" style="background:#f8f9fa;">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>{{ Auth::user()->name ?? '-' }}</h5>
                            <p class="mb-1"><strong>NIDN:</strong> {{ $dosen->nidn }}</p>
                            <p class="mb-0"><strong>Certified:</strong> {{ $dosen->is_certified ? 'Ya' : 'Tidak' }}</p>
                        </div>

                        <div class="col-md-4 text-md-end">
                            <h5 class="mb-1">Skor Akhir KPI</h5>

                            <h1 class="display-5 fw-bold 
                                {{ $skorAkhir >= 3.5 ? 'text-success' : ($skorAkhir >= 3 ? 'text-primary' : 'text-danger') }}">

                                {{ number_format($skorAkhir, 2) }}
                            </h1>

                            <p class="mb-0">Kategori: {{ $kategori }}</p>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <h5 class="mt-4">Rincian Capaian Indikator</h5>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Indikator Kinerja</th>
                                <th class="text-center">Skor</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($indikator as $item)

                                @php
                                    // gunakan name, bukan nama
                                    $skor = $nilai[$item->id]->skor ?? 0;

                                    $status = $skor >= 3.5 ? 'Sangat Baik' :
                                             ($skor >= 3 ? 'Baik' :
                                             ($skor >= 2 ? 'Cukup' : 'Buruk'));

                                    $badge = $skor >= 3.5 ? 'bg-success' :
                                             ($skor >= 3 ? 'bg-primary' :
                                             ($skor >= 2 ? 'bg-warning text-dark' : 'bg-danger'));
                                @endphp

                                <tr class="{{ $skor < 2.5 ? 'table-danger' : '' }}">
                                    <td>{{ $item->name }}</td>

                                    <td class="text-center">{{ number_format($skor, 2) }}</td>

                                    <td class="text-center">
                                        <span class="badge {{ $badge }}">{{ $status }}</span>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>

                    </table>
                </div>

                <!-- Chart -->
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
    const labels = {!! json_encode($indikator->pluck('name')->toArray()) !!};

    const dataValues = {!! json_encode(
        $indikator->map(fn($i) => $nilai[$i->id]->skor ?? 0)->toArray()
    ) !!};

    new Chart(document.getElementById('reportChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Skor Capaian',
                data: dataValues,
                backgroundColor: 'rgba(54,162,235,0.7)',
                borderColor: 'rgba(54,162,235,1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5
                }
            }
        }
    });
</script>
@endpush
