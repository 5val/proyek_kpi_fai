@extends('layouts.app')

@section('title', 'Form Kelas')

@section('page-title', 'Formulir Kelas')
@section('page-subtitle', 'Buka kelas baru untuk periode akademik')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
<div class="card-custom">
    <div class="card-header"><i class="bi bi-pencil-square"></i> Form Kelas</div>
    <div class="card-body">
        @if (isset($kelas))
            <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
         @else
            <form action="{{ route('admin.kelas.insert') }}" method="POST">
         @endif
         @csrf
            <div class="mb-3">
                <label for="matkul" class="form-label">Mata Kuliah</label>
                <select class="form-select" id="matkul" name="mata_kuliah">
                    <option selected disabled>Pilih mata kuliah...</option>
                    @foreach ($matkul as $m)
                     <option value="{{ $m->id }}" {{ old('mata_kuliah', $kelas->mata_kuliah_id ?? '') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
                @error('mata_kuliah')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
            </div>
            <div class="mb-3">
                <label for="program_studi" class="form-label">Program Studi</label>
                <select class="form-select" id="program_studi" name="program_studi">
                    <option selected disabled>Pilih program studi...</option>
                    @foreach ($program_studi as $m)
                     <option value="{{ $m->id }}" {{ old('program_studi', $kelas->program_studi_id ?? '') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
                @error('program_studi')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
            </div>
             <div class="mb-3">
                <label for="periode" class="form-label">Periode Akademik</label>
                <select class="form-select" id="periode" name="periode">
                    <option selected disabled>Pilih periode...</option>
                    @foreach ($periode as $p)
                     <option value="{{ $p->id }}" {{ old('periode', $kelas->periode_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->nama_periode }}</option>
                    @endforeach
                </select>
                @error('periode')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
            </div>
             <div class="mb-3">
                <label for="dosen" class="form-label">Dosen Pengampu</label>
                <select class="form-select" id="dosen" name="dosen">
                    <option selected disabled>Pilih dosen...</option>
                    @foreach ($dosen as $d)
                     <option value="{{ $d->nidn }}" {{ old('dosen', $kelas->dosen_nidn ?? '') == $d->nidn ? 'selected' : '' }}>{{ $d->user->name ?? 'No User Linked' }}</option>
                    @endforeach
                </select>
                @error('dosen')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
            </div>
            <div class="mb-3">
                <label for="sks" class="form-label">Jumlah SKS</label>
                <input type="number" class="form-control" id="sks" placeholder="Contoh: 3" name="sks" value="{{ isset($kelas) ? $kelas->sks : old('sks') }}">
                @error('sks')
                     <p class="text-danger">{{ $message }}</p>
               @enderror
            </div>
            <div class="col-md-6 mb-3">
                  <label for="has_praktikum" class="form-label">Praktikum</label>
                  <div class="form-check">
                     <input type="checkbox" class="form-check-input" id="has_praktikum" name="has_praktikum" {{ isset($kelas) ? (($kelas->has_praktikum ?? false) ? 'checked' : '') : (old('has_praktikum') ? 'checked' : '') }}>
                     <label class="form-check-label" for="has_praktikum">
                           Ada Praktikum
                     </label>
                  </div>
                  @error('has_praktikum')
                     <p class="text-danger">{{ $message }}</p>
                  @enderror
               </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.kelas') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

