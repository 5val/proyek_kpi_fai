@extends('layouts.app')

@section('title', 'Formulir Unit')

@section('page-title', 'Formulir Unit')
@section('page-subtitle', 'Tambah atau edit data unit layanan/akademik')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="{{ route('admin.user') }}"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="{{ route('admin.fasilitas') }}"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link active" href="{{ route('admin.unit') }}"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="{{ route('admin.periode') }}"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link" href="{{ route('admin.mata_kuliah') }}"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
    <a class="nav-link" href="{{ route('admin.kelas') }}"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header">
        <i class="bi bi-plus-circle-fill"></i> Tambah Unit Baru
    </div>
    <div class="card-body">
         @if (isset($unit))
            <form action="{{ route('admin.unit.update', $unit->id) }}" method="POST">
         @else
            <form action="{{ route('admin.unit.insert') }}" method="POST">
         @endif
         @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="unitName" class="form-label">Nama Unit</label>
                    <input type="text" class="form-control" id="unitName" placeholder="Contoh: Biro Administrasi Akademik" name="name" value="{{ isset($unit) ? $unit->name : old('name') }}" {{ isset($user) ? 'disabled' : '' }}>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="unitType" class="form-label">Tipe Unit</label>
                    <select id="unitType" class="form-select" name="type">
                        <option selected>Pilih tipe...</option>
                        <option value="Layanan" {{ old('type', $unit->type ?? '') == 'Layanan' ? 'selected' : '' }}>Layanan</option>
                        <option value="Akademik" {{ old('type', $unit->type ?? '') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="UKM" {{ old('type', $unit->type ?? '') == 'UKM' ? 'selected' : '' }}>UKM</option>
                        <option value="UKK" {{ old('type', $unit->type ?? '') == 'UKK' ? 'selected' : '' }}>UKK</option>
                        <option value="Organisasi" {{ old('type', $unit->type ?? '') == 'Organisasi' ? 'selected' : '' }}>Organisasi</option>
                    </select>
                    @error('type')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label for="personInCharge" class="form-label">Penanggung Jawab</label>
                    <select class="form-select" name="penanggung_jawab_id">
                       <option selected>Pilih penanggung jawab...</option>
                       @foreach ($users as $user)
                           <option value="{{ $user->id }}"  {{ old('penanggung_jawab_id', $unit->penanggung_jawab_id ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                       @endforeach
                    </select>
                    @error('penanggung_jawab_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('admin.unit') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
