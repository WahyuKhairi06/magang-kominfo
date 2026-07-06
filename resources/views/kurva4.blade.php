@include('navbar')
<div class="mt-28">

</div>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
table { border-collapse: collapse; width: 100%; }
th, td {
    border: 1px solid #000;
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
 <div><h3>Kegiatan POKJA IV</h3></div>
 <div class="overflow-x-auto overflow-y-auto max-h-[500px] border p-1">

<table>
<thead>

<!-- BARIS 1 -->
<tr>
    <th rowspan="4">NO</th>
    <th rowspan="4">NAMA DUSUN</th>

    <th colspan="6">JUMLAH KADER</th>
    <th colspan="5">KESEHATAN</th>
    <th colspan="8">KELESTARIAN LINGKUNGAN HIDUP</th>
    <th colspan="5">PERENCANAAN SEHAT</th>

    <th rowspan="4">KET</th>
</tr>

<!-- BARIS 2 -->
<tr>
    <!-- KADER -->
    <th rowspan="3">POSYANDU</th>
    <th rowspan="3">GIZI</th>
    <th rowspan="3">KESLING</th>
    <th rowspan="3">NAPZA</th>
    <th rowspan="3">PHBS</th>
    <th rowspan="3">KB</th>

    <!-- KESEHATAN -->
    <th colspan="2">POSYANDU</th>
    <th colspan="3">LANSIA</th>

    <!-- LINGKUNGAN -->
    <th colspan="3">RUMAH</th>
    <th rowspan="3">MCK</th>
    <th colspan="3">SUMBER AIR</th>

    <!-- PERENCANAAN -->
    <th rowspan="3">PUS</th>
    <th rowspan="3">WUS</th>
    <th colspan="2">AKSEPTOR KB</th>
    <th rowspan="3">TABUNGAN</th>
</tr>

<!-- BARIS 3 -->
<tr>
    <!-- POSYANDU -->
    <th rowspan="2">JUMLAH</th>
    <th rowspan="2">TERINTEGRASI</th>

    <!-- LANSIA -->
    <th rowspan="2">KELOMPOK</th>
    <th rowspan="2">ANGGOTA</th>
    <th rowspan="2">KARTU</th>

    <!-- RUMAH -->
    <th rowspan="2">JAMBAN</th>
    <th rowspan="2">SPAL</th>
    <th rowspan="2">SAMPAH</th>

    <!-- AIR -->
    <th rowspan="2">PDAM</th>
    <th rowspan="2">SUMUR</th>
    <th rowspan="2">LAIN</th>

    <!-- KB -->
    <th rowspan="2">L</th>
    <th rowspan="2">P</th>
</tr>

<tr></tr>

</thead>

<tbody>

@foreach($data_tabel as $i => $d)
<tr>
    <td>{{ $i+1 }}</td>
    <td style="text-align:left">{{ $d->nama_dusun }}</td>

    <!-- KADER -->
    <td>{{ $d->kader_posyandu }}</td>
    <td>{{ $d->kader_gizi }}</td>
    <td>{{ $d->kader_kesling }}</td>
    <td>{{ $d->kader_penyuluhan_narkoba }}</td>
    <td>{{ $d->kader_phbs }}</td>
    <td>{{ $d->kader_kb }}</td>

    <!-- POSYANDU -->
    <td>{{ $d->posyandu_jumlah }}</td>
    <td>{{ $d->posyandu_terintegrasi }}</td>

    <!-- LANSIA -->
    <td>{{ $d->lansia_jumlah_kelompok }}</td>
    <td>{{ $d->lansia_jumlah_anggota }}</td>
    <td>{{ $d->lansia_memiliki_kartu_obat_gratis }}</td>

    <!-- LINGKUNGAN -->
    <td>{{ $d->rumah_memiliki_jamban }}</td>
    <td>{{ $d->rumah_memiliki_spal }}</td>
    <td>{{ $d->rumah_memiliki_tempat_sampah }}</td>

    <td>{{ $d->jumlah_mck }}</td>

    <td>{{ $d->air_pdam }}</td>
    <td>{{ $d->air_sumur }}</td>
    <td>{{ $d->air_lainnya }}</td>

    <!-- PERENCANAAN -->
    <td>{{ $d->jumlah_pus }}</td>
    <td>{{ $d->jumlah_wus }}</td>
    <td>{{ $d->akseptor_kb_l }}</td>
    <td>{{ $d->akseptor_kb_p }}</td>
    <td>{{ $d->kk_memiliki_tabungan_keluarga }}</td>

    <td>{{ $d->ket }}</td>
</tr>
@endforeach

</tbody>
</table>
 </div>
</body>
</html>
{{-- //ednpdf --}}

<div class="p-6 space-y-6">

{{-- <h1 class="text-2xl font-bold">Dashboard Pokja 3</h1> --}}

<!-- FILTER -->
<form method="GET" class="flex gap-3 flex-wrap">

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

    <select name="kategori" class="border p-2 rounded">
        <option value="">Semua</option>
        <option value="kader" {{ $kategori=='kader'?'selected':'' }}>Kader</option>
        <option value="posyandu" {{ $kategori=='posyandu'?'selected':'' }}>Posyandu</option>
        <option value="lansia" {{ $kategori=='lansia'?'selected':'' }}>Lansia</option>
        <option value="lingkungan" {{ $kategori=='lingkungan'?'selected':'' }}>Lingkungan</option>
        <option value="air" {{ $kategori=='air'?'selected':'' }}>Air</option>
        <option value="sehat" {{ $kategori=='sehat'?'selected':'' }}>Sehat</option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
</form>

@if($data->count())

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

<div class="bg-white p-4 rounded shadow">
    <canvas id="pie"></canvas>
</div>

<div class="bg-white p-4 rounded shadow">
    <canvas id="bar"></canvas>
</div>

<div class="bg-white p-4 rounded shadow">
    <canvas id="line"></canvas>
</div>

</div>

@endif

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if($data->count())
<script>

const data = @json($data);
const kategori = "{{ $kategori }}";

/* =========================
TOTAL SEMUA FIELD
========================= */
let t = {
kader_posyandu:0,kader_gizi:0,kader_kesling:0,kader_narkoba:0,kader_phbs:0,kader_kb:0,
posyandu_jumlah:0,posyandu_terintegrasi:0,
lansia_kelompok:0,lansia_anggota:0,lansia_obat:0,
jamban:0,spal:0,sampah:0,mck:0,
air_pdam:0,air_sumur:0,air_lainnya:0,
pus:0,wus:0,kb_l:0,kb_p:0,tabungan:0
};

data.forEach(d=>{
t.kader_posyandu+=d.kader_posyandu;
t.kader_gizi+=d.kader_gizi;
t.kader_kesling+=d.kader_kesling;
t.kader_narkoba+=d.kader_penyuluhan_narkoba;
t.kader_phbs+=d.kader_phbs;
t.kader_kb+=d.kader_kb;

t.posyandu_jumlah+=d.posyandu_jumlah;
t.posyandu_terintegrasi+=d.posyandu_terintegrasi;

t.lansia_kelompok+=d.lansia_jumlah_kelompok;
t.lansia_anggota+=d.lansia_jumlah_anggota;
t.lansia_obat+=d.lansia_memiliki_kartu_obat_gratis;

t.jamban+=d.rumah_memiliki_jamban;
t.spal+=d.rumah_memiliki_spal;
t.sampah+=d.rumah_memiliki_tempat_sampah;
t.mck+=d.jumlah_mck;

t.air_pdam+=d.air_pdam;
t.air_sumur+=d.air_sumur;
t.air_lainnya+=d.air_lainnya;

t.pus+=d.jumlah_pus;
t.wus+=d.jumlah_wus;
t.kb_l+=d.akseptor_kb_l;
t.kb_p+=d.akseptor_kb_p;
t.tabungan+=d.kk_memiliki_tabungan_keluarga;
});

/* =========================
SWITCH KATEGORI
========================= */
let labels=[],values=[];

if(kategori==='kader'){
labels=['Posyandu','Gizi','Kesling','Narkoba','PHBS','KB'];
values=[t.kader_posyandu,t.kader_gizi,t.kader_kesling,t.kader_narkoba,t.kader_phbs,t.kader_kb];
}
else if(kategori==='posyandu'){
labels=['Jumlah','Terintegrasi'];
values=[t.posyandu_jumlah,t.posyandu_terintegrasi];
}
else if(kategori==='lansia'){
labels=['Kelompok','Anggota','Obat'];
values=[t.lansia_kelompok,t.lansia_anggota,t.lansia_obat];
}
else if(kategori==='lingkungan'){
labels=['Jamban','SPAL','Sampah','MCK'];
values=[t.jamban,t.spal,t.sampah,t.mck];
}
else if(kategori==='air'){
labels=['PDAM','Sumur','Lainnya'];
values=[t.air_pdam,t.air_sumur,t.air_lainnya];
}
else if(kategori==='sehat'){
labels=['PUS','WUS','KB L','KB P','Tabungan'];
values=[t.pus,t.wus,t.kb_l,t.kb_p,t.tabungan];
}
else{
labels=['Kader','Posyandu','Lansia','Lingkungan','Air','Sehat'];
values=[
t.kader_posyandu+t.kader_gizi+t.kader_kesling+t.kader_narkoba+t.kader_phbs+t.kader_kb,
t.posyandu_jumlah+t.posyandu_terintegrasi,
t.lansia_kelompok+t.lansia_anggota+t.lansia_obat,
t.jamban+t.spal+t.sampah+t.mck,
t.air_pdam+t.air_sumur+t.air_lainnya,
t.pus+t.wus+t.kb_l+t.kb_p+t.tabungan
];
}

/* =========================
PIE
========================= */
new Chart(document.getElementById('pie'),{
type:'doughnut',
data:{labels:labels,datasets:[{data:values}]}
});

/* =========================
BAR
========================= */
new Chart(document.getElementById('bar'),{
type:'bar',
data:{labels:labels,datasets:[{data:values}]}
});

/* =========================
LINE (TREND)
========================= */
let tahunMap={};
data.forEach(d=>{
if(!tahunMap[d.tahun]) tahunMap[d.tahun]=0;
tahunMap[d.tahun]+=values.reduce((a,b)=>a+b,0);
});

new Chart(document.getElementById('line'),{
type:'line',
data:{
labels:Object.keys(tahunMap),
datasets:[{data:Object.values(tahunMap)}]
}
});

</script>
@endif
@include('footer')