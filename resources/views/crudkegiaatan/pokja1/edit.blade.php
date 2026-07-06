@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

<h1 class="text-xl font-bold mb-4">Edit Kegiatan Pokja 1</h1>

<form action="{{ route('kegiatanpokja1.update',$data->id) }}" method="POST"
      class="bg-white p-4 rounded shadow">
@csrf
@method('PUT')

<div class="grid grid-cols-2 gap-3">

   
    <select name="id_dusun">
    <option value="">Pilih Dusun</option>

    @foreach ($dusun as $dusunku)
        <option value="{{ $dusunku->id }}"
            {{ $data->id_dusun == $dusunku->id ? 'selected' : '' }}>
            {{ $dusunku->nama_dusun }}
        </option>
    @endforeach
</select>

    <input type="number" name="kader_pkbn"
        value="{{ $data->kader_pkbn }}"
        class="border p-2 rounded">

    <input type="number" name="kader_pkdrt"
        value="{{ $data->kader_pkdrt }}"
        class="border p-2 rounded">

    <input type="number" name="kader_pola_asuh"
        value="{{ $data->kader_pola_asuh }}"
        class="border p-2 rounded">

    <input type="number" name="pkbn_kelompok"
        value="{{ $data->pkbn_kelompok }}"
        class="border p-2 rounded">

    <input type="number" name="pkbn_anggota"
        value="{{ $data->pkbn_anggota }}"
        class="border p-2 rounded">

    <input type="number" name="pkdrt_kelompok"
        value="{{ $data->pkdrt_kelompok }}"
        class="border p-2 rounded">

    <input type="number" name="pkdrt_anggota"
        value="{{ $data->pkdrt_anggota }}"
        class="border p-2 rounded">

    <input type="number" name="pola_asuh_kelompok"
        value="{{ $data->pola_asuh_kelompok }}"
        class="border p-2 rounded">

    <input type="number" name="pola_asuh_anggota"
        value="{{ $data->pola_asuh_anggota }}"
        class="border p-2 rounded">

    <input type="number" name="lansia_kelompok"
        value="{{ $data->lansia_kelompok }}"
        class="border p-2 rounded">

    <input type="number" name="lansia_anggota"
        value="{{ $data->lansia_anggota }}"
        class="border p-2 rounded">

    <input type="number" name="kerja_bakti"
        value="{{ $data->kerja_bakti }}"
        class="border p-2 rounded">

    <input type="number" name="rukun_kematian"
        value="{{ $data->rukun_kematian }}"
        class="border p-2 rounded">

    <input type="number" name="keagamaan"
        value="{{ $data->keagamaan }}"
        class="border p-2 rounded">

    <input type="number" name="jimpitan"
        value="{{ $data->jimpitan }}"
        class="border p-2 rounded">

    <input type="number" name="arisan"
        value="{{ $data->arisan }}"
        class="border p-2 rounded">

    <textarea name="ket"
        class="border p-2 rounded col-span-2">{{ $data->ket }}</textarea>

</div>

<button class="bg-yellow-500 text-white px-4 py-2 mt-4 rounded">
    Update
</button>

</form>

</div>

@endsection