@extends('layouts.app')

@section('title', 'Laporan KPI')

@section('page-title', 'Laporan Kinerja Mahasiswa')
@section('page-subtitle', 'Rangkuman dan arsip performa Anda')
@section('user-name', ucfirst($mahasiswa->user->name))
@section('user-role', 'Mahasiswa - '. ucfirst($mahasiswa->program_studi->name))
@section('user-initial', 'AP')

@section('content')

{{-- ===========================
    MAHASISWA BARU
=========================== --}}
@if($isBaru)
    <div class="alert alert-info p-4 text-center fw-bold">
        <i class="bi bi-info-circle me-2"></i>
        Mahasiswa baru — belum ada laporan yang bisa ditampilkan.
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body p-5 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076500.png" 
                 width="120" class="mb-4 opacity-75">

            <h4 class="fw-bold text-muted">Belum Ada Data</h4>
            <p class="text-secondary mb-0">
                Sistem akan menampilkan grafik dan laporan setelah Anda mengikuti kelas & presensi.
            </p>
        </div>
    </div>
    @endif

@if(!$isBaru)

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
                            <label for="periode" class="form-label fw-bold text-muted small text-uppercase">
                                Pilih Periode Laporan
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-calendar-event"></i>
                                </span>
                                <select id="periode" class="form-select" name="periode_id" onchange="this.form.submit()">
                                    @foreach ($all_periode as $p)
                                        <option value="{{ $p->id }}" 
                                                {{ $periode_id == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_periode }}
                                        </option>
                                    @endforeach
                                </select>
                                <div></div>
                                <a
                                    href="{{ route('mahasiswa.laporan.pdf', $periode_id) }}"
                                    class="btn btn-danger text-white shadow-sm px-4"
                                    target="_blank"
                                >
                                    <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
                                </a>

                            </div>
                        </div>

                        <div class="col-12 col-md-7 d-flex flex-column flex-md-row gap-2"></div>

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
                            <h4 class="fw-bold text-dark mb-2">
                                {{ ucfirst($mahasiswa->user->name) }}
                            </h4>
                            <div class="text-muted">
                                <p class="mb-1"><i class="bi bi-card-text me-2"></i>{{ $mahasiswa->nrp }}</p>
                                <p class="mb-0"><i class="bi bi-mortarboard me-2"></i>{{ $mahasiswa->program_studi->name }}</p>
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
    DETAIL LAPORAN
=========================== --}}
<div class="row g-4">

    {{-- ================== TABEL KEHADIRAN ================== --}}
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

    {{-- ================== FEEDBACK DOSEN ================== --}}
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

@endif

@endsection

{{-- ===========================
    CHART SCRIPT
=========================== --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const grafikLabels = @json($grafik_labels);
const grafikValues = @json($grafik_values);

const ctx = document.getElementById('reportChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: grafikLabels,
        datasets: [
            {
                label: 'Rata-rata Kehadiran (%)',
                data: grafikValues,
                showLine: true,
                fill: false,
                borderWidth: 2,
                borderColor: "#3498db",
                backgroundColor: "rgba(52,152,219,0.25)",
                pointBackgroundColor: "#3498db",
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.3,
            },
            {
                label: 'Target Minimum (75%)',
                data: grafikLabels.map(() => 75),
                showLine: true,
                fill: false,
                borderWidth: 1.5,
                borderColor: "#e74c3c",
                borderDash: [5,5],
                pointRadius: 0,
                spanGaps: true
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: { stepSize: 10 }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'bottom'
            }
        }
    }
});
</script>

@endpush




