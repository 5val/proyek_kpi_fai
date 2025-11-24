@extends('layouts.app')

@section('title', 'Detail Feedback')

@section('page-title', 'Detail Feedback')
@section('page-subtitle', 'Rincian lengkap masukan dari pengguna')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="{{ route('admin.user') }}"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="{{ route('admin.fasilitas') }}"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="{{ route('admin.unit') }}"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="{{ route('admin.periode') }}"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link" href="{{ route('admin.mata_kuliah') }}"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
    <a class="nav-link" href="{{ route('admin.kelas') }}"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link active" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
    <form action="{{ route('logout') }}" method="POST" style="float: right;">
      @csrf
      <div style="align-items: center; justify-content: center; display: flex;">
        <button class="btn btn-danger" type="submit">Logout</button>
      </div>
   </form>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card-custom">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-file-text-fill"></i> Rincian Feedback #{{ $feedback->id }}
                </div>
                <a href="{{ route('admin.feedback') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body p-3">
                <!-- Informasi Pengirim & Meta Data -->
                <div class="row mb-4 border-bottom pb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Pengirim</h6>
                            <div class="d-flex align-items-center">
                                <div>
                                    @if ($feedback->is_anonymous == 1)
                                       <h5 class="mb-0 fw-bold">Anonim</h5>
                                    @else
                                       @if ($feedback->pengirim->role == 'mahasiswa')
                                          <h5 class="mb-0 fw-bold">{{ $feedback->pengirim->name }}</h5>
                                          <small class="text-muted">Mahasiswa - {{ $feedback->pengirim->mahasiswa->program_studi->name }}</small>
                                       @elseif ($feedback->pengirim->role == 'dosen')
                                          <h5 class="mb-0 fw-bold">{{ $feedback->pengirim->name }}</h5>
                                          <small class="text-muted">Dosen</small>
                                       @endif
                                    @endif
                                </div>
                            </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <div class="mb-2">
                            <span class="text-muted small">Tanggal:</span>
                            <span class="fw-bold text-dark ms-2">{{ $feedback->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-muted small">Status:</span>
                              @if($feedback->status == 1) 
                                <span class="badge bg-success ms-2">Sudah Ditanggapi</span> 
                              @else 
                                <span class="badge bg-warning text-dark ms-2">Belum Ditanggapi</span>
                              @endif 
                        </div>
                    </div>
                </div>

                <!-- Konten Utama Feedback -->
                <div class="mb-4">
                    <h6 class="text-muted text-uppercase small fw-bold mb-2">Feedback</h6>
                    <div class="mb-3">
                        <span class="badge bg-info text-dark fs-6 mb-2">{{ $feedback->kategori->name }}</span>
                    </div>
                    
                    <div class="p-3 bg-light rounded border text-dark">
                        <p class="mb-0">
                            {{ $feedback->isi }}
                        </p>
                    </div>
                </div>

                <!-- Bukti Foto -->
                <div class="mb-4">
                    <h6 class="text-muted text-uppercase small fw-bold mb-2">Lampiran Bukti</h6>
                    
                     @if($feedback->foto)
                        <!-- Jika ada foto -->
                        <div class="card d-inline-block">
                            <img src="{{ Storage::url($feedback->foto) }}" class="img-fluid rounded" alt="Bukti Foto" style="max-height: 400px; object-fit: contain;">
                            <div class="card-footer bg-transparent border-0 text-center">
                                <a href="#" class="btn btn-sm btn-outline-primary" target="_blank"><i class="bi bi-zoom-in"></i> Lihat Ukuran Penuh</a>
                            </div>
                        </div>
                    @else
                        <!-- Jika foto null -->
                        <div class="alert alert-secondary d-flex align-items-center" role="alert">
                            <i class="bi bi-image-alt me-2 fs-4"></i>
                            <div>Tidak ada bukti foto yang dilampirkan.</div>
                        </div>
                    @endif
                </div>

                <hr>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2">
                    @if($feedback->status != 'sudah_ditanggapi')
                        <a href="{{ route('admin.feedback.update', $feedback->id) }}" class="btn btn-success"><i class="bi bi-check-circle-fill"></i> Tandai Sudah Ditanggapi</a>
                    @else
                        <a href="{{ route('admin.feedback.update', $feedback->id) }}" class="btn btn-warning text-dark"><i class="bi bi-arrow-counterclockwise"></i> Tandai Belum Ditanggapi</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection