@extends('layouts.app')

@section('title', 'Daftar Feedback')

@section('page-title', 'Daftar Feedback')
@section('page-subtitle', 'Kelola semua feedback yang masuk dari pengguna')
@section('user-name', 'Administrator')
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
    <a class="nav-link" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link active" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
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
        <span><i class="bi bi-chat-left-text-fill"></i> Daftar Feedback Masuk</span>
        <div class="d-flex align-items-center">
            <form action="{{ route('admin.feedback') }}" method="GET" class="d-flex align-items-center">
                <select class="form-select form-select-sm me-2" name="kategori_id" id="kategoriFilter" onchange="this.form.submit()" style="width: auto;">
                    <option value="" @if (request('kategori_id') == null) selected @endif>Semua Kategori</option>
                    @foreach ($all_kategori as $k)
                     <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                    @endforeach
                </select>
                <select class="form-select form-select-sm me-2" name="status" id="periodeFilter" onchange="this.form.submit()" style="width: auto;">
                    <option value="" @if (request('status') == null) selected @endif>Semua Status</option>
                    <option value="1" {{ request('status') == "1" ? 'selected' : '' }}>Sudah Ditanggapi</option>
                    <option value="0" {{ request('status') == "0" ? 'selected' : '' }}>Belum Ditanggapi</option>
                </select>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Pengirim</th>
                        <th>Isi Feedback</th>
                        <th>Target</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($feedbacks as $feedback)
                     <tr>
                        <td>{{ $feedback->id }}</td>
                        <td>
                           @if ($feedback->is_anonymous == 1)
                              Anonim
                           @else
                              {{ $feedback->pengirim->name }}
                           @endif
                        </td>
                        <td>{{ $feedback->isi }}</td>
                        <td>{{ $feedback->kategori->name }}</td>
                        <td>{{ $feedback->created_at->format('d M Y, H:i') }}</td>
                        <td>
                           @if ($feedback->status == 1)
                           <span class="badge bg-success">Sudah Ditanggapi</span>
                           @else
                           <span class="badge bg-warning text-dark">Belum Ditanggapi</span>
                           @endif
                        </td>
                        <td class="text-center">
                           @if ($feedback->status == 1)
                           <a href="{{ route('admin.feedback.update', $feedback->id) }}" class="btn btn-danger btn-sm" title="Tandai Belum Ditanggapi"><i class="bi bi-x-circle-fill"></i></a>
                           @else
                           <a href="{{ route('admin.feedback.update', $feedback->id) }}" class="btn btn-success btn-sm" title="Tandai Sudah Ditanggapi"><i class="bi bi-check-circle-fill"></i></a>
                           @endif
                           <a href="{{ route('admin.feedback.detail', $feedback->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</a>
                        </td>
                     </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

