@extends('layouts.app')

@section('title', 'Manajemen User')

@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Kelola semua akun pengguna sistem')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')

@if(session('success'))
   <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
       <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card card-custom shadow-sm border-0">
            {{-- Header Card: Stack vertikal di mobile, horizontal di desktop --}}
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                
                {{-- Judul --}}
                <div class="fw-bold fs-5">
                    <i class="bi bi-people-fill me-1"></i> Daftar Pengguna
                </div>
                
                {{-- Area Filter & Tombol --}}
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <form action="{{ route('admin.user') }}" method="GET" class="d-flex align-items-center">
                        <select class="form-select form-select-sm border-secondary-subtle" name="role" id="roleFilter" onchange="this.form.submit()">
                            <option value={{ null }} @if (!request('role')) selected @endif>Semua Role</option>
                            <option value="mahasiswa" @if(request('role') == 'mahasiswa') selected @endif>Mahasiswa</option>
                            <option value="dosen" @if(request('role') == 'dosen') selected @endif>Dosen</option>
                            <option value="admin" @if(request('role') == 'admin') selected @endif>Admin</option>
                        </select>
                    </form>
                    
                    {{-- Di mobile tombol akan full width agar mudah dipencet --}}
                    <a href="{{ route('admin.form_user') }}" id="addUserButton" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center text-nowrap">
                        <i class="bi bi-plus-circle me-2"></i> 
                        <span id="addButtonText">Tambah User</span>
                    </a>
                </div>
            </div>

            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap membuat tabel rapi memanjang ke samping di HP --}}
                    <table class="table table-hover align-middle data-table w-100 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th class="text-center">Role</th>
                                <th>Tanggal Dibuat</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @forelse ($users as $user)
                             <tr>
                                <td>
                                    <div class="fw-bold">{{ $user->name }}</div>
                                    @if($user->is_active == 0)
                                        <small class="text-danger fst-italic"><i class="bi bi-slash-circle"></i> Tidak Aktif</small>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    @if ($user->role == "admin")
                                       <span class="badge bg-danger rounded-pill px-3">Admin</span>
                                    @elseif ($user->role == "dosen")
                                       <span class="badge bg-success rounded-pill px-3">Dosen</span>
                                    @else
                                       <span class="badge bg-info text-dark rounded-pill px-3">Mahasiswa</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm" role="group">
                                        <a href="{{ route('admin.form_user_edit', $user->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        @if ($user->is_active == 0)
                                            <a href="{{ route('admin.user.delete', $user->id) }}" class="btn btn-success btn-sm" title="Aktifkan" onclick="return confirm('Aktifkan user ini?')">
                                                <i class="bi bi-check-circle"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.user.delete', $user->id) }}" class="btn btn-danger btn-sm" title="Non-aktifkan" onclick="return confirm('Non-aktifkan user ini?')">
                                                <i class="bi bi-x-circle"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                             </tr>
                          @empty
                             <tr>
                                 <td colspan="5" class="text-center py-5 text-muted">
                                     <i class="bi bi-person-x fs-1 d-block mb-2 opacity-50"></i>
                                     Tidak ada data user ditemukan.
                                 </td>
                             </tr>
                          @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection