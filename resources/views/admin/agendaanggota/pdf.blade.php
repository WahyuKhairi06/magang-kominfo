<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body {
    font-family: sans-serif;
    font-size: 9px;
}

.title {
    text-align: center;
    font-weight: bold;
    margin-bottom: 5px;
}

.info {
    margin-bottom: 5px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #000;
    padding: 3px;
    text-align: center;
    vertical-align: middle;
}

th {
    background: #f2f2f2;
}

.text-left {
    text-align: left;
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

<!-- JUDUL -->
<div class="title">
    <h3>BUKU AGENDA SURAT</h3>
</div>

<!-- INFO -->
<div class="info info-table">
<table>
<tr>
    <td >Desa</td>
    <td>: {{ $data->first()->nama_desa ?? '-' }}</td>
    <td >Kecamatan</td>
    <td>: {{ $data->first()->nama_kecamatan ?? '-' }}</td>
</tr>
<tr>
    <td>Dusun</td>
    <td>: {{ $data->first()->nama_dusun ?? '-' }}</td>
    <td>Tahun</td>
    <td>: {{ $data->first()->tahun ?? '-' }}</td>
</tr>
</table>
</div>

<!-- TABEL -->
<table>
<thead>

<tr>
    <th colspan="8">SURAT MASUK</th>
    <th colspan="7">SURAT KELUAR</th>
</tr>

<tr>
    <th>No</th>
    <th>Tgl Terima</th>
    <th>Tgl Surat</th>
    <th>No Surat</th>
    <th>Dari</th>
    <th>Perihal</th>
    <th>Lampiran</th>
    <th>Diteruskan</th>

    <th>No</th>
    <th>No Surat</th>
    <th>Tgl Surat</th>
    <th>Kepada</th>
    <th>Perihal</th>
    <th>Lampiran</th>
    <th>Tembusan</th>
</tr>

</thead>

<tbody>
@foreach($data as $i => $d)
<tr>

<!-- MASUK -->
<td>{{ $i+1 }}</td>
<td>{{ \Carbon\Carbon::parse($d->tanggal_terima_surat)->format('d-m-Y') }}</td>
<td>{{ \Carbon\Carbon::parse($d->tanggal_surat_masuk)->format('d-m-Y') }}</td>
<td>{{ $d->nomor_surat_diterima }}</td>
<td class="text-left">{{ $d->dari }}</td>
<td class="text-left">{{ $d->perihal_masuk }}</td>
<td>{{ $d->lampiran_masuk }}</td>
<td class="text-left">{{ $d->diteruskan_kepada }}</td>

<!-- KELUAR -->
<td>{{ $i+1 }}</td>
<td>{{ $d->nomor_surat }}</td>
<td>{{ \Carbon\Carbon::parse($d->tanggal_surat_keluar)->format('d-m-Y') }}</td>
<td class="text-left">{{ $d->kepada }}</td>
<td class="text-left">{{ $d->perihal_keluar }}</td>
<td>{{ $d->lampiran_keluar }}</td>
<td class="text-left">{{ $d->tembusan }}</td>

</tr>
@endforeach
</tbody>

</table>

</body>
</html>