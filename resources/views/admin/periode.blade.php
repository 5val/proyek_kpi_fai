@extends('layouts.app')

@section('title', 'Manajemen Periode')

@section('page-title', 'Manajemen Periode')
@section('page-subtitle', 'Kelola periode akademik untuk penilaian dan kelas')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
@if(session('success'))
   <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-calendar-event-fill"></i> Daftar Periode Akademik</div>
        <a href="{{ route('admin.periode.insert') }}" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> Buka Periode</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead class="table-light">
                    <tr>
                        <th>Nama Periode</th>
                        <th>Tahun</th>
                        <th>Semester</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($periode as $p)
                  <tr>
                     <td>{{ $p->nama_periode }}</td>
                     <td>{{ $p->tahun }}</td>
                     <td>{{ Str::ucfirst($p->semester) }}</td>
                     <td>
                        @if ($loop->last)
                           <a href="{{ route('admin.periode.delete', $p->id) }}" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
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
