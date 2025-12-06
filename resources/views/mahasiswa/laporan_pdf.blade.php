@extends('layouts.app')

@section('title', 'Penilaian Dosen')

@section('page-title', 'Penilaian Dosen')
@section('page-subtitle', 'Berikan penilaian terhadap kinerja dosen semester ini')
@section('user-name', 'Andi Pratama')
@section('user-role', 'Mahasiswa - Teknik Informatika')
@section('user-initial', 'AP')

@section('content')
    <h2>Laporan Kehadiran Mahasiswa</h2>
    <p>Nama: {{ $mahasiswa->user->name }}</p>

    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>SKS</th>
                <th>Kehadiran (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasil as $h)
            <tr>
                <td>{{ $h['matkul'] }}</td>
                <td>{{ $h['dosen'] }}</td>
                <td>{{ $h['sks'] }}</td>
                <td>{{ $h['hadir'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Feedback</h3>
    @foreach ($feedback as $f)
    <p>
        <strong>{{ $f->pengirim->name }}:</strong>
        {{ $f->komentar }}
    </p>
    @endforeach

@endsection