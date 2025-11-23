@extends('layouts.app')

@section('title', 'Laporan KPI')

@section('page-title', 'Laporan Key Performance Indicator')
@section('page-subtitle', 'Generate dan export laporan KPI')
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
    <a class="nav-link active" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
    <form action="{{ route('logout') }}" method="POST" style="float: right;">
      @csrf
      <div style="align-items: center; justify-content: center; display: flex;">
        <button class="btn btn-danger" type="submit">Logout</button>
      </div>
   </form>
@endsection

@section('content')
<div class="card-custom mb-4">
    <div class="card-header"><i class="bi bi-filter"></i> Filter Laporan</div>
    <div class="card-body">
        <form action="{{ route('admin.laporan') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="kategori" class="form-label">Kategori KPI</label>
                <select id="kategori" class="form-select" name="kategori_id">
                    @foreach ($all_kategori as $k)
                     <option value={{ $k->id }} {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="periode" class="form-label">Periode</label>
                <select id="periode" class="form-select" name="periode_id">
                    @foreach ($all_periode as $p)
                     <option value={{ $p->id }} {{ request('periode_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_periode }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Tampilkan Laporan</button>
            </div>
        </form>
    </div>
</div>

<div class="card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-file-earmark-text-fill"></i> Hasil Laporan: {{ $curKategori->name }}</div>
        <div>
            <button class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel-fill"></i> Export Excel</button>
            <button class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf-fill"></i> Export PDF</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                 <thead class="table-light">
                    <tr>
                        <th>Nama {{ ucfirst($curKategori->target_role) }}</th>
                        <th>Skor Rata-rata</th>
                        <th>Jumlah Penilai</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach ($penilaian as $p)
                        <tr>
                           <td>
                              @if ($curKategori->id == 1 || $curKategori->id == 2)
                                 {{ $p->user->name ?? '' }}
                              @elseif ($curKategori->id == 3 || $curKategori-> id == 4)
                                 {{ $p->name ?? '' }}
                              @else
                                 {{ $p->kelas->mataKuliah->name ?? '' }}
                              @endif
                           </td>
                           <td>{{ $p->penilaian_avg_avg_score ? number_format($p->penilaian_avg_avg_score, 1) : 'Belum Ada Penilaian' }}</td>
                           <td>{{ $p->penilaian_count ?? 'Belum Ada Penilaian' }}</td>
                        </tr>
                     @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
