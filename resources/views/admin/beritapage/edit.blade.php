@extends('template.layout')
@section('content')

<div class="p-6">

<div class="bg-white rounded-3xl shadow-lg p-6">

<h2 class="text-xl font-bold mb-4">Edit Berita</h2>

<form action="{{ route('beritapage.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<!-- JUDUL -->
<input type="text" name="judul"
value="{{ $berita->judul }}"
class="w-full border p-3 rounded mb-3"
placeholder="Judul berita" required>

<!-- KATEGORI -->
<select name="kategori_id" class="w-full border p-3 rounded mb-3">
<option value="">Pilih Kategori</option>
@foreach($kategori as $k)
<option value="{{ $k->id }}"
    {{ $berita->kategori_id == $k->id ? 'selected' : '' }}>
    {{ $k->nama }}
</option>
@endforeach
</select>


<!-- GAMBAR -->
@if($berita->gambar)
<div class="mb-3">
    <p class="text-sm mb-1 text-gray-500">Gambar Saat Ini:</p>
    <img src="{{ asset('storage/' . $berita->gambar) }}"
         class="w-40 rounded-lg shadow">
</div>
@endif

<input type="file" name="gambar" class="w-full mb-3">

<div class="space-y-2 mb-3">
          <label class="text-xs font-bold uppercase tracking-wider text-slate-600">
            Tanggal Publish
          </label>
          <input 
            type="date"
            name="tanggal_publish"
            value="{{ $berita->tanggal_publish }}"
            placeholder="Contoh: Admin"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none"
          />
        </div>

<!-- STATUS -->
<select name="status" class="w-full border p-3 rounded mb-3">
<option value="draft" {{ $berita->status == 'draft' ? 'selected' : '' }}>Draft</option>
<option value="publish" {{ $berita->status == 'publish' ? 'selected' : '' }}>Publish</option>
</select>

<!-- ISI (CKEDITOR) -->
<textarea name="isi" id="editor" class="w-full border">
{{ $berita->isi }}
</textarea>

<!-- BUTTON -->
<div class="flex justify-end gap-2 mt-4">
<a href="{{ route('beritapage.index') }}"
   class="px-4 py-2 bg-gray-200 rounded">
   Batal
</a>

<button class="px-4 py-2 bg-primary text-white rounded">
Update
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