@extends('layouts.app')

@section('title', 'Form Enrollment')

@section('page-title', 'Formulir Enrollment')
@section('page-subtitle', 'Unggah data mahasiswa untuk didaftarkan ke kelas')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="{{ route('admin.user') }}"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="{{ route('admin.fasilitas') }}"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="{{ route('admin.unit') }}"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="{{ route('admin.periode') }}"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link active" href="{{ route('admin.mata_kuliah') }}"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
    <a class="nav-link" href="{{ route('admin.kelas') }}"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
    <form action="{{ route('logout') }}" method="POST" style="float: right;">
      @csrf
      <div style="align-items: center; justify-content: center; display: flex;">
        <button class="btn btn-danger" type="submit">Logout</button>
      </div>
   </form>
@endsection

@push('styles')
<style>
    .drop-zone {
        border: 2px dashed #0d6efd;
        border-radius: 0.5rem;
        padding: 50px;
        text-align: center;
        font-family: Arial, sans-serif;
        color: #0d6efd;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }
    .drop-zone--over {
        background-color: #e9ecef;
    }
    .drop-zone__input {
        display: none;
    }
    .drop-zone__icon {
        font-size: 3rem;
        display: block;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="card-custom">
    <div class="card-header"><i class="bi bi-upload"></i> Unggah Data Enrollment</div>
    <div class="card-body">
      <div class="p-3 mb-4 rounded" style="background-color: #f8f9fa;">
            <div class="row">
                <div class="col-md-12">
                    <h5>{{ $kelas->mataKuliah->name }}</h5>
                    <p class="mb-1"><strong>Dosen Pengampu:</strong> {{ $kelas->dosen->user->name }}</p>
                    <p class="mb-0"><strong>Periode:</strong> {{ $kelas->periode->nama_periode }}</p>
                </div>
            </div>
        </div>

        <form>
            <div class="mb-3">
                <label class="form-label">File Excel Mahasiswa</label>
                <div class="drop-zone" id="dropZone">
                    <input class="drop-zone__input" type="file" id="file_excel" accept=".xlsx, .xls" multiple="false">
                    <i class="bi bi-cloud-arrow-up-fill drop-zone__icon"></i>
                    <span class="drop-zone__prompt">Klik di sini atau seret file ke sini</span>
                </div>
                <div class="form-text mt-1">Format File: .xlsx, .xls</div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary w-100 mb-2"><i class="bi bi-send-fill"></i> Kirim</button>
                <a href="{{ route('admin.enrollment.download', $kelas->id) }}" class="btn btn-outline-secondary w-100">Unduh Template Excel</a>
            </div>

             <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.enrollment', $kelas->id) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropZoneElement = document.getElementById("dropZone");
        const inputElement = document.getElementById("file_excel");
        const promptElement = dropZoneElement.querySelector(".drop-zone__prompt");

        dropZoneElement.addEventListener("click", e => {
            inputElement.click();
        });

        inputElement.addEventListener("change", e => {
            if (inputElement.files.length) {
                updateThumbnail(dropZoneElement, inputElement.files[0]);
            }
        });

        dropZoneElement.addEventListener("dragover", e => {
            e.preventDefault();
            dropZoneElement.classList.add("drop-zone--over");
        });

        ["dragleave", "dragend"].forEach(type => {
            dropZoneElement.addEventListener(type, e => {
                dropZoneElement.classList.remove("drop-zone--over");
            });
        });

        dropZoneElement.addEventListener("drop", e => {
            e.preventDefault();
            
            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
            }

            dropZoneElement.classList.remove("drop-zone--over");
        });

        function updateThumbnail(dropZoneElement, file) {
            if (promptElement) {
                promptElement.textContent = file.name;
            }
        }
    });
</script>
@endpush

