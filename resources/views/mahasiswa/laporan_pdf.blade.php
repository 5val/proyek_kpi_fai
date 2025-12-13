<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kehadiran</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background: #eee; }
        h2, h4 { margin: 0; }
    </style>
</head>
<body>

<h2>Laporan Kehadiran Mahasiswa</h2>
<p>
    Nama: <strong>{{ $mahasiswa->user->name }}</strong><br>
    NRP: {{ $mahasiswa->nrp }}<br>
    Prodi: {{ $mahasiswa->program_studi->name ?? '-' }}
</p>

<table>
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
            <td>{{ $h['hadir'] }}%</td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($feedback->count())
<h4 style="margin-top:20px;">Feedback Dosen</h4>
@foreach ($feedback as $f)
<p>
    <strong>{{ $f->pengirim->name }}:</strong><br>
    {{ $f->komentar }}
</p>
@endforeach
@endif

</body>
</html>
