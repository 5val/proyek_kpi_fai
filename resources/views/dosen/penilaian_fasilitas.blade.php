@extends('layouts.app')

@section('title', 'Penilaian Fasilitas')

@section('page-title', 'Penilaian Fasilitas')
@section('page-subtitle', 'Beri penilaian terhadap kualitas fasilitas kampus')
@section('user-name', 'Dr. Budi Hartono, M.Kom.')
@section('user-role', 'Dosen - Teknik Informatika')
@section('user-initial', 'BH')

@section('content')
<div class="card-custom">
    <div class="card-header"><i class="bi bi-building"></i> Daftar Fasilitas untuk Dinilai</div>
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
                    <tr>
                        <td>Perpustakaan Pusat</td>
                        <td>Gedung Rektorat Lt. 3</td>
                        <td><span class="badge bg-success">Sudah Dinilai</span></td>
                        <td><button class="btn btn-secondary btn-sm" disabled><i class="bi bi-check-circle"></i> Nilai</button></td>
                    </tr>
                    <tr>
                        <td>Laboratorium Komputer Jaringan</td>
                        <td>Gedung A Lt. 2</td>
                        <td><span class="badge bg-danger">Belum Dinilai</span></td>
                        <td><button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Nilai</button></td>
                    </tr>
                    <tr>
                        <td>Ruang Dosen</td>
                        <td>Gedung B Lt. 1</td>
                        <td><span class="badge bg-danger">Belum Dinilai</span></td>
                        <td><button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Nilai</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
