@extends('layouts.app')

@section('title', 'Kategori KPI')

@section('page-title', 'Kategori Key Performance Indicator (KPI)')
@section('page-subtitle', 'Kelola kategori utama untuk penilaian')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-custom shadow-sm border-0">
            
            {{-- Header Card --}}
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="fw-bold fs-5">
                    <i class="bi bi-tags-fill me-2"></i> Daftar Kategori KPI
                </div>
                {{-- Jika nanti butuh tombol tambah kategori, bisa diletakkan di sini --}}
            </div>

            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap: Agar tabel rapi memanjang ke samping di HP --}}
                    <table class="table table-hover align-middle data-table w-100 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th class="text-center">Jumlah Indikator</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @forelse ($kategori as $k)
                             <tr>
                                <td class="fw-bold">{{ $k->name }}</td>
                                
                                {{-- Batasi lebar deskripsi agar tidak merusak layout --}}
                                <td style="max-width: 300px;" class="text-truncate" title="{{ $k->description }}">
                                    {{ $k->description ?? '-' }}
                                </td>
                                
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill px-3">{{ $k->indikator_count }}</span>
                                </td>
                                
                                <td class="text-center">
                                   <a href="{{ route('admin.list_indikator', $k->id) }}" class="btn btn-info btn-sm text-white shadow-sm" title="Lihat Indikator">
                                       <i class="bi bi-list-task me-1"></i> <span class="d-none d-md-inline">Indikator</span>
                                   </a>
                                </td>
                             </tr>
                          @empty
                             <tr>
                                 <td colspan="4" class="text-center py-5 text-muted">
                                     <i class="bi bi-folder-x fs-1 d-block mb-2 opacity-25"></i>
                                     Belum ada data kategori.
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