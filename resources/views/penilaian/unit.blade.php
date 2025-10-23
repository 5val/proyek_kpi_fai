@extends('layouts.app')

@section('title', 'Formulir Penilaian Unit')

@section('page-title', 'Penilaian Unit Layanan')
@section('page-subtitle', 'Beri penilaian untuk Biro Administrasi Keuangan (BAK)')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('sidebar-menu')
    {{-- Sidebar menu can be dynamically included based on user role --}}
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link active" href="#"><i class="bi bi-bank2"></i> Penilaian Unit</a>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-header">
        <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-arrow-left"></i> Kembali</a>
        <i class="bi bi-bank2"></i> Formulir Penilaian Unit Layanan
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
                            $indicators = ['Kecepatan Respon Layanan', 'Keramahan dan Sikap Petugas', 'Kejelasan Informasi yang Diberikan', 'Kemudahan Prosedur Layanan', 'Solusi dan Bantuan yang Diberikan'];
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
                <label for="feedback" class="form-label">Saran untuk Peningkatan Layanan (Opsional)</label>
                <textarea class="form-control" id="feedback" rows="4" placeholder="Berikan saran spesifik untuk perbaikan layanan..."></textarea>
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
