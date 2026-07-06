@extends('template.layout')

@section('content')
<div class="container mx-auto p-4">

<h1 class="text-xl font-bold mb-4">Edit Data Buku 2 Catatan Data dan Kegiatan Warga</h1>

@if($errors->any())
<div class="bg-red-100 p-2 mb-3">
    @foreach($errors->all() as $e)
        <div>{{ $e }}</div>
    @endforeach
</div>
@endif

<form action="{{ route('buku2.update',$data->id) }}" method="POST"
class="bg-white p-4 rounded shadow space-y-6">
@csrf
@method('PUT')

<!-- 🔥 JUMLAH KK -->
<div>
    <label>Jumlah KK</label>
    <input type="number" name="jumlah_kk"
           value="{{ $data->jumlah_kk }}"
           class="border p-2 w-full">
</div>

<!-- 🔥 JUMLAH ANGGOTA -->
<div>
<h2 class="font-semibold">Jumlah Anggota</h2>
<div class="grid grid-cols-3 gap-3 mt-2">

<div><label>Total Laki</label><input type="number" name="total_l" value="{{ $data->total_l }}" class="border p-2 w-full"></div>
<div><label>Total Perempuan</label><input type="number" name="total_p" value="{{ $data->total_p }}" class="border p-2 w-full"></div>

<div><label>Balita L</label><input type="number" name="balita_l" value="{{ $data->balita_l }}" class="border p-2 w-full"></div>
<div><label>Balita P</label><input type="number" name="balita_p" value="{{ $data->balita_p }}" class="border p-2 w-full"></div>

<div><label>PUS</label><input type="number" name="pus" value="{{ $data->pus }}" class="border p-2 w-full"></div>
<div><label>WUS</label><input type="number" name="wus" value="{{ $data->wus }}" class="border p-2 w-full"></div>

<div><label>Ibu Hamil</label><input type="number" name="ibu_hamil" value="{{ $data->ibu_hamil }}" class="border p-2 w-full"></div>
<div><label>Ibu Menyusui</label><input type="number" name="ibu_menyusui" value="{{ $data->ibu_menyusui }}" class="border p-2 w-full"></div>

<div><label>Lansia</label><input type="number" name="lansia" value="{{ $data->lansia }}" class="border p-2 w-full"></div>
<div><label>3 Buta</label><input type="number" name="buta" value="{{ $data->buta }}" class="border p-2 w-full"></div>

<div><label>Berkebutuhan Khusus</label><input type="number" name="berkebutuhan_khusus" value="{{ $data->berkebutuhan_khusus }}" class="border p-2 w-full"></div>

</div>
</div>

<!-- 🔥 KRITERIA RUMAH -->
<div>
<h2 class="font-semibold">Kriteria Rumah</h2>
<div class="grid grid-cols-3 gap-3 mt-2">

<div>
    <label>Sehat Layak Huni</label>
    <input type="number" name="sehat_layak_huni"
           value="{{ $data->sehat_layak_huni }}"
           class="border p-2 w-full">
</div>

<div>
    <label>Tidak Layak Huni</label>
    <input type="number" name="tidak_sehat_layak_huni"
           value="{{ $data->tidak_sehat_layak_huni }}"
           class="border p-2 w-full">
</div>

<label class="flex items-center gap-2">
    <input type="hidden" name="ada_tempat_buang_sampah" value="0">

    <input type="checkbox"
        name="ada_tempat_buang_sampah"
        value="1"
        {{ $data->ada_tempat_buang_sampah ? 'checked' : '' }}>

    Ada Tempat Sampah
</label>

<label class="flex items-center gap-2">
    <input type="hidden" name="spal" value="0">

    <input type="checkbox"
        name="spal"
        value="1"
        {{ $data->spal ? 'checked' : '' }}>

    SPAL
</label>

<label class="flex items-center gap-2">
    <input type="hidden" name="mck_septik_tank" value="0">

    <input type="checkbox"
        name="mck_septik_tank"
        value="1"
        {{ $data->mck_septik_tank ? 'checked' : '' }}>

    MCK Septik Tank
</label>

<label class="flex items-center gap-2">
    <input type="hidden" name="pdam" value="0">

    <input type="checkbox"
        name="pdam"
        value="1"
        {{ $data->pdam ? 'checked' : '' }}>

    PDAM
</label>

<div>
    <label>Sumber Air</label>
    <select name="sumber_air" class="border p-2 w-full">
        <option value="">Pilih</option>
        <option value="PDAM" {{ $data->sumber_air=='PDAM'?'selected':'' }}>PDAM</option>
        <option value="Sumur" {{ $data->sumber_air=='Sumur'?'selected':'' }}>Sumur</option>
        <option value="Lainnya" {{ $data->sumber_air=='Lainnya'?'selected':'' }}>Lainnya</option>
    </select>
</div>

<div>
    <label>Makanan Pokok</label>
    <select name="makanan_pokok" class="border p-2 w-full">
        <option value="Beras" {{ $data->makanan_pokok=='Beras'?'selected':'' }}>Beras</option>
        <option value="Non Beras" {{ $data->makanan_pokok=='Non Beras'?'selected':'' }}>Non Beras</option>
    </select>
</div>

</div>
</div>

<!-- 🔥 KEGIATAN -->
<div>
<h2 class="font-semibold">Kegiatan Warga</h2>
<div class="grid grid-cols-2 gap-3 mt-2">

<label><input type="checkbox" name="up2k" {{ $data->up2k?'checked':'' }}> UP2K</label>
<label><input type="checkbox" name="pemanfataan_perkarangan" {{ $data->pemanfataan_perkarangan?'checked':'' }}> Pemanfaatan Pekarangan</label>
<label><input type="checkbox" name="industri_rumah_tanggal" {{ $data->industri_rumah_tanggal?'checked':'' }}> Industri Rumah Tangga</label>
<label><input type="checkbox" name="kesehatan_lingkungan" {{ $data->kesehatan_lingkungan?'checked':'' }}> Kesehatan Lingkungan</label>

</div>
</div>

<!-- 🔥 KETERANGAN -->
<div>
<label>Keterangan</label>
<textarea name="ket" class="border p-2 w-full">{{ $data->ket }}</textarea>
</div>

<button class="bg-green-500 text-white px-4 py-2 rounded w-full">
    Update
</button>

</form>
</div>
@endsection