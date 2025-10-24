@extends('layouts.app')

@section('title', 'Penilaian Unit Layanan')

@section('page-title', 'Penilaian Unit Layanan')
@section('page-subtitle', 'Berikan penilaian terhadap unit layanan di kampus')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-star"></i> Penilaian Dosen</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link active" href="#"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-person-workspace"></i> Penilaian Praktikum</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text"></i> Feedback</a>
    <a class="nav-link" href="#"><i class="bi bi-bar-chart"></i> Laporan KPI</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-body">
        <ul class="nav nav-tabs" id="assessmentTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                    Belum Dinilai <span class="badge bg-danger ms-1">4</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                    Sudah Dinilai <span class="badge bg-success ms-1">2</span>
                </button>
            </li>
        </ul>
        <div class="tab-content pt-3" id="assessmentTabContent">
            <!-- Pending Assessment Tab -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3"><i class="bi bi-journal-album fs-2 text-primary"></i></div>
                            <div>
                                <h6 class="mb-0">BAA (Biro Administrasi Akademik)</h6>
                                <small class="text-muted">Layanan terkait KRS, transkrip, dan jadwal.</small>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Beri Penilaian</button>
                    </div>
                     <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3"><i class="bi bi-wallet2 fs-2 text-success"></i></div>
                            <div>
                                <h6 class="mb-0">BAK (Biro Administrasi Keuangan)</h6>
                                <small class="text-muted">Layanan terkait pembayaran dan keuangan.</small>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Beri Penilaian</button>
                    </div>
                </div>
            </div>
            <!-- Completed Assessment Tab -->
            <div class="tab-pane fade" id="completed" role="tabpanel">
                <div class="list-group list-group-flush">
                     <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3"><i class="bi bi-heart-pulse-fill fs-2 text-danger"></i></div>
                            <div>
                                <h6 class="mb-0">Unit Kesehatan Mahasiswa</h6>
                                <small class="text-muted">Layanan kesehatan dan P3K.</small>
                            </div>
                        </div>
                        <div>
                            <span class="fw-bold me-2">Skor: 3.0/4.0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
