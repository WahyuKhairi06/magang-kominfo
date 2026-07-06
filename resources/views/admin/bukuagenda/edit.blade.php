@extends('template.layout')
@section('content')

<div class="p-6 max-w-xl mx-auto">

<div class="bg-white p-6 rounded shadow">

<h3 class="font-bold mb-4">Edit Data</h3>

<form action="{{ route('bukuagenda.update',$data->id) }}" method="POST">
@csrf
@method('PUT')

<select name="desa_id" class="border p-2 w-full mb-3">
@foreach($desa as $d)
<option value="{{ $d->id }}" {{ $data->desa_id==$d->id?'selected':'' }}>
{{ $d->nama_desa }}
</option>
@endforeach
</select>

<select name="kecamatan_id" class="border p-2 w-full mb-3">
@foreach($kecamatan as $k)
<option value="{{ $k->id }}" {{ $data->kecamatan_id==$k->id?'selected':'' }}>
{{ $k->nama_kecamatan }}
</option>
@endforeach
</select>

<select name="dusun_id" class="border p-2 w-full mb-3">
<option value="">-</option>
@foreach($dusun as $d)
<option value="{{ $d->id }}" {{ $data->dusun_id==$d->id?'selected':'' }}>
{{ $d->nama_dusun }}
</option>
@endforeach
</select>

<input type="number" name="tahun" value="{{ $data->tahun }}" class="border p-2 w-full mb-3">

<button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>

</form>

</div>
</div>

@endsection