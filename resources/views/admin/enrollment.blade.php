@extends('layouts.app')

@section('title', 'Detail Enrollment')

@section('page-title', 'Detail Enrollment Kelas')
@section('page-subtitle', 'Daftar mahasiswa terdaftar di kelas Algoritma & Pemrograman')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
@if(session('success'))
   <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-people-fill"></i> Daftar Mahasiswa Kelas</div>
        <div>
           <a href="{{ route('admin.kelas') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Kelas</a>
           <a href="{{ route('admin.form_enrollment', $kelas->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Enrollment</a>
        </div>
    </div>
    <div class="card-body">
        <div class="p-3 mb-4 rounded" style="background-color: #f8f9fa;">
            <div class="row">
                <div class="col-md-12">
                    <h5>{{ $kelas->mataKuliah->name }}</h5>
                    <p class="mb-1"><strong>Program Studi:</strong> {{ $kelas->program_studi->name }}</p>
                    <p class="mb-1"><strong>Dosen Pengampu:</strong> {{ $kelas->dosen->user->name }}</p>
                    <p class="mb-0"><strong>Periode:</strong> {{ $kelas->periode->nama_periode }}</p>
                </div>
            </div>
        </div>

        <!-- Student List -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($enrollments as $e)
                     <tr>
                        <td>{{ $e->id }}</td>
                        <td>{{ $e->mahasiswa_nrp }}</td>
                        <td>{{ $e->mahasiswa->user->name ?? '' }}</td>
                        <td>{{ $e->mahasiswa->program_studi->name ?? '' }}</td>
                        <td>
                           <a href="{{ route('admin.enrollment.delete', [$e->kelas_id, $e->id]) }}" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
                        </td>
                     </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
