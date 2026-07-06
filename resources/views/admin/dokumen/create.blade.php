@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 border-b flex items-center justify-between">
      <h3 class="font-bold text-slate-800 text-lg">Tambah Dokumen</h3>

      <a href="{{ route('dokumen.index') }}"
        class="text-sm text-slate-500 hover:text-primary transition">
        ← Kembali
      </a>
    </div>

    <!-- FORM -->
    <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
      @csrf

      <!-- JUDUL -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Dokumen</label>
        <input type="text" name="judul" value="{{ old('judul') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Contoh: Form Pengajuan Bantuan">

        @error('judul')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- KATEGORI -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
        <input type="text" name="kategori" value="{{ old('kategori') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Contoh: Surat / Laporan / Form">
      </div>

      <!-- FILE -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Upload File</label>

        <input type="file" name="file"
          class="block w-full text-sm text-slate-500
          file:mr-4 file:py-2 file:px-4
          file:rounded-xl file:border-0
          file:text-sm file:font-semibold
          file:bg-primary file:text-white
          hover:file:opacity-90 cursor-pointer">

        <p class="text-xs text-slate-400 mt-2">
          Format: PDF, DOC, XLS, ZIP (Max: 5MB)
        </p>

        @error('file')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- DESKRIPSI -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
        <textarea name="deskripsi" rows="4"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Deskripsi dokumen...">{{ old('deskripsi') }}</textarea>
      </div>

      <!-- STATUS -->
      <div class="flex items-center gap-3">
        <input type="checkbox" name="is_active" value="1" checked
          class="w-5 h-5 text-primary rounded focus:ring-primary">
        <label class="text-sm text-slate-700 font-semibold">Aktifkan Dokumen</label>
      </div>

      <!-- BUTTON -->
      <div class="flex justify-end gap-3 pt-4 border-t">

        <a href="{{ route('dokumen.index') }}"
          class="px-5 py-2 rounded-xl border text-slate-600 hover:bg-slate-100 transition">
          Batal
        </a>

        <button type="submit"
          class="px-6 py-2 rounded-xl bg-primary text-white font-semibold shadow hover:opacity-90 transition flex items-center gap-2">
          <span class="material-symbols-outlined text-sm">save</span>
          Simpan
        </button>

      </div>

    </form>

  </div>

</div>

@endsection