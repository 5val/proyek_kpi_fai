@extends('layouts.app')

@section('title', 'Manajemen Unit')

@section('page-title', 'Manajemen Unit')
@section('page-subtitle', 'Kelola data unit layanan dan akademik')
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
                <div class="fw-bold fs-5">
                    <i class="bi bi-bank2 me-2"></i> Daftar Unit
                </div>
                
                <a href="{{ route('admin.form_unit') }}" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Unit
                </a>
            </div>

            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap: Agar tabel memanjang ke samping (scrollable) di HP --}}
                    {{-- data-table: Class wajib DataTables --}}
                    <table class="table table-hover align-middle data-table w-100 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Unit</th>
                                <th>Tipe</th>
                                <th>Penanggung Jawab</th>
                                <th class="text-center" width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($units as $unit)
                             <tr>
                                <td>
                                    <div class="fw-bold">{{ $unit->name }}</div>
                                    @if($unit->is_active == 0)
                                        <small class="text-danger fst-italic">
                                            <i class="bi bi-slash-circle"></i> Tidak Aktif
                                        </small>
                                    @endif
                                </td>
                                
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-dark border border-secondary rounded-pill px-3">
                                        {{ $unit->type }}
                                    </span>
                                </td>
                                
                                <td>
                                    @if($unit->penanggungJawab)
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle text-muted me-2"></i>
                                            {{ $unit->penanggungJawab->name }}
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic">Belum ditentukan</span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    <div class="btn-group shadow-sm" role="group">
                                       <a href="{{ route('admin.form_unit_edit', $unit->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                           <i class="bi bi-pencil-fill"></i>
                                       </a>
                                       
                                       @if ($unit->is_active == 0)
                                           <a href="{{ route('admin.unit.delete', $unit->id) }}" class="btn btn-success btn-sm" title="Aktifkan" onclick="return confirm('Aktifkan unit ini?')">
                                               <i class="bi bi-check-circle"></i>
                                           </a>
                                       @else
                                           <a href="{{ route('admin.unit.delete', $unit->id) }}" class="btn btn-danger btn-sm" title="Non-aktifkan" onclick="return confirm('Non-aktifkan unit ini?')">
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