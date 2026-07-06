@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

<h1 class="text-xl font-bold mb-4">Edit Data Wilayah PKK</h1>

<form action="{{ route('wilayah.update',$data->id) }}" method="POST" class="space-y-3">
@csrf

<select name="id_dusun" class="border p-2 w-full">
    @foreach($dusun as $d)
        <option value="{{ $d->id }}"
            {{ $data->id_dusun == $d->id ? 'selected' : '' }}>
            {{ $d->nama_dusun }}
        </option>
    @endforeach
</select>

<input type="number" name="pkk_rw" value="{{ $data->pkk_rw }}"
class="border p-2 w-full">

<input type="number" name="pkk_rt" value="{{ $data->pkk_rt }}"
class="border p-2 w-full">

<input type="number" name="dasawisma" value="{{ $data->dasawisma }}"
class="border p-2 w-full">

<input type="number" name="krt" value="{{ $data->krt }}"
class="border p-2 w-full">

<input type="number" name="kk" value="{{ $data->kk }}"
class="border p-2 w-full">

<hr>

<h2 class="font-bold">Jiwa</h2>
<input type="number" name="jiwa_l" value="{{ $data->jiwa_l }}"
class="border p-2 w-full">

<input type="number" name="jiwa_p" value="{{ $data->jiwa_p }}"
class="border p-2 w-full">

<hr>

<h2 class="font-bold">Kader TP PKK</h2>
<input type="number" name="kader_tp_l" value="{{ $data->kader_tp_l }}"
class="border p-2 w-full">

<input type="number" name="kader_tp_p" value="{{ $data->kader_tp_p }}"
class="border p-2 w-full">

<h2 class="font-bold">Kader Umum</h2>
<input type="number" name="kader_umum_l" value="{{ $data->kader_umum_l }}"
class="border p-2 w-full">

<input type="number" name="kader_umum_p" value="{{ $data->kader_umum_p }}"
class="border p-2 w-full">

<h2 class="font-bold">Kader Khusus</h2>
<input type="number" name="kader_khusus_l" value="{{ $data->kader_khusus_l }}"
class="border p-2 w-full">

<input type="number" name="kader_khusus_p" value="{{ $data->kader_khusus_p }}"
class="border p-2 w-full">

<hr>

<h2 class="font-bold">Sekretariat</h2>
<input type="number" name="sekretariat_honorer_l" value="{{ $data->sekretariat_honorer_l }}"
class="border p-2 w-full">

<input type="number" name="sekretariat_honorer_p" value="{{ $data->sekretariat_honorer_p }}"
class="border p-2 w-full">

<input type="number" name="sekretariat_bantuan_l" value="{{ $data->sekretariat_bantuan_l }}"
class="border p-2 w-full">

<input type="number" name="sekretariat_bantuan_p" value="{{ $data->sekretariat_bantuan_p }}"
class="border p-2 w-full">

<textarea name="ket" class="border p-2 w-full">{{ $data->ket }}</textarea>

<button class="bg-blue-500 text-white px-4 py-2 rounded">
    Update
</button>

</form>

</div>

@endsection