@extends('template.layout')

@section('content')
<div class="container mx-auto p-4">

<h1 class="text-xl font-bold mb-4">Tambah Data Buku 3 Ibu Hamil,Melahirkan,Nifas, <br>
Ibu Meninggal,Kelahiran Bayi, Bayi Meninggal,dan Kematian Balita
</h1>

<form action="{{ route('buku3.store') }}" method="POST"
class="bg-white p-4 rounded shadow space-y-4">
@csrf

<input type="hidden" name="id_dasawisma" value="{{ $id }}">

<!-- DATA IBU -->
<h2 class="font-semibold">Data Ibu</h2>
   <select name="bulan_id" class="border p-2 rounded w-full">
                <option value="">-- Semua Bulan --</option>
                @foreach($bulans as $b)
                    <option value="{{ $b->id }}"
                        {{ request('bulan_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->nama_bulan }}
                    </option>
                @endforeach
            </select>
<input name="nama_ibu" placeholder="Nama Ibu" class="border p-2 w-full">
<input name="nama_suami" placeholder="Nama Suami" class="border p-2 w-full">

<select name="status" class="border p-2 w-full">
<option value="">Status</option>
<option>Hamil</option>
<option>Melahirkan</option>
<option>Nifas</option>
</select>

<!-- KELAHIRAN -->
<h2 class="font-semibold">Kelahiran</h2>

<input name="nama_bayi" placeholder="Nama Bayi" class="border p-2 w-full">

<select name="jenis_kelamin_bayi" class="border p-2 w-full">
<option value="">JK Bayi</option>
<option value="L">L</option>
<option value="P">P</option>
</select>

<input type="date" name="tgl_lahir" class="border p-2 w-full">

<select name="akte_kelahiran" class="border p-2 w-full">
<option value="">Akte</option>
<option>Ada</option>
<option>Tidak Ada</option>
</select>

<!-- KEMATIAN -->
<h2 class="font-semibold">Kematian</h2>

<input name="nama_meninggal" placeholder="Nama" class="border p-2 w-full">

<select name="status_meninggal" class="border p-2 w-full">
<option value="">Status</option>
<option>Ibu</option>
<option>Bayi</option>
<option>Balita</option>
</select>

<select name="jenis_kelamin_meninggal" class="border p-2 w-full">
<option value="">JK</option>
<option value="L">L</option>
<option value="P">P</option>
</select>

<input type="date" name="tanggal_meninggal" class="border p-2 w-full">

<input name="sebab_meninggal" placeholder="Sebab" class="border p-2 w-full">

<textarea name="keterangan" class="border p-2 w-full" placeholder="Keterangan"></textarea>

<button class="bg-blue-500 text-white p-2 w-full">Simpan</button>

</form>

</div>
@endsection