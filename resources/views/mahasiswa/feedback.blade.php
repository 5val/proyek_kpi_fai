@extends('layouts.app')

@section('title', 'Feedback')

@section('page-title', 'Feedback')
@section('page-subtitle', 'Kirim feedback atau keluhan Anda')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="row">
    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-header"><i class="bi bi-chat-left-text-fill"></i> Kirim Feedback atau Laporan</div>
            <div class="card-body">
                <form action="{{ route('mahasiswa.insertFeedback') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="subjek" class="form-label">Subjek</label>
                        <input type="text" class="form-control" id="subjek" name="subjek" placeholder="Contoh: AC di Ruang R.301 tidak dingin">
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori">
                            <option selected>Pilih kategori feedback...</option>
                            @foreach($kategori as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi / Isi Feedback</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="6" placeholder="Tuliskan rincian feedback, laporan, atau keluhan Anda di sini..."></textarea>
                    </div>

                    <!-- Input Foto Bukti -->
                    <div class="mb-3">
                        <label for="bukti" class="form-label">Lampiran Bukti (Foto)</label>
                        <input class="form-control" type="file" id="bukti" name="file" accept="image/*">
                        <small class="text-muted">Opsional. Unggah foto sebagai bukti jika diperlukan.</small>
                    </div>
                    <!-- Selesai Input Foto Bukti -->

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="anonim" name="anonim" value="1">
                        <label class="form-check-label" for="anonim">
                            Kirim sebagai anonim
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-send-fill"></i> Kirim Feedback</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card-custom">
            <div class="card-header"><i class="bi bi-clock-history"></i> Riwayat Feedback Saya</div>
            <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">AC di R.301 tidak dingin</h6>
                            <small>3 hari lalu</small>
                        </div>
                        <p class="mb-1 small">Kategori: Fasilitas</p>
                        <span class="badge bg-success">Sudah Ditanggapi</span>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Antrian layanan BAA lama</h6>
                            <small>1 minggu lalu</small>
                        </div>
                        <p class="mb-1 small">Kategori: Layanan Unit</p>
                        <span class="badge bg-warning text-dark">Belum Ditanggapi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

