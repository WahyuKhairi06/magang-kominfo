@extends('template.layout')

@section('content')
<div class="container mx-auto p-4">

<h1 class="text-xl font-bold mb-4">Tambah Data Buku 2 Catatan Data dan Kegiatan Warga</h1>

@if($errors->any())
<div class="bg-red-100 p-2 mb-3">
    @foreach($errors->all() as $e)
        <div>{{ $e }}</div>
    @endforeach
</div>
@endif

<form action="{{ route('buku2.store',$dasawisma->id) }}" method="POST"
class="bg-white p-4 rounded shadow space-y-6">
@csrf
<div>
    <label class="text-sm">ID Dasawisma</label>
    <input type="hidden" name="id_dasawisma" value="{{ $dasawisma->id }}" class="border p-2 w-full">
</div>
<!-- 🔥 JUMLAH KK -->
<div>
    <label>Kepala Rumah Tangga</label>
<input name="nama_kepala_rumah_tangga" placeholder="Nama" class="border p-2 w-full">
</div>
<div>
    <label>Jumlah KK</label>
    <input type="number" name="jumlah_kk" class="border p-2 w-full">
</div>

<!-- 🔥 JUMLAH ANGGOTA -->
<div>
<h2 class="font-semibold">Jumlah Anggota</h2>
<div class="grid grid-cols-3 gap-3 mt-2">

<div><label>Total Laki</label><input type="number" name="total_l" class="border p-2 w-full"></div>
<div><label>Total Perempuan</label><input type="number" name="total_p" class="border p-2 w-full"></div>

<div><label>Balita L</label><input type="number" name="balita_l" class="border p-2 w-full"></div>
<div><label>Balita P</label><input type="number" name="balita_p" class="border p-2 w-full"></div>

<div><label>PUS</label><input type="number" name="pus" class="border p-2 w-full"></div>
<div><label>WUS</label><input type="number" name="wus" class="border p-2 w-full"></div>

<div><label>Ibu Hamil</label><input type="number" name="ibu_hamil" class="border p-2 w-full"></div>
<div><label>Ibu Menyusui</label><input type="number" name="ibu_menyusui" class="border p-2 w-full"></div>

<div><label>Lansia</label><input type="number" name="lansia" class="border p-2 w-full"></div>
<div><label>3 Buta</label><input type="number" name="buta" class="border p-2 w-full"></div>

<div><label>Berkebutuhan Khusus</label><input type="number" name="berkebutuhan_khusus" class="border p-2 w-full"></div>

</div>
</div>

<!-- 🔥 KRITERIA RUMAH -->
<div>
<h2 class="font-semibold">Kriteria Rumah</h2>
<div class="grid grid-cols-3 gap-3 mt-2">

<div>
    <label>Sehat Layak Huni</label>
    <input type="number" name="sehat_layak_huni" class="border p-2 w-full">
</div>

<div>
    <label>Tidak Layak Huni</label>
    <input type="number" name="tidak_sehat_layak_huni" class="border p-2 w-full">
</div>

<label class="flex items-center gap-2">
    <input type="checkbox" name="ada_tempat_buang_sampah">
    Ada Tempat Sampah
</label>

<label class="flex items-center gap-2">
    <input type="checkbox" name="spal">
    SPAL
</label>

<label class="flex items-center gap-2">
    <input type="checkbox" name="mck_septik_tank">
    MCK Septik Tank
</label>

<label class="flex items-center gap-2">
    <input type="checkbox" name="pdam">
    PDAM
</label>

<div>
    <label>Sumber Air</label>
    <select name="sumber_air" class="border p-2 w-full">
        <option value="">Pilih</option>
        <option value="PDAM">PDAM</option>
        <option value="Sumur">Sumur</option>
        <option value="Lainnya">Lainnya</option>
    </select>
</div>

<div>
    <label>Makanan Pokok</label>
    <select name="makanan_pokok" class="border p-2 w-full">
        <option value="Beras">Beras</option>
        <option value="Non Beras">Non Beras</option>
    </select>
</div>

</div>
</div>

<!-- 🔥 KEGIATAN WARGA -->
<div>
<h2 class="font-semibold">Kegiatan Warga</h2>
<div class="grid grid-cols-2 gap-3 mt-2">

<label><input type="checkbox" name="up2k"> UP2K</label>
<label><input type="checkbox" name="pemanfataan_perkarangan"> Pemanfaatan Pekarangan</label>
<label><input type="checkbox" name="industri_rumah_tanggal"> Industri Rumah Tangga</label>
<label><input type="checkbox" name="kesehatan_lingkungan"> Kesehatan Lingkungan</label>

</div>
</div>

<!-- 🔥 KETERANGAN -->
<div>
<label>Keterangan</label>
<textarea name="ket" class="border p-2 w-full"></textarea>
</div>

<button class="bg-blue-500 text-white px-4 py-2 rounded w-full">
    Simpan
</button>

</form>
</div>
@endsection