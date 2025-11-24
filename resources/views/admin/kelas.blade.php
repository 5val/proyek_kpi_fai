@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('page-title', 'Manajemen Kelas')
@section('page-subtitle', 'Kelola kelas yang dibuka setiap periode')
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
    <a class="nav-link active" href="{{ route('admin.kelas') }}"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
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
        <div><i class="bi bi-easel-fill"></i> Daftar Kelas</div>
        
        <div class="d-flex align-items-center">
            <!-- Form untuk Filter Periode -->
            <form action="{{ route('admin.kelas') }}" method="GET" class="d-flex align-items-center">
                <select class="form-select form-select-sm me-2" name="periode_id" id="periodeFilter" onchange="this.form.submit()" style="width: auto;">
                    <option value={{ null }} @if (!request('periode_id')) selected @endif>Semua Periode</option>
                    @foreach ($all_periode as $p)
                     <option value={{ $p->id }} {{ request('periode_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_periode }}</option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('admin.form_kelas') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle-fill"></i> Buka Kelas Baru</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Mata Kuliah</th>
                        <th>Program Studi</th>
                        <th>Dosen Pengampu</th>
                        <th>Periode</th>
                        <th>Jumlah Mahasiswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($kelas as $k)
                     <tr>
                        <td>{{ $k->id }}</td>
                        <td>{{ $k->mataKuliah->name }} <span style="color:red;">{{ $k->is_active == 0 ? '(Tidak Aktif)' : ''}}</span></td>
                        <td>{{ $k->program_studi->name }}</td>
                        <td>{{ $k->dosen->user->name ?? 'Dosen belum ditentukan' }}</td>
                        <td>{{ $k->periode->nama_periode }}</td>
                        <td>{{ $k->enrollment_count }}</td>
                        <td>
                           <a href="{{ route('admin.form_kelas_edit', $k->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                           @if ($k->is_active == 0)
                           <a href="{{ route('admin.kelas.delete', $k->id) }}" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i></a>
                           @else
                           <a href="{{ route('admin.kelas.delete', $k->id) }}" class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i></a>
                           @endif
                           <a href="{{ route('admin.enrollment', $k->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</a>
                        </td>
                     </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

