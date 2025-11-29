@extends('layouts.app')

@section('title', 'Data Penilaian')

@section('page-title', 'Data Penilaian Masuk')
@section('page-subtitle', 'Monitoring semua data penilaian yang telah diinput')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-custom shadow-sm border-0">
            
            {{-- Header Responsif --}}
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="fw-bold fs-5">
                    <i class="bi bi-star-fill me-2"></i> Log Penilaian Terbaru
                </div>
                
                {{-- Form Filter --}}
                <div class="w-100 w-md-auto">
                    <form action="{{ route('admin.penilaian') }}" method="GET" class="d-flex flex-column flex-sm-row gap-2">
                        {{-- Filter Kategori --}}
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="bi bi-tags"></i></span>
                            <select class="form-select border-secondary-subtle" name="kategori_id" id="kategoriFilter" onchange="this.form.submit()">
                                <option value='' @if (request('kategori_id') == null) selected @endif>Semua Kategori</option>
                                @foreach ($all_kategori as $k)
                                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Periode --}}
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="bi bi-calendar-event"></i></span>
                            <select class="form-select border-secondary-subtle" name="periode_id" id="periodeFilter" onchange="this.form.submit()">
                                <option value='' @if (request('periode_id') == null) selected @endif>Semua Periode</option>
                                @foreach ($all_periode as $p)
                                    <option value={{ $p->id }} {{ request('periode_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_periode }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap: Agar tabel memanjang ke samping (scrollable) di HP --}}
                    <table class="table table-hover align-middle data-table w-100 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">ID</th>
                                <th>Subjek yang Dinilai</th>
                                <th>Kategori</th>
                                <th>Periode</th>
                                <th class="text-center">Skor</th>
                                <th>Waktu</th>
                                <th class="text-center" width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($penilaian as $p)
                             <tr>
                                <td class="text-center">{{ $p->id }}</td>
                                
                                {{-- Batasi lebar nama agar tidak terlalu panjang --}}
                                <td style="max-width: 250px;" class="text-truncate" title="{{ $p->dinilai_user->name ?? $p->dinilai->name }}">
                                    <span class="fw-bold">{{ $p->dinilai_user->name ?? $p->dinilai->name }}</span>
                                </td>
                                
                                <td><span class="badge bg-light text-dark border">{{ $p->kategori->name }}</span></td>
                                <td>{{ $p->periode->nama_periode }}</td>
                                
                                <td class="text-center">
                                    {{-- Warna badge berdasarkan skor --}}
                                    @php $score = $p->avg_score; @endphp
                                    @if($score >= 4)
                                        <span class="badge bg-success rounded-pill px-3">{{ $score }} / 5.0</span>
                                    @elseif($score >= 3)
                                        <span class="badge bg-primary rounded-pill px-3">{{ $score }} / 5.0</span>
                                    @else
                                        <span class="badge bg-warning text-dark rounded-pill px-3">{{ $score }} / 5.0</span>
                                    @endif
                                </td>
                                
                                <td>
                                    <div class="small text-muted">{{ $p->created_at->format('d M Y') }}</div>
                                    <div class="small fw-bold">{{ $p->created_at->format('H:i') }}</div>
                                </td>
                                
                                <td class="text-center">
                                   <a href="{{ route('admin.detail_penilaian', $p->id) }}" class="btn btn-info btn-sm text-white shadow-sm" title="Lihat Detail">
                                       <i class="bi bi-eye-fill"></i>
                                   </a>
                                </td>
                             </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection