<!DOCTYPE html>
<html>
<head>
<style>
body { font-family: Arial; font-size: 9px; }

table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid black; padding: 3px; text-align: center; }

.header { text-align: center; font-weight: bold; font-size: 14px; }

.bg-yellow { background:#ffd966; }
.bg-blue { background:#9dc3e6; }
.bg-green { background:#a9d18e; }
.bg-red { background:#f4b183; }
.bg-purple { background:#d9b8ff; }

.left { text-align:left; }
</style>
</head>

<body>

<div class="header">DATA UMUM PKK</div>

<table style="margin-bottom:10px;">
<tr>
    <td class="left"><b>DESA</b></td>
    <td class="left">: {{ $data->first()->nama_desa ?? '-' }}</td>
    <td class="left"><b>KECAMATAN</b></td>
    <td class="left">: {{ $data->first()->nama_kecamatan ?? '-' }}</td>
</tr>
<tr>
    <td class="left"><b>KOTA</b></td>
    <td class="left">: Pariaman</td>
    <td class="left"><b>PROVINSI</b></td>
    <td class="left">: Sumatera Barat</td>
</tr>
<tr>
    <td class="left"><b>TAHUN</b></td>
    <td colspan="3" class="left">: {{ $data->first()->tahun}}</td>
</tr>
</table>

<table>

{{-- HEADER 3 LEVEL --}}
<tr>
    <th rowspan="3">NO</th>
    <th rowspan="3">NAMA WILAYAH</th>

    <th colspan="3" class="bg-yellow">KELOMPOK</th>
    <th colspan="2" class="bg-blue">JUMLAH</th>
    <th colspan="2" class="bg-green">JIWA</th>

    <th colspan="6" class="bg-red">KADER</th>
    <th colspan="4" class="bg-purple">SEKRETARIAT</th>

    <th rowspan="3">KET</th>
</tr>

<tr>
    <th rowspan="2">RW</th>
    <th rowspan="2">RT</th>
    <th rowspan="2">DASA</th>

    <th rowspan="2">KRT</th>
    <th rowspan="2">KK</th>

    <th rowspan="2">L</th>
    <th rowspan="2">P</th>

    <th colspan="2">TP PKK</th>
    <th colspan="2">UMUM</th>
    <th colspan="2">KHUSUS</th>

    <th colspan="2">HONORER</th>
    <th colspan="2">BANTUAN</th>
</tr>

<tr>
    <th>L</th><th>P</th>
    <th>L</th><th>P</th>
    <th>L</th><th>P</th>
    <th>L</th><th>P</th>
    <th>L</th><th>P</th>
</tr>

{{-- DATA --}}
@foreach($data as $i => $d)
<tr>
<td>{{ $i+1 }}</td>
<td class="left">{{ $d->nama_dusun }}</td>

<td>{{ $d->pkk_rw }}</td>
<td>{{ $d->pkk_rt }}</td>
<td>{{ $d->dasawisma }}</td>

<td>{{ $d->krt }}</td>
<td>{{ $d->kk }}</td>

<td>{{ $d->jiwa_l }}</td>
<td>{{ $d->jiwa_p }}</td>

<td>{{ $d->kader_tp_l }}</td>
<td>{{ $d->kader_tp_p }}</td>

<td>{{ $d->kader_umum_l }}</td>
<td>{{ $d->kader_umum_p }}</td>

<td>{{ $d->kader_khusus_l }}</td>
<td>{{ $d->kader_khusus_p }}</td>

<td>{{ $d->sekretariat_honorer_l }}</td>
<td>{{ $d->sekretariat_honorer_p }}</td>

<td>{{ $d->sekretariat_bantuan_l }}</td>
<td>{{ $d->sekretariat_bantuan_p }}</td>

<td>{{ $d->ket }}</td>
</tr>
@endforeach

{{-- TOTAL --}}
<tr style="font-weight:bold; background:#eee;">
<td colspan="2">JUMLAH</td>

<td>{{ $total['pkk_rw'] }}</td>
<td>{{ $total['pkk_rt'] }}</td>
<td>{{ $total['dasawisma'] }}</td>

<td>{{ $total['krt'] }}</td>
<td>{{ $total['kk'] }}</td>

<td>{{ $total['jiwa_l'] }}</td>
<td>{{ $total['jiwa_p'] }}</td>

<td>{{ $total['kader_tp_l'] }}</td>
<td>{{ $total['kader_tp_p'] }}</td>

<td>{{ $total['kader_umum_l'] }}</td>
<td>{{ $total['kader_umum_p'] }}</td>

<td>{{ $total['kader_khusus_l'] }}</td>
<td>{{ $total['kader_khusus_p'] }}</td>

<td>{{ $total['sekretariat_honorer_l'] }}</td>
<td>{{ $total['sekretariat_honorer_p'] }}</td>

<td>{{ $total['sekretariat_bantuan_l'] }}</td>
<td>{{ $total['sekretariat_bantuan_p'] }}</td>

<td>-</td>
</tr>

</table>

</body>
</html>