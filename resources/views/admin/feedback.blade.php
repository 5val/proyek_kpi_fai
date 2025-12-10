@extends('layouts.app')

@section('title', 'Daftar Feedback')

@section('page-title', 'Daftar Feedback')
@section('page-subtitle', 'Kelola semua feedback yang masuk dari pengguna')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('content')

@if(session('success'))
   <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
       <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card card-custom shadow-sm border-0">
            
            {{-- Header: Stack vertikal di Mobile, Horizontal di Desktop --}}
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="fw-bold fs-5">
                    <i class="bi bi-chat-left-text-fill me-2"></i> Daftar Feedback Masuk
                </div>
                
                {{-- Area Filter --}}
                <div class="w-100 w-md-auto">
                    <form action="{{ route('admin.feedback') }}" method="GET" class="d-flex flex-column flex-sm-row gap-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="bi bi-funnel"></i></span>
                            <select class="form-select border-secondary-subtle" name="kategori_id" id="kategoriFilter" onchange="this.form.submit()">
                                <option value="" @if (request('kategori_id') == null) selected @endif>Semua Kategori</option>
                                @foreach ($all_kategori as $k)
                                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="bi bi-check2-circle"></i></span>
                            <select class="form-select border-secondary-subtle" name="status" id="periodeFilter" onchange="this.form.submit()">
                                <option value="" @if (request('status') == null) selected @endif>Semua Status</option>
                                <option value="1" {{ request('status') == "1" ? 'selected' : '' }}>Sudah Ditanggapi</option>
                                <option value="0" {{ request('status') == "0" ? 'selected' : '' }}>Belum Ditanggapi</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body p-0 p-md-3">
                <div class="table-responsive">
                    {{-- text-nowrap: Agar tabel memanjang ke samping (scrollable) di HP --}}
                    <table class="table table-hover align-middle data-table w-100 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th>Pengirim</th>
                                <th>Isi Feedback</th>
                                <th>Kategori</th>
                                <th>Target</th>
                                <th>Tanggal</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @forelse ($feedbacks as $feedback)
                             <tr>
                                <td class="text-center">{{ $feedback->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                       @if ($feedback->is_anonymous == 1)
                                          <span class="fst-italic text-muted">Anonim</span>
                                       @else
                                          {{ $feedback->pengirim->name }}
                                       @endif
                                    </div>
                                </td>
                                
                                {{-- Batasi lebar kolom isi dan potong teks jika terlalu panjang --}}
                                <td style="max-width: 250px;" class="text-truncate" title="{{ $feedback->isi }}">
                                    {{ $feedback->isi }}
                                </td>
                                
                                <td><span class="badge bg-info text-dark bg-opacity-25 border border-info">{{ $feedback->kategori->name }}</span></td>
                                <td>{{ $feedback->target_user->name ?? $feedback->target->name ?? "{$feedback->target_user->mata_kuliah->name} - {$feedback->target_user->program_studi->name}" }}</td>
                                <td>
                                    <span class="small text-muted">{{ $feedback->created_at->format('d M Y') }}</span><br>
                                    <span class="small fw-bold">{{ $feedback->created_at->format('H:i') }}</span>
                                </td>
                                <td class="text-center">
                                    @if ($feedback->status == 1)
                                       <span class="badge bg-success rounded-pill px-3">Sudah Ditanggapi</span>
                                    @else
                                       <span class="badge bg-warning text-dark rounded-pill px-3">Belum Ditanggapi</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm" role="group">
                                        @if ($feedback->status == 1)
                                            <a href="{{ route('admin.feedback.update', $feedback->id) }}" class="btn btn-danger btn-sm" title="Tandai Belum Ditanggapi">
                                                <i class="bi bi-x-circle-fill"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.feedback.update', $feedback->id) }}" class="btn btn-success btn-sm" title="Tandai Sudah Ditanggapi">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.feedback.detail', $feedback->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </div>
                                </td>
                             </tr>
                          @empty
                             <tr>
                                 <td colspan="8" class="text-center py-5 text-muted">
                                     <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                     Belum ada feedback yang masuk sesuai filter ini.
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