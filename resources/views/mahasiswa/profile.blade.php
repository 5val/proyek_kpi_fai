@extends('layouts.app')

@section('title', 'Profil Saya')

@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun dan password Anda')
@section('user-name', ucfirst($mahasiswa->user->name))
@section('user-role', 'Mahasiswa - '. ucfirst($mahasiswa->program_studi->name))
@section('user-initial', '')

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
    <!-- Profile Card -->
    <div class="card-custom">
        <div class="card-body text-center">
            <img src="{{ $mahasiswa->user->photo_profile ? Storage::url($mahasiswa->user->photo_profile) : asset('images/default-user.png') }}"
                 class="rounded-circle mb-3" width="150" alt="Profile Picture" height="150">
            <h4 class="mb-1">{{ $mahasiswa->user->name }}</h4>
            <p class="text-muted mb-1">NIM: {{ $mahasiswa->nrp }}</p>
            <p class="text-muted">
                Jurusan: {{ $mahasiswa->program_studi->name ?? '-' }}
            </p>
            <form action="{{ route('mahasiswa.uploadProfpic', Auth::id()) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label fw-medium">Pilih Foto (JPG/PNG - Max 5MB)</label>
                    <input type="file" name="file" id="file" required class="form-control">
                </div>
                <button class="btn btn-sm btn-outline-primary" type="submit">
                    <i class="bi bi-upload"></i> Ubah Foto Profil
                </button>
            </form>
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
                    <div class="tab-pane fade show active p-3" id="info" role="tabpanel">
                        <form>
                            <div class="mb-3">
                                <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="namaLengkap" value="{{ $mahasiswa->user->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" value="{{ $mahasiswa->nrp }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control" id="email" value="{{ $mahasiswa->user->email }}">
                            </div>
                             <div class="mb-3">
                                <label for="prodi" class="form-label">Program Studi</label>
                                <input type="text" class="form-control" id="prodi" value="{{ $mahasiswa->program_studi->name }}" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary btn-custom"><i class="bi bi-save"></i> Simpan Perubahan</button>
                        </form>
                    </div>
                    <!-- Change Password Tab -->
                    <div class="tab-pane fade p-3" id="password" role="tabpanel">
                         <form action="{{ route('mahasiswa.changePassword') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                            <label class="form-label">Password Lama</label>
                            <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Password Baru</label>
                                <input type="password" name="new_password" class="form-control" id="newPassword" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="new_password_confirmation" class="form-control" id="confirmPassword" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-custom">
                                <i class="bi bi-key"></i> Ubah Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
