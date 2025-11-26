@extends('layouts.app')

@section('title', 'Penilaian Unit')

@section('page-title', 'Penilaian Unit Layanan')
@section('page-subtitle', 'Beri penilaian terhadap kualitas unit layanan kampus')
@section('user-name', 'Dr. Budi Hartono, M.Kom.')
@section('user-role', 'Dosen - Teknik Informatika')
@section('user-initial', 'BH')

@section('content')
<div class="card-custom">
    <div class="card-header"><i class="bi bi-bank2"></i> Daftar Unit Layanan untuk Dinilai</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Unit</th>
                        <th>Deskripsi</th>
                        <th>Status Penilaian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                     <tr>
                        <td>Biro Administrasi Akademik (BAA)</td>
                        <td>Layanan administrasi akademik dan perkuliahan</td>
                        <td><span class="badge bg-success">Sudah Dinilai</span></td>
                        <td><button class="btn btn-secondary btn-sm" disabled><i class="bi bi-check-circle"></i> Nilai</button></td>
                    </tr>
                    <tr>
                        <td>Biro Administrasi Keuangan (BAK)</td>
                        <td>Layanan administrasi keuangan dan pembayaran</td>
                         <td><span class="badge bg-danger">Belum Dinilai</span></td>
                        <td><button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Nilai</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
