<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: sans-serif; font-size: 8px; }
table { border-collapse: collapse; width: 100%; }
th, td {
    border: 1px solid black;
    padding: 4px;
    text-align: center;
}
.title {
    text-align: center;
    font-size: 14px;
    font-weight: bold;
}
</style>
</head>
<body>

<div class="title">
DATA KEGIATAN PKK <br>
TP. PKK DESA {{ $data[0]->nama_desa ?? '-' }} <br>
TAHUN 2025
</div>

<table>
<thead>

<!-- BARIS 1 -->
<tr>
    <th rowspan="4">NO</th>
    <th rowspan="4">NAMA DUSUN</th>

    <th colspan="3">JUMLAH KADER</th>
    <th colspan="8">PANGAN</th>
    <th colspan="3">INDUSTRI RUMAH TANGGA</th>
    <th colspan="2">JUMLAH RUMAH</th>

    <th rowspan="4">KET</th>
</tr>

<!-- BARIS 2 -->
<tr>
    <!-- KADER -->
    <th rowspan="3">PANGAN</th>
    <th rowspan="3">SANDANG</th>
    <th rowspan="3">TATA LKS</th>

    <!-- PANGAN -->
    <th colspan="2">MAKANAN POKOK</th>
    <th colspan="6">PEMANFAATAN PEKARANGAN</th>

    <!-- INDUSTRI -->
    <th rowspan="3">PANGAN</th>
    <th rowspan="3">SANDANG</th>
    <th rowspan="3">JASA</th>

    <!-- RUMAH -->
    <th rowspan="3">SEHAT</th>
    <th rowspan="3">TIDAK</th>
</tr>

<!-- BARIS 3 -->
<tr>
    <th rowspan="2">BERAS</th>
    <th rowspan="2">NON</th>

    <th rowspan="2">TERNAK</th>
    <th rowspan="2">IKAN</th>
    <th rowspan="2">WARUNG</th>
    <th rowspan="2">LUMBUNG</th>
    <th rowspan="2">TOGA</th>
    <th rowspan="2">TANAMAN KERAS</th>
</tr>

<tr></tr>

</thead>

<tbody>

@foreach($data as $i => $d)
<tr>
    <td>{{ $i+1 }}</td>
    <td style="text-align:left">{{ $d->nama_dusun }}</td>

    <!-- KADER -->
    <td>{{ $d->kader_pangan }}</td>
    <td>{{ $d->kader_sandang }}</td>
    <td>{{ $d->kader_tata_laksana_rumah_tangga }}</td>

    <!-- PANGAN -->
    <td>{{ $d->pangan_beras }}</td>
    <td>{{ $d->pangan_non_beras }}</td>

    <td>{{ $d->peternakan }}</td>
    <td>{{ $d->perikanan }}</td>
    <td>{{ $d->warung_hidup }}</td>
    <td>{{ $d->lumbung_hidup }}</td>
    <td>{{ $d->toga }}</td>
    <td>{{ $d->tanaman_keras }}</td>

    <!-- INDUSTRI -->
    <td>{{ $d->industri_pangan }}</td>
    <td>{{ $d->industri_sandang }}</td>
    <td>{{ $d->industri_jasa }}</td>

    <!-- RUMAH -->
    <td>{{ $d->rumah_sehat_layak }}</td>
    <td>{{ $d->rumah_tidak_sehat_tidak_layak }}</td>

    <td>{{ $d->keterangan }}</td>
</tr>
@endforeach

</tbody>
</table>

</body>
</html>