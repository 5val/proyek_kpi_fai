@extends('layouts.app')

@section('title', 'Mata Kuliah Dosen')
@section('page-title', 'Mata Kuliah')
@section('page-subtitle', 'Daftar mata kuliah yang Anda ampu')

@section('content')
@if(session('success'))
   <div class="alert alert-success">{{ session('success') }}</div>
@endif
<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card card-custom"> {{-- Pastikan class card-custom ada CSS-nya atau pakai 'card' bawaan bootstrap --}}
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <form method="GET" action="{{ route('dosen.kelas') }}">
                            <label for="periode" class="form-label fw-bold text-secondary small text-uppercase">
                                <i class="bi bi-funnel me-1"></i> Pilih Periode Laporan
                            </label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0 text-muted">
                                    <i class="bi bi-calendar-range"></i>
                                </span>
                                <select id="periode" class="form-select border-start-0 ps-0 bg-light" name="periode_id" onchange="this.form.submit()" style="cursor: pointer;">
                                    @foreach ($all_periode as $p)
                                        <option value="{{ $p->id }}" {{ $periode_id == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_periode }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <!-- <th>Kode MK</th> -->
                        <th>Nama Mata Kuliah</th>
                        <th>Program Studi</th>
                        <th>SKS</th>
                        <th>Jumlah Mhs</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
            @forelse($kelasList as $kelas)
                <tr>
                    <!-- <td>{{ $kelas->mataKuliah->code }}</td> -->
                    <td>{{ $kelas->mataKuliah->name }}</td>
                    <td>{{ $kelas->program_studi->name }}</td>
                    <td class="text-center">{{ $kelas->sks }}</td>
                    <td class="text-center">{{ $kelas->enrollment_count }}</td>
                    <td>
                        <a href="{{ route('dosen.form_kehadiran', $kelas->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-calendar-plus-fill"></i> Input Kehadiran
                        </a>
                        @if($kelas->punya_praktikum ?? false)
                            <a href="#" class="btn btn-info btn-sm">
                                <i class="bi bi-clipboard-data"></i> Laporan Praktikum
                            </a>
                        @else
                            <a href="#" class="btn btn-secondary btn-sm disabled">
                                <i class="bi bi-clipboard-data"></i> Laporan Praktikum
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada mata kuliah yang Anda ampu.</td>
                </tr>
            @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

