@extends('layouts.app')

@section('title', 'Daftar Indikator KPI')

@section('page-title', 'Indikator KPI')
@section('page-subtitle', 'Kelola semua indikator penilaian')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')

@if(session('success'))
   <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
       <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card card-custom shadow-sm border-0">
            
            {{-- Header Responsif --}}
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.kategori_kpi') }}" class="btn btn-secondary btn-sm d-flex align-items-center">
                        <i class="bi bi-arrow-left me-1"></i> <span class="d-none d-sm-inline">Kembali</span>
                    </a>
                    <div class="vr mx-1 text-muted"></div>
                    <div class="fw-bold fs-5">
                        <i class="bi bi-list-task me-1"></i> Daftar Indikator: {{ $kategori->name }}
                    </div>
                </div>
                
                <a href="{{ route('admin.form_indikator', $kategori->id) }}" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Indikator
                </a>
            </div>

            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- data-table: Class wajib DataTables --}}
                    <table class="table table-hover align-middle data-table w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">#</th>
                                <th>Nama Indikator</th>
                                <th class="text-center" width="100">Bobot</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @forelse ($indikator as $i)
                             <tr>
                                <td class="text-center">{{ $i->id }}</td>
                                
                                {{-- 
                                    min-width: 300px -> Agar teks indikator yang panjang 
                                    tidak terlalu gepeng di layar HP, tapi tetap wrap ke bawah.
                                --}}
                                <td style="min-width: 250px;">
                                    {{ $i->name }}
                                </td>
                                
                                <td class="text-center">
                                    <span class="badge bg-info text-dark border border-info rounded-pill px-3">
                                        {{ $i->bobot }}%
                                    </span>
                                </td>
                                
                                <td class="text-center">
                                    <div class="btn-group shadow-sm" role="group">
                                       <a href="{{ route('admin.form_indikator_edit', [$kategori->id, $i->id] ) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                           <i class="bi bi-pencil-fill"></i>
                                       </a>
                                       <a href="{{ route('admin.indikator.delete', [$kategori->id, $i->id]) }}" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus indikator ini?')">
                                           <i class="bi bi-trash-fill"></i>
                                       </a>
                                    </div>
                                </td>
                             </tr>
                          @empty
                             <tr>
                                 <td colspan="4" class="text-center py-5 text-muted">
                                     <i class="bi bi-clipboard-x fs-1 d-block mb-2 opacity-25"></i>
                                     Belum ada indikator untuk kategori ini.
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