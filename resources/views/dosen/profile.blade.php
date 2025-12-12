{{-- @extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Lihat dan perbarui informasi pribadi Anda')


@section('content')
@if(session('success'))
   <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
   <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="row">
    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-header"><i class="bi bi-pencil-square"></i> Edit Informasi Profil</div>
            <div class="card-body">
                <form action="{{ route('dosen.updateProfile') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                                    <img src="{{ $dosen->user->photo_profile ? Storage::url($dosen->user->photo_profile) : asset('images/default-user.png') }}"
                 class="rounded-circle mb-3" width="150" alt="Profile Picture" height="150">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ $user->name }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIDN</label>
                            <input type="text" name="nidn" class="form-control" 
                                   value="{{ $dosen->nidn }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" 
                                   value="{{ $user->email }}">
                                                       @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="phone" class="form-control" 
                                   value="{{ $user->phone_number }}">
                                                       @error('phone')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                        </div>
                        <form action="{{ route('dosen.uploadProfpic', Auth::id()) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label fw-medium">Pilih Foto (JPG/PNG - Max 5MB)</label>
                    <input type="file" name="file" id="file" class="form-control">
                </div>
                <button class="btn btn-sm btn-outline-primary" type="submit" style="width: 700px;margin:0 auto">
                    <i class="bi bi-upload"></i> Ubah Foto Profil
                </button>
            </form>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-custom mt-4">
            <div class="card-header"><i class="bi bi-key-fill"></i> Ubah Password</div>
            <div class="card-body">
            <form action="{{ route('dosen.changePassword') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-shield-lock"></i> Ubah Password
                </button>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('title', 'Profil Saya')

@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun dan password Anda')

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
            <img src="{{ $dosen->user->photo_profile ? Storage::url($dosen->user->photo_profile) : asset('images/default-user.png') }}"
                 class="rounded-circle mb-3" width="150" alt="Profile Picture" height="150">
            <h4 class="mb-1">{{ $user->name }}</h4>
            <p class="text-muted mb-1">NIDN: {{ $dosen->nidn }}</p>
            <form action="{{ route('dosen.uploadProfpic', Auth::id()) }}" method="POST" enctype="multipart/form-data">
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
                        <form action="{{ route('dosen.updateProfile') }}" method="POST">
                    @csrf
                    @method('PUT')
                            <div class="mb-3">
                                <label for="Nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nidn" class="form-label">NIDN</label>
                                <input type="text" class="form-control" id="nidn" value="{{ $dosen->nidn }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone_number }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-custom"><i class="bi bi-save"></i> Simpan Perubahan</button>
                        </form>
                    </div>
                    <!-- Change Password Tab -->
                    <div class="tab-pane fade p-3" id="password" role="tabpanel">
                        <form action="{{ route('dosen.changePassword') }}" method="POST">
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
