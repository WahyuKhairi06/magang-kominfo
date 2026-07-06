<!DOCTYPE html>
<html>
<head>
<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 9px;
}
table { border-collapse: collapse; width:100%; }
th, td {
    border:1px solid black;
    padding:3px;
    text-align:center;
}

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
</style>
</head>

<body>
<h4 style="text-align:center;">
CATATAN KELUARGA DARI ANGGOTA KELOMPOK DASAWISMA
</h4>

<table class="info-table" style="width:100%; margin-bottom:10px; border:none; font-size:12px;">
<tr>

<!-- 🔥 KIRI -->
<td style="width:50%; border:none; vertical-align:top;">

    <div style="font-weight:bold; font-size:13px; margin-bottom:5px;">
        CATATAN KELUARGA
    </div>

    <table style="border:none;">
        <tr>
            <td style="border:none; width:140px;">Kecamatan</td>
            <td style="border:none;">: {{ $data->first()->nama_kecamatan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:none;">Desa</td>
            <td style="border:none;">: {{ $data->first()->nama_desa ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:none;">Dusun</td>
            <td style="border:none;">: {{ $data->first()->nama_dusun ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:none;">Kelompok Dasawisma</td>
            <td style="border:none;">: {{ $data->first()->nama_dasawisma ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:none;">Tahun</td>
            <td style="border:none;">: {{ date('Y') }}</td>
        </tr>
    </table>

</td>

<!-- 🔥 KANAN -->
<td style="width:50%; border:none; vertical-align:top;">

    <div style="font-weight:bold; margin-bottom:5px;">
        Filter Data
    </div>

    <table style="border:none;">
        <tr>
            <td style="border:none; width:140px;">Kriteria Rumah</td>
            <td style="border:none;">: {{ request('kriteria_rumah') ?? 'Semua' }}</td>
        </tr>
        <tr>
            <td style="border:none;">Jamban Keluarga</td>
            <td style="border:none;">: {{ request('jamban_keluarga') ?? 'Semua' }}</td>
        </tr>
        <tr>
            <td style="border:none;">Sumber Air</td>
            <td style="border:none;">: {{ request('sumber_air') ?? 'Semua' }}</td>
        </tr>
        <tr>
            <td style="border:none;">Tempat Sampah</td>
            <td style="border:none;">: {{ request('tempat_sampah') ?? 'Semua' }}</td>
        </tr>
    </table>

</td>

</tr>
</table>
<table>
<thead>

<!-- HEADER UTAMA -->
<tr>
    <th rowspan="2">No</th>
    <th rowspan="2">Nama</th>
    <th rowspan="2">Status</th>
    <th rowspan="2">L/P</th>

    <!-- KEGIATAN PKK -->
    <th colspan="8">KEGIATAN PKK YANG DIIKUTI</th>
    <th rowspan="2">Keterangan</th>
    <th rowspan="2">Rumah</th>
</tr>

<!-- SUB HEADER -->
<tr>
    <th>Pancasila</th>
    <th>Goro</th>
    <th>Pendidikan</th>
    <th>Koperasi</th>
    <th>Pangan</th>
    <th>Sandang</th>
    <th>Kesehatan</th>
    <th>Perencanaan</th>
</tr>

</thead>

<tbody>
@foreach($data as $i => $d)
<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $d->nama_anggota_keluarga }}</td>
    <td>{{ $d->status_perkawinan }}</td>
    <td>{{ $d->jenis_kelamin }}</td>

    <!-- KEGIATAN PKK -->
    <td>{!! $d->pancasila ? 'V' : '-' !!}</td>
    <td>{!! $d->goro ? 'V' : '-' !!}</td>
<td>{!! $d->pendidikan_keterampilan ? 'V' : '-' !!}</td>
<td>{!! $d->penghidupan_berkoperasi ? 'V' : '-' !!}</td>
<td>{!! $d->pangan ? 'V' : '-' !!}</td>
<td>{!! $d->sandang ? 'V' : '-' !!}</td>
<td>{!! $d->kesehatan ? 'V' : '-' !!}</td>
<td>{!! $d->perencanaan_sehat ? 'V' : '-' !!}</td>
    <td>{{ $d->ket ??  '-' }}</td>
    <td>{{ $d->nama_rumah ??  '-' }}</td>
</tr>
@endforeach
</tbody>

</table>

</body>
</html>