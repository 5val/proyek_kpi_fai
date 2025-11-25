@extends('layouts.app')

@section('title', 'Manajemen Fasilitas')

@section('page-title', 'Manajemen Fasilitas')
@section('page-subtitle', 'Kelola data fasilitas kampus')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
@if(session('success'))
   <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-building"></i> Daftar Fasilitas</div>
        <a href="{{ route('admin.form_fasilitas') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Fasilitas</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead class="table-light">
                    <tr>
                        <th>Nama Fasilitas</th>
                        <th>Kategori</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($fasilitas as $f)
                     <tr class="{{ $f->kondisi == 'baik' ? '' : 'table-danger' }}">
                        <td>{{ $f->name }} <span style="color:red;">{{ $f->is_active == 0 ? '(Tidak Aktif)' : ''}}</span></td>
                        <td>{{$f->kategori}}</td>
                        @if ($f->kondisi == "baik")
                           <td><span class="badge bg-success">Baik</span></td>
                        @else
                           <td><span class="badge bg-warning text-dark">Perlu Perbaikan</span></td>
                        @endif
                        <td>
                           <a href="{{ route('admin.form_fasilitas_edit', $f->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                           @if ($f->is_active == 0)
                           <a href="{{ route('admin.fasilitas.delete', $f->id) }}" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i></a>
                           @else
                           <a href="{{ route('admin.fasilitas.delete', $f->id) }}" class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i></a>
                           @endif
                        </td>
                     </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
