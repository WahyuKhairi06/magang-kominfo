@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 border-b flex items-center justify-between">
      <h3 class="font-bold text-slate-800 text-lg">Tambah Galeri Kegiatan</h3>

      <a href="{{ route('galeri.index') }}"
        class="text-sm text-slate-500 hover:text-primary transition">
        ← Kembali
      </a>
    </div>

    <!-- FORM -->
    <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
      @csrf

      <!-- FOTO -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Foto</label>

        <div class="flex items-center gap-6">
          <!-- PREVIEW -->
          <div id="preview"
            class="w-32 h-32 rounded-2xl border-2 border-dashed flex items-center justify-center text-slate-400 overflow-hidden">
            <span class="text-sm">Preview</span>
          </div>

          <!-- INPUT -->
          <input type="file" name="foto" id="foto"
            class="block w-full text-sm text-slate-500
            file:mr-4 file:py-2 file:px-4
            file:rounded-xl file:border-0
            file:text-sm file:font-semibold
            file:bg-primary file:text-white
            hover:file:opacity-90 cursor-pointer">
        </div>

        @error('foto')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- JUDUL -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Kegiatan</label>
        <input type="text" name="judul_kegiatan" value="{{ old('judul_kegiatan') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Masukkan judul kegiatan">

        @error('judul_kegiatan')
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

      <!-- LOKASI -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi</label>
        <input type="text" name="lokasi" value="{{ old('lokasi') }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Contoh: Kantor Walikota">

        @error('lokasi')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

<div class="mb-3">
    <label for="jenis" class="form-label">Jenis Infografis</label>
    <select name="jenis" id="jenis"  class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none form-select">
        <option value="">-- Pilih Jenis --</option>
        <option value="infografis">Infografis</option>
    </select>

    <small class="text-muted">
        Jika memilih kategori galeri, jenis tidak perlu dipilih.
    </small>
</div>

      <!-- DESKRIPSI -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
        <textarea name="deskripsi" rows="4"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
          placeholder="Deskripsi kegiatan...">{{ old('deskripsi') }}</textarea>
      </div>


      <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Pokja
                    </label>
                    <select name="pokja_id"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="">-- Pilih Pokja --</option>
                        @foreach($pokja as $k)
                            <option value="{{ $k->id }}">
                                {{ $k->nama_pokja }}
                            </option>
                        @endforeach
                    </select>
                </div>
      <!-- BUTTON -->
      <div class="flex justify-end gap-3 pt-4 border-t">

        <a href="{{ route('galeri.index') }}"
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

<!-- PREVIEW IMAGE -->
<script>
document.getElementById('foto').addEventListener('change', function(e) {
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