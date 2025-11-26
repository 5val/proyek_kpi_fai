@extends('layouts.app')

@section('title', 'Penilaian Unit Layanan')

@section('page-title', 'Penilaian Unit Layanan')
@section('page-subtitle', 'Berikan penilaian terhadap unit layanan di kampus')
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
                    Sudah Dinilai <span class="badge bg-success ms-1">2</span>
                </button>
            </li>
        </ul>
        <div class="tab-content pt-3" id="assessmentTabContent">
            <!-- Pending Assessment Tab -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                <div class="list-group list-group-flush">
                    @foreach($units as $unit)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="me-3"><i class="bi bi-journal-album fs-2 text-primary"></i></div>
                                <div>
                                    <h6 class="mb-0">{{$unit->name}}</h6>
                                    <small class="text-muted">{{ $unit->penanggungJawab->name ?? 'Belum ditentukan' }}</small>
                                </div>
                            </div>
                            <a href="{{ route('penilaian.form', ['tipe' => 'unit', 'id' => $unit->id]) }}" class="btn btn-primary btn-sm">
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
