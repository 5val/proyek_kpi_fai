@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('page-title', 'Dashboard Mahasiswa')
@section('page-subtitle', 'Monitoring & Penilaian KPI')
@section('user-name', ucfirst($mahasiswa->user->name))
@section('user-role', 'Mahasiswa - '. ucfirst($mahasiswa->program_studi->name))
@section('user-initial', 'AP')

@section('content')

{{-- ============================
    HEADER PROFIL
============================= --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-custom border-0 text-white shadow-sm"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body p-4">

                <div class="d-flex flex-column flex-md-row align-items-center text-center text-md-start">

                    {{-- Avatar --}}
                    <div class="mb-3 mb-md-0 me-md-4">
                        <img src="{{ $mahasiswa->user->photo_profile ? Storage::url($mahasiswa->user->photo_profile) : asset('images/default-user.png') }}"
                        class="rounded-circle mb-3" width="150" height="150" alt="Profile Picture">
                    </div>

                    {{-- Info Mahasiswa --}}
                    <div class="flex-grow-1 mb-3 mb-md-0">
                        <h3 class="fw-bold mb-2">{{ $mahasiswa->user->name }}</h3>
                        <div class="d-flex flex-column opacity-75">
                            <span><i class="bi bi-card-text me-2"></i> NRP: {{ $mahasiswa->nrp }}</span>
                            <span><i class="bi bi-book me-2"></i>{{ $mahasiswa->program_studi->name }}</span>
                        </div>
                    </div>

                    {{-- IPK --}}
                    <div class="bg-white bg-opacity-10 p-3 rounded-3 text-center" style="min-width: 140px;">
                        <h1 class="display-5 fw-bold mb-0">{{ $mahasiswa->ipk }}</h1>
                        <small class="text-uppercase text-white-50 fw-bold" style="font-size: 0.7rem;">IP Kumulatif</small>
                        <div class="mt-2">
                            <span class="badge bg-white text-primary rounded-pill px-3">Aktif</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>



{{-- ==========================================================
     BAGIAN UNTUK MEMBEDAKAN MAHASISWA BARU / LAMA
=========================================================== --}}

@if($isBaru)
    {{-- =================== MAHASISWA BARU =================== --}}
    <div class="alert alert-info text-center fw-bold py-4">
        <i class="bi bi-info-circle-fill me-2"></i>
        Anda belum memiliki data kelas & laporan kehadiran.
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <i class="bi bi-emoji-smile fs-1 text-primary mb-3"></i>
                    <h4 class="fw-bold">Selamat datang di Dashboard!</h4>
                    <p class="text-muted">
                        Setelah Anda mengikuti kelas, grafik performa dan daftar kelas akan tampil di sini.
                    </p>
                </div>
            </div>
        </div>
    </div>

@else
    {{-- =================== MAHASISWA LAMA =================== --}}

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="icon text-warning fs-1 mb-2"><i class="bi bi-star-fill"></i></div>
                    <h3 class="fw-bold mb-0">{{ $dosenBelum }}</h3>
                    <p class="text-muted small text-uppercase fw-bold mb-1">Pending</p>
                    <small class="text-danger fw-bold">Perlu diisi</small>
                </div>
            </div>
        </div>
    </div>

    {{-- GRAFIK --}}
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-graph-up me-2"></i> Performa KPI Saya
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="grafikKehadiran"></canvas>
                    </div>
                </div>
            </div>
        </div>

        @php
    $persenDosen = $totalDosen > 0
        ? round(($dosenSudah / $totalDosen) * 100)
        : 0;

    $totalFasilitas = $fasilitasSudah + $fasilitasBelum;
    $persenFasilitas = $totalFasilitas > 0
        ? round(($fasilitasSudah / $totalFasilitas) * 100)
        : 0;

    $totalPraktikum = $praktikumSudah + $praktikumBelum;
    $persenPraktikum = $totalPraktikum > 0
        ? round(($praktikumSudah / $totalPraktikum) * 100)
        : 0;

    $totalUnit = $unitSudah + $unitBelum;
    $persenUnit = $totalUnit > 0
        ? round(($unitSudah / $totalUnit) * 100)
        : 0;
@endphp

        {{-- STATUS PENILAIAN --}}
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-list-check me-2"></i> Status Penilaian
                </div>
                <div class="card-body">
                    {{-- Dosen --}}
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Penilaian Dosen</span>
                            <span class="badge bg-success">{{ $dosenSudah}} / {{ $totalDosen }}</span>
                        </div>
                        <div class="progress mt-2" style="height: 8px;">
                            <div class="progress-bar bg-success"  style="width: {{ $persenDosen }}%"></div>
                        </div>
                    </div>
                    {{-- Fasilitas --}}
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Penilaian Fasilitas</span>
                            <span class="badge bg-warning text-dark">{{ $fasilitasSudah }} / {{ $totalFasilitas }}</span>
                        </div>
                        <div class="progress mt-2" style="height: 8px;">
                            <div class="progress-bar bg-warning"  style="width: {{ $persenFasilitas }}%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Penilaian Praktikum</span>
                            <span class="badge bg-info text-dark">{{ $praktikumSudah }} / {{ $totalPraktikum }}</span>
                        </div>
                        <div class="progress mt-2" style="height: 8px;">
                            <div class="progress-bar bg-info"  style="width: {{ $persenPraktikum }}%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Penilaian Unit</span>
                            <span class="badge bg-danger text-light">{{ $unitSudah }} / {{ $totalUnit }}</span>
                        </div>
                        <div class="progress mt-2" style="height: 8px;">
                            <div class="progress-bar bg-dark"  style="width: {{ $persenUnit }}%"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- TABEL KELAS --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-clipboard-data me-2"></i> Kelas yang Saya Ikuti
                </div>
                <div class="card-body p-0 p-md-3">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Nama Kelas</th>
                                    <th class="text-center">Dosen Pengajar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kelasSaya as $k)
                                    <tr>
                                        <td class="text-center fw-bold">{{ $k->mataKuliah->name }}</td>
                                        <td class="text-center fw-bold">{{ $k->dosen->user->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif


{{-- MENU CEPAT --}}
<div class="row mt-4 g-4">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-lightning-charge-fill me-2"></i> Menu Cepat
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('mahasiswa.penilaian_dosen') }}" 
                           class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center justify-content-center">
                            <i class="bi bi-person-video3 fs-1"></i>
                            <span class="small fw-bold">Nilai Dosen</span>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('mahasiswa.penilaian_fasilitas') }}"
                           class="btn btn-outline-success w-100 py-3 d-flex flex-column align-items-center justify-content-center">
                            <i class="bi bi-building fs-1"></i>
                            <span class="small fw-bold">Nilai Fasilitas</span>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('mahasiswa.feedback') }}"
                           class="btn btn-outline-warning text-dark w-100 py-3 d-flex flex-column align-items-center justify-content-center">
                            <i class="bi bi-chat-dots fs-1"></i>
                            <span class="small fw-bold">Feedback</span>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('mahasiswa.laporan') }}"
                           class="btn btn-outline-info text-dark w-100 py-3 d-flex flex-column align-items-center justify-content-center">
                            <i class="bi bi-file-earmark-text fs-1"></i>
                            <span class="small fw-bold">Laporan</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection



{{-- ===============================
     JAVASCRIPT GRAFIK
================================ --}}
@if(!$isBaru)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikKehadiran');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($grafik_labels),
        datasets: [
            {
                label: 'Rata-rata Kehadiran (%)',
                data: @json($grafik_values),
                borderWidth: 3,
                borderColor: '#3498db',
                backgroundColor: 'rgba(52,152,219,0.2)',
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: '#3498db'
            },
            {
                label: 'Target Minimum',
                data: Array(@json($grafik_values).length).fill(75),
                borderWidth: 2,
                borderColor: '#e74c3c',
                borderDash: [5,5],
                pointRadius: 0
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>
@endpush
@endif
