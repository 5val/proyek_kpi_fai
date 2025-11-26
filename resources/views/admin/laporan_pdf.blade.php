<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
        h3 { text-align:center; }
    </style>
</head>
<body>

<h3>Laporan KPI: {{ $curKategori->name }}</h3>

<table>
    <thead>
        <tr>
            <th>Nama {{ ucfirst($curKategori->target_role) }}</th>
            <th>Skor Rata-rata</th>
            <th>Jumlah Penilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($penilaian as $p)
        <tr>
            <td>
                @if ($curKategori->id == 1 || $curKategori->id == 2)
                    {{ $p->user->name ?? '' }}
                @elseif ($curKategori->id == 3 || $curKategori->id == 4)
                    {{ $p->name ?? '' }}
                @else
                    {{ $p->kelas->mataKuliah->name ?? '' }}
                @endif
            </td>
            <td>{{ $p->penilaian_avg_avg_score ? number_format($p->penilaian_avg_avg_score, 1) : 'Belum Ada Penilaian' }}</td>
            <td>{{ $p->penilaian_count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
