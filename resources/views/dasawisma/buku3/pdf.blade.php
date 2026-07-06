<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-size:10px; font-family: sans-serif; }

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    border:1px solid black;
    padding:3px;
    text-align:center;
}

.no-border td {
    border:none;
}

.center {
    text-align:center;
    font-weight:bold;
}
.info-tab td{
    text-align: left;
}

.info-tab td:last-child{
    text-align: left;
}
</style>
</head>
<body>

<!-- JUDUL -->
<div class="center">
REKAPITULASI DATA / BUKU CATATAN <br>
IBU HAMIL, MELAHIRKAN, NIFAS, IBU MENINGGAL, KELAHIRAN BAYI, BAYI MENINGGAL DAN KEMATIAN BALITA
</div>

<br>

<!-- INFO -->
<table class="no-border" style="width:100%; font-size:11px;">
<tr>

    <td style="width:20%;">Kelompok Dasawisma</td>
    <td style="width:30%;">: {{ $data->first()->nama_dasawisma ?? '-' }}</td>

    <td style="width:20%;">Tahun</td>
    <td style="width:30%;">: {{ $data->first()->tahun}} ?? '-'</td>

</tr>

<tr>

    <td>Desa</td>
    <td>: {{ $data->first()->nama_desa ?? '-' }}</td>

    <td></td>
    <td></td>

</tr>
</table>

<br>

<!-- TABEL -->
<table>
<thead>

<tr>
<th rowspan="2">No</th>
<th rowspan="2">Nama Ibu</th>
<th rowspan="2">Nama Suami</th>
<th rowspan="2">Status</th>

<th colspan="4">CATATAN KELAHIRAN</th>
<th colspan="6">CATATAN KEMATIAN</th>
</tr>

<tr>
<th>Nama Bayi</th>
<th>JK</th>
<th>Tgl Lahir</th>
<th>Akte</th>

<th>Nama</th>
<th>Status</th>
<th>JK</th>
<th>Tgl</th>
<th>Sebab</th>
<th>Ket</th>
</tr>

</thead>

<tbody>

@foreach($data as $i => $d)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $d->nama_ibu }}</td>
<td>{{ $d->nama_suami }}</td>
<td>{{ $d->status }}</td>

<td>{{ $d->nama_bayi }}</td>
<td>{{ $d->jenis_kelamin_bayi }}</td>
<td>{{ $d->tgl_lahir }}</td>
<td>{{ $d->akte_kelahiran }}</td>

<td>{{ $d->nama_meninggal }}</td>
<td>{{ $d->status_meninggal }}</td>
<td>{{ $d->jenis_kelamin_meninggal }}</td>
<td>{{ $d->tanggal_meninggal }}</td>
<td>{{ $d->sebab_meninggal }}</td>
<td>{{ $d->keterangan }}</td>
</tr>
@endforeach

</tbody>
</table>

<br>

<!-- JUMLAH -->
<table>
<tr>
<td colspan="4"><b>JUMLAH</b></td>
<td colspan="10"></td>
</tr>
</table>

<br>

<!-- CATATAN -->
<table class="no-border" style="width:20%; font-size:11px;">
<tr>
<td colspan="2"><b>CATATAN:</b></td>
</tr>

<tr>
<td>1. Jumlah Ibu Hamil</td>
<td style="text-align:right;">: {{ $rekap['hamil'] }} Orang</td>
</tr>

<tr>
<td>2. Jumlah Ibu Melahirkan</td>
<td style="text-align:right;">: {{ $rekap['melahirkan'] }} Orang</td>
</tr>

<tr>
<td>3. Jumlah Ibu Nifas</td>
<td style="text-align:right;">: {{ $rekap['nifas'] }} Orang</td>
</tr>

<tr>
<td>4. Jumlah Ibu Meninggal</td>
<td style="text-align:right;">: {{ $rekap['ibu_meninggal'] }} Orang</td>
</tr>

<tr>
<td>5. Jumlah Bayi Lahir</td>
<td style="text-align:right;">: {{ $rekap['bayi_lahir'] }} Orang</td>
</tr>

<tr>
<td>6. Jumlah Bayi Meninggal</td>
<td style="text-align:right;">: {{ $rekap['bayi_meninggal'] }} Orang</td>
</tr>

<tr>
<td>7. Jumlah Balita Meninggal</td>
<td style="text-align:right;">: {{ $rekap['balita_meninggal'] }} Orang</td>
</tr>

</table>

</body>
</html>