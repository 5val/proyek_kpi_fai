@extends('layouts.app')

@section('title', 'Form Enrollment')

@section('page-title', 'Formulir Enrollment')
@section('page-subtitle', 'Unggah data mahasiswa untuk didaftarkan ke kelas')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="#"><i class="bi bi-people-fill"></i> Manajemen User</a>
    <a class="nav-link" href="#"><i class="bi bi-person-rolodex"></i> Manajemen Dosen</a>
    <a class="nav-link" href="#"><i class="bi bi-building"></i> Manajemen Fasilitas</a>
    <a class="nav-link" href="#"><i class="bi bi-bank2"></i> Manajemen Unit</a>
    <a class="nav-link" href="#"><i class="bi bi-calendar-event-fill"></i> Manajemen Periode</a>
    <a class="nav-link" href="#"><i class="bi bi-book-fill"></i> Manajemen Mata Kuliah</a>
    <a class="nav-link active" href="#"><i class="bi bi-easel-fill"></i> Manajemen Kelas</a>
    <a class="nav-link" href="#"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
    <a class="nav-link" href="#"><i class="bi bi-star-fill"></i> Data Penilaian</a>
    <a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
    <a class="nav-link" href="#"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>
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
        <form>
            <div class="mb-3">
                <label for="kelas" class="form-label">Pilih Kelas</label>
                <select class="form-select" id="kelas">
                    <option selected disabled>Pilih kelas yang akan diisi...</option>
                    <option value="1">Algoritma & Pemrograman (Prof. Budi Santoso) - Gasal 2024/2025</option>
                    <option value="2">Struktur Data (Dr. Citra Lestari) - Gasal 2024/2025</option>
                </select>
            </div>
            
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
                <a href="#" class="btn btn-outline-secondary w-100">Unduh Template Excel</a>
            </div>

             <div class="d-flex justify-content-end mt-4">
                <a href="#" class="btn btn-secondary">Batal</a>
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

