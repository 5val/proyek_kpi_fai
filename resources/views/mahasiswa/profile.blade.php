@extends('layouts.app')

@section('title', 'Profil Saya')

@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun dan password Anda')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link active" href="#"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-star"></i> Penilaian Dosen</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text"></i> Feedback</a>
    <a class="nav-link" href="#"><i class="bi bi-bar-chart"></i> Laporan KPI</a>
@endsection

@section('content')
<div class="row">
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card-custom">
            <div class="card-body text-center">
                <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 3rem; color: white; font-weight: bold;">
                    AP
                </div>
                <h4 class="mb-1">Andi Pratama</h4>
                <p class="text-muted mb-1">NIM: 2021010001</p>
                <p class="text-muted">Teknik Informatika</p>
                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-upload"></i> Ubah Foto Profil</button>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-header">
                <i class="bi bi-pencil-square"></i> Edit Informasi Akun
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="profileTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">Informasi Akun</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">Ganti Password</button>
                    </li>
                </ul>
                <div class="tab-content pt-3" id="profileTabContent">
                    <!-- Account Info Tab -->
                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                        <form>
                            <div class="mb-3">
                                <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="namaLengkap" value="Andi Pratama">
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" value="2021010001" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control" id="email" value="andi.pratama@example.com">
                            </div>
                             <div class="mb-3">
                                <label for="prodi" class="form-label">Program Studi</label>
                                <input type="text" class="form-control" id="prodi" value="Teknik Informatika" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary btn-custom"><i class="bi bi-save"></i> Simpan Perubahan</button>
                        </form>
                    </div>
                    <!-- Change Password Tab -->
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <form>
                            <div class="mb-3">
                                <label for="oldPassword" class="form-label">Password Lama</label>
                                <input type="password" class="form-control" id="oldPassword">
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="newPassword">
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="confirmPassword">
                            </div>
                            <button type="submit" class="btn btn-primary btn-custom"><i class="bi bi-key"></i> Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
