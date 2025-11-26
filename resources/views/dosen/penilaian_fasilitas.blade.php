@extends('layouts.app')

@section('title', 'KPI Saya')

@section('page-title', 'Penilaian Fasilitas')
@section('page-subtitle', 'Beri penilaian terhadap kualitas Fasilitas kampus')

@section('user-name', $user->name)
@section('user-role', $user->role)

@section('content')
<div class="card-custom">
    <div class="card-header">
        <i class="bi bi-building"></i> Daftar Fasilitas untuk Dinilai
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Fasilitas</th>
                        <th>Lokasi</th>
                        <th>Status Penilaian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- ========================
                         FASILITAS SUDAH DINILAI
                    ========================= --}}
                    @foreach ($completed as $item)
                        <tr>
                            <td>{{ $item->fasilitas->name }}</td>
                            <td>{{ $item->fasilitas->lokasi }}</td>
                            <td>
                                <span class="badge bg-success">Sudah Dinilai</span>
                            </td>
                            <td>
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="bi bi-check-circle"></i> Nilai
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    {{-- ========================
                         FASILITAS BELUM DINILAI
                    ========================= --}}
                    @foreach ($pending as $fasilitas)
                        <tr>
                            <td>{{ $fasilitas->name }}</td>
                            <td>{{ $fasilitas->lokasi }}</td>
                            <td>
                                <span class="badge bg-danger">Belum Dinilai</span>
                            </td>
                            <td>
                                <a href="{{ route('dosen.penilaian_fasilitas.form', $fasilitas->id) }}"
                                   class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i> Nilai
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    {{-- Jika tidak ada data --}}
                    @if ($pending->isEmpty() && $completed->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Tidak ada fasilitas terdaftar.
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
