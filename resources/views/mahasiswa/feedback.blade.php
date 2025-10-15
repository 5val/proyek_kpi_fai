@extends('layouts.app')

@section('title', 'Feedback & Laporan')

@section('page-title', 'Feedback & Laporan')
@section('page-subtitle', 'Kirimkan masukan atau laporkan masalah kepada pihak kampus')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-star"></i> Penilaian Dosen</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link active" href="#"><i class="bi bi-chat-left-text"></i> Feedback</a>
    <a class="nav-link" href="#"><i class="bi bi-bar-chart"></i> Laporan KPI</a>
@endsection

@section('content')
<div class="row">
    <!-- Submit Feedback Form -->
    <div class="col-md-6">
        <div class="card-custom">
            <div class="card-header">
                <i class="bi bi-send"></i> Kirim Feedback Baru
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="feedbackCategory" class="form-label">Kategori Tujuan</label>
                        <select class="form-select" id="feedbackCategory">
                            <option selected>Pilih kategori...</option>
                            <option value="1">Umum</option>
                            <option value="2">Fasilitas</option>
                            <option value="3">Unit Layanan (BAA, BAK, dll)</option>
                            <option value="4">Akademik/Dosen</option>
                        </select>
                    </div>
                     <div class="mb-3">
                        <label for="feedbackSubject" class="form-label">Subjek</label>
                        <input type="text" class="form-control" id="feedbackSubject" placeholder="Contoh: AC di Ruang Kelas R.301 tidak dingin">
                    </div>
                    <div class="mb-3">
                        <label for="feedbackMessage" class="form-label">Isi Pesan</label>
                        <textarea class="form-control" id="feedbackMessage" rows="5" placeholder="Jelaskan masukan atau laporan Anda secara detail di sini..."></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="anonymousCheck">
                        <label class="form-check-label" for="anonymousCheck">
                            Kirim sebagai anonim
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-custom w-100"><i class="bi bi-send-fill"></i> Kirim</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Feedback History -->
    <div class="col-md-6">
        <div class="card-custom">
             <div class="card-header">
                <i class="bi bi-clock-history"></i> Riwayat Feedback Saya
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Keran air di toilet lantai 2 rusak</h6>
                            <small class="text-muted">3 hari lalu</small>
                        </div>
                        <p class="mb-1">Kategori: Fasilitas</p>
                        <span class="badge bg-success">Sudah Ditanggapi</span>
                    </div>
                     <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Saran untuk koleksi buku di perpustakaan</h6>
                            <small class="text-muted">1 minggu lalu</small>
                        </div>
                        <p class="mb-1">Kategori: Umum</p>
                        <span class="badge bg-warning text-dark">Sedang Diproses</span>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Jadwal Ujian bentrok</h6>
                            <small class="text-muted">2 minggu lalu</small>
                        </div>
                        <p class="mb-1">Kategori: Akademik/Dosen</p>
                        <span class="badge bg-secondary">Terkirim</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

