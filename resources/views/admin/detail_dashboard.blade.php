@extends('layouts.app')

{{-- Menggunakan variabel dari Controller untuk judul halaman --}}
@section('title', $data['pageTitle'] ?? 'Detail Data')
@section('page-title', $data['pageTitle'] ?? 'Detail Data')
@section('page-subtitle', $data['pageSubtitle'] ?? 'Daftar lengkap data sistem')

{{-- Sidebar sudah otomatis ditangani oleh layouts.app (tidak perlu didefinisikan lagi) --}}

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-custom">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-list-ul"></i> {{ $data['tableTitle'] ?? 'Data List' }}
                </div>
                
                <div class="d-flex gap-2">
                    {{-- Tombol Kembali --}}
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle data-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px">No</th>
                                {{-- Render Header Kolom Dinamis --}}
                                @foreach($data['headers'] as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['items'] as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    
                                    {{-- Render Isi Kolom Dinamis --}}
                                    @foreach($data['keys'] as $key)
                                        <td>
                                            {{-- Logika khusus untuk formatting (bisa disesuaikan) --}}
                                            @if($key === 'status')
                                                @if($item[$key] == 'Sudah Ditanggapi' || $item[$key] == 'Aktif' || $item[$key] == 1)
                                                    <span class="badge bg-success">{{ $item[$key] }}</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">{{ $item[$key] }}</span>
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
                                                {!! $item[$key] ?? '<span class="text-muted">-</span>' !!}
                                            @endif
                                        </td>
                                    @endforeach

                                    @if (isset($data['actionType']) && $data['actionType'] == 'detail')
                                    <td>
                                       <a href="{{ route('admin.detail_penilaian', $item['id']) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                          <i class="bi bi-eye"></i> Detail
                                       </a>
                                    </td>
                                    @elseif(isset($data['actionType']) && $data['actionType'] == 'feedback')
                                    <td>
                                       <a href="{{ route('admin.feedback.detail', $item['id']) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                          <i class="bi bi-eye"></i> Detail
                                       </a>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($data['headers']) + 2 }}" class="text-center py-5 text-muted">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-folder2-open fs-1 mb-2 opacity-50"></i>
                                            <p class="mb-0 fw-bold">Tidak ada data ditemukan</p>
                                            <small>Data untuk kategori ini belum tersedia.</small>
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