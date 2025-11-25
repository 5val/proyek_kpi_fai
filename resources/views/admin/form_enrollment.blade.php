@extends('layouts.app')

@section('title', 'Form Enrollment')

@section('page-title', 'Formulir Enrollment')
@section('page-subtitle', 'Unggah data mahasiswa untuk didaftarkan ke kelas')
@section('user-name', Auth::user()->name)
@section('user-role', 'Admin')
@section('user-initial', 'AD')

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
                    <p class="mb-1"><strong>Program Studi:</strong> {{ $kelas->program_studi->name }}</p>
                    <p class="mb-1"><strong>Dosen Pengampu:</strong> {{ $kelas->dosen->user->name }}</p>
                    <p class="mb-0"><strong>Periode:</strong> {{ $kelas->periode->nama_periode }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.enrollment.upload', $kelas->id) }}" method="POST" enctype="multipart/form-data">
         @csrf
            <div class="mb-3">
                <label class="form-label">File Excel Mahasiswa</label>
                <div class="drop-zone" id="dropZone">
                    <input class="drop-zone__input" type="file" id="file_excel" accept=".xlsx, .xls" multiple="false" name="file">
                    <i class="bi bi-cloud-arrow-up-fill drop-zone__icon"></i>
                    <span class="drop-zone__prompt">Klik di sini atau seret file ke sini</span>
                </div>
                <div class="form-text mt-1">Format File: .xlsx, .xls</div>
                @error('file')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
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

