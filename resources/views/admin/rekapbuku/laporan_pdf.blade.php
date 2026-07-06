<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 9px;
            margin: 10px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* 🔥 penting biar tidak melebar liar */
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        th {
            background: #f2f2f2;
        }

        .text-left {
            text-align: left;
        }

        /* HEADER ATAS */
        .info-table td {
            padding: 2px 4px;
            text-align: left;
            border-collapse: collapse;
        }
        .info-table {
            width:auto;
        }
.info-table, 
.info-table td, 
.info-table tr {
    border: none !important;
}
        /* biar header tabel tidak hilang saat print */
        thead {
            display: table-header-group;
        }
    </style>
</head>
<body>

<!-- JUDUL -->
<div class="title">
    <h3>DAFTAR ANGGOTA TP PKK DAN KADER</h3>
</div>

<!-- HEADER ATAS (SUDAH FIX) -->
<table class="info-table" style="margin-bottom:8px; border-collapse: collapse;
">
    <tr>
        <td >Desa</td>
        <td >:</td>
        <td >{{ $data->first()->nama_buku ?? '-' }}</td>

        <td >Kota</td>
        <td >:</td>
        <td >Pariaman</td>
    </tr>
    <tr style="margin-right: 50%">
        <td>Kecamatan</td>
        <td>:</td>
        <td>{{ $data->first()->nama_kecamatan ?? '-' }}</td>

        <td>Masa Bhakti</td>
        <td>:</td>
        <td>{{ $data->first()->masa_mulai ?? '-' }} - {{ $data->first()->masa_selesai ?? '-' }}</td>
    </tr>
</table>

<!-- TABEL UTAMA -->
<table>
    <thead>
        <tr>
            <th rowspan="2" style="width:3%;">No</th>
            <th rowspan="2" style="width:10%;">Nama</th>

            <th colspan="2" style="width:8%;">Jenis Kelamin</th>

            <th colspan="3" style="width:15%;">Kedudukan / Fungsi</th>

            <th rowspan="2" style="width:8%;">Tgl Lahir</th>
            <th rowspan="2" style="width:7%;">Status</th>
            <th rowspan="2" style="width:12%;">Alamat</th>
            <th rowspan="2" style="width:8%;">Pendidikan</th>
            <th rowspan="2" style="width:8%;">Pekerjaan</th>
            <th rowspan="2" style="width:11%;">Keterangan</th>
        </tr>

        <tr>
            <th>L</th>
            <th>P</th>

            <th>TP PKK</th>
            <th>Kader Umum</th>
            <th>Kader Khusus</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td class="text-left">{{ $d->nama }}</td>

            <td>{{ $d->jenis_kelamin == 'L' ? 'v' : '' }}</td>
            <td>{{ $d->jenis_kelamin == 'P' ? 'v' : '' }}</td>

            <td>{{ $d->dalam_keanggotaan_tp_pkk }}</td>
            <td>{{ $d->kader_umum }}</td>
            <td>{{ $d->kader_khusus }}</td>

            <td>{{ $d->tanggal_lahir }}</td>
            <td>{{ $d->status }}</td>
            <td class="text-left">{{ $d->alamat }}</td>
            <td>{{ $d->pendidikan }}</td>
            <td>{{ $d->pekerjaan }}</td>
            <td>{{ $d->keterangan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>