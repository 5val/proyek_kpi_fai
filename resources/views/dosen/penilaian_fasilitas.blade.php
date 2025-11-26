@extends('layouts.app')

@section('title', 'KPI Saya')

@section('page-title', 'Penilaian Fasilitas')
@section('page-subtitle', 'Beri penilaian terhadap kualitas Fasilitas kampus')

{{-- @section('user-name', $user->name) --}}
{{-- @section('user-role', $user->role) --}}

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
             <tbody>
    @foreach ($fasilitas as $f)
        {{-- LOGIKA PENGECEKAN --}}
        @php
            // Cek apakah user saat ini sudah memberikan penilaian pada fasilitas ini
            // Sesuaikan 'penilaian' dengan nama relasi di Model Fasilitas Anda
            // Contoh logika: Ambil data penilaian dimana user_id = user yang login
            $sudahDinilai = $f->penilaian->where('user_id', Auth::id())->count() > 0;
        @endphp

        <tr>
            <td>{{ $f->name }}</td>
            <td>{{ $f->lokasi }}</td>
            
            {{-- KONDISI STATUS (BADGE) --}}
            <td>
                @if($sudahDinilai)
                    <span class="badge bg-success">Sudah Dinilai</span>
                @else
                    <span class="badge bg-danger">Belum Dinilai</span>
                @endif
            </td>

            {{-- KONDISI TOMBOL --}}
            <td>
                @if($sudahDinilai)
                    {{-- Opsi 1: Tombol disable jika sudah menilai --}}
                    <button class="btn btn-secondary btn-sm" disabled>
                        <i class="bi bi-check-circle"></i> Selesai
                    </button>
                    
                    {{-- Opsi 2: Atau tombol Edit jika ingin mengubah nilai --}}
                    {{-- 
                    <a href="{{ route('penilaian.form', ['tipe' => 'fasilitas', 'id' => $f->id]) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i> Edit Nilai
                    </a> 
                    --}}
                @else
                    {{-- Tombol Nilai jika belum --}}
                    <a href="{{ route('penilaian.form', ['tipe' => 'fasilitas', 'id' => $f->id]) }}" 
                       class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square"></i> Nilai
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>

                    {{-- Jika tidak ada data --}}
                    {{-- @if ($pending->isEmpty() && $completed->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Tidak ada fasilitas terdaftar.
                            </td>
                        </tr>
                    @endif --}} 

                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
