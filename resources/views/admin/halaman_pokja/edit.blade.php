@extends('template.layout')
@section('content')

@php use Illuminate\Support\Str; @endphp

<div class="p-6">

  <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 border-b flex items-center justify-between">
      <h3 class="font-bold text-slate-800 text-lg">Edit Halaman Pokja</h3>

      <a href="{{ route('halamanpokja.index') }}"
        class="text-sm text-slate-500 hover:text-primary transition">
        ← Kembali
      </a>
    </div>

    <!-- FORM -->
    <form action="{{ route('halamanpokja.update', $data->id) }}" method="POST" class="p-6 space-y-6">
      @csrf
      @method('PUT')

      <!-- JUDUL -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Judul</label>
        <input type="text" name="judul"
          value="{{ old('judul', $data->judul) }}"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
      </div>

      <!-- POKJA -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Pokja</label>
        <select name="pokja_id"
          class="w-full rounded-xl border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">

          @foreach($pokja as $p)
            <option value="{{ $p->id }}"
              {{ $data->pokja_id == $p->id ? 'selected' : '' }}>
              {{ $p->nama_pokja }}
            </option>
          @endforeach

        </select>
      </div>

      <!-- ISI CKEDITOR -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Isi Halaman</label>

        <textarea name="isi" id="editor" rows="10"
          class="w-full rounded-xl border border-slate-300 px-4 py-2">
          {{ old('isi', $data->isi) }}
        </textarea>
      </div>

      <!-- BUTTON -->
      <div class="flex justify-end gap-3 pt-4 border-t">

        <a href="{{ route('halamanpokja.index') }}"
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

<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
ClassicEditor
  .create(document.querySelector('#editor'), {
    ckfinder: {
      uploadUrl: "{{ url('/upload-ckeditor') }}?_token={{ csrf_token() }}"
    }
  })
  .catch(error => {
      console.error(error);
  });
</script>

@endsection