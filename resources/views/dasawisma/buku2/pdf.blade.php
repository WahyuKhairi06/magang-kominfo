<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-size:10px; }
table { border-collapse: collapse; width:100%; }
th, td { border:1px solid black; padding:3px; text-align:center; }
.no-border td { border:none; }
</style>
</head>

<body>

<!-- 🔥 HEADER -->
<table class="no-border">
<tr>
<td style="width:70%;">
    <b>REKAPITULASI</b><br>
    CATATAN DATA DAN KEGIATAN WARGA<br>
    KELOMPOK DASAWISMA
</td>

<td style="width:30%; text-align:left;">
    Dasawisma : {{ $data->first()->nama_dasawisma ?? '-' }}<br>
    Desa : {{ $data->first()->nama_desa ?? '-' }}<br>
    Tahun : {{ $data->first()->tahun_daswisma }}
</td>
</tr>
</table>

<br>

<!-- 🔥 TABLE -->
<table>

<thead>

<!-- BARIS 1 -->
<tr>
<th rowspan="3">No</th>
<th rowspan="3">Nama Kepala Rumah Tangga</th>
<th rowspan="3">Jumlah KK</th>

<th colspan="11">JUMLAH ANGGOTA KELUARGA</th>
<th colspan="6">KRITERIA RUMAH</th>
<th colspan="2">SUMBER AIR</th>
<th colspan="2">MAKANAN POKOK</th>
<th colspan="4">KEGIATAN</th>
<th rowspan="3">Ket</th>
</tr>

<!-- BARIS 2 -->
<tr>
<th colspan="2">Total</th>
<th colspan="2">Balita</th>
<th rowspan="2">PUS</th>
<th rowspan="2">WUS</th>
<th rowspan="2">Hamil</th>
<th rowspan="2">Menyusui</th>
<th rowspan="2">Lansia</th>
<th rowspan="2">3 Buta</th>
<th rowspan="2">Khusus</th>

<th rowspan="2">Layak</th>
<th rowspan="2">Tidak Layak</th>
<th rowspan="2">Sampah</th>
<th rowspan="2">SPAL</th>
<th rowspan="2">MCK</th>
<th rowspan="2">PDAM</th>

<th rowspan="2">PDAM</th>
<th rowspan="2">Sumur</th>

<th rowspan="2">Beras</th>
<th rowspan="2">Non</th>

<th rowspan="2">UP2K</th>
<th rowspan="2">Pekarangan</th>
<th rowspan="2">Industri</th>
<th rowspan="2">Lingkungan</th>
</tr>

<!-- BARIS 3 -->
<tr>
<th>L</th><th>P</th>
<th>L</th><th>P</th>
</tr>

</thead>

<tbody>

@foreach($data as $i => $d)
<tr>

<td>{{ $i+1 }}</td>
<td>{{ $d->nama_kepala_rumah_tangga }}</td>
<td>{{ $d->jumlah_kk }}</td>

<td>{{ $d->total_l }}</td>
<td>{{ $d->total_p }}</td>

<td>{{ $d->balita_l }}</td>
<td>{{ $d->balita_p }}</td>

<td>{{ $d->pus }}</td>
<td>{{ $d->wus }}</td>
<td>{{ $d->ibu_hamil }}</td>
<td>{{ $d->ibu_menyusui }}</td>
<td>{{ $d->lansia }}</td>
<td>{{ $d->buta }}</td>
<td>{{ $d->berkebutuhan_khusus }}</td>

<td>{{ $d->sehat_layak_huni }}</td>
<td>{{ $d->tidak_sehat_layak_huni }}</td>

<td>{{ $d->ada_tempat_buang_sampah ? 'v' : '-' }}</td>
<td>{{ $d->spal ? 'v' : '-' }}</td>
<td>{{ $d->mck_septik_tank ? 'v' : '-' }}</td>
<td>{{ $d->pdam ? 'v' : '-' }}</td>

<td>{{ $d->sumber_air == 'PDAM' ? 'v' : '' }}</td>
<td>{{ $d->sumber_air == 'Sumur' ? 'v' : '' }}</td>

<td>{{ $d->makanan_pokok == 'Beras' ? 'v' : '' }}</td>
<td>{{ $d->makanan_pokok == 'Non Beras' ? 'v' : '' }}</td>

<td>{{ $d->up2k ? 'v' : '' }}</td>
<td>{{ $d->pemanfataan_perkarangan ? 'v' : '' }}</td>
<td>{{ $d->industri_rumah_tanggal ? 'v' : '' }}</td>
<td>{{ $d->kesehatan_lingkungan ? 'v' : '' }}</td>

<td>{{ $d->ket }}</td>

</tr>
@endforeach

</tbody>
</table>

</body>
</html>