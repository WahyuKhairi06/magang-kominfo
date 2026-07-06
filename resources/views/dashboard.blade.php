@extends('template.layout')
@section('content')

<div class="p-6 space-y-6">

<!-- ================= CARD ================= -->
<div class="grid md:grid-cols-4 gap-6">

<!-- <div class="bg-white p-5 rounded-2xl shadow">
    <p class="text-sm text-gray-500">Total Produk</p>
    <h2 class="text-3xl font-bold">{{ $totalProduk }}</h2>
</div> -->

<!-- <div class="bg-white p-5 rounded-2xl shadow">
    <p class="text-sm text-gray-500">Produk Aktif</p>
    <h2 class="text-3xl font-bold text-green-600">{{ $produkAktif }}</h2>
</div> -->

<!-- <div class="bg-white p-5 rounded-2xl shadow">
    <p class="text-sm text-gray-500">Anggota PKK</p>
    <h2 class="text-3xl font-bold text-pink-600">{{ $totalAnggota }}</h2>
</div> -->

<!-- <div class="bg-white p-5 rounded-2xl shadow">
    <p class="text-sm text-gray-500">Buku PKK</p>
    <h2 class="text-3xl font-bold text-blue-600">{{ $totalBukuPkk }}</h2> -->
</div>

</div>

<!-- ================= CARD 2 ================= -->
<!-- <div class="grid md:grid-cols-3 gap-6">

<div class="bg-white p-5 rounded-2xl shadow">
    <p class="text-sm text-gray-500">Surat Masuk</p>
    <h2 class="text-2xl font-bold">{{ $suratMasuk }}</h2>
</div>

<div class="bg-white p-5 rounded-2xl shadow">
    <p class="text-sm text-gray-500">Surat Keluar</p>
    <h2 class="text-2xl font-bold">{{ $suratKeluar }}</h2>
</div>

<div class="bg-white p-5 rounded-2xl shadow">
    <p class="text-sm text-gray-500">Stok Menipis</p>
    <h2 class="text-2xl font-bold text-red-500">{{ $stokMenipis }}</h2> -->
<!-- </div>

</div> -->
<!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6"> -->

    <!-- TOTAL VISITOR -->
    <!-- <div class="bg-white shadow rounded-xl p-5 border">
        <p class="text-sm text-gray-500">Total Pengunjung</p>
        <h2 class="text-3xl font-bold text-blue-600">
            {{ number_format($totalVisitor) }}
        </h2>
    </div> -->

    <!-- HARI INI -->
    <!-- <div class="bg-white shadow rounded-xl p-5 border">
        <p class="text-sm text-gray-500">Pengunjung Hari Ini</p>
        <h2 class="text-3xl font-bold text-green-600">
            {{ number_format($todayVisitor) }}
        </h2> -->
    <!-- </div>

</div> -->
<!-- ================= CHART ================= -->
<!-- <div class="bg-white p-6 rounded-2xl shadow">
    <h3 class="font-bold mb-4">Produk per Kategori</h3>
    <canvas id="chartKategori"></canvas>
</div> -->

<!-- ================= DATA ================= -->
<div class="flex justify-center">

    <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden w-full max-w-3xl">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b bg-slate-50">
            <div>
                <h3 class="text-lg font-bold text-slate-800">
                    Inovasi Terbaru
                </h3>
                
            </div>

            <div class="w-11 h-11 rounded-xl bg-primary/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary">
                    emoji_objects
                </span>
            </div>
        </div>

        <!-- List -->
        <div class="divide-y divide-slate-100">

            @foreach($inovasiTerbaru as $p)

            <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition">

                <div class="flex items-center gap-4">

                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">

                        <span class="material-symbols-outlined text-yellow-600 text-[20px]">
                            lightbulb
                        </span>

                    </div>

                    <div>

                        <h4 class="font-semibold text-slate-700">
                            {{ $p->judul_inovasi }}
                        </h4>

                        <p class="text-xs text-slate-500">
                            Judul Inovasi
                        </p>

                    </div>

                </div>

                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                    {{ $p->tahun_inovasi }}
                </span>

            </div>

            @endforeach

            @if(count($inovasiTerbaru)==0)

            <div class="text-center py-10 text-slate-400">

                <span class="material-symbols-outlined text-5xl mb-2">
                    inbox
                </span>

                <p>Belum ada data inovasi.</p>

            </div>

            @endif

        </div>

    </div>

    <!-- TEMPAT CARD SELANJUTNYA -->
    <!--
    <div class="bg-white rounded-3xl shadow-lg border border-slate-200">
        ....
    </div>
    -->

</div>

<!-- ================= CHART JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chartKategori');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($kategori->toArray())) !!},
        datasets: [{
            label: 'Jumlah Produk',
            data: {!! json_encode(array_values($kategori->toArray())) !!}
        }]
    }
});
</script>

@endsection