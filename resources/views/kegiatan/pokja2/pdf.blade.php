<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: sans-serif; font-size: 7px; }
table { border-collapse: collapse; width: 100%; }
th, td {
    border: 1px solid black;
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

<table>
<thead>

<!-- BARIS 1 -->
<tr>
    <th rowspan="4">NO</th>
    <th rowspan="4">NAMA DUSUN</th>
    <th rowspan="4">BUTA HURUF</th>

    <th colspan="22">PENDIDIKAN KETERAMPILAN</th>
    <th colspan="10">PENGEMBANGAN KEHIDUPAN BERKOPERASI</th>

    <th rowspan="4">KET</th>
</tr>

<!-- BARIS 2 -->
<tr>
    <!-- PENDIDIKAN -->
    <th colspan="8">KELOMPOK BELAJAR</th>
    <th colspan="2">PAUD & TBM</th>
    <th colspan="4">BKB</th>
    <th colspan="5">KADER KHUSUS</th>
    <th colspan="3">KADER TERLATIH</th>

    <!-- KOPERASI -->
    <th colspan="8">UP2K / PRA KOPERASI</th>
    <th colspan="2">KOPERASI HUKUM</th>
</tr>

<!-- BARIS 3 -->
<tr>
    <!-- KELOMPOK BELAJAR -->
    <th colspan="2">PAKET A</th>
    <th colspan="2">PAKET B</th>
    <th colspan="2">PAKET C</th>
    <th colspan="2">KF</th>

    <!-- PAUD -->
    <th rowspan="2">PAUD</th>
    <th rowspan="2">TBM</th>

    <!-- BKB -->
    <th rowspan="2">KLP</th>
    <th rowspan="2">IBU</th>
    <th rowspan="2">APE</th>
    <th rowspan="2">SIM</th>

    <!-- KADER -->
    <th rowspan="2">KF</th>
    <th rowspan="2">PAUD</th>
    <th rowspan="2">BKB</th>
    <th rowspan="2">KOP</th>
    <th rowspan="2">KETR</th>

    <!-- TERLATIH -->
    <th rowspan="2">LP3</th>
    <th rowspan="2">TPK3</th>
    <th rowspan="2">DAMAS</th>

    <!-- KOPERASI -->
    <th colspan="2">PEMULA</th>
    <th colspan="2">MADYA</th>
    <th colspan="2">UTAMA</th>
    <th colspan="2">MANDIRI</th>

    <!-- HUKUM -->
    <th rowspan="2">KLP</th>
    <th rowspan="2">ANG</th>
</tr>

<!-- BARIS 4 -->
<tr>
    <th>K</th><th>W</th>
    <th>K</th><th>W</th>
    <th>K</th><th>W</th>
    <th>K</th><th>W</th>

    <th>K</th><th>P</th>
    <th>K</th><th>P</th>
    <th>K</th><th>P</th>
    <th>K</th><th>P</th>
</tr>

</thead>

<tbody>

@foreach($data as $i => $d)
<tr>
    <td>{{ $i+1 }}</td>
    <td style="text-align:left">{{ $d->nama_dusun }}</td>

    <td>{{ $d->jumlah_warga_masih_buta }}</td>

    <!-- PAKET -->
    <td>{{ $d->paket_a_kelompok }}</td>
    <td>{{ $d->paket_a_warga }}</td>

    <td>{{ $d->paket_b_kelompok }}</td>
    <td>{{ $d->paket_b_warga }}</td>

    <td>{{ $d->paket_c_kelompok }}</td>
    <td>{{ $d->paket_c_warga }}</td>

    <td>{{ $d->kf_kelompok }}</td>
    <td>{{ $d->kf_warga }}</td>

    <!-- PAUD -->
    <td>{{ $d->paud_sejenis }}</td>
    <td>{{ $d->taman_bacaan }}</td>

    <!-- BKB -->
    <td>{{ $d->bkb_kelompok }}</td>
    <td>{{ $d->bkb_ibu }}</td>
    <td>{{ $d->bkb_ape }}</td>
    <td>{{ $d->bkb_simulasi }}</td>

    <!-- KADER KHUSUS -->
    <td>{{ $d->kader_kf }}</td>
    <td>{{ $d->kader_paud }}</td>
    <td>{{ $d->kader_bkb }}</td>
    <td>{{ $d->kader_koperasi }}</td>
    <td>{{ $d->kader_keterampilan }}</td>

    <!-- TERLATIH -->
    <td>{{ $d->lp3_pkk }}</td>
    <td>{{ $d->tpk3_pkk }}</td>
    <td>{{ $d->damas_pkk }}</td>

    <!-- KOPERASI -->
    <td>{{ $d->koperasi_pemula_kelompok }}</td>
    <td>{{ $d->koperasi_pemula_peserta }}</td>

    <td>{{ $d->koperasi_madya_kelompok }}</td>
    <td>{{ $d->koperasi_madya_peserta }}</td>

    <td>{{ $d->koperasi_utama_kelompok }}</td>
    <td>{{ $d->koperasi_utama_peserta }}</td>

    <td>{{ $d->koperasi_mandiri_kelompok }}</td>
    <td>{{ $d->koperasi_mandiri_peserta }}</td>

    <!-- HUKUM -->
    <td>{{ $d->koperasi_hukum_kelompok }}</td>
    <td>{{ $d->koperasi_hukum_anggota }}</td>

    <td>{{ $d->ket }}</td>
</tr>
@endforeach

</tbody>
</table>

</body>
</html>