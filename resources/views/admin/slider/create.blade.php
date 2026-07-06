@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 border-b flex items-center justify-between">
      <h3 class="font-bold text-slate-800 text-lg">Tambah Slider</h3>

      <a href="{{ route('slider.index') }}"
        class="text-sm text-slate-500 hover:text-primary transition">
        ← Kembali
      </a>
    </div>

    <!-- FORM -->
    <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
      @csrf

      <!-- GAMBAR -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar</label>

        <div class="flex items-center gap-6">

          <!-- PREVIEW -->
          <div id="preview"
            class="w-56 h-32 rounded-2xl border-2 border-dashed flex items-center justify-center text-slate-400 overflow-hidden">
            <span class="text-sm">Preview</span>
          </div>

          <!-- INPUT -->
          <input type="file" name="gambar" id="gambar"
            class="block w-full text-sm text-slate-500
            file:mr-4 file:py-2 file:px-4
            file:rounded-xl file:border-0
            file:text-sm file:font-semibold
            file:bg-primary file:text-white
            hover:file:opacity-90 cursor-pointer">
        </div>

        @error('gambar')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- JUDUL -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Judul</label>
        <input type="text" name="judul" value="{{ old('judul') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Contoh: Selamat Datang di PKK">
      </div>

      <!-- SUB JUDUL -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Sub Judul</label>
        <input type="text" name="sub_judul" value="{{ old('sub_judul') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Contoh: Membangun keluarga sejahtera">
      </div>

      <!-- LINK -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Link (Opsional)</label>
        <input type="text" name="link" value="{{ old('link') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="/profil atau https://...">
      </div>

      <!-- URUTAN -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Urutan</label>
        <input type="number" name="urutan" value="{{ old('urutan', 0) }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
      </div>

      <!-- STATUS -->
      <div class="flex items-center gap-3">
        <input type="checkbox" name="is_active" value="1" checked
          class="w-5 h-5 text-primary rounded focus:ring-primary">
        <label class="text-sm text-slate-700 font-semibold">Aktifkan Slider</label>
      </div>

      <!-- BUTTON -->
      <div class="flex justify-end gap-3 pt-4 border-t">

        <a href="{{ route('slider.index') }}"
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

<!-- PREVIEW GAMBAR -->
<script>
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        }
        reader.readAsDataURL(file);
    }
});
</script>

@endsection