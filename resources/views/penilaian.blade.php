@extends('layouts.app')

@section('title', 'Formulir Penilaian - ' . ucfirst($tipe))

@section('page-title', 'Penilaian - ' . ucfirst($tipe))

@section('page-subtitle', 'Beri penilaian untuk: ' . $targetName)
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="card-custom">
    <div class="card-header">
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm me-2"><i class="bi bi-arrow-left"></i> Kembali</a>
        <i class="bi bi-building"></i> Formulir Penilaian {{ ucfirst($tipe) }}
    </div>
    <div class="card-body">
        <form action="{{ route('penilaian.store', ['tipe' => $tipe, 'id' => $id]) }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Indikator Penilaian</th>
                            <th class="text-center">Rating (1-4 Bintang)</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($indikator as $i)
                        <tr>
                            <td>{{ $i->name }}</td>
                            <td class="text-center">
                                <div class="rating">
                                    <input type="radio" name="rating[{{ $i->id }}]" id="star4-{{ $i->id }}" value="4">
                                    <label for="star4-{{ $i->id }}"><i class="bi bi-star-fill"></i></label>

                                    <input type="radio" name="rating[{{ $i->id }}]" id="star3-{{ $i->id }}" value="3">
                                    <label for="star3-{{ $i->id }}"><i class="bi bi-star-fill"></i></label>

                                    <input type="radio" name="rating[{{ $i->id }}]" id="star2-{{ $i->id }}" value="2">
                                    <label for="star2-{{ $i->id }}"><i class="bi bi-star-fill"></i></label>

                                    <input type="radio" name="rating[{{ $i->id }}]" id="star1-{{ $i->id }}" value="1">
                                    <label for="star1-{{ $i->id }}"><i class="bi bi-star-fill"></i></label>
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
