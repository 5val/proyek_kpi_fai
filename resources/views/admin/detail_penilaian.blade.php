@extends('layouts.app')

@section('title', 'Detail Penilaian')

@section('page-title', 'Detail Penilaian')
@section('page-subtitle', 'Rincian skor dan komentar dari penilaian')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')
<a href="{{ route('admin.penilaian') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
<div class="row">
    <!-- Kolom Kiri: Ringkasan & Komentar -->
    <div class="col-md-5">
        <div class="card-custom mb-4">
             <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="bi bi-info-circle-fill"></i> Ringkasan Penilaian</div>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Subjek Dinilai:</strong>
                        <span>{{ $penilaian->dinilai_user->name ?? $penilaian->dinilai->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Kategori:</strong>
                        <span>{{ $penilaian->kategori->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Periode:</strong>
                        <span>{{ $penilaian->periode->nama_periode }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Waktu Penilaian:</strong>
                        <span>{{ $penilaian->created_at }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Skor Rata-rata:</strong>
                        <span class="badge bg-primary fs-6">{{ $penilaian->avg_score }} / 5.0</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-custom">
            <div class="card-header"><i class="bi bi-chat-quote-fill"></i> Komentar Penilai</div>
            <div class="card-body">
                <p class="fst-italic">"{{ $penilaian->komentar ?? '-' }}"</p>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Rincian Skor -->
    <div class="col-md-7">
        <div class="card-custom">
            <div class="card-header"><i class="bi bi-list-stars"></i> Rincian Skor per Indikator</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Indikator Penilaian</th>
                                <th class="text-center">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($details as $detail)
                              <tr>
                                 <td>{{ $detail->indikator->name }}</td>
                                 <td class="text-center"><span class="badge bg-success">{{ $detail->score }}.0</span></td>
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
