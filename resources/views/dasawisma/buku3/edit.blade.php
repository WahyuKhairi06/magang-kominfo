@extends('template.layout')

@section('content')
<div class="container mx-auto p-4">

<h1 class="text-xl font-bold mb-4">Edit Data Ibu Hamil,Melahirkan,Nifas, <br>
Ibu Meninggal,Kelahiran Bayi, Bayi Meninggal,dan Kematian Balita
</h1>
<form action="{{ route('buku3.update',$data->id) }}" method="POST"
class="bg-white p-4 rounded shadow space-y-4">
@csrf
@method('PUT')


   <select name="bulan_id" class="border p-2 rounded w-full">
    <option value="">-- Semua Bulan --</option>
    @foreach ($bulans as $b)
        <option value="{{ $b->id }}"
    {{ $data->bulan_id == $b->id ? 'selected' : '' }}>
    {{ $b->nama_bulan }}
</option>
    @endforeach
</select>
@error('bulan_id')
    <span class="text-red-500 text-sm">{{ $message }}</span>
@enderror

<input type="hidden" name="id_dasawisma" value="{{ $data->id_dasawisma }}">

<!-- DATA IBU -->
<h2 class="font-semibold">Data Ibu</h2>

<input name="nama_ibu" value="{{ $data->nama_ibu }}" class="border p-2 w-full">
<input name="nama_suami" value="{{ $data->nama_suami }}" class="border p-2 w-full">

<select name="status" class="border p-2 w-full">
<option {{ $data->status=='Hamil'?'selected':'' }}>Hamil</option>
<option {{ $data->status=='Melahirkan'?'selected':'' }}>Melahirkan</option>
<option {{ $data->status=='Nifas'?'selected':'' }}>Nifas</option>
</select>

<!-- KELAHIRAN -->
<h2 class="font-semibold">Kelahiran</h2>

<input name="nama_bayi" value="{{ $data->nama_bayi }}" class="border p-2 w-full">

<select name="jenis_kelamin_bayi" class="border p-2 w-full">
<option value="L" {{ $data->jenis_kelamin_bayi=='L'?'selected':'' }}>L</option>
<option value="P" {{ $data->jenis_kelamin_bayi=='P'?'selected':'' }}>P</option>
</select>

<input type="date" name="tgl_lahir" value="{{ $data->tgl_lahir }}" class="border p-2 w-full">

<select name="akte_kelahiran" class="border p-2 w-full">
<option {{ $data->akte_kelahiran=='Ada'?'selected':'' }}>Ada</option>
<option {{ $data->akte_kelahiran=='Tidak Ada'?'selected':'' }}>Tidak Ada</option>
</select>

<!-- KEMATIAN -->
<h2 class="font-semibold">Kematian</h2>

<input name="nama_meninggal" value="{{ $data->nama_meninggal }}" class="border p-2 w-full">

<select name="status_meninggal" class="border p-2 w-full">
<option {{ $data->status_meninggal=='Ibu'?'selected':'' }}>Ibu</option>
<option {{ $data->status_meninggal=='Bayi'?'selected':'' }}>Bayi</option>
<option {{ $data->status_meninggal=='Balita'?'selected':'' }}>Balita</option>
</select>

<select name="jenis_kelamin_meninggal" class="border p-2 w-full">
<option value="L" {{ $data->jenis_kelamin_meninggal=='L'?'selected':'' }}>L</option>
<option value="P" {{ $data->jenis_kelamin_meninggal=='P'?'selected':'' }}>P</option>
</select>

<input type="date" name="tanggal_meninggal"
       value="{{ $data->tanggal_meninggal }}"
       class="border p-2 w-full">

<input name="sebab_meninggal"
       value="{{ $data->sebab_meninggal }}"
       class="border p-2 w-full">

<textarea name="keterangan" class="border p-2 w-full">{{ $data->keterangan }}</textarea>

<button class="bg-green-500 text-white p-2 w-full">Update</button>

</form>

</div>
@endsection