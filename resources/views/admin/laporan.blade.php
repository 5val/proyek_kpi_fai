@extends('layouts.app')

@section('title', 'Laporan KPI')

@section('page-title', 'Laporan Key Performance Indicator')
@section('page-subtitle', 'Generate dan export laporan KPI')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')

{{-- Filter Section --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-custom shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-filter me-2"></i> Filter Laporan
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.laporan') }}" method="GET" class="row g-3">
                    <div class="col-12 col-md-4">
                        <label for="kategori" class="form-label fw-bold small text-uppercase text-muted">Kategori KPI</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-tags"></i></span>
                            <select id="kategori" class="form-select" name="kategori_id">
                                @foreach ($all_kategori as $k)
                                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="periode" class="form-label fw-bold small text-uppercase text-muted">Periode</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-calendar-event"></i></span>
                            <select id="periode" class="form-select" name="periode_id">
                                @foreach ($all_periode as $p)
                                    <option value="{{ $p->id }}" {{ request('periode_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_periode }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 shadow-sm">
                            <i class="bi bi-search me-2"></i> Tampilkan Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Result Section --}}
<div class="row">
    <div class="col-12">
        <div class="card card-custom shadow-sm border-0">
            
            {{-- Header Responsif: Stack di Mobile, Row di Desktop --}}
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="fw-bold fs-5">
                    <i class="bi bi-file-earmark-bar-graph-fill me-2"></i> 
                    Laporan: {{ $curKategori->name }}
                </div>
                
                {{-- Tombol Export --}}
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.laporan.export.excel', [$curKategori->id, $periode_id]) }}" class="btn btn-success btn-sm d-flex align-items-center">
                        <i class="bi bi-file-earmark-excel-fill me-2"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.laporan.export.pdf', [$curKategori->id, $periode_id]) }}" class="btn btn-danger btn-sm d-flex align-items-center">
                        <i class="bi bi-file-earmark-pdf-fill me-2"></i> Export PDF
                    </a>
                </div>
            </div>

            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap: Agar tabel rapi scroll ke samping di HP --}}
                    <table class="table table-hover align-middle table-bordered w-100 text-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama {{ ucfirst($curKategori->target_role) }}</th>
                                <th class="text-center" width="20%">Skor Rata-rata</th>
                                <th class="text-center" width="20%">Jumlah Penilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penilaian as $p)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">
                                            @if ($curKategori->id == 1 || $curKategori->id == 2)
                                                {{-- Icon User --}}
                                                <i class="bi bi-person-circle me-2 text-secondary"></i> {{ $p->user->name ?? '-' }}
                                            @elseif ($curKategori->id == 3 || $curKategori->id == 4)
                                                {{-- Icon Building --}}
                                                <i class="bi bi-building me-2 text-secondary"></i> {{ $p->name ?? '-' }}
                                            @else
                                                {{-- Icon Book --}}
                                                <i class="bi bi-book me-2 text-secondary"></i> {{ $p->kelas->mataKuliah->name ?? '-' }}
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        @if($p->penilaian_avg_avg_score)
                                            @php $score = $p->penilaian_avg_avg_score; @endphp
                                            @if($score >= 4)
                                                <span class="badge bg-success rounded-pill px-3">{{ number_format($score, 1) }}</span>
                                            @elseif($score >= 3)
                                                <span class="badge bg-primary rounded-pill px-3">{{ number_format($score, 1) }}</span>
                                            @elseif($score >= 2)
                                                <span class="badge bg-warning text-dark rounded-pill px-3">{{ number_format($score, 1) }}</span>
                                            @else
                                                <span class="badge bg-danger rounded-pill px-3">{{ number_format($score, 1) }}</span>
                                            @endif
                                        @else
                                            <span class="badge bg-light text-muted border">Belum Ada</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        @if($p->penilaian_count)
                                            <span class="badge bg-secondary bg-opacity-10 text-dark border px-3">
                                                <i class="bi bi-people me-1"></i> {{ $p->penilaian_count }}
                                            </span>
                                        @else
                                            <span class="small text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="bi bi-clipboard-x fs-1 d-block mb-2 opacity-25"></i>
                                        Tidak ada data penilaian untuk periode dan kategori ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection