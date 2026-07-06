@include('navbar')

<div class="mt-28">
</div>
{{-- //pdf --}}
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
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
TP. PKK DESA {{ $data_tabel[0]->nama_desa ?? '-' }} <br>
TAHUN 2025
</div>
<div class="overflow-x-auto overflow-y-auto max-h-[500px] border p-1">

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

@foreach($data_tabel as $i => $d)
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
</div>
</body>
</html>
</div>
{{-- 
endpdf --}}
<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold">Dashboard Kurva Pokja 2</h1>

    <!-- FILTER -->
    <form method="GET" class="flex gap-3 flex-wrap">

        <select name="id_dusun" class="border p-2 rounded">
            <option value="">Semua Dusun</option>
            @foreach($dusuns as $d)
                <option value="{{ $d->id }}" {{ $id_dusun == $d->id ? 'selected' : '' }}>
                    {{ $d->nama_dusun }}
                </option>
            @endforeach
        </select>

        <select name="tahun" class="border p-2 rounded">
            <option value="">Semua Tahun</option>
            @foreach($tahuns as $t)
                <option value="{{ $t->tahun }}" {{ $tahun == $t->tahun ? 'selected' : '' }}>
                    {{ $t->tahun }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Filter
        </button>

    </form>

    @if($data->count() > 0)

    <!-- CHART -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- PIE -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-center font-semibold mb-3">Distribusi Semua Data</h3>
            <div class="h-[300px]">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <!-- BAR -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-center font-semibold mb-3">Semua Field</h3>
            <div class="h-[300px]">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- LINE -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-center font-semibold mb-3">Trend Total</h3>
            <div class="h-[300px]">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

    </div>

    @else
        <div class="bg-yellow-100 p-6 text-center rounded">
            Data belum tersedia
        </div>
    @endif

</div>

@if($data->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const data = @json($data);

/* =========================
   TOTAL SEMUA FIELD
========================= */
const total = {
    buta:0,

    a_kel:0,a_war:0,
    b_kel:0,b_war:0,
    c_kel:0,c_war:0,
    kf_kel:0,kf_war:0,

    paud:0,baca:0,

    bkb_kel:0,bkb_ibu:0,bkb_ape:0,bkb_sim:0,

    kader_kf:0,kader_paud:0,kader_bkb:0,
    kader_koperasi:0,kader_keterampilan:0,

    lp3:0,tpk3:0,damas:0,

    kop_pem_kel:0,kop_pem_pes:0,
    kop_mad_kel:0,kop_mad_pes:0,
    kop_uta_kel:0,kop_uta_pes:0,
    kop_man_kel:0,kop_man_pes:0,

    hukum_kel:0,hukum_ang:0
};

data.forEach(d => {
    total.buta += d.jumlah_warga_masih_buta;

    total.a_kel += d.paket_a_kelompok;
    total.a_war += d.paket_a_warga;

    total.b_kel += d.paket_b_kelompok;
    total.b_war += d.paket_b_warga;

    total.c_kel += d.paket_c_kelompok;
    total.c_war += d.paket_c_warga;

    total.kf_kel += d.kf_kelompok;
    total.kf_war += d.kf_warga;

    total.paud += d.paud_sejenis;
    total.baca += d.taman_bacaan;

    total.bkb_kel += d.bkb_kelompok;
    total.bkb_ibu += d.bkb_ibu;
    total.bkb_ape += d.bkb_ape;
    total.bkb_sim += d.bkb_simulasi;

    total.kader_kf += d.kader_kf;
    total.kader_paud += d.kader_paud;
    total.kader_bkb += d.kader_bkb;
    total.kader_koperasi += d.kader_koperasi;
    total.kader_keterampilan += d.kader_keterampilan;

    total.lp3 += d.lp3_pkk;
    total.tpk3 += d.tpk3_pkk;
    total.damas += d.damas_pkk;

    total.kop_pem_kel += d.koperasi_pemula_kelompok;
    total.kop_pem_pes += d.koperasi_pemula_peserta;

    total.kop_mad_kel += d.koperasi_madya_kelompok;
    total.kop_mad_pes += d.koperasi_madya_peserta;

    total.kop_uta_kel += d.koperasi_utama_kelompok;
    total.kop_uta_pes += d.koperasi_utama_peserta;

    total.kop_man_kel += d.koperasi_mandiri_kelompok;
    total.kop_man_pes += d.koperasi_mandiri_peserta;

    total.hukum_kel += d.koperasi_hukum_kelompok;
    total.hukum_ang += d.koperasi_hukum_anggota;
});

/* =========================
   LABEL & VALUE (SEMUA)
========================= */
const labels = Object.keys(total);
const values = Object.values(total);

/* =========================
   PIE
========================= */
new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            data: values
        }]
    },
    options: {
        cutout: '60%',
        maintainAspectRatio: false
    }
});

/* =========================
   BAR
========================= */
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            data: values
        }]
    },
    options: {
        maintainAspectRatio: false
    }
});

/* =========================
   LINE (TREND TOTAL)
========================= */
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: data.map((d,i)=> 'Data '+(i+1)),
        datasets: [{
            label: 'Total Semua Field',
            data: data.map(d =>
                Object.values(d).reduce((a,b)=> (typeof b==='number'?a+b:a),0)
            )
        }]
    },
    options: {
        maintainAspectRatio: false
    }
});
</script>
@endif


@include('footer')