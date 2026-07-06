<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: sans-serif; font-size: 7px; }
table { border-collapse: collapse; width: 100%; }
th, td {
    border: 1px solid #000;
    padding: 3px;
    text-align: center;
}
.title {
    text-align: center;
    font-size: 13px;
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
 <div><h3>Kegiatan POKJA IV</h3></div>
<table>
<thead>

<!-- BARIS 1 -->
<tr>
    <th rowspan="4">NO</th>
    <th rowspan="4">NAMA DUSUN</th>

    <th colspan="6">JUMLAH KADER</th>
    <th colspan="5">KESEHATAN</th>
    <th colspan="8">KELESTARIAN LINGKUNGAN HIDUP</th>
    <th colspan="5">PERENCANAAN SEHAT</th>

    <th rowspan="4">KET</th>
</tr>

<!-- BARIS 2 -->
<tr>
    <!-- KADER -->
    <th rowspan="3">POSYANDU</th>
    <th rowspan="3">GIZI</th>
    <th rowspan="3">KESLING</th>
    <th rowspan="3">NAPZA</th>
    <th rowspan="3">PHBS</th>
    <th rowspan="3">KB</th>

    <!-- KESEHATAN -->
    <th colspan="2">POSYANDU</th>
    <th colspan="3">LANSIA</th>

    <!-- LINGKUNGAN -->
    <th colspan="3">RUMAH</th>
    <th rowspan="3">MCK</th>
    <th colspan="3">SUMBER AIR</th>

    <!-- PERENCANAAN -->
    <th rowspan="3">PUS</th>
    <th rowspan="3">WUS</th>
    <th colspan="2">AKSEPTOR KB</th>
    <th rowspan="3">TABUNGAN</th>
</tr>

<!-- BARIS 3 -->
<tr>
    <!-- POSYANDU -->
    <th rowspan="2">JUMLAH</th>
    <th rowspan="2">TERINTEGRASI</th>

    <!-- LANSIA -->
    <th rowspan="2">KELOMPOK</th>
    <th rowspan="2">ANGGOTA</th>
    <th rowspan="2">KARTU</th>

    <!-- RUMAH -->
    <th rowspan="2">JAMBAN</th>
    <th rowspan="2">SPAL</th>
    <th rowspan="2">SAMPAH</th>

    <!-- AIR -->
    <th rowspan="2">PDAM</th>
    <th rowspan="2">SUMUR</th>
    <th rowspan="2">LAIN</th>

    <!-- KB -->
    <th rowspan="2">L</th>
    <th rowspan="2">P</th>
</tr>

<tr></tr>

</thead>

<tbody>

@foreach($data as $i => $d)
<tr>
    <td>{{ $i+1 }}</td>
    <td style="text-align:left">{{ $d->nama_dusun }}</td>

    <!-- KADER -->
    <td>{{ $d->kader_posyandu }}</td>
    <td>{{ $d->kader_gizi }}</td>
    <td>{{ $d->kader_kesling }}</td>
    <td>{{ $d->kader_penyuluhan_narkoba }}</td>
    <td>{{ $d->kader_phbs }}</td>
    <td>{{ $d->kader_kb }}</td>

    <!-- POSYANDU -->
    <td>{{ $d->posyandu_jumlah }}</td>
    <td>{{ $d->posyandu_terintegrasi }}</td>

    <!-- LANSIA -->
    <td>{{ $d->lansia_jumlah_kelompok }}</td>
    <td>{{ $d->lansia_jumlah_anggota }}</td>
    <td>{{ $d->lansia_memiliki_kartu_obat_gratis }}</td>

    <!-- LINGKUNGAN -->
    <td>{{ $d->rumah_memiliki_jamban }}</td>
    <td>{{ $d->rumah_memiliki_spal }}</td>
    <td>{{ $d->rumah_memiliki_tempat_sampah }}</td>

    <td>{{ $d->jumlah_mck }}</td>

    <td>{{ $d->air_pdam }}</td>
    <td>{{ $d->air_sumur }}</td>
    <td>{{ $d->air_lainnya }}</td>

    <!-- PERENCANAAN -->
    <td>{{ $d->jumlah_pus }}</td>
    <td>{{ $d->jumlah_wus }}</td>
    <td>{{ $d->akseptor_kb_l }}</td>
    <td>{{ $d->akseptor_kb_p }}</td>
    <td>{{ $d->kk_memiliki_tabungan_keluarga }}</td>

    <td>{{ $d->ket }}</td>
</tr>
@endforeach

</tbody>
</table>

</body>
</html>