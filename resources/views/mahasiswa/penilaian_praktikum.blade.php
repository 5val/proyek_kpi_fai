@extends('layouts.app')

@section('title', 'Penilaian Praktikum')

@section('page-title', 'Penilaian Praktikum')
@section('page-subtitle', 'Beri penilaian untuk praktikum yang Anda ikuti')
@section('user-name', '')
@section('user-role', '')
@section('user-initial', '')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-12">
        <div class="card card-custom shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-person-workspace me-2"></i> Daftar Praktikum Semester Ini
            </div>
            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap: Agar tabel rapi scroll ke samping di HP --}}
                    <table class="table table-hover align-middle w-100 text-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Praktikum</th>
                                <th>Dosen Pengampu</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($praktikumList as $p)
                                <tr>
                                    {{-- Batasi lebar kolom Nama Praktikum --}}
                                    <td style="max-width: 250px;" class="text-truncate" title="{{ $p->mataKuliah->nama }}">
                                        <div class="fw-bold">{{ $p->mataKuliah->nama }}</div>
                                        <small class="text-muted d-block">
                                            <i class="bi bi-code-slash me-1"></i> Laboratorium Komputer
                                        </small>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-1 me-2 d-none d-md-block">
                                                <i class="bi bi-person text-secondary"></i>
                                            </div>
                                            {{ $p->dosen->user->name }}
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        {{-- Logika Badge (Contoh) --}}
                                        <span class="badge bg-warning text-dark border border-warning bg-opacity-25 rounded-pill px-3">
                                            Belum Dinilai
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <a href="{{ route('penilaian.form', ['tipe' => 'praktikum', 'id' => $p->id]) }}" class="btn btn-primary btn-sm shadow-sm rounded-pill px-3">
                                            <i class="bi bi-pencil-square me-1"></i> Nilai
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-journal-x fs-1 d-block mb-2 opacity-25"></i>
                                        <p class="mb-0 fw-bold">Tidak ada praktikum aktif</p>
                                        <small>Anda belum terdaftar di kelas praktikum manapun semester ini.</small>
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