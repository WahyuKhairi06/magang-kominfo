@extends('template.layout')
@section('content')

<style>
.label {
    @apply text-sm font-semibold text-slate-600 mb-1 block;
}

.input {
    @apply w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition;
}
</style>
<div class="min-h-screen bg-slate-100 py-10 px-4 flex justify-center">

<div class="w-full max-w-4xl">

    <!-- CARD -->
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

        <!-- HEADER -->
        <div class="px-8 py-6 bg-gradient-to-r from-yellow-500 to-orange-500 text-white">
            <h2 class="text-xl font-bold">Edit Produk</h2>
            <p class="text-sm opacity-90">Perbarui data produk</p>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('produk.update',$data->id) }}" enctype="multipart/form-data" class="p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ $data->nama_produk }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Kode Produk</label>
                <input type="text" name="kode_produk" value="{{ $data->kode_produk }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Harga</label>
                <input type="number" name="harga" value="{{ $data->harga }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Harga Diskon</label>
                <input type="number" name="harga_diskon" value="{{ $data->harga_diskon }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Diskon Mulai</label>
                <input type="date" name="diskon_mulai" value="{{ $data->diskon_mulai }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Diskon Selesai</label>
                <input type="date" name="diskon_selesai" value="{{ $data->diskon_selesai }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Stok</label>
                <input type="number" name="stok" value="{{ $data->stok }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Stok Minimum</label>
                <input type="number" name="stok_minimum" value="{{ $data->stok_minimum }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Berat (gram)</label>
                <input type="number" name="berat" value="{{ $data->berat }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Satuan</label>
                <input type="text" name="satuan" value="{{ $data->satuan }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Kategori</label>
                <input type="text" name="kategori" value="{{ $data->kategori }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600 mb-1 block">Status</label>
                <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
                    <option value="draft" {{ $data->status=='draft'?'selected':'' }}>Draft</option>
                    <option value="aktif" {{ $data->status=='aktif'?'selected':'' }}>Aktif</option>
                    <option value="nonaktif" {{ $data->status=='nonaktif'?'selected':'' }}>Nonaktif</option>
                </select>
            </div>

        </div>

        <!-- DESKRIPSI -->
        <div class="mt-6">
            <label class="text-sm font-semibold text-slate-600 mb-1 block">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">{{ $data->deskripsi }}</textarea>
        </div>

        <!-- CATATAN -->
        <div class="mt-4">
            <label class="text-sm font-semibold text-slate-600 mb-1 block">Catatan</label>
            <textarea name="catatan" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">{{ $data->catatan }}</textarea>
        </div>

        <!-- FOTO -->
        <div class="mt-6">
            <label class="text-sm font-semibold text-slate-600 mb-1 block">Foto Produk</label>

            <div class="flex items-center gap-4">
                <input type="file" name="foto" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

                @if($data->foto)
                    <img src="{{ asset('storage/'.$data->foto) }}" 
                         class="w-24 h-24 object-cover rounded-xl border shadow">
                @endif
            </div>
        </div>

        <!-- BUTTON -->
        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('produk.index') }}" 
               class="px-5 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-semibold">
               Batal
            </a>

            <button 
                class="px-6 py-2 rounded-xl bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-semibold shadow hover:opacity-90 transition">
                Update Produk
            </button>
        </div>

        </form>

    </div>

</div>
</div>


@endsection