@extends('layouts.app')

@section('title', 'Formulir Fasilitas')

@section('page-title', 'Formulir Fasilitas')
@section('page-subtitle', 'Tambah atau edit data fasilitas kampus')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
<div class="card-custom">
    <div class="card-header">
        <i class="bi bi-plus-circle-fill"></i> Tambah Fasilitas Baru
    </div>
    <div class="card-body">
         @if (isset($editing))
            <form action="{{ route('admin.fasilitas.update', $editing->id) }}" method="POST">
         @else
            <form action="{{ route('admin.fasilitas.insert') }}" method="POST">
         @endif
         @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="facilityName" class="form-label">Nama Fasilitas</label>
                    <input type="text" class="form-control" id="facilityName" placeholder="Contoh: Perpustakaan Pusat" name="name" value="{{ isset($editing) ? $editing->name : old('name') }}">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="facilityCategory" class="form-label">Kategori</label>
                    <select id="facilityCategory" class="form-select" name="kategori">
                        <option selected>Pilih kategori...</option>
                        <option value="Umum" {{ old('kategori', $editing->kategori ?? '') == 'Umum' ? 'selected' : '' }}>Umum</option>
                        <option value="Akademik" {{ old('kategori', $editing->kategori ?? '') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="Laboratorium" {{ old('kategori', $editing->kategori ?? '') == 'Laboratorium' ? 'selected' : '' }}>Laboratorium</option>
                        <option value="Olahraga" {{ old('kategori', $editing->kategori ?? '') == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                        <option value="Kesehatan" {{ old('kategori', $editing->kategori ?? '') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        <option value="Administrasi" {{ old('kategori', $editing->kategori ?? '') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                    </select>
                    @error('kategori')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="condition" class="form-label">Kondisi</label>
                    <select id="condition" class="form-select" name="kondisi">
                        <option selected>Pilih kondisi...</option>
                        <option value="baik" {{ old('kondisi', $editing->kondisi ?? '') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="perbaikan" {{ old('kondisi', $editing->kondisi ?? '') == 'perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                    </select>
                    @error('kondisi')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('admin.fasilitas') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
