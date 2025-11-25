@extends('layouts.app')

@section('title', 'Penilaian Fasilitas')

@section('page-title', 'Penilaian Fasilitas Kampus')
@section('page-subtitle', 'Berikan penilaian untuk meningkatkan kualitas fasilitas')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

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
                    Sudah Dinilai <span class="badge bg-success ms-1">6</span>
                </button>
            </li>
        </ul>
        <div class="tab-content pt-3" id="assessmentTabContent">
            <!-- Pending Assessment Tab -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                <div class="list-group list-group-flush">
                    @foreach($fasilitas as $f)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3"><i class="bi bi-pc-display-horizontal fs-2 text-info"></i></div>
                            <div>
                                <h6 class="mb-0">{{ $f->name }}</h6>
                                <small class="text-muted">{{ $f->lokasi }}</small>
                            </div>
                        </div>
                        <a href="{{ route('penilaian.form', ['tipe' => 'fasilitas', 'id' => $f->id]) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i> Beri Penilaian
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Completed Assessment Tab -->
            <div class="tab-pane fade" id="completed" role="tabpanel">
                 <div class="list-group list-group-flush">
                     <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3"><i class="bi bi-wifi fs-2 text-success"></i></div>
                            <div>
                                <h6 class="mb-0">Jaringan WiFi Kampus</h6>
                                <small class="text-muted">Kategori: Infrastruktur IT</small>
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
