@extends('template.layout')
@section('content')

<div class="p-6 max-w-5xl mx-auto">
<div class="bg-white p-6 rounded-2xl shadow">

<h3 class="font-bold text-lg mb-4">Edit Agenda Surat</h3>

<form action="{{ route('agendaanggota.update',$data->id) }}" method="POST">
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

<!-- TANGGAL TERIMA -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Terima Surat</label>
<input type="date" name="tanggal_terima_surat" value="{{ $data->tanggal_terima_surat }}" class="border p-2 rounded w-full">
</div>

<!-- TANGGAL MASUK -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat Masuk</label>
<input type="date" name="tanggal_surat_masuk" value="{{ $data->tanggal_surat_masuk }}" class="border p-2 rounded w-full">
</div>

<!-- NOMOR SURAT MASUK -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat Masuk</label>
<input type="text" name="nomor_surat_diterima" value="{{ $data->nomor_surat_diterima }}" class="border p-2 rounded w-full">
</div>

<!-- DARI -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Dari</label>
<input type="text" name="dari" value="{{ $data->dari }}" class="border p-2 rounded w-full">
</div>

<!-- PERIHAL MASUK -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Perihal Masuk</label>
<input type="text" name="perihal_masuk" value="{{ $data->perihal_masuk }}" class="border p-2 rounded w-full">
</div>

<!-- LAMPIRAN MASUK -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Lampiran Masuk</label>
<input type="text" name="lampiran_masuk" value="{{ $data->lampiran_masuk }}" class="border p-2 rounded w-full">
</div>

<!-- DITERUSKAN -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Diteruskan Kepada</label>
<input type="text" name="diteruskan_kepada" value="{{ $data->diteruskan_kepada }}" class="border p-2 rounded w-full">
</div>

<!-- NOMOR SURAT KELUAR -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat Keluar</label>
<input type="text" name="nomor_surat" value="{{ $data->nomor_surat }}" class="border p-2 rounded w-full">
</div>

<!-- TANGGAL KELUAR -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat Keluar</label>
<input type="date" name="tanggal_surat_keluar" value="{{ $data->tanggal_surat_keluar }}" class="border p-2 rounded w-full">
</div>

<!-- KEPADA -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Kepada</label>
<input type="text" name="kepada" value="{{ $data->kepada }}" class="border p-2 rounded w-full">
</div>

<!-- PERIHAL KELUAR -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Perihal Keluar</label>
<input type="text" name="perihal_keluar" value="{{ $data->perihal_keluar }}" class="border p-2 rounded w-full">
</div>

<!-- LAMPIRAN KELUAR -->
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">Lampiran Keluar</label>
<input type="text" name="lampiran_keluar" value="{{ $data->lampiran_keluar }}" class="border p-2 rounded w-full">
</div>

<!-- TEMBUSAN -->
<div class="col-span-2">
<label class="block text-sm font-medium text-gray-700 mb-1">Tembusan</label>
<textarea name="tembusan" class="border p-2 rounded w-full">{{ $data->tembusan }}</textarea>
</div>

</div>

<button class="mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow">
Update
</button>

</form>

</div>
</div>

@endsection