@extends('layouts.app')

@section('title', 'Feedback Dosen')

@section('page-title', 'Feedback')
@section('page-subtitle', 'Kirim feedback atau keluhan Anda')
@section('user-name', 'Dr. Citra Lestari')
@section('user-role', 'Dosen - Teknik Informatika')
@section('user-initial', 'CL')

@section('sidebar-menu')
    <a class="nav-link" href="/dosen"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="/dosen/profile"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="/dosen/kpi"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="/dosen/kelas"><i class="bi bi-pencil-square"></i> Kelas</a>
    <a class="nav-link" href="/dosen/penilaian_mahasiswa"><i class="bi bi-people"></i> Penilaian Mahasiswa</a>
    <a class="nav-link" href="/dosen/penilaian_fasilitas"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="/dosen/penilaian_unit"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="/dosen/laporan"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kinerja</a>
    <a class="nav-link active" href="/dosen/feedback"><i class="bi bi-chat-left-text"></i> Feedback</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-header"><i class="bi bi-chat-left-text-fill"></i> Kirim Feedback atau Laporan</div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="subjek" class="form-label">Subjek</label>
                        <input type="text" class="form-control" id="subjek" placeholder="Contoh: Proyektor di Ruang Dosen sering bermasalah">
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori">
                            <option selected>Pilih kategori feedback...</option>
                            <option value="fasilitas_dosen">Fasilitas Dosen</option>
                            <option value="layanan_sdm">Layanan SDM (HR)</option>
                            <option value_laporan="layanan_keuangan">Layanan Keuangan (BAU)</option>
                            <option value="akademik">Akademik</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi / Isi Feedback</label>
                        <textarea class="form-control" id="deskripsi" rows="6" placeholder="Tuliskan rincian feedback, laporan, atau keluhan Anda di sini..."></textarea>
                    </div>

                    <!-- Input Foto Bukti -->
                    <div class="mb-3">
                        <label for="bukti" class="form-label">Lampiran Bukti (Foto)</label>
                        <input class="form-control" type="file" id="bukti" accept="image/*">
                        <small class="text-muted">Opsional. Unggah foto sebagai bukti jika diperlukan.</small>
                    </div>
                    <!-- Selesai Input Foto Bukti -->

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="anonim">
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
                            <h6 class="mb-1">Proyektor di Ruang Dosen</h6>
                            <small>5 hari lalu</small>
                        </div>
                        <p class="mb-1 small">Kategori: Fasilitas Dosen</p>
                        <span class="badge bg-warning text-dark">Belum Ditanggapi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection