@extends('template.layout')
@section('content')

<div class="p-6">

<div class="bg-white rounded-3xl shadow-lg p-6">

<h2 class="text-xl font-bold mb-4">Tambah Berita</h2>

<form action="{{ route('beritapage.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<!-- JUDUL -->
<input type="text" name="judul"
class="w-full border p-3 rounded mb-3"
placeholder="Judul berita" required>

<!-- KATEGORI -->
<select name="kategori_id" class="w-full border p-3 rounded mb-3">
<option value="">Pilih Kategori</option>
@foreach($kategori as $k)
<option value="{{ $k->id }}">{{ $k->nama }}</option>
@endforeach
</select>

<!-- GAMBAR -->
<input type="file" name="gambar" class="w-full mb-3" required>

<!-- STATUS -->
<select name="status" class="w-full border p-3 rounded mb-3">
<option value="draft">Draft</option>
<option value="publish">Publish</option>
</select>

<!-- ISI (CKEDITOR) -->
<textarea name="isi" id="editor" class="w-full border"></textarea>

<!-- BUTTON -->
<div class="flex justify-end gap-2 mt-4">
<a href="{{ route('beritapage.index') }}"
   class="px-4 py-2 bg-gray-200 rounded">Batal</a>

<button class="px-4 py-2 bg-primary text-white rounded">
Simpan
</button>
</div>

</form>

</div>

</div>

<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
CKEDITOR.replace('editor');
</script>

@endsection