@extends('layouts.app')

@section('title', 'Formulir Penilaian - ' . ucfirst($tipe))
@section('page-title', 'Penilaian - ' . ucfirst($tipe))
@section('page-subtitle', 'Beri penilaian untuk: ' . $targetName)
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
<div class="container-fluid px-0"> @if (session('success'))
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

    <div class="card card-custom shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Kembali</span>
                </a>
                <h5 class="mb-0 ms-2 text-truncate">
                    <i class="bi bi-building me-1"></i> Formulir Penilaian {{ ucfirst($tipe) }}
                </h5>
            </div>
        </div>
        
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('penilaian.store', ['tipe' => $tipe, 'id' => $id]) }}" method="POST">
                @csrf
                
                <div class="table-responsive">
                    <table class="table mobile-table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60%;">Indikator Penilaian</th>
                                <th class="text-center" style="width: 40%;">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($indikator as $i)
                            <tr>
                                <td class="question-cell">
                                    <span class="fw-medium">{{ $i->name }}</span>
                                </td>
                                <td class="text-center rating-cell">
                                    <div class="rating-wrapper">
                                        <div class="rating">
                                            <input type="radio" name="rating[{{ $i->id }}]" id="star4-{{ $i->id }}" value="4" required>
                                            <label for="star4-{{ $i->id }}" title="Sangat Baik"><i class="bi bi-star-fill"></i></label>

                                            <input type="radio" name="rating[{{ $i->id }}]" id="star3-{{ $i->id }}" value="3">
                                            <label for="star3-{{ $i->id }}" title="Baik"><i class="bi bi-star-fill"></i></label>

                                            <input type="radio" name="rating[{{ $i->id }}]" id="star2-{{ $i->id }}" value="2">
                                            <label for="star2-{{ $i->id }}" title="Cukup"><i class="bi bi-star-fill"></i></label>

                                            <input type="radio" name="rating[{{ $i->id }}]" id="star1-{{ $i->id }}" value="1">
                                            <label for="star1-{{ $i->id }}" title="Kurang"><i class="bi bi-star-fill"></i></label>
                                        </div>
                                        <div class="rating-text d-block d-md-none text-muted small mt-1">Pilih Bintang</div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <label for="feedback" class="form-label fw-bold">Laporan / Masukan (Opsional)</label>
                    <textarea class="form-control" name="feedback" id="feedback" rows="4" placeholder="Tuliskan kritik, saran, atau laporan kerusakan di sini..."></textarea>
                </div>

                <hr class="my-4">
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-send-check me-2"></i> Kirim Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* === Base Rating Styles === */
    .rating { 
        display: inline-flex; 
        flex-direction: row-reverse; /* Agar urutan hover benar 1-4 */
        justify-content: center;
        align-items: center;
    }
    .rating input { display: none; }
    .rating label { 
        font-size: 1.8rem; /* Ukuran default */
        color: #e4e5e9; 
        cursor: pointer; 
        padding: 0 5px; /* Jarak antar bintang */
        transition: all 0.2s;
    }
    /* Warna saat di-check atau di-hover */
    .rating input:checked ~ label, 
    .rating label:hover, 
    .rating label:hover ~ label { 
        color: #ffc107; 
        transform: scale(1.1); /* Efek membesar sedikit */
    }

    /* === Mobile Responsive Table Styles === */
    @media (max-width: 768px) {
        /* Sembunyikan Header Tabel Asli */
        .mobile-table thead {
            display: none;
        }

        /* Ubah Baris Tabel menjadi Blok (Card) */
        .mobile-table tbody tr {
            display: block;
            margin-bottom: 15px;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            padding: 15px;
        }

        /* Ubah Kolom Tabel menjadi Blok bertumpuk */
        .mobile-table tbody td {
            display: block;
            border: none;
            padding: 5px 0;
            width: 100% !important; /* Paksa lebar penuh */
        }

        /* Styling Kolom Pertanyaan */
        .mobile-table .question-cell {
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 1px dashed #eee;
            margin-bottom: 10px;
            padding-bottom: 10px !important;
            text-align: center; /* Center text di HP */
        }

        /* Styling Kolom Rating */
        .mobile-table .rating-cell {
            text-align: center;
        }

        /* Perbesar Bintang di HP agar mudah disentuh */
        .rating label {
            font-size: 2.2rem; 
            padding: 0 8px;
        }
        
        /* Layout Tombol Kirim Penuh di HP */
        .btn-primary {
            width: 100%;
            padding: 12px;
        }
    }
</style>
@endpush