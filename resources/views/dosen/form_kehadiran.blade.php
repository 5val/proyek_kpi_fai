@extends('layouts.app')

@section('title', 'Form Input Kehadiran')

@section('page-title', 'Formulir Input Kehadiran')
@section('page-subtitle', 'Unggah data kehadiran untuk kelas Algoritma & Pemrograman')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')
@section('user-initial', 'AD')

@section('sidebar-menu')
    <a class="nav-link" href="/dosen"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="nav-link" href="/dosen/profile"><i class="bi bi-person-badge"></i> Profil Saya</a>
    <a class="nav-link" href="/dosen/kpi"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
    <a class="nav-link active" href="/dosen/kelas"><i class="bi bi-pencil-square"></i> Kelas</a>
    <a class="nav-link" href="/dosen/penilaian_mahasiswa"><i class="bi bi-people"></i> Penilaian Mahasiswa</a>
    <a class="nav-link" href="/dosen/penilaian_fasilitas"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
    <a class="nav-link" href="/dosen/penilaian_unit"><i class="bi bi-bank2"></i> Penilaian Unit</a>
    <a class="nav-link" href="/dosen/laporan"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kinerja</a>
    <a class="nav-link" href="/dosen/feedback"><i class="bi bi-chat-left-text"></i> Feedback</a>
    <form action="{{ route('logout') }}" method="POST" style="float: right;">
      @csrf
      <div style="align-items: center; justify-content: center; display: flex;">
        <button class="btn btn-danger" type="submit">Logout</button>
      </div>
   </form>
@endsection

@section('content')

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
    <div class="card-header"><i class="bi bi-upload"></i> Unggah Data Kehadiran</div>
    <div class="card-body">
        <form action="{{ route('dosen.kehadiran.upload', $kelas->id) }}" method="POST" enctype="multipart/form-data">
         @csrf
            <!-- Info -->
            <div class="p-3 mb-4 rounded" style="background-color: #f8f9fa;">
                <p class="mb-1"><strong>Kelas:</strong> {{ $kelas->mataKuliah->name }}</p>
                <p class="mb-1"><strong>Program Studi:</strong> {{ $kelas->program_studi->name }}</p>
                <p class="mb-0"><strong>Dosen:</strong> {{ $kelas->dosen->user->name }}</p>
            </div>

            <div class="mb-3">
                <label for="pertemuan" class="form-label">Pilih Pertemuan</label>
                <select class="form-select" id="pertemuan" name="pertemuan">
                    <option selected disabled>Pilih pertemuan ke-...</option>
                    <option value="1">Pertemuan 1</option>
                    <option value="2">Pertemuan 2</option>
                    <option value="3">Pertemuan 3</option>
                    <option value="4">Pertemuan 4</option>
                    <option value="5">Pertemuan 5</option>
                    <option value="6">Pertemuan 6</option>
                    <option value="7">Pertemuan 7</option>
                    <option value="8">Pertemuan 8</option>
                    <option value="9">Pertemuan 9</option>
                    <option value="10">Pertemuan 10</option>
                    <option value="11">Pertemuan 11</option>
                    <option value="12">Pertemuan 12</option>
                    <option value="13">Pertemuan 13</option>
                    <option value="14">Pertemuan 14</option>
                </select>
                @error('pertemuan')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">File Excel Kehadiran</label>
                <div class="drop-zone" id="dropZone">
                    <input class="drop-zone__input" type="file" id="file_excel" accept=".xlsx, .xls" multiple="false" name="file">
                    <i class="bi bi-cloud-arrow-up-fill drop-zone__icon"></i>
                    <span class="drop-zone__prompt">Klik di sini atau seret file ke sini</span>
                    <div class="form-text mt-1">Format File: .xlsx, .xls</div>
                @error('file')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                 
                <div class="mt-4">
                  <button type="submit" class="btn btn-primary w-100 mb-2"><i class="bi bi-send-fill"></i> Kirim</button>
                  <a href="{{ route('dosen.kehadiran.download', $kelas->id) }}" class="btn btn-outline-secondary w-100">Unduh Template Excel</a>
               </div>

               <div class="d-flex justify-content-end mt-4">
                  <a href="{{ route('dosen.kelas') }}" class="btn btn-secondary">Batal</a>
               </div>
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
