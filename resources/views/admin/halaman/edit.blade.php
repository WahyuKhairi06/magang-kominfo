@extends('template.layout')
@section('content')

<div class="max-w-4xl mx-auto mt-6">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">

        {{-- Header --}}
        <div class="bg-green-600 text-white px-6 py-4">
            <h2 class="text-lg font-semibold">Edit Halaman</h2>
        </div>

        {{-- Body --}}
        <div class="p-6">
            <form action="{{ url('halaman/update/'.$data->id) }}" method="POST">
                @csrf

                {{-- Judul --}}
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Judul
                    </label>
                    <input type="text"
                           name="judul"
                           value="{{ $data->judul }}"
                           placeholder="Masukkan judul"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                {{-- Kategori --}}
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Kategori
                    </label>
                    <select name="kategori_halaman_id"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}"
                                {{ $data->kategori_halaman_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Isi --}}
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Isi Halaman
                    </label>
                    <textarea name="isi" id="editor">{!! $data->isi !!}</textarea>
                </div>

                {{-- Button --}}
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
ClassicEditor
    .create(document.querySelector('#editor'), {
        ckfinder: {
            uploadUrl: "{{ route('upload.image') }}?_token={{ csrf_token() }}"
        }
    })
    .catch(error => {
        console.error(error);
    });
</script>

@endsection