@extends('template.layout')
@section('content')

<div class="p-6 max-w-xl mx-auto">

<div class="bg-white p-6 rounded shadow">

<h3 class="font-bold mb-4">Tambah Data</h3>

<form action="{{ route('bukuagenda.store') }}" method="POST">
@csrf

<select name="desa_id" class="border p-2 w-full mb-3">
<option value="">Pilih Desa</option>
@foreach($desa as $d)
<option value="{{ $d->id }}">{{ $d->nama_desa }}</option>
@endforeach
</select>

<select name="kecamatan_id" class="border p-2 w-full mb-3">
<option value="">Pilih Kecamatan</option>
@foreach($kecamatan as $k)
<option value="{{ $k->id }}">{{ $k->nama_kecamatan }}</option>
@endforeach
</select>

<select name="dusun_id" class="border p-2 w-full mb-3">
<option value="">Pilih Dusun</option>
@foreach($dusun as $d)
<option value="{{ $d->id }}">{{ $d->nama_dusun }}</option>
@endforeach
</select>

<input type="number" name="tahun" placeholder="Tahun" class="border p-2 w-full mb-3">

<button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>

</form>

</div>
</div>

@endsection