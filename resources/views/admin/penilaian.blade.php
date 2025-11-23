@extends('layouts.app')

@section('title', 'Data Penilaian')

@section('page-title', 'Data Penilaian Masuk')
@section('page-subtitle', 'Monitoring semua data penilaian yang telah diinput')
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
    <a class="nav-link active" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Data Penilaian</a>
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
        <div><i class="bi bi-star-fill"></i> Log Penilaian Terbaru</div>
        
        <div class="d-flex align-items-center">
            <!-- Form untuk Filter Kategori -->
            <form action="{{ route('admin.penilaian') }}" method="GET" class="d-flex align-items-center">
                <select class="form-select form-select-sm me-2" name="kategori_id" id="kategoriFilter" onchange="this.form.submit()" style="width: auto;">
                    <option value='' @if (request('kategori_id') == null) selected @endif>Semua Kategori</option>
                    @foreach ($all_kategori as $k)
                     <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                    @endforeach
                </select>
                <select class="form-select form-select-sm me-2" name="periode_id" id="periodeFilter" onchange="this.form.submit()" style="width: auto;">
                    <option value='' @if (request('periode_id') == null) selected @endif>Semua Periode</option>
                    @foreach ($all_periode as $p)
                     <option value={{ $p->id }} {{ request('periode_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_periode }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead class="table-light">
                    <tr>
                        <th>Penilai</th>
                        <th>Subjek yang Dinilai</th>
                        <th>Kategori</th>
                        <th>Periode</th>
                        <th>Skor Rata-rata</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($penilaian as $p)
                     <tr>
                        <td>{{ $p->penilai->name }}</td>
                        <td>{{ $p->dinilai_user->name ?? $p->dinilai->name }}</td>
                        <td>{{ $p->kategori->name }}</td>
                        <td>{{ $p->periode->nama_periode }}</td>
                        <td><span class="badge bg-primary">{{ $p->avg_score }} / 5.0</span></td>
                        <td>{{ $p->created_at }}</td>
                        <td><a href="{{ route('admin.detail_penilaian', $p->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</a></td>
                     </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

