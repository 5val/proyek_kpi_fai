@extends('layouts.app')

{{-- Menggunakan variabel dari Controller untuk judul halaman --}}
@section('title', $data['pageTitle'] ?? 'Detail Data')
@section('page-title', $data['pageTitle'] ?? 'Detail Data')
@section('page-subtitle', $data['pageSubtitle'] ?? 'Daftar lengkap data sistem')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            {{-- Header Responsif: flex-wrap agar tombol turun ke bawah jika layar sempit --}}
            <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="fw-bold fs-5">
                    <i class="bi bi-list-ul me-1"></i> {{ $data['tableTitle'] ?? 'Data List' }}
                </div>
                
                <div>
                    {{-- Tombol Kembali --}}
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm px-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-0 p-md-3">
                {{-- Table Responsive Wrapper --}}
                <div class="table-responsive">
                    {{-- text-nowrap: Mencegah teks gepeng di mobile, user scroll ke samping --}}
                    <table class="table table-hover align-middle data-table w-100 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px" class="text-center">No</th>
                                {{-- Render Header Kolom Dinamis --}}
                                @foreach($data['headers'] as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['items'] as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    
                                    {{-- Render Isi Kolom Dinamis --}}
                                    @foreach($data['keys'] as $key)
                                        <td>
                                            {{-- Logika khusus untuk formatting --}}
                                            @if($key === 'status')
                                                @if($item[$key] == 'Sudah Ditanggapi' || $item[$key] == 'Aktif' || $item[$key] == 1)
                                                    <span class="badge bg-success rounded-pill">{{ $item[$key] }}</span>
                                                @else
                                                    <span class="badge bg-warning text-dark rounded-pill">{{ $item[$key] }}</span>
                                                @endif
                                            @elseif($key === 'avg_kpi')
                                                @if($item[$key] < 3.0)
                                                    <span class="text-danger fw-bold">{{ number_format($item[$key], 1) }}</span>
                                                @elseif($item[$key] >= 4.0)
                                                    <span class="text-success fw-bold">{{ number_format($item[$key], 1) }}</span>
                                                @else
                                                    <span class="text-dark fw-bold">{{ number_format($item[$key], 1) }}</span>
                                                @endif
                                            @else
                                                {!! $item[$key] ?? '<span class="text-muted fst-italic">-</span>' !!}
                                            @endif
                                        </td>
                                    @endforeach

                                    @if (isset($data['actionType']))
                                        <td class="text-center">
                                            @if($data['actionType'] == 'detail')
                                                <a href="{{ route('admin.detail_penilaian', $item['id']) }}" class="btn btn-info btn-sm text-white shadow-sm" title="Detail">
                                                    <i class="bi bi-eye"></i> <span class="d-none d-md-inline">Detail</span>
                                                </a>
                                            @elseif($data['actionType'] == 'feedback')
                                                <a href="{{ route('admin.feedback.detail', $item['id']) }}" class="btn btn-info btn-sm text-white shadow-sm" title="Detail">
                                                    <i class="bi bi-eye"></i> <span class="d-none d-md-inline">Detail</span>
                                                </a>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    {{-- Colspan dinamis + margin error --}}
                                    <td colspan="{{ count($data['headers']) + 2 }}" class="text-center py-5 text-muted">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-folder-x fs-1 mb-2 opacity-25"></i>
                                            <p class="mb-0 fw-bold">Tidak ada data ditemukan</p>
                                            <small class="text-muted">Data untuk kategori ini belum tersedia saat ini.</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection