@include('navbar')

<div class="p-4 md:p-6 max-w-7xl mx-auto mt-[80px] bg-slate-50 min-h-screen">

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow-sm border p-4 mb-6">
<h1 class="text-center text-3xl font-extrabold text-gray-900 tracking-wide">
  Puskesmas Marunggi
  <span class="text-blue-600">Kota Pariaman</span>
</h1>        <form method="GET"
              class="flex flex-col md:flex-row gap-3 md:items-center">

            <div>
                <label class="text-sm font-semibold text-slate-600 block mb-1">
                    Tahun
                </label>

                <select name="tahun"
                        class="border border-slate-300 rounded-xl px-4 py-2 w-full"
                        onchange="this.form.submit()">

                    <option value="2025" {{ $tahun==2025?'selected':'' }}>
                        2025
                    </option>

                    <option value="2026" {{ $tahun==2026?'selected':'' }}>
                        2026
                    </option>

                </select>
            </div>

            <div class="flex-1">
                <label class="text-sm font-semibold text-slate-600 block mb-1">
                    Puskesmas
                </label>

                <select name="dasawisma_id"
                        class="border border-slate-300 rounded-xl px-4 py-2 w-full">

                    <option value="">Semua Puskesmas</option>

                    @foreach($dasawismas as $d)

                    <option value="{{ $d->id }}"
                        {{ request('dasawisma_id') == $d->id ? 'selected' : '' }}>

                        {{ $d->nama_dasawisma }}

                    </option>

                    @endforeach

                </select>
            </div>

            <div class="pt-6">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow">

                    🔍 Filter

                </button>
            </div>

        </form>

    </div>

    {{-- //manuall --}}

@if($tahun == 2025)

<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

    {{-- TBC --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-red-500 via-rose-500 to-pink-600 p-6 text-white shadow-xl">

        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-12 -left-10 w-44 h-44 bg-white/5 rounded-full"></div>

        <div class="relative z-10">

            <div class="flex items-center justify-between">

                <div>
                    <div class="text-sm opacity-80">
                        Persentase
                    </div>

                    <h2 class="text-xl font-bold mt-1">
                        TBC
                    </h2>
                </div>

                <div class="text-5xl opacity-30">
                    🫁
                </div>

            </div>

            <div class="mt-6 text-5xl font-black">
                77.4%
            </div>

            <div class="mt-2 text-sm opacity-80">
                Tahun 2025
            </div>

        </div>

    </div>

    {{-- MBG --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-400 via-orange-500 to-red-500 p-6 text-white shadow-xl">

        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-12 -left-10 w-44 h-44 bg-white/5 rounded-full"></div>

        <div class="relative z-10">

            <div class="flex items-center justify-between">

                <div>
                    <div class="text-sm opacity-80">
                        Persentase
                    </div>

                    <h2 class="text-xl font-bold mt-1">
                        MBG
                    </h2>
                </div>

                <div class="text-5xl opacity-30">
                    🍱
                </div>

            </div>

            <div class="mt-6 text-5xl font-black">
                100%
            </div>

            <div class="mt-2 text-sm opacity-80">
                Tahun 2025
            </div>

        </div>

    </div>

    {{-- SAMPAH --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-500 via-green-500 to-teal-600 p-6 text-white shadow-xl">

        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-12 -left-10 w-44 h-44 bg-white/5 rounded-full"></div>

        <div class="relative z-10">

            <div class="flex items-center justify-between">

                <div>
                    <div class="text-sm opacity-80">
                        Persentase
                    </div>

                    <h2 class="text-xl font-bold mt-1">
                        Sampah Terpilah
                    </h2>
                </div>

                <div class="text-5xl opacity-30">
                    ♻️
                </div>

            </div>

            <div class="mt-6 text-5xl font-black">
                22.6%
            </div>

            <div class="mt-2 text-sm opacity-80">
                Tahun 2025
            </div>

        </div>

    </div>

</div>

@endif
{{-- 
    endmanual --}}

    {{-- ALERT --}}
    @php $top = $ranking->first(); @endphp

    @if($top)

    <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-2xl mb-6 shadow-sm">

        ⚠️ Stunting tertinggi:
        <b>{{ $top->nama_dasawisma }}</b>
        ({{ $top->balita_stunting }})

    </div>

    @endif

    {{-- INFO CARD --}}
    <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">

        @if($tbcTertinggi)

        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl p-5 shadow">

            <div class="text-sm opacity-80">
                TBC Tertinggi
            </div>

            <div class="text-2xl font-black mt-2">
                {{ $tbcTertinggi->tbc ?? 0 }}
            </div>

            <div class="mt-2 text-sm">
                {{ $tbcTertinggi->nama_dasawisma }}
            </div>

        </div>

        @endif


        @if($mbgTerendah)

        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-2xl p-5 shadow">

            <div class="text-sm opacity-80">
                MBG Terendah
            </div>

            <div class="text-2xl font-black mt-2">
                {{ $mbgTerendah->mbg ?? 0 }}
            </div>

            <div class="mt-2 text-sm">
                {{ $mbgTerendah->nama_dasawisma }}
            </div>

        </div>

        @endif


        @if($ckgTerendah)

        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl p-5 shadow">

            <div class="text-sm opacity-80">
                CKG Terendah
            </div>

            <div class="text-2xl font-black mt-2">
                {{ $ckgTerendah->ckg ?? 0 }}
            </div>

            <div class="mt-2 text-sm">
                {{ $ckgTerendah->nama_dasawisma }}
            </div>

        </div>

        @endif


        @if($sampahTerendah)

        <div class="bg-gradient-to-r from-purple-500 to-fuchsia-600 text-white rounded-2xl p-5 shadow">

            <div class="text-sm opacity-80">
                Sampah Terpilah Terendah
            </div>

            <div class="text-2xl font-black mt-2">
                {{ $sampahTerendah->sampah_terpilah ?? 0 }}
            </div>

            <div class="mt-2 text-sm">
                {{ $sampahTerendah->nama_dasawisma }}
            </div>

        </div>

        @endif

    </div>

    {{-- ===================================== --}}
    {{-- LIST GRAFIK --}}
    {{-- ===================================== --}}

    @php

    if($tahun == 2025){

        $charts = [

            'Protokol Kesehatan' => 'protokol_kesehatan',
            'Jamban Sehat' => 'jamban_sehat',
            'Bak Penampungan Air' => 'bak_penampungan_air',
            'Penurunan Penyakit Diare' => 'penurunan_penyakit_diare',
            'Keluarga Sadar Gizi' => 'keluarga_sadar_gizi',
            'Rumah Tanpa Asap Rokok' => 'rumah_tanpa_asap_rokok',
            'BAB Sembarangan' => 'bab_sembarangan',
            'Memiliki Bak Sampah' => 'memiliki_bak_sampah',
            'SPAL' => 'spal',

            'Persalinan di Faskes' => 'persalinan_di_faskes',
            'ASI Ekslusif' => 'asi_ekslusif',
            'Timbang Balita' => 'timbang_balita',
            'Berantas Jentik' => 'berantas_jentik',

            'Makan Buah dan Sayur' => 'makan_buah_dan_sayur',
            'Aktivitas Fisik' => 'aktivitas_fisik',

            'Balita Stunting' => 'balita_stunting',
            'KB' => 'kb',

            'Berpenghasilan Tetap' => 'berpenghasilan_tetap',

        ];

    }else{

        $charts = [

            'TBC' => 'tbc',
            'Jamban Sehat' => 'jamban_sehat',
            'Bak Penampungan Air' => 'bak_penampungan_air',
            'Penyakit Diare' => 'penyakit_diare',
            'Keluarga Sadar Gizi' => 'keluarga_sadar_gizi',
            'Rumah Tanpa Asap Rokok' => 'rumah_tanpa_asap_rokok',
            'BAB Sembarangan' => 'bab_sembarangan',

            'B3 Dapat MBG' => 'b3_dapat_mbg',
            'Sampah Terpilah' => 'sampah_terpilah',

            'SPAL' => 'spal',
            'Persalinan di Faskes' => 'persalinan_ditolong_difaskes',
            'ASI Ekslusif' => 'asi_ekslusif',
            'Timbang Balita' => 'timbang_balita',
            'Berantas Jentik' => 'berantas_jentik',
            'Makan Buah Sayur' => 'makan_buah_sayur',

            'Balita Stunting' => 'balita_stunting',
            'KB Aktif' => 'kb_aktif',
            'Penghasilan Tetap' => 'penghasilan_tetap',

        ];

    }

    @endphp


    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">

        @foreach($charts as $title => $field)

        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden hover:shadow-xl transition duration-300">

            {{-- HEADER --}}
            <div class="bg-gradient-to-r from-slate-800 to-slate-700 text-white p-4">

                <div class="flex items-center justify-between">

                    <div>

                        <div class="text-sm opacity-80">
                            Statistik
                        </div>

                        <h2 class="text-lg font-bold">
                            {{ $title }}
                        </h2>

                    </div>

                    <div class="text-4xl opacity-50">
                        📊
                    </div>

                </div>

            </div>

            {{-- TOTAL --}}
            <div class="p-4 border-b">

                <div class="text-4xl font-black text-slate-800">
@php
$totalDasawisma = request('dasawisma_id')
    ? 1
    : $dasawismas->count();

$totalMax = $totalDasawisma * 100;
@endphp
{{ $totalMax > 0 
    ? round((collect($data)->sum($field) / $totalMax) * 100, 1) 
    : 0 
}}%
                </div>

                <div class="text-sm text-slate-500 mt-1">

                    Total {{ $title }}

                </div>

            </div>

            {{-- CHART --}}
            <div id="pie_{{ Str::slug($field) }}"
                 style="height:350px;">
            </div>

        </div>

        @endforeach

    </div>

    {{-- RANKING --}}
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <div class="p-5 border-b">

            <h2 class="font-bold text-xl text-slate-800">

                Ranking Stunting

            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="p-3 text-center">
                            No
                        </th>

                        <th class="p-3 text-left">
                            Dasawisma
                        </th>

                        <th class="p-3 text-center">
                            Stunting
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($ranking as $i => $r)

                    <tr class="border-t hover:bg-slate-50">

                        <td class="p-3 text-center">
                            {{ $i+1 }}
                        </td>

                        <td class="p-3">
                            {{ $r->nama_dasawisma }}
                        </td>

                        <td class="p-3 text-center font-bold text-red-600">
                            {{ $r->balita_stunting }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- HIGHCHART --}}
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>

<script>

@foreach($charts as $title => $field)

Highcharts.chart('pie_{{ Str::slug($field) }}', {

    chart: {

        // type: 'pie',
    type: '{{ $tahun == 2025 ? "column" : "column" }}',
        backgroundColor: 'transparent',

        // options3d: {
        //     enabled: true,
        //     alpha: 45,
        //     beta: 0
        // }
        options3d: {
    enabled: {{ $tahun == 2025 ? 'true' : 'false' }},
    alpha: 45,
    beta: 0
}

    },

    title: {
        text: ''
    },

    tooltip: {
        pointFormat: '<b>{point.y}</b>'
    },
xAxis: {
    type: 'category'
},

yAxis: {
    title: {
        text: 'Jumlah'
    }
},
    plotOptions: {

        pie: {

            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,

            dataLabels: {

                enabled: true,

                format:
                    '<b>{point.name}</b><br>{point.y}'

            }

        }

    },

    series: [{

        name: '{{ $title }}',

        data: [

            @foreach($data as $d)

            [
                '{{ $d->nama_dasawisma }}',
                {{ $d->$field ?? 0 }}
            ],

            @endforeach

        ]

    }]

});

@endforeach

</script>

@include('footer')