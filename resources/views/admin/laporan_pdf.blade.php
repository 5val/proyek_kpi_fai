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
<h3>Periode: {{ $curPeriode->nama_periode }}</h3>

<table>
    <thead>
         @if ($curKategori->id == 6)
            <tr>
               <th>Nama Indikator</th>
               <th>Skor Rata-rata</th>
            </tr>
         @else
            <tr>
               <th>Nama {{ ucfirst($curKategori->target_role) }}</th>
               <th>Skor Rata-rata</th>
               <th>Jumlah Penilai</th>
            </tr>
         @endif
    </thead>
    <tbody>
         @if ($curKategori->id == 6)
            @foreach ($penilaian as $p)
            <tr>
                  <td>{{ $p->indikator->name }}</td>
                  <td>{{ $p->avg_score ? number_format($p->avg_score, 1) : 'Belum Ada Penilaian' }}</td>
            </tr>
            @endforeach
         @else
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
         @endif
    </tbody>
</table>

</body>
</html>
