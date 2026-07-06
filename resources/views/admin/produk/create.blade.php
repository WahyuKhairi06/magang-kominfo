@extends('template.layout')
@section('content')

<div class="relative p-10 min-h-[calc(100vh-80px)]">

<div class="max-w-5xl mx-auto">

<div class="mb-10">
<span class="inline-block px-3 py-1 bg-secondary-fixed text-on-secondary-fixed rounded-full text-xs font-bold uppercase mb-4">
Marketplace Module
</span>
<h2 class="text-4xl font-bold text-primary mb-2">Tambah Produk Baru</h2>
<p class="text-on-surface-variant max-w-2xl">
Lengkapi detail produk UMKM di bawah ini.
</p>
</div>

<div class="bg-white rounded-[2rem] p-8 md:p-12 shadow-xl border">

<form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
@csrf

<!-- INFORMASI UMUM -->
<section class="mb-10">
<h3 class="font-bold mb-4">Informasi Umum</h3>

<label class="text-sm font-semibold mb-1 block">Nama Produk</label>
<input name="nama_produk" placeholder="Nama Produk" class="w-full mb-3 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

<label class="text-sm font-semibold mb-1 block">Kode Produk</label>
<input name="kode_produk" placeholder="Kode Produk" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

</section>

<!-- HARGA -->
<section class="mb-10">
<h3 class="font-bold mb-4">Harga & Promo</h3>

<label class="text-sm font-semibold mb-1 block">Harga</label>
<input name="harga" type="number" placeholder="Harga" class="w-full mb-3 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

<label class="text-sm font-semibold mb-1 block">Harga Diskon</label>
<input name="harga_diskon" type="number" placeholder="Harga Diskon" class="w-full mb-3 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

<label class="text-sm font-semibold mb-1 block">Diskon Mulai</label>
<input name="diskon_mulai" type="date" class="w-full mb-3 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

<label class="text-sm font-semibold mb-1 block">Diskon Selesai</label>
<input name="diskon_selesai" type="date" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

</section>

<!-- STOK -->
<section class="mb-10">
<h3 class="font-bold mb-4">Stok & Logistik</h3>

<label class="text-sm font-semibold mb-1 block">Stok</label>
<input name="stok" type="number" placeholder="Stok" class="w-full mb-3 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

<label class="text-sm font-semibold mb-1 block">Stok Minimum</label>
<input name="stok_minimum" type="number" placeholder="Stok Minimum" class="w-full mb-3 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

<label class="text-sm font-semibold mb-1 block">Berat</label>
<input name="berat" type="number" placeholder="Berat" class="w-full mb-3 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

<label class="text-sm font-semibold mb-1 block">Satuan</label>
<input name="satuan" placeholder="Satuan" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

</section>

<!-- LAINNYA -->
<section class="mb-10">
<h3 class="font-bold mb-4">Lainnya</h3>

<label class="text-sm font-semibold mb-1 block">Kategori</label>
<input name="kategori" placeholder="Kategori" class="w-full mb-3 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

<label class="text-sm font-semibold mb-1 block">Status Produk</label>
<select name="status" class="w-full mb-3 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
<option value="draft">Draft</option>
<option value="aktif">Aktif</option>
<option value="nonaktif">Nonaktif</option>
</select>

<label class="text-sm font-semibold mb-1 block">Deskripsi Produk</label>
<textarea name="deskripsi" placeholder="Deskripsi" class="w-full mb-3 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition"></textarea>

<label class="text-sm font-semibold mb-1 block">Catatan Tambahan</label>
<textarea name="catatan" placeholder="Catatan" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition"></textarea>

</section>

<!-- FOTO -->
<section class="mb-10">
<h3 class="font-bold mb-4">Foto</h3>

<label class="text-sm font-semibold mb-1 block">Upload Foto Produk</label>
<input type="file" name="foto" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

</section>

<!-- ACTION -->
<div class="flex justify-end gap-3">
<a href="{{ route('produk.index') }}" class="btn-secondary">Batal</a>

<button class="btn-primary">
Simpan
</button>
</div>

</form>

</div>
</div>
</div>

@endsection