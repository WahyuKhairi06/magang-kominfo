<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Kegiatan PKK</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }

        th {
            font-weight: bold;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="title">
    DATA KEGIATAN PKK <br>
    TP. PKK DESA TALAGO SARIak <br>
    TAHUN 2025
</div>

<table>
    <thead>
        <tr>
            <th rowspan="3">NO</th>
            <th rowspan="3">NAMA DUSUN</th>
            <th colspan="3">JUMLAH KADER</th>
            <th colspan="8">PENGHAYATAN & PENGAMALAN PANCASILA</th>
            <th colspan="5">GOTONG ROYONG</th>
            <th rowspan="3">KET</th>
        </tr>

        <tr>
            <th rowspan="2">PKBN</th>
            <th rowspan="2">PKDRT</th>
            <th rowspan="2">POLA ASUH</th>

            <th colspan="2">PKBN</th>
            <th colspan="2">PKDRT</th>
            <th colspan="2">POLA ASUH</th>
            <th colspan="2">LANSIA</th>

            <th rowspan="2">KERJA BAKTI</th>
            <th rowspan="2">RUKUN</th>
            <th rowspan="2">KEAGAMAAN</th>
            <th rowspan="2">JIMPITAN</th>
            <th rowspan="2">ARISAN</th>
        </tr>

        <tr>
            <th>Kelompok</th>
            <th>Anggota</th>

            <th>Kelompok</th>
            <th>Anggota</th>

            <th>Kelompok</th>
            <th>Anggota</th>

            <th>Kelompok</th>
            <th>Anggota</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $i => $row)
        <tr>
            <td>{{ $i+1 }}</td>
            <td style="text-align:left;">{{ $row->nama_dusun }}</td>

            <td>{{ $row->kader_pkbn }}</td>
            <td>{{ $row->kader_pkdrt }}</td>
            <td>{{ $row->kader_pola_asuh }}</td>

            <td>{{ $row->pkbn_kelompok }}</td>
            <td>{{ $row->pkbn_anggota }}</td>

            <td>{{ $row->pkdrt_kelompok }}</td>
            <td>{{ $row->pkdrt_anggota }}</td>

            <td>{{ $row->pola_asuh_kelompok }}</td>
            <td>{{ $row->pola_asuh_anggota }}</td>

            <td>{{ $row->lansia_kelompok }}</td>
            <td>{{ $row->lansia_anggota }}</td>

            <td>{{ $row->kerja_bakti }}</td>
            <td>{{ $row->rukun_kematian }}</td>
            <td>{{ $row->keagamaan }}</td>
            <td>{{ $row->jimpitan }}</td>
            <td>{{ $row->arisan }}</td>

            <td>{{ $row->ket }}</td>
        </tr>
        @endforeach

        <!-- TOTAL -->
        <tr style="font-weight:bold;">
            <td colspan="2">TOTAL</td>

            <td>{{ $data->sum('kader_pkbn') }}</td>
            <td>{{ $data->sum('kader_pkdrt') }}</td>
            <td>{{ $data->sum('kader_pola_asuh') }}</td>

            <td>{{ $data->sum('pkbn_kelompok') }}</td>
            <td>{{ $data->sum('pkbn_anggota') }}</td>

            <td>{{ $data->sum('pkdrt_kelompok') }}</td>
            <td>{{ $data->sum('pkdrt_anggota') }}</td>

            <td>{{ $data->sum('pola_asuh_kelompok') }}</td>
            <td>{{ $data->sum('pola_asuh_anggota') }}</td>

            <td>{{ $data->sum('lansia_kelompok') }}</td>
            <td>{{ $data->sum('lansia_anggota') }}</td>

            <td>{{ $data->sum('kerja_bakti') }}</td>
            <td>{{ $data->sum('rukun_kematian') }}</td>
            <td>{{ $data->sum('keagamaan') }}</td>
            <td>{{ $data->sum('jimpitan') }}</td>
            <td>{{ $data->sum('arisan') }}</td>

            <td></td>
        </tr>

    </tbody>
</table>

</body>
</html>