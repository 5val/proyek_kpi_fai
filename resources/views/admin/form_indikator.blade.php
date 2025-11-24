@extends('layouts.app')

@section('title', 'Formulir Indikator KPI')

@section('page-title', 'Formulir Indikator KPI')
@section('page-subtitle', 'Tambah atau edit indikator untuk sebuah kategori')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="{{ route('admin.user') }}"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="{{ route('admin.fasilitas') }}"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="{{ route('admin.unit') }}"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="{{ route('admin.periode') }}"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link" href="{{ route('admin.mata_kuliah') }}"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
    <a class="nav-link" href="{{ route('admin.kelas') }}"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link active" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
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
        <i class="bi bi-plus-circle-fill"></i> Tambah Indikator untuk Kategori: <strong>Kinerja Dosen</strong>
    </div>
    <div class="card-body">
         @if (isset($indikator))
            <form action="{{ route('admin.indikator.update', [$kategori_id, $indikator->id]) }}" method="POST">
         @else
            <form action="{{ route('admin.indikator.insert', $kategori_id) }}" method="POST">
         @endif
         @csrf
            <div class="mb-3">
                <label for="indicatorName" class="form-label">Nama Indikator</label>
                <input type="text" class="form-control" id="indicatorName" placeholder="Contoh: Penguasaan Materi" name="name" value="{{ isset($indikator) ? $indikator->name : old('name') }}">
                @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
            </div>
            <div class="mb-3">
                <label for="weight" class="form-label">Bobot (%)</label>
                <input type="number" class="form-control" id="weight" placeholder="Masukkan bobot dalam persen (contoh: 20)" name="bobot" value="{{ isset($indikator) ? $indikator->bobot : old('bobot') }}">
                @error('bobot')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('admin.list_indikator', $kategori_id) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
