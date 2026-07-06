@include('navbar')

<div class="min-h-screen bg-slate-100 pt-[90px] pb-10 px-4 md:px-8">

    {{-- HEADER --}}
    <div class="max-w-7xl mx-auto mb-8">

        <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 rounded-[32px] p-8 shadow-2xl overflow-hidden relative">

            <div class="absolute -top-16 -right-16 w-72 h-72 bg-white/10 rounded-full"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-white/5 rounded-full"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>

                    <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-md px-4 py-2 rounded-full text-white text-sm font-semibold mb-5">

                        📊 Dashboard Statistik Dasawisma

                    </div>

                    <h1 class="text-4xl md:text-5xl font-black text-white leading-tight">

                        Data Kependudukan
                        <span class="block text-cyan-200">
                            PKK & Dasawisma
                        </span>

                    </h1>

                    <p class="text-cyan-50/80 mt-4 max-w-2xl leading-relaxed">

                        Monitoring jumlah warga, kehamilan, balita,
                        serta statistik kesehatan masyarakat berdasarkan
                        dusun dan dasawisma secara realtime.

                    </p>

                </div>

                <div class="flex gap-4">

                    <div class="bg-white/10 backdrop-blur-lg rounded-3xl px-6 py-5 text-white min-w-[150px]">

                        <div class="text-sm opacity-80">
                            Total Warga
                        </div>

                        <div class="text-4xl font-black mt-2">

                            {{ number_format($totalL + $totalP,0,',','.') }}

                        </div>

                    </div>

                    <div class="bg-white/10 backdrop-blur-lg rounded-3xl px-6 py-5 text-white min-w-[150px]">

                        <div class="text-sm opacity-80">
                            Dasawisma
                        </div>

                        <div class="text-4xl font-black mt-2">

                            {{ $dasawismas->count() }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- FILTER --}}
    <div class="max-w-7xl mx-auto mb-8">

        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">

            <form method="GET"
                  class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>

                    <label class="text-sm font-bold text-slate-600 block mb-2">
                        Pilih Dusun
                    </label>

                    <select name="dusun_id"
                            class="w-full border border-slate-300 rounded-2xl px-4 py-3 focus:ring-4 focus:ring-cyan-200 focus:border-cyan-500"
                            onchange="this.form.submit()">

                        <option value="">
                            Semua Dusun
                        </option>

                        @foreach($dusuns as $d)

                        <option value="{{ $d->id }}"
                            {{ request('dusun_id') == $d->id ? 'selected' : '' }}>

                            {{ $d->nama_dusun }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div>

                    <label class="text-sm font-bold text-slate-600 block mb-2">
                        Pilih Dasawisma
                    </label>

                    <select name="dasawisma_id"
                            class="w-full border border-slate-300 rounded-2xl px-4 py-3 focus:ring-4 focus:ring-cyan-200 focus:border-cyan-500">

                        <option value="">
                            Semua Dasawisma
                        </option>

                        @foreach($dasawismas as $d)

                        <option value="{{ $d->id }}"
                            {{ request('dasawisma_id') == $d->id ? 'selected' : '' }}>

                            {{ $d->nama_dasawisma }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="flex items-end">

                    <button class="w-full bg-gradient-to-r from-cyan-600 to-blue-600 hover:scale-[1.02] transition-all text-white py-3 rounded-2xl font-bold shadow-lg">

                        🔍 Tampilkan Statistik

                    </button>

                </div>

            </form>

        </div>

    </div>

    {{-- CARD --}}
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        {{-- TOTAL --}}
        <div class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden">

            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full"></div>

            <div class="relative z-10">

                <div class="text-sm opacity-80">
                    Total Warga
                </div>

                <div class="text-5xl font-black mt-3">

                    {{ number_format($totalL + $totalP,0,',','.') }}

                </div>

                <div class="mt-4 flex justify-between text-sm">

                    <div>
                        👨 {{ number_format($totalL,0,',','.') }}
                    </div>

                    <div>
                        👩 {{ number_format($totalP,0,',','.') }}
                    </div>

                </div>

            </div>

        </div>

        {{-- HAMIL --}}
        <div class="bg-gradient-to-br from-pink-500 to-rose-500 rounded-3xl p-6 text-white shadow-xl">

            <div class="text-sm opacity-80">
                Ibu Hamil
            </div>

            <div class="text-5xl font-black mt-3">

                {{ $kehamilan->where('status','Hamil')->sum('total') }}

            </div>

            <div class="mt-4 opacity-80 text-sm">
                Data Kehamilan
            </div>

        </div>

        {{-- MELAHIRKAN --}}
        <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-3xl p-6 text-white shadow-xl">

            <div class="text-sm opacity-80">
                Melahirkan
            </div>

            <div class="text-5xl font-black mt-3">

                {{ $kehamilan->where('status','Melahirkan')->sum('total') }}

            </div>

            <div class="mt-4 opacity-80 text-sm">
                Data Persalinan
            </div>

        </div>

        {{-- NIFAS --}}
        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-3xl p-6 text-white shadow-xl">

            <div class="text-sm opacity-80">
                Nifas
            </div>

            <div class="text-5xl font-black mt-3">

                {{ $kehamilan->where('status','Nifas')->sum('total') }}

            </div>

            <div class="mt-4 opacity-80 text-sm">
                Pasca Melahirkan
            </div>

        </div>

    </div>

    {{-- CHART --}}
    <div class="max-w-7xl mx-auto grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

        {{-- PIE --}}
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">

            <div class="flex items-center justify-between mb-4">

                <div>

                    <h2 class="text-2xl font-black text-slate-800">
                        Komposisi Warga
                    </h2>

                    <div class="text-slate-500 mt-1">
                        Berdasarkan Jenis Kelamin
                    </div>

                </div>

                <div class="text-5xl">
                    👨‍👩‍👧‍👦
                </div>

            </div>

            <div id="pieGender" style="height:420px;"></div>

        </div>

        {{-- COLUMN --}}
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">

            <div class="flex items-center justify-between mb-4">

                <div>

                    <h2 class="text-2xl font-black text-slate-800">
                        Statistik Kehamilan
                    </h2>

                    <div class="text-slate-500 mt-1">
                        Hamil, Melahirkan, Nifas
                    </div>

                </div>

                <div class="text-5xl">
                    🤱
                </div>

            </div>

            <div id="chartKehamilan" style="height:420px;"></div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="max-w-7xl mx-auto">

        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

            <div class="p-6 border-b bg-slate-50">

                <h2 class="text-2xl font-black text-slate-800">

                    Data Dasawisma

                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-100">

                        <tr>

                            <th class="p-4 text-left">
                                Dusun
                            </th>

                            <th class="p-4 text-left">
                                Dasawisma
                            </th>

                            <th class="p-4 text-center">
                                👨 L
                            </th>

                            <th class="p-4 text-center">
                                👩 P
                            </th>

                            <th class="p-4 text-center">
                                Total
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($catatan as $c)

                        <tr class="border-t hover:bg-cyan-50 transition">

                            <td class="p-4 font-semibold text-slate-700">
                                {{ $c->nama_dusun }}
                            </td>

                            <td class="p-4">
                                {{ $c->nama_dasawisma }}
                            </td>

                            <td class="p-4 text-center text-blue-600 font-bold">
                                {{ $c->laki }}
                            </td>

                            <td class="p-4 text-center text-pink-500 font-bold">
                                {{ $c->perempuan }}
                            </td>

                            <td class="p-4 text-center font-black text-emerald-600">
                                {{ $c->total }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script src="https://code.highcharts.com/highcharts.js"></script>

<script>

Highcharts.chart('pieGender', {

    chart: {
        type: 'pie'
    },

    title: {
        text: ''
    },

    plotOptions: {

        pie: {

            innerSize: '60%',

            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b><br>{point.y}'
            }

        }

    },

    series: [{

        name: 'Jumlah',

        data: [

            {
                name: 'Laki-Laki',
                y: {{ $totalL }},
                color: '#2563eb'
            },

            {
                name: 'Perempuan',
                y: {{ $totalP }},
                color: '#ec4899'
            }

        ]

    }]

});

Highcharts.chart('chartKehamilan', {

    chart: {
        type: 'column'
    },

    title: {
        text: ''
    },

    xAxis: {
        type: 'category'
    },

    yAxis: {

        title: {
            text: 'Jumlah'
        }

    },

    series: [{

        name: 'Jumlah',

        colorByPoint: true,

        data: [

            @foreach($kehamilan as $k)

            [
                '{{ $k->status }}',
                {{ $k->total }}
            ],

            @endforeach

        ]

    }]

});

</script>

@include('footer')