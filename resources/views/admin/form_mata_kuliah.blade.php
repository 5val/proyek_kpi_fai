@extends('layouts.app')

@section('title', 'Form Mata Kuliah')

@section('page-title', 'Formulir Mata Kuliah')
@section('page-subtitle', 'Tambah atau ubah data mata kuliah')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
<div class="card-custom">
    <div class="card-header"><i class="bi bi-pencil-square"></i> Form Mata Kuliah</div>
    <div class="card-body p-3">
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
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.mata_kuliah') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

