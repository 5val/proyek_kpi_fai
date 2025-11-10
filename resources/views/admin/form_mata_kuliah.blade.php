@extends('layouts.app')

@section('title', 'Form Mata Kuliah')

@section('page-title', 'Formulir Mata Kuliah')
@section('page-subtitle', 'Tambah atau ubah data mata kuliah')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="{{ route('admin.user') }}"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="{{ route('admin.fasilitas') }}"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="{{ route('admin.unit') }}"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="{{ route('admin.periode') }}"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link active" href="{{ route('admin.mata_kuliah') }}"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
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
    <div class="card-header"><i class="bi bi-pencil-square"></i> Form Mata Kuliah</div>
    <div class="card-body">
        @if (isset($matkul))
            <form action="{{ route('admin.mata_kuliah.update', $matkul->id) }}" method="POST">
         @else
            <form action="{{ route('admin.mata_kuliah.insert') }}" method="POST">
         @endif
         @csrf
            <div class="mb-3">
                <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                <input type="text" class="form-control" id="nama_mk" placeholder="Contoh: Algoritma & Pemrograman" name="name" value="{{ isset($matkul) ? $matkul->name : old('name') }}">
                @error('name')
                     <p class="text-danger">{{ $message }}</p>
               @enderror
            </div>
            <div class="col-md-6 mb-3">
               <label for="program_studi" class="form-label">Program Studi</label>
               <select id="program_studi" class="form-select" name="program_studi">
                     <option selected disabled>Pilih program studi...</option>
                     <option value="Informatika" {{ old('program_studi', $matkul->program_studi ?? '') == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                     <option value="SIB" {{ old('program_studi', $matkul->program_studi ?? '') == 'SIB' ? 'selected' : '' }}>SIB</option>
                     <option value="DKV" {{ old('program_studi', $matkul->program_studi ?? '') == 'DKV' ? 'selected' : '' }}>DKV</option>
                     <option value="Industri" {{ old('program_studi', $matkul->program_studi ?? '') == 'Industri' ? 'selected' : '' }}>Industri</option>
                     <option value="Elektro" {{ old('program_studi', $matkul->program_studi ?? '') == 'Elektro' ? 'selected' : '' }}>Elektro</option>
                     <option value="Desain Produk" {{ old('program_studi', $matkul->program_studi ?? '') == 'Desain Produk' ? 'selected' : '' }}>Desain Produk</option>
                     <option value="MBD" {{ old('program_studi', $matkul->program_studi ?? '') == 'MBD' ? 'selected' : '' }}>MBD</option>
               </select>
               @error('program_studi')
                     <p class="text-danger">{{ $message }}</p>
               @enderror
            </div>
            <div class="mb-3">
                <label for="sks" class="form-label">Jumlah SKS</label>
                <input type="number" class="form-control" id="sks" placeholder="Contoh: 3" name="sks" value="{{ isset($matkul) ? $matkul->sks : old('sks') }}">
                @error('sks')
                     <p class="text-danger">{{ $message }}</p>
               @enderror
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.mata_kuliah') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

