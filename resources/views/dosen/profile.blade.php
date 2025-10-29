@extends('layouts.app')

@section('title', 'Profil Saya')

@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Lihat dan perbarui informasi pribadi Anda')
@section('user-name', 'Dr. Budi Hartono, M.Kom.')
@section('user-role', 'Dosen - Teknik Informatika')
@section('user-initial', 'BH')

@section('sidebar-menu')
    <a class="nav-link" href="/dosen"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link active" href="/dosen/profile"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="/dosen/kpi"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="/dosen/kelas"><i class="bi bi-pencil-square"></i> Kelas</a>
    <a class="nav-link" href="/dosen/penilaian_mahasiswa"><i class="bi bi-people"></i> Penilaian Mahasiswa</a>
    <a class="nav-link" href="/dosen/penilaian_fasilitas"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="/dosen/penilaian_unit"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="/dosen/laporan"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kinerja</a>
    <a class="nav-link" href="/dosen/feedback"><i class="bi bi-chat-left-text"></i> Feedback</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-header"><i class="bi bi-pencil-square"></i> Edit Informasi Profil</div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="Dr. Budi Hartono, M.Kom.">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIDN</label>
                            <input type="text" class="form-control" value="0712345601" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="budi.hartono@example.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jabatan Fungsional</label>
                            <input type="text" class="form-control" value="Lektor Kepala" readonly>
                        </div>
                        <div class="col-12 mt-3">
                             <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-custom mt-4">
            <div class="card-header"><i class="bi bi-key-fill"></i> Ubah Password</div>
            <div class="card-body">
                <form>
                     <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="password" class="form-control">
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control">
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-shield-lock"></i> Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
