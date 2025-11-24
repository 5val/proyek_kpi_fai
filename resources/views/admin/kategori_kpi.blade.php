@extends('layouts.app')

@section('title', 'Kategori KPI')

@section('page-title', 'Kategori Key Performance Indicator (KPI)')
@section('page-subtitle', 'Kelola kategori utama untuk penilaian')
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
