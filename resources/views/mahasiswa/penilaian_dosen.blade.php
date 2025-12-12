@extends('layouts.app')

@section('title', 'Penilaian Dosen')

@section('page-title', 'Penilaian Dosen')
@section('page-subtitle', 'Berikan penilaian terhadap kinerja dosen semester ini')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-12">
        <div class="card card-custom shadow-sm border-0">
            <div class="card-body p-0 p-md-3">
                {{-- Tabs Navigation --}}
                <ul class="nav nav-tabs nav-fill" id="assessmentTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active py-3 fw-bold" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                            Belum Dinilai <span class="badge bg-danger ms-1 rounded-pill">{{ count($dosenBelum) }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-3 fw-bold" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                            Sudah Dinilai <span class="badge bg-success ms-1 rounded-pill">{{ count($dosenSudah) }}</span>
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="assessmentTabContent">
                    
                    <div class="tab-pane fade show active" id="pending" role="tabpanel">
                        <div class="list-group list-group-flush">
                            @forelse ($dosenBelum as $d)
                                <div class="list-group-item p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold">{{ $d->user->name }}</h6>
                                            <small class="text-muted">Pengampu Mata Kuliah</small>
                                        </div>
                                        <a href="{{ route('penilaian.form', ['tipe' => 'dosen', 'id' => $d->id]) }}" class="btn btn-primary btn-sm rounded-pill">
                                            Beri Penilaian
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="bi bi-check-circle-fill text-success display-1 opacity-50"></i>
                                    <h5 class="fw-bold">Semua Selesai!</h5>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="tab-pane fade" id="completed" role="tabpanel">
                        <div class="list-group list-group-flush">
                            @foreach ($dosenSudah as $d)
                                <div class="list-group-item p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold">{{ $d->user->name }}</h6>
                                            <small class="text-muted">Sudah dinilai</small>
                                        </div>

                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            ✔️ Dinilai
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection