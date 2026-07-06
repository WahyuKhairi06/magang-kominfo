@extends('template.layout')
@section('content')

<div class="p-6 max-w-5xl mx-auto">
<div class="bg-white p-6 rounded-2xl shadow">

<h3 class="font-bold text-lg mb-4">Tambah Agenda Surat</h3>

<form action="{{ route('agendaanggota.store') }}" method="POST">
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

<!-- ID -->
<div>
<label class="block text-sm font-medium mb-1">ID Buku Agenda</label>
<input type="text" name="buku_agenda_id" readonly value="{{ $data->id }}" class="border p-2 rounded w-full bg-gray-100">
</div>

<!-- TANGGAL TERIMA -->
<div>
<label class="block text-sm font-medium mb-1">Tanggal Terima Surat</label>
<input type="date" name="tanggal_terima_surat" class="border p-2 rounded w-full">
</div>

<!-- TANGGAL SURAT MASUK -->
<div>
<label class="block text-sm font-medium mb-1">Tanggal Surat Masuk</label>
<input type="date" name="tanggal_surat_masuk" class="border p-2 rounded w-full">
</div>

<!-- NOMOR MASUK -->
<div>
<label class="block text-sm font-medium mb-1">Nomor Surat Masuk</label>
<input type="text" name="nomor_surat_diterima" placeholder="Nomor Surat Masuk" class="border p-2 rounded w-full">
</div>

<!-- DARI -->
<div>
<label class="block text-sm font-medium mb-1">Dari</label>
<input type="text" name="dari" placeholder="Pengirim Surat" class="border p-2 rounded w-full">
</div>

<!-- PERIHAL MASUK -->
<div>
<label class="block text-sm font-medium mb-1">Perihal Masuk</label>
<input type="text" name="perihal_masuk" placeholder="Perihal Surat Masuk" class="border p-2 rounded w-full">
</div>

<!-- LAMPIRAN MASUK -->
<div>
<label class="block text-sm font-medium mb-1">Lampiran Masuk</label>
<input type="text" name="lampiran_masuk" placeholder="Lampiran" class="border p-2 rounded w-full">
</div>

<!-- DITERUSKAN -->
<div>
<label class="block text-sm font-medium mb-1">Diteruskan Kepada</label>
<input type="text" name="diteruskan_kepada" placeholder="Tujuan Disposisi" class="border p-2 rounded w-full">
</div>

<!-- ==================== -->
<!-- SURAT KELUAR -->
<!-- ==================== -->

<div class="col-span-2 mt-4">
<h4 class="font-semibold text-blue-600">📤 Surat Keluar</h4>
</div>

<!-- NOMOR KELUAR -->
<div>
<label class="block text-sm font-medium mb-1">Nomor Surat Keluar</label>
<input type="text" name="nomor_surat" placeholder="Nomor Surat Keluar" class="border p-2 rounded w-full">
</div>

<!-- TANGGAL KELUAR -->
<div>
<label class="block text-sm font-medium mb-1">Tanggal Surat Keluar</label>
<input type="date" name="tanggal_surat_keluar" class="border p-2 rounded w-full">
</div>

<!-- KEPADA -->
<div>
<label class="block text-sm font-medium mb-1">Kepada</label>
<input type="text" name="kepada" placeholder="Penerima Surat" class="border p-2 rounded w-full">
</div>

<!-- PERIHAL KELUAR -->
<div>
<label class="block text-sm font-medium mb-1">Perihal Keluar</label>
<input type="text" name="perihal_keluar" placeholder="Perihal Surat Keluar" class="border p-2 rounded w-full">
</div>

<!-- LAMPIRAN KELUAR -->
<div>
<label class="block text-sm font-medium mb-1">Lampiran Keluar</label>
<input type="text" name="lampiran_keluar" placeholder="Lampiran" class="border p-2 rounded w-full">
</div>

<!-- TEMBUSAN -->
<div class="col-span-2">
<label class="block text-sm font-medium mb-1">Tembusan</label>
<textarea name="tembusan" placeholder="Tembusan" class="border p-2 rounded w-full"></textarea>
</div>

</div>

<button class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
💾 Simpan
</button>

</form>

</div>
</div>

@endsection