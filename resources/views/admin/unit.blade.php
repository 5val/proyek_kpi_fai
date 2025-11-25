@extends('layouts.app')

@section('title', 'Manajemen Unit')

@section('page-title', 'Manajemen Unit')
@section('page-subtitle', 'Kelola data unit layanan dan akademik')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
@if(session('success'))
   <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-bank2"></i> Daftar Unit</div>
        <a href="{{ route('admin.form_unit') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Unit</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead class="table-light">
                    <tr>
                        <th>Nama Unit</th>
                        <th>Tipe</th>
                        <th>Penanggung Jawab</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($units as $unit)
                     <tr>
                        <td>{{ $unit->name }} <span style="color:red;">{{ $unit->is_active == 0 ? '(Tidak Aktif)' : ''}}</span></td>
                        <td>{{ $unit->type }}</td>
                        <td>{{ $unit->penanggungJawab->name ?? 'Belum ditentukan' }}</td>
                        <td>
                           <a href="{{ route('admin.form_unit_edit', $unit->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                           @if ($unit->is_active == 0)
                           <a href="{{ route('admin.unit.delete', $unit->id) }}" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i></a>
                           @else
                           <a href="{{ route('admin.unit.delete', $unit->id) }}" class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i></a>
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
