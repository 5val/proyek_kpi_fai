@extends('layouts.app')

@section('title', 'Penilaian Unit')

@section('page-title', 'Penilaian Unit Layanan')
@section('page-subtitle', 'Beri penilaian terhadap kualitas unit layanan kampus')

{{-- @section('user-name', $user->name) --}}
{{-- @section('user-role', $user->role) --}}

@section('content')
<div class="card-custom">
    <div class="card-header">
        <i class="bi bi-bank2"></i> Daftar Unit Layanan untuk Dinilai
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Unit</th>
                        <th>Status Penilaian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($units as $u)
                    <tr>
                        <td>{{ $u->name }}</td>

                        <td>
                            @if ($u->sudah_dinilai)
                                <span class="badge bg-success">Sudah Dinilai</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum Dinilai</span>
                            @endif
                        </td>

                        <td>
                            @if ($u->sudah_dinilai)
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="bi bi-check-circle"></i> Sudah Dinilai
                                </button>
                            @else
                                <a href="{{ route('penilaian.form', ['tipe' => 'unit', 'id' => $u->id]) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i> Nilai
                                </a>
                            @endif
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
