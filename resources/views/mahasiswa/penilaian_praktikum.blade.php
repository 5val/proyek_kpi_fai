@extends('layouts.app')

@section('title', 'Penilaian Praktikum')

@section('page-title', 'Penilaian Praktikum')
@section('page-subtitle', 'Beri penilaian untuk praktikum yang Anda ikuti')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
<div class="card-custom">
    <div class="card-header">
        <i class="bi bi-person-workspace"></i> Daftar Praktikum Semester Ini
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Mata Kuliah</th>
                        <th>Nama Praktikum</th>
                        <th>Asisten Lab</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Algoritma & Pemrograman</td>
                        <td>Dasar-dasar Python</td>
                        <td>Budi Setiawan</td>
                        <td><span class="badge bg-warning text-dark">Belum Dinilai</span></td>
                        <td><a href="{{ route('penilaian.form', 'praktikum') }}" class="btn btn-primary btn-sm">
                            Nilai
                        </a></td>
                    </tr>
                    <tr>
                        <td>Struktur Data</td>
                        <td>Implementasi Linked List</td>
                        <td>Citra Ayu</td>
                        <td><span class="badge bg-success">Sudah Dinilai</span></td>
                        <td><a href="#" class="btn btn-secondary btn-sm disabled">Dinilai</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection