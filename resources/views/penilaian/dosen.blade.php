@extends('layouts.app')

@section('title', 'Formulir Penilaian Dosen')

@section('page-title', 'Penilaian Kinerja Dosen')
@section('page-subtitle', 'Beri penilaian untuk Dr. Budi Hartono, M.Kom. - Mata Kuliah Kecerdasan Buatan')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="#"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link active" href="#"><i class="bi bi-star"></i> Penilaian Dosen</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text"></i> Feedback</a>
    <a class="nav-link" href="#"><i class="bi bi-bar-chart"></i> Laporan KPI</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header">
        <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-arrow-left"></i> Kembali</a>
        <i class="bi bi-star-fill"></i> Formulir Penilaian Dosen
    </div>
    <div class="card-body">
        <form>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Indikator Penilaian</th>
                            <th class="text-center">Rating (1-5 Bintang)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $indicators = ['Penguasaan Materi', 'Kejelasan dalam Menyampaikan Materi', 'Kemampuan Memberi Motivasi', 'Kedisiplinan Waktu', 'Keadilan dalam Penilaian'];
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
                <label for="feedback" class="form-label">Komentar atau Masukan (Opsional)</label>
                <textarea class="form-control" id="feedback" rows="4" placeholder="Berikan masukan yang membangun..."></textarea>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-send-check"></i> Kirim Penilaian</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .rating {
        display: inline-block;
        direction: rtl;
    }
    .rating input {
        display: none;
    }
    .rating label {
        font-size: 1.5rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }
    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
        color: #ffc107;
    }
</style>
@endpush
