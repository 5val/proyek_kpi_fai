@extends('layouts.app')

@section('title', 'Daftar Indikator KPI')

@section('page-title', 'Indikator KPI')
@section('page-subtitle', 'Kelola semua indikator penilaian')
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
@if(session('success'))
   <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('admin.kategori_kpi') }}" class="btn btn-secondary btn-sm me-2"><i class="bi bi-arrow-left"></i> Kembali</a>
            <i class="bi bi-list-task"></i> Daftar Indikator untuk <strong>Kinerja Dosen</strong>
        </div>
        <a href="{{ route('admin.form_indikator', $kategori_id) }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Indikator</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Indikator</th>
                        <th>Bobot (%)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($indikator as $i)
                  
                     <tr>
                        <td>{{ $i->id }}</td>
                        <td>{{ $i->name }}</td>
                        <td>{{ $i->bobot }}</td>
                        <td>
                           <a href="{{ route('admin.form_indikator_edit', [$kategori_id, $i->id] ) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i> Edit</a>
                           <a href="{{ route('admin.indikator.delete', [$kategori_id, $i->id]) }}" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i> Hapus</a>
                        </td>
                     </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
