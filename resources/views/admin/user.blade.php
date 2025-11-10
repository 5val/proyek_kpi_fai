@extends('layouts.app')

@section('title', 'Manajemen User')

@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Kelola semua akun pengguna sistem')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link active" href="{{ route('admin.user') }}"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="{{ route('admin.fasilitas') }}"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="{{ route('admin.unit') }}"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="{{ route('admin.periode') }}"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link" href="{{ route('admin.mata_kuliah') }}"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
    <a class="nav-link" href="{{ route('admin.kelas') }}"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
    <form action="{{ route('logout') }}" method="POST" style="float: right;">
      @csrf
      <div style="align-items: center; justify-content: center; display: flex;">
        <button class="btn btn-danger" type="submit">Logout</button>
      </div>
   </form>
@endsection

@section('content')
@if(session('success'))
   <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-people-fill"></i> Daftar Pengguna</div>
        
        <div class="d-flex align-items-center">
            <!-- Form untuk Filter Role -->
            <form action="{{ route('admin.user') }}" method="GET" class="d-flex align-items-center">
                <select class="form-select form-select-sm me-2" name="role" id="roleFilter" onchange="this.form.submit()" style="width: auto;">
                    {{-- Default ke 'mahasiswa' jika tidak ada filter --}}
                    <option value="mahasiswa" @if(request('role') == 'mahasiswa' || !request('role')) selected @endif>Tampilkan: Mahasiswa</option>
                    <option value="dosen" @if(request('role') == 'dosen') selected @endif>Tampilkan: Dosen</option>
                    <option value="admin" @if(request('role') == 'admin') selected @endif>Tampilkan: Admin</option>
                    <option value="semua" @if(request('role') == 'semua') selected @endif>Tampilkan: Semua</option>
                </select>
                <button type="submit" class="d-none">Filter</button>
            </form>
            
            <!-- Tombol Tambah Dinamis -->
            <a href="{{ route('admin.form_user') }}" id="addUserButton" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> 
                <span id="addButtonText">Tambah User</span>
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                     <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        @if ($user->role == "admin")
                           <td><span class="badge bg-danger">Admin</span></td>
                        @elseif ($user->role == "dosen")
                           <td><span class="badge bg-success">Dosen</span></td>
                        @else
                           <td><span class="badge bg-info">Mahasiswa</span></td>
                        @endif
                        <td>{{ $user->created_at }}</td>
                        <td>
                           <a href="{{ route('admin.form_user_edit', $user->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                           <a href="{{ route('admin.user.delete', $user->id) }}" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
                        </td>
                     </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleFilter = document.getElementById('roleFilter');
        const addButton = document.getElementById('addUserButton');
        const addButtonText = document.getElementById('addButtonText');
        
        // Fungsi untuk memperbarui tombol berdasarkan nilai select
        function updateButton(role) {
            let newText = "Tambah Pengguna";
            // Asumsi route 'admin.user.create' adalah route untuk form,
            // dan kita parsing query 'role'
            
            if (role === 'dosen') {
                newText = "Tambah Dosen";
            } else if (role === 'mahasiswa') {
                newText = "Tambah Mahasiswa";
            } else if (role === 'admin') {
                newText = "Tambah Admin";
            }
            
            addButtonText.textContent = newText;
            addButton.href = newUrl;
        }
        
        // 1. Atur status tombol saat halaman pertama kali dimuat
        updateButton(roleFilter.value);
        
        // 2. Atur status tombol saat filter diubah (sebelum form di-submit)
        roleFilter.addEventListener('change', function() {
            updateButton(this.value);
            // Form akan di-submit secara otomatis oleh atribut onchange="this.form.submit()"
        });
    });
</script> -->
@endpush

