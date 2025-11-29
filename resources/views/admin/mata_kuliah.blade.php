@extends('layouts.app')

@section('title', 'Manajemen Mata Kuliah')

@section('page-title', 'Manajemen Mata Kuliah')
@section('page-subtitle', 'Kelola data master mata kuliah')
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
                    <i class="bi bi-book-fill me-2"></i> Daftar Mata Kuliah
                </div>
                
                <a href="{{ route('admin.form_mata_kuliah') }}" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
                    <i class="bi bi-plus-circle-fill me-2"></i> Tambah Mata Kuliah
                </a>
            </div>

            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap: Agar tabel memanjang ke samping (scrollable) di HP --}}
                    {{-- data-table: Class wajib DataTables --}}
                    <table class="table table-hover align-middle data-table w-100 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">ID</th>
                                <th>Nama Mata Kuliah</th>
                                <th class="text-center" width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($matkul as $m)
                             <tr>
                                <td class="text-center">{{ $m->id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $m->name }}</div>
                                    @if($m->is_active == 0)
                                        <small class="text-danger fst-italic">
                                            <i class="bi bi-slash-circle"></i> Tidak Aktif
                                        </small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm" role="group">
                                       <a href="{{ route('admin.form_mata_kuliah_edit', $m->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                           <i class="bi bi-pencil-fill"></i>
                                       </a>
                                       
                                       @if ($m->is_active == 0)
                                           <a href="{{ route('admin.mata_kuliah.delete', $m->id) }}" class="btn btn-success btn-sm" title="Aktifkan" onclick="return confirm('Aktifkan mata kuliah ini?')">
                                               <i class="bi bi-check-circle"></i>
                                           </a>
                                       @else
                                           <a href="{{ route('admin.mata_kuliah.delete', $m->id) }}" class="btn btn-danger btn-sm" title="Non-aktifkan" onclick="return confirm('Non-aktifkan mata kuliah ini?')">
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