@extends('layouts.app')

@section('title', 'Formulir Penilaian Fasilitas')

@section('page-title', 'Penilaian Fasilitas')
@section('page-subtitle', 'Beri penilaian untuk Laboratorium Komputer Jaringan')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
<div class="card-custom">
    <div class="card-header">
        <a href="#" class="btn btn-secondary btn-sm me-2"><i class="bi bi-arrow-left"></i> Kembali</a>
        <i class="bi bi-building"></i> Formulir Penilaian Fasilitas
    </div>
    <div class="card-body">
        <form>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Indikator Penilaian</th>
                            <th class="text-center">Rating (1-4 Bintang)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $indicators = ['Kebersihan dan Kerapian', 'Kelengkapan Peralatan', 'Kondisi Peralatan (Fungsionalitas)', 'Kenyamanan Ruangan', 'Ketersediaan Akses (Internet/Listrik)'];
                        @endphp
                        @foreach($indicators as $index => $indicator)
                        <tr>
                            <td>{{ $indicator }}</td>
                            <td class="text-center">
                                <div class="rating">
                                    @for($i = 4; $i >= 1; $i--)
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
                <label for="feedback" class="form-label">Laporan Kerusakan atau Masukan Lainnya (Opsional)</label>
                <textarea class="form-control" id="feedback" rows="4" placeholder="Jika ada kerusakan atau saran, mohon jelaskan di sini..."></textarea>
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
