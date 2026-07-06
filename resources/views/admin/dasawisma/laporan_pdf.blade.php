{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 10px; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }

        th {
            background: #eee;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <h3>KUISIONER PHBS RUMAH TANGGA</h3>
    <p>Desa: {{ $data->first()->nama_desa ?? '-' }}</p>
    <p>Dusun: {{ $data->first()->nama_dusun ?? '-' }}</p>
    <p>Kecamatan: {{ $data->first()->nama_kecamatan ?? '-' }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Dasawisma</th>
            <th>TBC</th>
            <th>Jamban</th>
            <th>Bak Air</th>
            <th>Diare</th>
            <th>Gizi</th>
            <th>Asap Rokok</th>
            <th>BAB</th>
            <th>Sampah</th>
            <th>SPAL</th>
            <th>Faskes</th>
            <th>ASI</th>
            <th>Timbang</th>
            <th>Jentik</th>
            <th>Buah</th>
            <th>Fisik</th>
            <th>Stunting</th>
            <th>KB</th>
            <th>Penghasilan</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $d->nama_dasawisma }}</td>
            <td>{{ $d->tbc }}</td>
            <td>{{ $d->jamban_sehat }}</td>
            <td>{{ $d->bak_penampungan_air }}</td>
            <td>{{ $d->penyakit_diare }}</td>
            <td>{{ $d->keluarga_sadar_gizi }}</td>
            <td>{{ $d->rumah_tanpa_asap_rokok }}</td>
            <td>{{ $d->bab_sembarangan }}</td>
            <td>{{ $d->sampah_terpilah }}</td>
            <td>{{ $d->spal }}</td>
            <td>{{ $d->persalinan_di_faskes }}</td>
            <td>{{ $d->asi_ekslusif }}</td>
            <td>{{ $d->timbang_balita }}</td>
            <td>{{ $d->berantas_jentik }}</td>
            <td>{{ $d->makan_buah_sayur }}</td>
            <td>{{ $d->aktivitas_fisik }}</td>
            <td>{{ $d->balita_stunting }}</td>
            <td>{{ $d->kb_aktif }}</td>
            <td>{{ $d->penghasilan_tetap }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html> --}}




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 9px; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* ======================
           HEADER
        ====================== */
        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header h3 {
            margin: 0;
        }

        /* ======================
           HEADER RIGHT (INFO)
        ====================== */
        .header-right {
            margin-bottom: 5px;
        }

        .header-table td {
            border: none;
            padding: 1px 2px;
            font-size: 10px;
        }

        /* ======================
           TABEL UTAMA
        ====================== */
        .main-table th, 
        .main-table td {
            border: 1px solid black;
            padding: 2px;
            text-align: center;
        }

        .main-table th {
            background: #eee;
            font-size: 9px;
        }

        /* Nama rata kiri */
        .main-table td:nth-child(2) {
            text-align: left;
        }

        /* Biar tidak melebar */
        .main-table td {
            white-space: nowrap;
        }

    </style>
</head>

<body>

<!-- ======================
     HEADER
====================== -->
<div class="header">
    <h3>KUISIONER PHBS RUMAH TANGGA</h3>
    <h3>KOTA PARIAMAN TAHUN 2025</h3>
</div>

<!-- ======================
     INFO DESA
====================== -->
<div class="header-right">
    <table class="header-table">
        <tr>
            <td style="width:60px;">Desa</td>
            <td>: {{ $data->first()->nama_desa ?? '-' }}</td>
        </tr>
        <tr>
            <td>Dusun</td>
            <td>: {{ $data->first()->nama_dusun ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kecamatan</td>
            <td>: {{ $data->first()->nama_kecamatan ?? '-' }}</td>
        </tr>
    </table>
</div>

<!-- ======================
     TABEL DATA
====================== -->
<table class="main-table">

    <thead>
        <tr>
            <th>No</th>
            <th>Nama Dasawisma</th>
            <th>Prokes</th>
            <th>Jamban</th>
            <th>Bak Air</th>
            <th>Diare</th>
            <th>Gizi</th>
            <th>Asap</th>
            <th>BAB</th>
            <th>Sampah</th>
            <th>SPAL</th>
            <th>Faskes</th>
            <th>ASI</th>
            <th>Timbang</th>
            <th>Jentik</th>
            <th>Buah</th>
            <th>Fisik</th>
            <th>Stunting</th>
            <th>KB</th>
            <th>Penghasilan</th>
            <th>Keterangan</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $d->nama_dasawisma }}</td>

            <td>{{ $d->protokol_kesehatan }}</td>
            <td>{{ $d->jamban_sehat }}</td>
            <td>{{ $d->bak_penampungan_air }}</td>
            <td>{{ $d->penurunan_penyakit_diare }}</td>
            <td>{{ $d->keluarga_sadar_gizi }}</td>
            <td>{{ $d->rumah_tanpa_asap_rokok }}</td>
            <td>{{ $d->bab_sembarangan }}</td>
            <td>{{ $d->memiliki_bak_sampah }}</td>
            <td>{{ $d->spal }}</td>

            <td>{{ $d->persalinan_di_faskes }}</td>
            <td>{{ $d->asi_ekslusif }}</td>
            <td>{{ $d->timbang_balita }}</td>
            <td>{{ $d->berantas_jentik }}</td>

            <td>{{ $d->makan_buah_dan_sayur }}</td>
            <td>{{ $d->aktivitas_fisik }}</td>

            <td>{{ $d->balita_stunting }}</td>
            <td>{{ $d->kb }}</td>

            <td>{{ $d->berpenghasilan_tetap }}</td>
            <td>{{ $d->ket }}</td>
        </tr>
        @endforeach
    </tbody>

</table>

</body>
</html>