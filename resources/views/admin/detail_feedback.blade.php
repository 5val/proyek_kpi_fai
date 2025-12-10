@extends('layouts.app')

@section('title', 'Detail Feedback')

@section('page-title', 'Detail Feedback')
@section('page-subtitle', 'Rincian lengkap masukan dari pengguna')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <div class="card card-custom shadow-sm border-0">
            {{-- Header: flex-wrap agar aman di layar kecil --}}
            <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center fw-bold fs-5">
                    <i class="bi bi-file-text-fill me-2"></i> 
                    <span class="text-truncate" style="max-width: 250px;">Rincian Feedback #{{ $feedback->id }}</span>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm px-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card-body p-4">
                {{-- Menggunakan g-3 (gap) agar jarak vertikal rapi saat stack di mobile --}}
                <div class="row g-4 mb-4 border-bottom pb-4">
                    
                    {{-- Kolom Kiri: Info Pengirim --}}
                    <div class="col-12 col-md-6">
                        <h6 class="text-muted text-uppercase small fw-bold mb-2">Pengirim</h6>
                        <div class="d-flex align-items-center bg-light p-3 rounded">
                            <div class="me-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-person-fill fs-4"></i>
                                </div>
                            </div>
                            <div>
                                @if ($feedback->is_anonymous == 1)
                                    <h5 class="mb-0 fw-bold text-dark">Anonim</h5>
                                    <small class="text-muted">Identitas disembunyikan</small>
                                @else
                                    <h5 class="mb-0 fw-bold text-dark">{{ $feedback->pengirim->name }}</h5>
                                    @if ($feedback->pengirim->role == 'mahasiswa')
                                        <small class="text-muted d-block lh-sm">
                                            {{ $feedback->pengirim->mahasiswa->program_studi->name ?? 'Mahasiswa' }}
                                        </small>
                                    @elseif ($feedback->pengirim->role == 'dosen')
                                        <small class="text-muted">Dosen Pengajar</small>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Meta Data (Tanggal & Status) --}}
                    <div class="col-12 col-md-6">
                         <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar3 text-muted me-2"></i>
                                <span class="fw-bold">{{ $feedback->created_at->format('d M Y') }}</span>
                                <span class="mx-2 text-muted">•</span>
                                <span class="text-muted">{{ $feedback->created_at->format('H:i') }} WIB</span>
                            </div>
                            
                            <div>
                                @if($feedback->status == 1) 
                                    <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> Sudah Ditanggapi</span> 
                                @else 
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split me-1"></i> Belum Ditanggapi</span>
                                @endif 
                            </div>
                         </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h6 class="text-muted text-uppercase small fw-bold mb-2">Isi Feedback</h6>
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <div class="mb-3">
                                <span class="badge bg-info text-dark mb-2">{{ $feedback->kategori->name }}</span>
                                <h4 class="fw-bold text-dark mb-0">{{ $feedback->target_user->name ?? $feedback->target->name ?? "{$feedback->target_user->mata_kuliah->name} - {$feedback->target_user->program_studi->name}" }}</h4>
                            </div>
                            <hr class="text-muted opacity-25">
                            {{-- text-break penting agar link panjang/kata panjang tidak merusak layout HP --}}
                            <p class="mb-0 fs-6 text-dark text-break" style="line-height: 1.6;">
                                {{ $feedback->isi }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted text-uppercase small fw-bold mb-2">Lampiran Bukti</h6>
                    
                    @if($feedback->foto)
                        <div class="card overflow-hidden border">
                            {{-- w-100 memastikan gambar full width di mobile, tapi tingginya dibatasi agar tidak terlalu panjang --}}
                            <div class="text-center bg-light">
                                <img src="{{ Storage::url($feedback->foto) }}" class="img-fluid" alt="Bukti Foto" style="max-height: 500px; width: auto; object-fit: contain;">
                            </div>
                            <div class="card-footer bg-white border-top text-center py-2">
                                <a href="{{ Storage::url($feedback->foto) }}" class="btn btn-sm btn-outline-primary w-100 w-md-auto" target="_blank">
                                    <i class="bi bi-arrows-fullscreen me-1"></i> Lihat Ukuran Penuh
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-light border d-flex align-items-center text-muted" role="alert">
                            <i class="bi bi-image-alt me-3 fs-3 opacity-50"></i>
                            <div>
                                <strong>Tidak ada lampiran.</strong><br>
                                <small>Pengirim tidak menyertakan bukti foto.</small>
                            </div>
                        </div>
                    @endif
                </div>

                <hr class="my-4">

                {{-- Flex column di mobile (tombol full width), Row di tablet ke atas --}}
                <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                    @if($feedback->status != 1)
                        <a href="{{ route('admin.feedback.update', $feedback->id) }}" class="btn btn-success py-2 px-4 shadow-sm">
                            <i class="bi bi-check-circle-fill me-2"></i> Tandai Sudah Ditanggapi
                        </a>
                    @else
                        <a href="{{ route('admin.feedback.update', $feedback->id) }}" class="btn btn-warning text-dark py-2 px-4 shadow-sm">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Tandai Belum Ditanggapi
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection