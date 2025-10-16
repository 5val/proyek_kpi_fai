@extends('layouts.app')

@section('title', 'Formulir Penilaian Mahasiswa')

@section('page-title', 'Penilaian Mahasiswa Bimbingan')
@section('page-subtitle', 'Beri penilaian untuk Rina Wulandari (2021010015)')
@section('user-name', 'Dr. Budi Hartono, M.Kom.')
@section('user-role', 'Dosen - Teknik Informatika')
@section('user-initial', 'BH')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link active" href="#"><i class="bi bi-people"></i> Penilaian Mahasiswa</a>
    <a class="nav-link" href="#"><i class="bi bi-star-half"></i> Rating dari Mahasiswa</a>
    <a class="nav-link" href="#"><i class="bi bi-book-fill"></i> Mata Kuliah</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kinerja</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text"></i> Feedback</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header">
        <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-arrow-left"></i> Kembali</a>
        <i class="bi bi-person-check-fill"></i> Formulir Penilaian Mahasiswa
    </div>
    <div class="card-body">
        <form>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Indikator Penilaian</th>
                            <th class="text-center" style="width: 30%;">Rating (1-5 Bintang)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $indicators = ['Kemajuan Studi & IPK', 'Keaktifan dalam Bimbingan', 'Inisiatif dan Kemandirian', 'Pengumpulan Tugas Tepat Waktu', 'Etika dan Sikap'];
                        @endphp
                        @foreach($indicators as $index => $indicator)
                        <tr>
                            <td>{{ $indicator }}</td>
                            <td class="text-center">
                                <div class="rating">
                                    @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating-{{ $index }}" id="rating-{{ $index }}-{{ $i }}" value="{{ $i }}">
                                    <label for="rating-{{ $index }}-{{ $i }}"><i class="bi bi-star-fill"></i></label>
                                    @endfor
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
             <div class="mt-3">
                <label for="feedback" class="form-label">Catatan untuk Mahasiswa</label>
                <textarea class="form-control" id="feedback" rows="4" placeholder="Berikan catatan atau saran untuk pengembangan mahasiswa..."></textarea>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-send-check"></i> Kirim Penilaian</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .rating { display: inline-block; direction: rtl; }
    .rating input { display: none; }
    .rating label { font-size: 1.5rem; color: #ddd; cursor: pointer; transition: color 0.2s; }
    .rating input:checked ~ label, .rating label:hover, .rating label:hover ~ label { color: #ffc107; }
</style>
@endpush

