<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kinerja Dosen</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2, h3 {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .header-text {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background: #eee;
            padding: 6px;
            text-align: center;
        }

        td {
            padding: 6px;
        }

        .summary-box {
            margin-top: 25px;
            padding: 10px;
            border: 1px solid #000;
        }

        .summary-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <h2>LAPORAN KINERJA DOSEN</h2>
    <h3>{{ $periode->nama_periode }}</h3>

    <div class="header-text">
        <p><strong>Nama Dosen:</strong> {{ $user->name }}</p>
        <p><strong>NIDN:</strong> {{ $dosen->nidn }}</p>
    </div>

    <!-- Tabel Penilaian -->
    <table>
        <thead>
        <tr>
            <th style="width: 10%">No</th>
            <th>Indikator</th>
            <th style="width: 20%">Nilai Rata-rata</th>
        </tr>
        </thead>

        <tbody>
        @php $no = 1; @endphp

        @foreach($indikator as $i)
            <tr>
                <td style="text-align: center;">{{ $no++ }}</td>
                <td>{{ $i->name }}</td>
                <td style="text-align: center;">
                    {{ number_format($nilai[$i->id]->skor ?? 0, 2) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary-box">
        <div class="summary-title">REKAP NILAI AKHIR</div>
        <p><strong>Skor Akhir:</strong> {{ number_format($skorAkhir, 2) }}</p>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ date('d-m-Y') }}</p>
    </div>

</body>
</html>
