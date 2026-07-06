@include('navbar')

{{-- //pdf --}}
<div class="mt-28"></div>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Kegiatan PKK</title>
    <style>
        

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }

        th {
            font-weight: bold;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="title">
    DATA KEGIATAN PKK <br>
    TP. PKK DESA TALAGO SARIak <br>
    TAHUN 2025
</div>
<div style="overflow-x:auto; overflow-y:auto; max-height:500px; border:1px solid #ccc; padding:4px;">

<table>
    <thead>
        <tr>
            <th rowspan="3">NO</th>
            <th rowspan="3">NAMA DUSUN</th>
            <th colspan="3">JUMLAH KADER</th>
            <th colspan="8">PENGHAYATAN & PENGAMALAN PANCASILA</th>
            <th colspan="5">GOTONG ROYONG</th>
            <th rowspan="3">KET</th>
        </tr>

        <tr>
            <th rowspan="2">PKBN</th>
            <th rowspan="2">PKDRT</th>
            <th rowspan="2">POLA ASUH</th>

            <th colspan="2">PKBN</th>
            <th colspan="2">PKDRT</th>
            <th colspan="2">POLA ASUH</th>
            <th colspan="2">LANSIA</th>

            <th rowspan="2">KERJA BAKTI</th>
            <th rowspan="2">RUKUN</th>
            <th rowspan="2">KEAGAMAAN</th>
            <th rowspan="2">JIMPITAN</th>
            <th rowspan="2">ARISAN</th>
        </tr>

        <tr>
            <th>Kelompok</th>
            <th>Anggota</th>

            <th>Kelompok</th>
            <th>Anggota</th>

            <th>Kelompok</th>
            <th>Anggota</th>

            <th>Kelompok</th>
            <th>Anggota</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data_tabel as $i => $row)
        <tr>
            <td>{{ $i+1 }}</td>
            <td style="text-align:left;">{{ $row->nama_dusun }}</td>

            <td>{{ $row->kader_pkbn }}</td>
            <td>{{ $row->kader_pkdrt }}</td>
            <td>{{ $row->kader_pola_asuh }}</td>

            <td>{{ $row->pkbn_kelompok }}</td>
            <td>{{ $row->pkbn_anggota }}</td>

            <td>{{ $row->pkdrt_kelompok }}</td>
            <td>{{ $row->pkdrt_anggota }}</td>

            <td>{{ $row->pola_asuh_kelompok }}</td>
            <td>{{ $row->pola_asuh_anggota }}</td>

            <td>{{ $row->lansia_kelompok }}</td>
            <td>{{ $row->lansia_anggota }}</td>

            <td>{{ $row->kerja_bakti }}</td>
            <td>{{ $row->rukun_kematian }}</td>
            <td>{{ $row->keagamaan }}</td>
            <td>{{ $row->jimpitan }}</td>
            <td>{{ $row->arisan }}</td>

            <td>{{ $row->ket }}</td>
        </tr>
        @endforeach

        <!-- TOTAL -->
        <tr style="font-weight:bold;">
            <td colspan="2">TOTAL</td>

            <td>{{ $data_tabel->sum('kader_pkbn') }}</td>
            <td>{{ $data_tabel->sum('kader_pkdrt') }}</td>
            <td>{{ $data_tabel->sum('kader_pola_asuh') }}</td>

            <td>{{ $data_tabel->sum('pkbn_kelompok') }}</td>
            <td>{{ $data_tabel->sum('pkbn_anggota') }}</td>

            <td>{{ $data_tabel->sum('pkdrt_kelompok') }}</td>
            <td>{{ $data_tabel->sum('pkdrt_anggota') }}</td>

            <td>{{ $data_tabel->sum('pola_asuh_kelompok') }}</td>
            <td>{{ $data_tabel->sum('pola_asuh_anggota') }}</td>

            <td>{{ $data_tabel->sum('lansia_kelompok') }}</td>
            <td>{{ $data_tabel->sum('lansia_anggota') }}</td>

            <td>{{ $data_tabel->sum('kerja_bakti') }}</td>
            <td>{{ $data_tabel->sum('rukun_kematian') }}</td>
            <td>{{ $data_tabel->sum('keagamaan') }}</td>
            <td>{{ $data_tabel->sum('jimpitan') }}</td>
            <td>{{ $data_tabel->sum('arisan') }}</td>

            <td></td>
        </tr>

    </tbody>
</table>
</div>
</body>
</html>
{{-- 
enpdf --}}

<div class="p-6 space-y-6">

<h1 class="text-2xl font-bold">Dashboard Semua Data Pokja 1</h1>

<!-- FILTER -->
<form method="GET" class="flex gap-4 flex-wrap">
    <select name="id_dusun" class="border p-2 rounded">
        <option value="">Semua Dusun</option>
        @foreach($dusuns as $d)
            <option value="{{ $d->id }}" {{ $id_dusun == $d->id ? 'selected' : '' }}>
                {{ $d->nama_dusun }}
            </option>
        @endforeach
    </select>

    <button class="bg-blue-500 text-white px-4 py-2 rounded">
        Filter
    </button>
</form>

<!-- CARD TOTAL -->
{{-- <div class="bg-indigo-600 text-white p-6 rounded-xl shadow">
    <h2>Total Semua Data</h2>
    <p class="text-3xl font-bold">{{ $total }}</p>
</div> --}}

@if($data->count() > 0)

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

<!-- PIE ALL -->
<div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-center mb-3 font-semibold">Distribusi Semua Data</h3>
    <div class="h-[300px]">
        <canvas id="pieChart"></canvas>
    </div>
</div>

<!-- BAR ALL -->
<div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-center mb-3 font-semibold">Semua Field</h3>
    <div class="h-[300px]">
        <canvas id="barChart"></canvas>
    </div>
</div>

<!-- LINE ALL -->
<div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-center mb-3 font-semibold">Trend Data</h3>
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
   HITUNG TOTAL SEMUA DATA
========================= */
const total = {
    kader_pkbn: 0,
    kader_pkdrt: 0,
    kader_pola_asuh: 0,

    pkbn_anggota: 0,
    pkdrt_anggota: 0,
    pola_asuh_anggota: 0,
    lansia_anggota: 0,

    kerja_bakti: 0,
    rukun_kematian: 0,
    keagamaan: 0,
    jimpitan: 0,
    arisan: 0
};

/* LOOP SEMUA DATA */
data.forEach(d => {
    total.kader_pkbn += d.kader_pkbn;
    total.kader_pkdrt += d.kader_pkdrt;
    total.kader_pola_asuh += d.kader_pola_asuh;

    total.pkbn_anggota += d.pkbn_anggota;
    total.pkdrt_anggota += d.pkdrt_anggota;
    total.pola_asuh_anggota += d.pola_asuh_anggota;
    total.lansia_anggota += d.lansia_anggota;

    total.kerja_bakti += d.kerja_bakti;
    total.rukun_kematian += d.rukun_kematian;
    total.keagamaan += d.keagamaan;
    total.jimpitan += d.jimpitan;
    total.arisan += d.arisan;
});

/* =========================
   LABEL & VALUE TOTAL
========================= */
const labels = [
    'PKBN','PKDRT','Pola Asuh',
    'PKBN Anggota','PKDRT Anggota','Pola Asuh Anggota','Lansia',
    'Kerja Bakti','Rukun','Keagamaan','Jimpitan','Arisan'
];

const values = [
    total.kader_pkbn,
    total.kader_pkdrt,
    total.kader_pola_asuh,

    total.pkbn_anggota,
    total.pkdrt_anggota,
    total.pola_asuh_anggota,
    total.lansia_anggota,

    total.kerja_bakti,
    total.rukun_kematian,
    total.keagamaan,
    total.jimpitan,
    total.arisan
];

/* =========================
   PIE (TOTAL)
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
        maintainAspectRatio: false,
        cutout: '60%'
    }
});

/* =========================
   BAR (TOTAL)
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
   LINE (TOTAL PER RECORD)
========================= */
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: data.map((d,i)=> 'Data '+(i+1)),
        datasets: [{
            label: 'Total per input',
            data: data.map(d =>
                d.kader_pkbn +
                d.kader_pkdrt +
                d.kader_pola_asuh +
                d.pkbn_anggota +
                d.pkdrt_anggota +
                d.pola_asuh_anggota +
                d.lansia_anggota +
                d.kerja_bakti +
                d.rukun_kematian +
                d.keagamaan +
                d.jimpitan +
                d.arisan
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