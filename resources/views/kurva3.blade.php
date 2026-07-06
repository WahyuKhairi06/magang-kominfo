@include('navbar')


<div class="mt-28"></div>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
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

@foreach($data_tabel as $i => $d)
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
</div>

</body>
</html>
{{-- endpdf --}}

<div class="p-6 space-y-6">

<h1 class="text-2xl font-bold">Grafik Pokja 3 (REAL)</h1>

<!-- FILTER -->
<form method="GET" class="flex gap-4 flex-wrap">

<select name="id_dusun" class="border p-2 rounded">
    <option value="">Semua Dusun</option>
    @foreach($dusuns as $d)
        <option value="{{ $d->id }}" {{ $id_dusun==$d->id?'selected':'' }}>
            {{ $d->nama_dusun }}
        </option>
    @endforeach
</select>

<select name="tahun" class="border p-2 rounded">
    <option value="">Semua Tahun</option>
    @foreach($tahuns as $t)
        <option value="{{ $t->tahun }}" {{ $tahun==$t->tahun?'selected':'' }}>
            {{ $t->tahun }}
        </option>
    @endforeach
</select>

<button class="bg-blue-500 text-white px-4 py-2 rounded">
    Filter
</button>

</form>

@if($data->count())

<!-- CARD TOTAL -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">

@foreach($total as $key => $val)
<div class="bg-white p-4 rounded shadow text-center">
    <p class="text-xs text-gray-500 capitalize">
        {{ str_replace('_',' ', $key) }}
    </p>
    <p class="text-xl font-bold">{{ $val }}</p>
</div>
@endforeach

</div>

<!-- CHART -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<div class="bg-white p-4 rounded shadow">
    <h3 class="font-bold mb-2">Pie Chart</h3>
    <canvas id="pieChart"></canvas>
</div>

<div class="bg-white p-4 rounded shadow">
    <h3 class="font-bold mb-2">Bar Chart</h3>
    <canvas id="barChart"></canvas>
</div>

<div class="bg-white p-4 rounded shadow md:col-span-2">
    <h3 class="font-bold mb-2">Line Chart (Per Tahun)</h3>
    <canvas id="lineChart"></canvas>
</div>

</div>

@else
<div class="bg-yellow-100 p-6 text-center rounded">
    Data belum tersedia
</div>
@endif

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if($data->count())
<script>

const total = @json($total);
const data = @json($data);

// LABEL & VALUE
const labels = Object.keys(total).map(i => i.replaceAll('_',' '));
const values = Object.values(total);

/* ================= PIE ================= */
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: labels,
        datasets: [{
            data: values
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    font: { size: 10 } // biar kebaca
                }
            }
        }
    }
});

/* ================= BAR ================= */
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Total',
            data: values
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                ticks: { font: { size: 9 } }
            }
        }
    }
});

/* ================= LINE ================= */
const tahunLabels = [...new Set(data.map(i => i.tahun))];

const lineData = tahunLabels.map(t =>
    data.filter(d => d.tahun == t)
        .reduce((sum, d) => sum + d.kader_pangan, 0)
);

new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: tahunLabels,
        datasets: [{
            label: 'Kader Pangan',
            data: lineData,
            fill: true
        }]
    }
});

</script>
@endif

@include('footer')