@extends('template.layout')
@section('content')

<div class="p-6 max-w-5xl mx-auto">

<div class="bg-white p-6 rounded-2xl shadow">

<h3 class="font-bold text-lg mb-4">Edit Data</h3>

<form action="{{ route('rekapbuku.update',$data->id) }}" method="POST">
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

<!-- NAMA -->
<div>
<label class="text-sm font-medium">Nama</label>
<input type="text" name="nama" value="{{ $data->nama }}" class="border p-2 rounded w-full">
</div>

<!-- JENIS KELAMIN -->
<div>
<label class="text-sm font-medium">Jenis Kelamin</label>
<select name="jenis_kelamin" class="border p-2 rounded w-full">
<option value="L" {{ $data->jenis_kelamin=='L'?'selected':'' }}>Laki-laki</option>
<option value="P" {{ $data->jenis_kelamin=='P'?'selected':'' }}>Perempuan</option>
</select>
</div>

<!-- KEANGGOTAAN -->
<div>
<label class="text-sm font-medium">Keanggotaan PKK</label>
<input type="text" name="dalam_keanggotaan_tp_pkk"
value="{{ $data->dalam_keanggotaan_tp_pkk }}" class="border p-2 rounded w-full" required>
</div>

<!-- KADER UMUM -->
<div>
<label class="text-sm font-medium">Kader Umum</label>
<input type="text" name="kader_umum" value="{{ $data->kader_umum }}" class="border p-2 rounded w-full">
</div>

<!-- KADER KHUSUS -->
<div>
<label class="text-sm font-medium">Kader Khusus</label>
<input type="text" name="kader_khusus" value="{{ $data->kader_khusus }}" class="border p-2 rounded w-full">
</div>

<!-- TANGGAL LAHIR -->
<div>
<label class="text-sm font-medium">Tanggal Lahir</label>
<input type="date" name="tanggal_lahir" value="{{ $data->tanggal_lahir }}" class="border p-2 rounded w-full">
</div>

<!-- STATUS -->
<div>
<label class="text-sm font-medium">Status</label>
<select name="status" class="border p-2 rounded w-full">
    <option value="Belum Menikah" {{ $data->status=='Belum Menikah'?'selected':'' }}>Belum Menikah</option>
    <option value="Menikah" {{ $data->status=='Menikah'?'selected':'' }}>Menikah</option>
    <option value="Cerai Hidup" {{ $data->status=='Cerai Hidup'?'selected':'' }}>Cerai Hidup</option>
    <option value="Cerai Mati" {{ $data->status=='Cerai Mati'?'selected':'' }}>Cerai Mati</option>
</select>
</div>

<!-- PENDIDIKAN -->
<div>
<label class="text-sm font-medium">Pendidikan</label>
<select name="pendidikan" class="border p-2 rounded w-full">
    <option value="Tidak Sekolah" {{ $data->pendidikan=='Tidak Sekolah'?'selected':'' }}>Tidak Sekolah</option>
    <option value="SD" {{ $data->pendidikan=='SD'?'selected':'' }}>SD</option>
    <option value="SMP" {{ $data->pendidikan=='SMP'?'selected':'' }}>SMP</option>
    <option value="SMA" {{ $data->pendidikan=='SMA'?'selected':'' }}>SMA</option>
    <option value="D1" {{ $data->pendidikan=='D1'?'selected':'' }}>D1</option>
    <option value="D2" {{ $data->pendidikan=='D2'?'selected':'' }}>D2</option>
    <option value="D3" {{ $data->pendidikan=='D3'?'selected':'' }}>D3</option>
    <option value="D4" {{ $data->pendidikan=='D4'?'selected':'' }}>D4</option>
    <option value="S1" {{ $data->pendidikan=='S1'?'selected':'' }}>S1</option>
    <option value="S2" {{ $data->pendidikan=='S2'?'selected':'' }}>S2</option>
    <option value="S3" {{ $data->pendidikan=='S3'?'selected':'' }}>S3</option>
</select>
</div>

<!-- PEKERJAAN -->
<div>
<label class="text-sm font-medium">Pekerjaan</label>
<select name="pekerjaan" class="border p-2 rounded w-full">
    <option value="IRT" {{ $data->pekerjaan=='IRT'?'selected':'' }}>Ibu Rumah Tangga</option>
    <option value="PNS" {{ $data->pekerjaan=='PNS'?'selected':'' }}>PNS</option>
    <option value="Swasta" {{ $data->pekerjaan=='Swasta'?'selected':'' }}>Swasta</option>
    <option value="Wiraswasta" {{ $data->pekerjaan=='Wiraswasta'?'selected':'' }}>Wiraswasta</option>
    <option value="Petani" {{ $data->pekerjaan=='Petani'?'selected':'' }}>Petani</option>
    <option value="Nelayan" {{ $data->pekerjaan=='Nelayan'?'selected':'' }}>Nelayan</option>
    <option value="Guru" {{ $data->pekerjaan=='Guru'?'selected':'' }}>Guru</option>
    <option value="Tenaga Kesehatan" {{ $data->pekerjaan=='Tenaga Kesehatan'?'selected':'' }}>Tenaga Kesehatan</option>
    <option value="Pelajar" {{ $data->pekerjaan=='Pelajar'?'selected':'' }}>Pelajar</option>
    <option value="Tidak Bekerja" {{ $data->pekerjaan=='Tidak Bekerja'?'selected':'' }}>Tidak Bekerja</option>
</select>
</div>

<!-- ALAMAT -->
<div class="col-span-2">
<label class="text-sm font-medium">Alamat</label>
<textarea name="alamat" class="border p-2 rounded w-full">{{ $data->alamat }}</textarea>
</div>

<!-- KETERANGAN -->
<div class="col-span-2">
<label class="text-sm font-medium">Keterangan</label>
<textarea name="keterangan" class="border p-2 rounded w-full">{{ $data->keterangan }}</textarea>
</div>

</div>

<button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
Update
</button>

</form>

</div>
</div>

@endsection