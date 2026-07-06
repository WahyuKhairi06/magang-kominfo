@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 border-b flex items-center justify-between">
      <h3 class="font-bold text-slate-800 text-lg">Edit Galeri Kegiatan</h3>

      <a href="{{ route('galeri.index') }}"
        class="text-sm text-slate-500 hover:text-primary transition">
        ← Kembali
      </a>
    </div>

    <!-- FORM -->
    <form action="{{ route('galeri.update', $data->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
      @csrf
      @method('PUT')

      <!-- FOTO -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Foto</label>

        <div class="flex items-center gap-6">

          <!-- PREVIEW -->
          <div id="preview"
            class="w-32 h-32 rounded-2xl border-2 border-dashed overflow-hidden flex items-center justify-center text-slate-400">

            @if($data->foto)
              <img src="{{ asset('storage/' . $data->foto) }}" class="w-full h-full object-cover">
            @else
              <span class="text-sm">Preview</span>
            @endif

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

        <p class="text-xs text-slate-400 mt-2">Kosongkan jika tidak ingin mengganti foto</p>

        @error('foto')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- JUDUL -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Kegiatan</label>
        <input type="text" name="judul_kegiatan" value="{{ old('judul_kegiatan', $data->judul_kegiatan) }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
      </div>

      <!-- TANGGAL -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal', $data->tanggal) }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
      </div>
<div class="mb-3">
    <label for="jenis" class="form-label">
        Jenis Infografis
    </label>

    <select name="jenis" id="jenis" class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none form-select">

        <option value="">
            -- Pilih Jenis --
        </option>

        <option value="infografis"
            {{ ($data->jenis ?? '') == 'infografis' ? 'selected' : '' }}>
            Infografis
        </option>

    </select>

    <small class="text-muted">
        Jika memilih kategori galeri, jenis tidak perlu dipilih.
    </small>
</div>
      <!-- LOKASI -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi</label>
        <input type="text" name="lokasi" value="{{ old('lokasi', $data->lokasi) }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
      </div>

      <!-- DESKRIPSI -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
        <textarea name="deskripsi" rows="4"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">{{ old('deskripsi', $data->deskripsi) }}</textarea>
      </div>



      <div class="mb-5">
    <label class="block mb-2 text-sm font-medium text-gray-700">
        Pokja
    </label>

    <select name="pokja_id"
        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none
        @error('kategori_halaman_id') border-red-500 @enderror">

        <option value="">-- Pilih Pokja --</option>

        @foreach($pokja as $k)
            <option value="{{ $k->id }}"
                {{ old('pokja_id', $data->pokja_id ?? '') == $k->id ? 'selected' : '' }}>
                {{ $k->nama_pokja }}
            </option>
        @endforeach

    </select>

    @error('kategori_halaman_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
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
          Update
        </button>

      </div>

    </form>

  </div>

</div>

<!-- PREVIEW GAMBAR BARU -->
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