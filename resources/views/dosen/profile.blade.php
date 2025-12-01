@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Lihat dan perbarui informasi pribadi Anda')

@section('user-name', $user->name)
@section('user-role', $user->role)

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
                        <form action="{{ route('mahasiswa.uploadProfpic', Auth::id()) }}" method="POST" enctype="multipart/form-data">
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
@endsection
