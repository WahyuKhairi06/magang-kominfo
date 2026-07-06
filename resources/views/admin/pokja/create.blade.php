@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 border-b flex items-center justify-between">
      <h3 class="font-bold text-slate-800 text-lg">Tambah Pokja</h3>

      <a href="{{ route('pokja.index') }}"
        class="text-sm text-slate-500 hover:text-primary transition">
        ← Kembali
      </a>
    </div>

    <!-- FORM -->
    <form action="{{ route('pokja.store') }}" method="POST" class="p-6 space-y-6">
      @csrf

      <!-- NAMA POKJA -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">
          Nama Pokja <span class="text-red-500">*</span>
        </label>

        <input type="text" name="nama_pokja" value="{{ old('nama_pokja') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Contoh: Pokja I">

        @error('nama_pokja')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- KETERANGAN -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan</label>

        <textarea name="keterangan" rows="4"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Contoh: Penghayatan dan Pengamalan Pancasila">{{ old('keterangan') }}</textarea>
      </div>

      <!-- BUTTON -->
      <div class="flex justify-end gap-3 pt-4 border-t">

        <a href="{{ route('pokja.index') }}"
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