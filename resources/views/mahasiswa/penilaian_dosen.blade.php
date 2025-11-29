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
                            Belum Dinilai <span class="badge bg-danger ms-1 rounded-pill">{{ count($dosenList) }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-3 fw-bold" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                            Sudah Dinilai <span class="badge bg-success ms-1 rounded-pill">5</span>
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="assessmentTabContent">
                    
                    <div class="tab-pane fade show active" id="pending" role="tabpanel">
                        <div class="list-group list-group-flush">
                            @forelse ($dosenList as $d)
                                <div class="list-group-item p-3 border-bottom-0">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                                        {{-- Info Dosen --}}
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-person-fill fs-3"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">{{ $d->name }}</h6>
                                                <small class="text-muted d-block">
                                                    <i class="bi bi-book me-1"></i> Pengampu Mata Kuliah
                                                </small>
                                            </div>
                                        </div>
                                        
                                        {{-- Tombol Aksi (Full width di mobile) --}}
                                        <a href="{{ route('penilaian.form', ['tipe' => 'dosen', 'id' => $d->id]) }}" class="btn btn-primary btn-sm shadow-sm px-4 py-2 rounded-pill d-flex align-items-center justify-content-center">
                                            <i class="bi bi-pencil-square me-2"></i> Beri Penilaian
                                        </a>
                                    </div>
                                </div> 
                            @empty
                                <div class="text-center py-5">
                                    <i class="bi bi-check-circle-fill text-success display-1 mb-3 opacity-50"></i>
                                    <h5 class="fw-bold">Semua Selesai!</h5>
                                    <p class="text-muted">Anda telah menilai semua dosen untuk semester ini.</p>
                                </div>
                            @endforelse   
                        </div>
                    </div>

                    <div class="tab-pane fade" id="completed" role="tabpanel">
                        <div class="list-group list-group-flush">
                            {{-- Item 1 --}}
                            <div class="list-group-item p-3 border-bottom-0">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="bi bi-check-lg fs-3"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">Dr. Agus Setiawan, M.Sc.</h6>
                                            <small class="text-muted">Dinilai pada 20 Nov 2024</small>
                                        </div>
                                    </div>
                                    <div class="mt-2 mt-sm-0 text-end">
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2">
                                            Skor: 3.5 / 4.0
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Item 2 --}}
                            <div class="list-group-item p-3 border-bottom-0 bg-light bg-opacity-25">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="bi bi-check-lg fs-3"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">Lina Marlina, S.Kom., M.Kom.</h6>
                                            <small class="text-muted">Dinilai pada 18 Nov 2024</small>
                                        </div>
                                    </div>
                                    <div class="mt-2 mt-sm-0 text-end">
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-2">
                                            Skor: 3.8 / 4.0
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection