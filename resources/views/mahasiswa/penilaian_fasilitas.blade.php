@extends('layouts.app')

@section('title', 'Penilaian Fasilitas')

@section('page-title', 'Penilaian Fasilitas Kampus')
@section('page-subtitle', 'Berikan penilaian untuk meningkatkan kualitas fasilitas')
@section('user-name', '')
@section('user-role', '')
@section('user-initial', '')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-12">
        <div class="card card-custom shadow-sm border-0">
            <div class="card-body p-0 p-md-3">
                
                <div class="tab-content" id="assessmentTabContent">
                    
                    <div class="tab-pane fade show active" id="pending" role="tabpanel">
                        <div class="list-group list-group-flush">
                            @forelse($fasilitas as $f)
                                <div class="list-group-item p-3 border-bottom-0">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                                        {{-- Info Fasilitas --}}
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-pc-display-horizontal fs-3"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">{{ $f->name }}</h6>
                                                <small class="text-muted d-block">
                                                    <i class="bi bi-geo-alt-fill me-1"></i> {{ $f->lokasi ?? 'Lokasi Umum' }}
                                                </small>
                                            </div>
                                        </div>
                                        
                                        {{-- Tombol Aksi (Full width di mobile) --}}
                                        <a href="{{ route('penilaian.form', ['tipe' => 'fasilitas', 'id' => $f->id]) }}" class="btn btn-primary btn-sm shadow-sm px-4 py-2 rounded-pill d-flex align-items-center justify-content-center">
                                            <i class="bi bi-pencil-square me-2"></i> Beri Penilaian
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="bi bi-building-check text-success display-1 mb-3 opacity-50"></i>
                                    <h5 class="fw-bold">Semua Fasilitas Dinilai!</h5>
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
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="bi bi-wifi fs-3"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">Jaringan WiFi Kampus</h6>
                                            <small class="text-muted">Infrastruktur IT</small>
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
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="bi bi-book-half fs-3"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">Perpustakaan Pusat</h6>
                                            <small class="text-muted">Layanan Umum</small>
                                        </div>
                                    </div>
                                    <div class="mt-2 mt-sm-0 text-end">
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2">
                                            Skor: 4.0 / 4.0
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