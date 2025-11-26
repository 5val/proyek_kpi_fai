@extends('layouts.app')

@section('title', 'Penilaian Mahasiswa')

@section('page-title', 'Penilaian Mahasiswa Bimbingan')
@section('page-subtitle', 'Berikan penilaian kinerja untuk mahasiswa bimbingan Anda')

@section('user-name', $user->name)
@section('user-role', $user->role)

@section('content')
<div class="card-custom">
    <div class="card-header"><i class="bi bi-list-check"></i> Daftar Mahasiswa Bimbingan</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <th>NRP</th>
                        <th>Semester</th>
                        <th>Status Penilaian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswaList as $m)
                        <tr>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->nrp }}</td>
                            <td>{{ $m->semester }}</td>
                            <td>
                                @if($m->penilaian)
                                    <span class="badge bg-success">Sudah Dinilai</span>
                                @else
                                    <span class="badge bg-danger">Belum Dinilai</span>
                                @endif
                            </td>
                            <td>
                                @if($m->penilaian)
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="bi bi-pencil-square"></i> Nilai
                                    </button>
                                @else
                                    <a href="{{ route('dosen.nilai_mahasiswa', $m->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i> Nilai
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada mahasiswa bimbingan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
