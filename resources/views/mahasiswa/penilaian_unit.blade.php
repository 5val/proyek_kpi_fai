@extends('layouts.app')

@section('title', 'Penilaian Unit Layanan')

@section('page-title', 'Penilaian Unit Layanan')
@section('page-subtitle', 'Berikan penilaian terhadap unit layanan di kampus')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-12">
        <div class="card card-custom shadow-sm border-0">
            <div class="card-body p-0 p-md-3">
                
                {{-- Tabs Navigation --}}

                <div class="tab-content" id="assessmentTabContent">
                    
                    <div class="tab-pane fade show active" id="pending" role="tabpanel">
                        <div class="list-group list-group-flush">
                            @forelse($units as $unit)
                                <div class="list-group-item p-3 border-bottom-0">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                                        {{-- Info Unit --}}
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-building-check fs-3"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">{{ $unit->name }}</h6>
                                                <div class="text-muted small">
                                                    <i class="bi bi-person-badge me-1"></i> 
                                                    {{ $unit->penanggungJawab->name ?? 'PJ belum ditentukan' }}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- Tombol Aksi (Full width di mobile) --}}
                                        <a href="{{ route('penilaian.form', ['tipe' => 'unit', 'id' => $unit->id]) }}" class="btn btn-primary btn-sm shadow-sm px-4 py-2 rounded-pill d-flex align-items-center justify-content-center">
                                            <i class="bi bi-pencil-square me-2"></i> Beri Penilaian
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="bi bi-check-circle text-success display-1 mb-3 opacity-50"></i>
                                    <h5 class="fw-bold">Semua Unit Telah Dinilai!</h5>
                                    <p class="text-muted">Terima kasih atas partisipasi Anda.</p>
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
                                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="bi bi-heart-pulse-fill fs-3"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">Unit Kesehatan Mahasiswa</h6>
                                            <small class="text-muted">Layanan Kesehatan</small>
                                        </div>
                                    </div>
                                    <div class="mt-2 mt-sm-0 text-end">
                                        <span class="badge bg-warning bg-opacity-10 text-dark border border-warning rounded-pill px-3 py-2">
                                            Skor: 3.0 / 4.0
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Item 2 (Contoh Tambahan) --}}
                            <div class="list-group-item p-3 border-bottom-0 bg-light bg-opacity-25">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="bi bi-briefcase-fill fs-3"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">Biro Administrasi Akademik</h6>
                                            <small class="text-muted">Layanan Administrasi</small>
                                        </div>
                                    </div>
                                    <div class="mt-2 mt-sm-0 text-end">
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2">
                                            Skor: 3.5 / 4.0
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