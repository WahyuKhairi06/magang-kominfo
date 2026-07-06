@extends('template.layout')
@section('content')

<div class="max-w-4xl mx-auto p-6">

<div class="bg-white rounded-3xl shadow border p-6">

    <h2 class="text-xl font-bold mb-6">➕ Tambah Buku PKK</h2>

<form action="{{ route('bukupkk.store') }}" method="POST">
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

<!-- DESA -->
<select name="desa_id" class="border p-2 rounded @error('desa_id') border-red-500 @enderror">
    <option value="">Pilih Desa</option>
    @foreach($desa as $d)
    <option value="{{ $d->id }}">{{ $d->nama_desa }}</option>
    @endforeach
</select>

<!-- KECAMATAN -->
<select name="kecamatan_id" class="border p-2 rounded @error('kecamatan_id') border-red-500 @enderror">
    <option value="">Pilih Kecamatan</option>
    @foreach($kecamatan as $k)
    <option value="{{ $k->id }}">{{ $k->nama_kecamatan }}</option>
    @endforeach
</select>

<!-- DUSUN -->
<select name="dusun_id" class="border p-2 rounded">
    <option value="">Pilih Dusun</option>
    @foreach($dusun as $d)
    <option value="{{ $d->id }}">{{ $d->nama_dusun }}</option>
    @endforeach
</select>

<!-- MASA MULAI -->
<input type="number" name="masa_mulai" placeholder="Tahun Mulai (2025)"
    class="border p-2 rounded @error('masa_mulai') border-red-500 @enderror">

<!-- MASA SELESAI -->
<input type="number" name="masa_selesai" placeholder="Tahun Selesai (2030)"
    class="border p-2 rounded @error('masa_selesai') border-red-500 @enderror">

</div>

<button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded-xl">
    Simpan
</button>

</form>

</div>

</div>

@endsection