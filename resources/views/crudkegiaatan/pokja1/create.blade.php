@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

<h1 class="text-xl font-bold mb-4">Tambah Kegiatan Pokja 1</h1>

<form action="{{ route('kegiatanpokja1.store') }}" method="POST"
      class="bg-white p-4 rounded shadow">
@csrf

<div class="grid grid-cols-2 gap-3">

    <input type="hidden" name="id_desa" value="{{ $desas->id }}"
        placeholder="Nama Dusun"
        class="border p-2 rounded col-span-2">

    <Select name="id_dusun"  class="rounded-lg w-full" required>
        <option >Pilih Dusun</option>
        @foreach ($dusun as $dusunku)
        <option value="{{ $dusunku->id }}">{{$dusunku->nama_dusun}}</option>
            
        @endforeach
    </Select>
    <input type="number" name="kader_pkbn" placeholder="Kader PKBN" class="border p-2 rounded">
    <input type="number" name="kader_pkdrt" placeholder="Kader PKDRT" class="border p-2 rounded">
    <input type="number" name="kader_pola_asuh" placeholder="Kader Pola Asuh" class="border p-2 rounded">

    <input type="number" name="pkbn_kelompok" placeholder="PKBN Kelompok" class="border p-2 rounded">
    <input type="number" name="pkbn_anggota" placeholder="PKBN Anggota" class="border p-2 rounded">

    <input type="number" name="pkdrt_kelompok" placeholder="PKDRT Kelompok" class="border p-2 rounded">
    <input type="number" name="pkdrt_anggota" placeholder="PKDRT Anggota" class="border p-2 rounded">

    <input type="number" name="pola_asuh_kelompok" placeholder="Pola Asuh Kelompok" class="border p-2 rounded">
    <input type="number" name="pola_asuh_anggota" placeholder="Pola Asuh Anggota" class="border p-2 rounded">

    <input type="number" name="lansia_kelompok" placeholder="Lansia Kelompok" class="border p-2 rounded">
    <input type="number" name="lansia_anggota" placeholder="Lansia Anggota" class="border p-2 rounded">

    <input type="number" name="kerja_bakti" placeholder="Kerja Bakti" class="border p-2 rounded">
    <input type="number" name="rukun_kematian" placeholder="Rukun Kematian" class="border p-2 rounded">

    <input type="number" name="keagamaan" placeholder="Keagamaan" class="border p-2 rounded">
    <input type="number" name="jimpitan" placeholder="Jimpitan" class="border p-2 rounded">

    <input type="number" name="arisan" placeholder="Arisan" class="border p-2 rounded">

    <textarea name="ket" placeholder="Keterangan"
        class="border p-2 rounded col-span-2"></textarea>

</div>

<button class="bg-blue-500 text-white px-4 py-2 mt-4 rounded">
    Simpan
</button>

</form>

</div>

@endsection