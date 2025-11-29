@extends('layouts.app')

@section('title', 'Manajemen Fasilitas')

@section('page-title', 'Manajemen Fasilitas')
@section('page-subtitle', 'Kelola data fasilitas kampus')
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
            
            {{-- Header: Stack vertikal di Mobile, Horizontal di Desktop --}}
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="fw-bold fs-5">
                    <i class="bi bi-building me-2"></i> Daftar Fasilitas
                </div>
                
                {{-- Tombol Tambah --}}
                <a href="{{ route('admin.form_fasilitas') }}" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Fasilitas
                </a>
            </div>

            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap: Agar tabel memanjang ke samping di HP (scrollable) & tidak gepeng --}}
                    {{-- data-table: Class wajib untuk DataTables JS --}}
                    <table class="table table-hover align-middle data-table w-100 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Fasilitas</th>
                                <th>Kategori</th>
                                <th class="text-center">Kondisi</th>
                                <th class="text-center" width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($fasilitas as $f)
                             {{-- Logic row merah jika kondisi rusak --}}
                             <tr class="{{ $f->kondisi == 'baik' ? '' : 'table-danger' }}">
                                <td>
                                    <div class="fw-bold">{{ $f->name }}</div>
                                    @if($f->is_active == 0)
                                        <small class="text-danger fst-italic">
                                            <i class="bi bi-slash-circle"></i> Tidak Aktif
                                        </small>
                                    @endif
                                </td>
                                <td>{{ $f->kategori }}</td>
                                <td class="text-center">
                                    @if ($f->kondisi == "baik")
                                       <span class="badge bg-success rounded-pill px-3">Baik</span>
                                    @else
                                       <span class="badge bg-warning text-dark rounded-pill px-3">
                                            <i class="bi bi-wrench-adjustable me-1"></i> Perlu Perbaikan
                                       </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm" role="group">
                                       <a href="{{ route('admin.form_fasilitas_edit', $f->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                           <i class="bi bi-pencil-fill"></i>
                                       </a>
                                       @if ($f->is_active == 0)
                                           <a href="{{ route('admin.fasilitas.delete', $f->id) }}" class="btn btn-success btn-sm" title="Aktifkan" onclick="return confirm('Aktifkan fasilitas ini?')">
                                               <i class="bi bi-check-circle"></i>
                                           </a>
                                       @else
                                           <a href="{{ route('admin.fasilitas.delete', $f->id) }}" class="btn btn-danger btn-sm" title="Non-aktifkan" onclick="return confirm('Non-aktifkan fasilitas ini?')">
                                               <i class="bi bi-x-circle"></i>
                                           </a>
                                       @endif
                                    </div>
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