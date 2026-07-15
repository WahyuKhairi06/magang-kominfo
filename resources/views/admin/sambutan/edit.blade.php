@extends('template.layout')

@section('content')


<div class="max-w-4xl mx-auto py-10 px-6 w-full">
    <h2 class="text-2xl font-bold mb-6">Edit Sambutan</h2>

    <form action="{{ route('sambutan.update', $data->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" name="judul" value="{{ $data->judul }}" class="w-full border rounded-lg px-4 py-2">
        </div>

        <div>
            <label class="block font-semibold mb-1">Nama</label>
            <input type="text" name="nama" value="{{ $data->nama }}" class="w-full border rounded-lg px-4 py-2">
        </div>

        <div>
            <label class="block font-semibold mb-1">Motto</label>
            <input type="text" name="motto" value="{{ $data->motto }}" class="w-full border rounded-lg px-4 py-2">
        </div>

        <div>
            <label class="block font-semibold mb-1">Isi Sambutan</label>
            <textarea name="isi" rows="5" class="w-full border rounded-lg px-4 py-2">{{ $data->isi }}</textarea>
        </div>

        <div>
            <label class="block font-semibold mb-2">Foto Sekarang</label>
            <img id="preview-foto" src="{{ $data->foto ? asset('storage/'.$data->foto) : asset('no-image.png') }}" class="w-32 rounded mb-3 object-cover max-h-48">

            <input type="file" name="foto" onchange="previewFoto(event)" class="w-full border rounded-lg px-4 py-2">
        </div>

        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Update
        </button>
    </form>
</div>

<script>
function previewFoto(event) {
    const input = event.target;
    const preview = document.getElementById('preview-foto');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection