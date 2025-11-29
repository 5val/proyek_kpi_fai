@extends('layouts.app')

@section('title', 'Manajemen Periode')

@section('page-title', 'Manajemen Periode')
@section('page-subtitle', 'Kelola periode akademik untuk penilaian dan kelas')
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
            
            {{-- Header: Stack di Mobile, Sebelahan di Desktop --}}
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="fw-bold fs-5">
                    <i class="bi bi-calendar-event-fill me-2"></i> Daftar Periode Akademik
                </div>
                
                <a href="{{ route('admin.periode.insert') }}" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
                    <i class="bi bi-plus-circle-fill me-2"></i> Buka Periode Baru
                </a>
            </div>

            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap: Agar tabel rapi scroll ke samping di HP --}}
                    <table class="table table-hover align-middle data-table w-100 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Periode</th>
                                <th class="text-center" width="100">Tahun</th>
                                <th class="text-center" width="150">Semester</th>
                                <th class="text-center" width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($periode as $p)
                             <tr>
                                <td class="fw-bold">{{ $p->nama_periode }}</td>
                                <td class="text-center">{{ $p->tahun }}</td>
                                <td class="text-center">
                                   <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3">{{ Str::ucfirst($p->semester) }}</span>
                                </td>
                                <td class="text-center">
                                    {{-- Logika hanya baris terakhir yang bisa dihapus --}}
                                    @if ($loop->last)
                                       <a href="{{ route('admin.periode.delete', $p->id) }}" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus periode ini? Data terkait mungkin akan hilang.')" title="Hapus Periode Terakhir">
                                           <i class="bi bi-trash-fill"></i>
                                       </a>
                                    @else
                                       <span class="text-muted small fst-italic" title="Periode lama tidak dapat dihapus demi integritas data">
                                           <i class="bi bi-lock-fill"></i> Terkunci
                                       </span>
                                    @endif
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