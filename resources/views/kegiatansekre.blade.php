@include('navbar')


<div class="mt-28"></div>


<!DOCTYPE html>
<html>
<head>
<style>

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
{{-- //endpdf --}}
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Dashboard Sekretariat</h1>

    <p class="mb-4">
        Desa: {{ $desa->nama_desa ?? '-' }} | Tahun: {{ $info->tahun ?? '-' }}
    </p>

    {{-- BAR CHART --}}
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-lg font-semibold mb-3">Total Data per Kategori</h2>
        <canvas id="barChart"></canvas>
    </div>

    {{-- TABLE --}} 
    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">No</th>
                    <th class="p-2">Dusun</th>
                    <th class="p-2">KK</th>
                    <th class="p-2">Jiwa L</th>
                    <th class="p-2">Jiwa P</th>
                    <th class="p-2">PKK RW</th>
                    <th class="p-2">PKK RT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $d)
                <tr>
                    <td class="p-2">{{ $i+1 }}</td>
                    <td class="p-2">{{ $d->nama_dusun }}</td>
                    <td class="p-2">{{ $d->kk }}</td>
                    <td class="p-2">{{ $d->jiwa_l }}</td>
                    <td class="p-2">{{ $d->jiwa_p }}</td>
                    <td class="p-2">{{ $d->pkk_rw }}</td>
                    <td class="p-2">{{ $d->pkk_rt }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('barChart').getContext('2d');

    const barData = {
        labels: {!! json_encode(array_keys($total)) !!},
        datasets: [{
            label: 'Jumlah Total',
            data: {!! json_encode(array_values($total)) !!},
            backgroundColor: 'rgba(59, 130, 246, 0.7)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 1
        }]
    };

    new Chart(ctx, {
        type: 'bar',
        data: barData,
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@include('footer')