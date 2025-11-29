@extends('layouts.app')

@section('title', 'Detail Enrollment')

@section('page-title', 'Detail Enrollment Kelas')
@section('page-subtitle', 'Daftar mahasiswa terdaftar di kelas ' . ($kelas->mataKuliah->name ?? ''))
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
            
            {{-- Header Responsif: Judul di atas, Tombol di bawah saat Mobile --}}
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="fw-bold fs-5">
                    <i class="bi bi-people-fill me-2"></i> Daftar Mahasiswa Kelas
                </div>
                
                {{-- Group Tombol --}}
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <a href="{{ route('admin.kelas') }}" class="btn btn-secondary btn-sm d-flex align-items-center justify-content-center">
                        <i class="bi bi-arrow-left me-2"></i> Kembali
                    </a>
                    <a href="{{ route('admin.form_enrollment', $kelas->id) }}" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Enrollment
                    </a>
                </div>
            </div>

            <div class="card-body p-3 p-md-4">
                {{-- Info Kelas Card --}}
                <div class="p-3 mb-4 rounded bg-light border border-start border-primary shadow-sm">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="fw-bold text-dark mb-2">{{ $kelas->mataKuliah->name }}</h5>
                            <div class="row g-2 text-muted small">
                                <div class="col-12 col-md-4">
                                    <i class="bi bi-mortarboard-fill me-1"></i> <strong>Prodi:</strong> {{ $kelas->program_studi->name }}
                                </div>
                                <div class="col-12 col-md-4">
                                    <i class="bi bi-person-video3 me-1"></i> <strong>Dosen:</strong> {{ $kelas->dosen->user->name }}
                                </div>
                                <div class="col-12 col-md-4">
                                    <i class="bi bi-calendar-event me-1"></i> <strong>Periode:</strong> {{ $kelas->periode->nama_periode }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    {{-- text-nowrap: Mencegah teks turun baris di mobile, scroll horizontal aktif --}}
                    <table class="table table-hover align-middle w-100 text-nowrap data-table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="15%">NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Program Studi</th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @forelse ($enrollments as $index => $e)
                              <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-bold font-monospace">{{ $e->mahasiswa_nrp }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $e->mahasiswa->user->name ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark bg-opacity-25 border border-info px-2 rounded-pill">
                                        {{ $e->mahasiswa->program_studi->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                   <a href="{{ route('admin.enrollment.delete', [$e->kelas_id, $e->id]) }}" 
                                      class="btn btn-danger btn-sm shadow-sm" 
                                      onclick="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini dari kelas?')"
                                      title="Hapus">
                                      <i class="bi bi-trash-fill"></i>
                                   </a>
                                </td>
                              </tr>
                          @empty
                              <tr>
                                 <td colspan="5" class="text-center py-5 text-muted d-none"></td>
                                 <td colspan="5" class="text-center py-5 text-muted d-none"></td>
                                 <td colspan="5" class="text-center py-5 text-muted d-none"></td>
                                 <td colspan="5" class="text-center py-5 text-muted d-none"></td>
                                  <td colspan="5" class="text-center py-5 text-muted">
                                      <div class="d-flex flex-column align-items-center">
                                          <i class="bi bi-people fs-1 mb-2 opacity-25"></i>
                                          <p class="mb-0 fw-bold">Belum ada mahasiswa</p>
                                          <small>Silakan klik tombol "Tambah Enrollment" di atas.</small>
                                      </div>
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