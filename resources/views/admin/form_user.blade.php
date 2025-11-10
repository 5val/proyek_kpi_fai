@extends('layouts.app')

@section('title', 'Formulir Pengguna')

@section('page-title', 'Formulir Pengguna')
@section('page-subtitle', 'Tambah atau edit data pengguna sistem')
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
<div class="card-custom">
    <div class="card-header">
        <i class="bi bi-plus-circle-fill"></i> Tambah Pengguna Baru
    </div>
    <div class="card-body">
         @if (isset($user))
            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
         @else
            <form action="{{ route('admin.user.insert') }}" method="POST">
         @endif
         @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fullName" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="fullName" placeholder="Masukkan nama lengkap" name="name" value="{{ isset($user) ? $user->name : old('name') }}">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="contoh@example.com" name="email" value="{{ isset($user) ? $user->email : old('email') }}">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Masukkan password" name="password" value="{{ isset($user) ? $user->password : old('password') }}" {{ isset($user) ? 'disabled' : '' }}>
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="userRole" class="form-label">Role / Peran</label>
                    <select id="userRole" class="form-select" name="role">
                        <option selected disabled>Pilih role...</option>
                        <option value="mahasiswa" {{ old('role', $user->role ?? '') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ old('role', $user->role ?? '') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div id="extraFields" class="row"></div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('admin.user') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('userRole');
    const extraFieldsContainer = document.getElementById('extraFields');

    function updateExtraFields(role) {
        extraFieldsContainer.innerHTML = ''; // hapus input lama

        if (role === 'mahasiswa') {
            extraFieldsContainer.innerHTML = `
                <div class="col-md-6 mb-3">
                    <label for="nrp" class="form-label">NRP</label>
                    <input type="text" class="form-control" id="nrp" name="nrp" placeholder="Masukkan NRP" value="{{ isset($user) ? $user->mahasiswa->nrp ?? '' : old('nrp') }}">
                    @error('nrp')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <select id="program_studi" class="form-select" name="program_studi">
                        <option selected disabled>Pilih program studi...</option>
                        <option value="Informatika" {{ old('program_studi', $user->mahasiswa->program_studi ?? '') == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                        <option value="SIB" {{ old('program_studi', $user->mahasiswa->program_studi ?? '') == 'SIB' ? 'selected' : '' }}>SIB</option>
                        <option value="DKV" {{ old('program_studi', $user->mahasiswa->program_studi ?? '') == 'DKV' ? 'selected' : '' }}>DKV</option>
                        <option value="Industri" {{ old('program_studi', $user->mahasiswa->program_studi ?? '') == 'Industri' ? 'selected' : '' }}>Industri</option>
                        <option value="Elektro" {{ old('program_studi', $user->mahasiswa->program_studi ?? '') == 'Elektro' ? 'selected' : '' }}>Elektro</option>
                        <option value="Desain Produk" {{ old('program_studi', $user->mahasiswa->program_studi ?? '') == 'Desain Produk' ? 'selected' : '' }}>Desain Produk</option>
                        <option value="MBD" {{ old('program_studi', $user->mahasiswa->program_studi ?? '') == 'MBD' ? 'selected' : '' }}>MBD</option>
                    </select>
                    @error('program_studi')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="angkatan" class="form-label">Angkatan</label>
                    <input type="number" class="form-control" id="angkatan" name="angkatan" placeholder="Masukkan Tahun Angkatan" value="{{ isset($user) ? $user->mahasiswa->angkatan ?? '' : old('angkatan') }}">
                    @error('angkatan')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="ipk" class="form-label">IPK</label>
                    <input type="number" step="0.01" class="form-control" id="ipk" name="ipk" placeholder="Masukkan IPK" value="{{ isset($user) ? $user->mahasiswa->ipk ?? '' : old('ipk') }}">
                    @error('ipk')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            `;
        } 
        else if (role === 'dosen') {
            extraFieldsContainer.innerHTML = `
                <div class="col-md-6 mb-3">
                    <label for="nidn" class="form-label">NIDN</label>
                    <input type="text" class="form-control" id="nidn" name="nidn" placeholder="Masukkan NIDN" value="{{ isset($user) ? $user->dosen->nidn ?? '' : old('nidn') }}">
                    @error('nidn')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            `;
        }
        // jika admin -> tidak menambahkan apapun
    }

    // jalankan saat halaman load (untuk edit mode)
    updateExtraFields(roleSelect.value);

    // jalankan saat user mengubah role
    roleSelect.addEventListener('change', function() {
        updateExtraFields(this.value);
    });
});
</script>
@endsection
