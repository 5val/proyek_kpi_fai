@extends('layouts.app')

@section('title', 'Manajemen Mata Kuliah')

@section('page-title', 'Manajemen Mata Kuliah')
@section('page-subtitle', 'Kelola data master mata kuliah')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
@if(session('success'))
   <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-book-fill"></i> Daftar Mata Kuliah</div>
        <a href="{{ route('admin.form_mata_kuliah') }}" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> Tambah Mata Kuliah</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead class="table-light">
                    <tr>
                       <th>ID</th>
                       <th>Nama Mata Kuliah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($matkul as $m)
                  
                  <tr>
                     <td>{{ $m->id }}</td>
                      <td>{{ $m->name }} <span style="color:red;">{{ $m->is_active == 0 ? '(Tidak Aktif)' : ''}}</span></td>
                      <td>
                          <a href="{{ route('admin.form_mata_kuliah_edit', $m->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                          @if ($m->is_active == 0)
                           <a href="{{ route('admin.mata_kuliah.delete', $m->id) }}" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i></a>
                           @else
                           <a href="{{ route('admin.mata_kuliah.delete', $m->id) }}" class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i></a>
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

