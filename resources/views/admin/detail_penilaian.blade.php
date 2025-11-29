@extends('layouts.app')

@section('title', 'Detail Penilaian')

@section('page-title', 'Detail Penilaian')
@section('page-subtitle', 'Rincian skor dan komentar dari penilaian')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')

{{-- Tombol Kembali Utama --}}
<div class="mb-3">
    <a href="{{ route('admin.penilaian') }}" class="btn btn-secondary btn-sm px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="row g-4"> <div class="col-12 col-lg-5">
        <div class="card card-custom shadow-sm border-0 mb-4 h-100">
             <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div class="fw-bold">
                    <i class="bi bi-info-circle-fill me-2"></i> Ringkasan Penilaian
                </div>
                {{-- Tombol kembali kecil disembunyikan di mobile agar header tidak penuh --}}
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm d-none d-md-inline-block">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                        <strong class="text-muted small text-uppercase">Subjek Dinilai</strong>
                        <span class="fw-bold text-end text-break ms-3">
                            {{ $penilaian->dinilai_user->name ?? $penilaian->dinilai->name }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                        <strong class="text-muted small text-uppercase">Kategori</strong>
                        <span class="text-end ms-3">{{ $penilaian->kategori->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                        <strong class="text-muted small text-uppercase">Periode</strong>
                        <span class="text-end ms-3">{{ $penilaian->periode->nama_periode }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                        <strong class="text-muted small text-uppercase">Waktu Penilaian</strong>
                        <span class="text-end ms-3">{{ \Carbon\Carbon::parse($penilaian->created_at)->format('d M Y, H:i') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 bg-light rounded mt-2">
                        <strong class="text-dark">Skor Rata-rata</strong>
                        <span class="badge bg-primary fs-6 rounded-pill px-3">{{ $penilaian->avg_score }} / 5.0</span>
                    </li>
                </ul>

                <div class="mt-4">
                    <div class="d-flex align-items-center mb-2 text-muted">
                        <i class="bi bi-chat-quote-fill me-2"></i> 
                        <span class="fw-bold small text-uppercase">Komentar Penilai</span>
                    </div>
                    <div class="p-3 bg-light rounded border">
                        {{-- text-break: Mencegah layout rusak jika komentar sangat panjang tanpa spasi --}}
                        <p class="fst-italic mb-0 text-break text-secondary">
                            "{{ $penilaian->komentar ?? 'Tidak ada komentar tambahan.' }}"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-7">
        <div class="card card-custom shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-list-stars me-2"></i> Rincian Skor per Indikator
            </div>
            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Indikator Penilaian</th>
                                <th class="text-center" style="width: 100px;">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($details as $detail)
                              <tr>
                                 <td class="ps-3 py-3">
                                     {{ $detail->indikator->name }}
                                 </td>
                                 <td class="text-center py-3">
                                     @if($detail->score >= 4)
                                        <span class="badge bg-success fs-6 rounded-pill w-75">{{ $detail->score }}.0</span>
                                     @elseif($detail->score >= 3)
                                        <span class="badge bg-primary fs-6 rounded-pill w-75">{{ $detail->score }}.0</span>
                                     @elseif($detail->score >= 2)
                                        <span class="badge bg-warning text-dark fs-6 rounded-pill w-75">{{ $detail->score }}.0</span>
                                     @else
                                        <span class="badge bg-danger fs-6 rounded-pill w-75">{{ $detail->score }}.0</span>
                                     @endif
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection