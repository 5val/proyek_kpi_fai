@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('page-title', 'Manajemen Kelas')
@section('page-subtitle', 'Kelola kelas yang dibuka setiap periode')
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
                    <i class="bi bi-easel-fill me-2"></i> Daftar Kelas
                </div>
                
                {{-- Area Filter & Tombol --}}
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <form action="{{ route('admin.kelas') }}" method="GET" class="d-flex align-items-center">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="bi bi-calendar-event"></i></span>
                            <select class="form-select border-secondary-subtle" name="periode_id" id="periodeFilter" onchange="this.form.submit()">
                                <option value={{ null }} @if (!request('periode_id')) selected @endif>Semua Periode</option>
                                @foreach ($all_periode as $p)
                                    <option value={{ $p->id }} {{ request('periode_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_periode }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <a href="{{ route('admin.form_kelas') }}" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
                        <i class="bi bi-plus-circle-fill me-2"></i> 
                        <span class="text-nowrap">Buka Kelas Baru</span>
                    </a>
                </div>
            </div>

            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap: Agar tabel memanjang ke samping (scrollable) di HP --}}
                    <table class="table table-hover align-middle data-table w-100 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">#</th>
                                <th>Mata Kuliah</th>
                                <th>Program Studi</th>
                                <th>Dosen Pengampu</th>
                                <th>Periode</th>
                                <th class="text-center">Jml Mhs</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($kelas as $k)
                             <tr>
                                <td class="text-center">{{ $k->id }}</td>
                                
                                {{-- Batasi lebar kolom Matkul --}}
                                <td style="max-width: 200px;" class="text-truncate" title="{{ $k->mataKuliah->name }}">
                                    <div class="fw-bold">{{ $k->mataKuliah->name }}</div>
                                    @if($k->is_active == 0)
                                        <small class="text-danger fst-italic"><i class="bi bi-slash-circle"></i> Tidak Aktif</small>
                                    @endif
                                </td>
                                
                                <td><span class="badge bg-info text-dark bg-opacity-25 border border-info">{{ $k->program_studi->name }}</span></td>
                                <td>{{ $k->dosen->user->name ?? '<span class="text-muted fst-italic">Belum ditentukan</span>' }}</td>
                                <td>{{ $k->periode->nama_periode }}</td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill px-3">{{ $k->enrollment_count }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm" role="group">
                                       <a href="{{ route('admin.form_kelas_edit', $k->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                           <i class="bi bi-pencil-fill"></i>
                                       </a>
                                       @if ($k->is_active == 0)
                                           <a href="{{ route('admin.kelas.delete', $k->id) }}" class="btn btn-success btn-sm" title="Aktifkan" onclick="return confirm('Aktifkan kelas ini?')">
                                               <i class="bi bi-check-circle"></i>
                                           </a>
                                       @else
                                           <a href="{{ route('admin.kelas.delete', $k->id) }}" class="btn btn-danger btn-sm" title="Non-aktifkan" onclick="return confirm('Non-aktifkan kelas ini?')">
                                               <i class="bi bi-x-circle"></i>
                                           </a>
                                       @endif
                                       <a href="{{ route('admin.enrollment', $k->id) }}" class="btn btn-info btn-sm text-white" title="Detail Enrollment">
                                           <i class="bi bi-people-fill"></i>
                                       </a>
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