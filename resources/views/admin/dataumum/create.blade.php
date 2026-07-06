@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

<h1 class="text-xl font-bold mb-4">Tambah Data Wilayah PKK</h1>

<form action="{{ route('wilayah.store') }}" method="POST" class="space-y-3">
@csrf

  <input type="hidden" name="id_desa" value="{{ $desas->id }}"
        placeholder="Nama Dusun"
        class="border p-2 rounded col-span-2">

    <Select name="id_dusun"  class="rounded-lg w-full" required>
        <option >Pilih Dusun</option>
        @foreach ($dusun as $dusunku)
        <option value="{{ $dusunku->id }}">{{$dusunku->nama_dusun}}</option>
            
        @endforeach
    </Select>

<input type="number" name="pkk_rw" placeholder="PKK RW"
class="border p-2 w-full">
@error('pkk_rw') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

<input type="number" name="pkk_rt" placeholder="PKK RT"
class="border p-2 w-full">

<input type="number" name="dasawisma" placeholder="Dasawisma"
class="border p-2 w-full">

<input type="number" name="krt" placeholder="KRT"
class="border p-2 w-full">

<input type="number" name="kk" placeholder="KK"
class="border p-2 w-full">

<hr>

<h2 class="font-bold">Jiwa</h2>
<input type="number" name="jiwa_l" placeholder="Jiwa L"
class="border p-2 w-full">

<input type="number" name="jiwa_p" placeholder="Jiwa P"
class="border p-2 w-full">

<hr>

<h2 class="font-bold">Kader TP PKK</h2>
<input type="number" name="kader_tp_l" placeholder="L"
class="border p-2 w-full">
<input type="number" name="kader_tp_p" placeholder="P"
class="border p-2 w-full">

<h2 class="font-bold">Kader Umum</h2>
<input type="number" name="kader_umum_l" placeholder="L"
class="border p-2 w-full">
<input type="number" name="kader_umum_p" placeholder="P"
class="border p-2 w-full">

<h2 class="font-bold">Kader Khusus</h2>
<input type="number" name="kader_khusus_l" placeholder="L"
class="border p-2 w-full">
<input type="number" name="kader_khusus_p" placeholder="P"
class="border p-2 w-full">

<hr>

<h2 class="font-bold">Sekretariat</h2>
<input type="number" name="sekretariat_honorer_l" placeholder="Honorer L"
class="border p-2 w-full">

<input type="number" name="sekretariat_honorer_p" placeholder="Honorer P"
class="border p-2 w-full">

<input type="number" name="sekretariat_bantuan_l" placeholder="Bantuan L"
class="border p-2 w-full">

<input type="number" name="sekretariat_bantuan_p" placeholder="Bantuan P"
class="border p-2 w-full">

<textarea name="ket" placeholder="Keterangan"
class="border p-2 w-full"></textarea>

<button class="bg-green-500 text-white px-4 py-2 rounded">
    Simpan
</button>

</form>

</div>

@endsection