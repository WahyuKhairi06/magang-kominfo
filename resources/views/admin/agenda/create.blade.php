@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 border-b flex items-center justify-between">
      <h3 class="font-bold text-slate-800 text-lg">Tambah Agenda</h3>

      <a href="{{ route('agenda.index') }}"
        class="text-sm text-slate-500 hover:text-primary transition">
        ← Kembali
      </a>
    </div>

    <!-- FORM -->
    <form action="{{ route('agenda.store') }}" method="POST" class="p-6 space-y-6">
      @csrf

      <!-- JUDUL -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Agenda</label>
        <input type="text" name="judul_agenda" value="{{ old('judul_agenda') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Contoh: Rapat Evaluasi ASN">

        @error('judul_agenda')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- TANGGAL -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">

        @error('tanggal')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- JAM -->
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Jam Mulai</label>
          <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Jam Selesai</label>
          <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
        </div>
      </div>

      <!-- LOKASI -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi</label>
        <input type="text" name="lokasi" value="{{ old('lokasi') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Contoh: Aula Walikota">
      </div>

      <!-- PENYELENGGARA -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Penyelenggara</label>
        <input type="text" name="penyelenggara" value="{{ old('penyelenggara') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Contoh: BKPSDM">
      </div>

      <!-- STATUS -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
        <select name="status"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">

          <option value="upcoming">Upcoming</option>
          <option value="selesai">Selesai</option>
          <option value="batal">Batal</option>

        </select>
      </div>

      <!-- DESKRIPSI -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
        <textarea name="deskripsi" rows="4"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Deskripsi kegiatan...">{{ old('deskripsi') }}</textarea>
      </div>

      <!-- BUTTON -->
      <div class="flex justify-end gap-3 pt-4 border-t">

        <a href="{{ route('agenda.index') }}"
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