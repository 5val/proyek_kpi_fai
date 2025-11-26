@extends('layouts.app')

@section('title', 'Daftar Indikator KPI')

@section('page-title', 'Indikator KPI')
@section('page-subtitle', 'Kelola semua indikator penilaian')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

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
