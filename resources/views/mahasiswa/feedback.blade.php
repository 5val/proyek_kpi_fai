@extends('layouts.app')

@section('title', 'Feedback')

@section('page-title', 'Feedback')
@section('page-subtitle', 'Kirim feedback atau keluhan Anda')
@section('user-name', '')
@section('user-role', '')
@section('user-initial', '')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4"> <div class="col-12 col-lg-8">
        <div class="card card-custom shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 fw-bold">
                <i class="bi bi-chat-left-text-fill me-2"></i> Kirim Feedback atau Laporan
            </div>
            <div class="card-body p-4">
                <form action="{{ route('mahasiswa.insertFeedback') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label for="kategori" class="form-label fw-bold">Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-tags"></i></span>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <option selected value="">Pilih kategori feedback...</option>
                                    @foreach($kategori as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="target" class="form-label fw-bold d-flex justify-content-between">
                                <span>Target / Objek</span>
                                <span id="loading-target" class="text-primary small" style="display:none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                </span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-bullseye"></i></span>
                                <select class="form-select" id="target" name="target" disabled required>
                                    <option selected value="">Pilih kategori dulu...</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi / Isi Feedback</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="6" placeholder="Jelaskan secara rinci feedback atau keluhan Anda..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="bukti" class="form-label fw-bold">Lampiran Bukti (Foto)</label>
                        <input class="form-control" type="file" id="bukti" name="file" accept="image/*">
                        <div class="form-text text-muted"><i class="bi bi-info-circle"></i> Opsional. Format: JPG, PNG. Max: 5MB.</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded mb-4 border">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="anonim" name="anonim" value="1" style="transform: scale(1.2);">
                            <label class="form-check-label fw-bold ms-1" for="anonim">
                                Kirim sebagai anonim
                            </label>
                        </div>
                        <small class="text-muted d-none d-sm-block">Identitas Anda akan disembunyikan.</small>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                            <i class="bi bi-send-fill me-2"></i> Kirim Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-4">
        <div class="card card-custom shadow-sm border-0 h-100">
    <div class="card-header bg-white py-3 fw-bold">
        <i class="bi bi-clock-history me-2"></i> Riwayat Feedback Saya
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush overflow-auto" style="max-height: 500px;">
            
            @forelse($riwayat as $item)
                <div class="list-group-item p-3 {{ $loop->last ? '' : 'border-bottom-0' }}">
                    <div class="d-flex w-100 justify-content-between align-items-start mb-1">
                        {{-- Isi Feedback (Dipotong jika terlalu panjang) --}}
                        <h6 class="mb-0 fw-bold text-truncate" style="max-width: 65%;">
                            {{ Str::limit($item->isi, 40) }}
                        </h6>
                        
                        {{-- Waktu (Created At) --}}
                        <small class="text-muted text-nowrap" style="font-size: 0.75rem;">
                            {{ $item->created_at->diffForHumans() }}
                        </small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">
                            <i class="bi bi-tag me-1"></i> {{ $item->kategori->name ?? 'Umum' }}
                        </small>
                        
                        {{-- Badge Status (Menggunakan Accessor Model) --}}
                        <span class="badge bg-{{ $item->status_color }} rounded-pill px-2" style="font-size: 0.7rem;">
                            {{ $item->status_label }}
                        </span>
                    </div>
                </div>

                @unless($loop->last)
                    <hr class="my-0 mx-3 opacity-25">
                @endunless

            @empty
                {{-- Empty State --}}
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                    <small>Belum ada riwayat feedback.</small>
                </div>
            @endforelse

        </div>
    </div>
</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#kategori').on('change', function() {
            var kategoriId = $(this).val();
            var targetDropdown = $('#target');
            var loading = $('#loading-target');

            // Reset dropdown target
            targetDropdown.html('<option selected value="">Pilih objek feedback...</option>');
            
            if (kategoriId) {
                // Disable dropdown & Show loading
                targetDropdown.prop('disabled', true);
                loading.fadeIn();

                $.ajax({
                    url: "{{ route('mahasiswa.feedback.get_targets') }}", 
                    type: "GET",
                    data: { kategori_id: kategoriId },
                    dataType: "json",
                    success: function(data) {
                        loading.hide();
                        targetDropdown.prop('disabled', false);

                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                targetDropdown.append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        } else {
                            targetDropdown.append('<option value="">Tidak ada data target ditemukan</option>');
                        }
                    },
                    error: function() {
                        loading.hide();
                        alert('Gagal memuat data target. Silakan periksa koneksi internet Anda.');
                        targetDropdown.prop('disabled', true);
                    }
                });
            } else {
                targetDropdown.prop('disabled', true);
                loading.hide();
            }
        });
    });
</script>
@endpush