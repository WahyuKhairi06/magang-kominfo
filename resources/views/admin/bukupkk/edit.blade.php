@extends('template.layout')
@section('content')

<div class="max-w-4xl mx-auto p-6">

<div class="bg-white rounded-3xl shadow border p-6">

    <h2 class="text-xl font-bold mb-6">✏️ Edit Buku PKK</h2>

<form action="{{ route('bukupkk.update',$data->id) }}" method="POST">
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

<!-- DESA -->
<select name="desa_id" class="border p-2 rounded">
    @foreach($desa as $d)
    <option value="{{ $d->id }}"
        {{ $data->desa_id == $d->id ? 'selected' : '' }}>
        {{ $d->nama_desa }}
    </option>
    @endforeach
</select>

<!-- KECAMATAN -->
<select name="kecamatan_id" class="border p-2 rounded">
    @foreach($kecamatan as $k)
    <option value="{{ $k->id }}"
        {{ $data->kecamatan_id == $k->id ? 'selected' : '' }}>
        {{ $k->nama_kecamatan }}
    </option>
    @endforeach
</select>

<!-- DUSUN -->
<select name="dusun_id" class="border p-2 rounded">
    @foreach($dusun as $d)
    <option value="{{ $d->id }}"
        {{ $data->dusun_id == $d->id ? 'selected' : '' }}>
        {{ $d->nama_dusun }}
    </option>
    @endforeach
</select>

<!-- MASA MULAI -->
<input type="number" name="masa_mulai"
    value="{{ $data->masa_mulai }}"
    class="border p-2 rounded">

<!-- MASA SELESAI -->
<input type="number" name="masa_selesai"
    value="{{ $data->masa_selesai }}"
    class="border p-2 rounded">

</div>

<button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded-xl">
    Update
</button>

</form>

</div>

</div>

@endsection