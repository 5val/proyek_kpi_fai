@extends('layouts.app')

@section('title', 'Kategori KPI')

@section('page-title', 'Kategori Key Performance Indicator (KPI)')
@section('page-subtitle', 'Kelola kategori utama untuk penilaian')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-tags-fill"></i> Daftar Kategori KPI</div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead class="table-light">
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Indikator</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($kategori as $k)
                     <tr>
                        <td>{{ $k->name }}</td>
                        <td>{{ $k->description }}</td>
                        <td>{{ $k->indikator_count }}</td>
                        <td>
                           <a href="{{ route('admin.list_indikator', $k->id) }}" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i> Indikator</a>
                        </td>
                     </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
