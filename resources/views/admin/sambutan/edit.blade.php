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
            <img src="{{ asset('storage/'.$data->foto) }}" class="w-32 rounded mb-3">

            <input type="file" name="foto" class="w-full border rounded-lg px-4 py-2">
        </div>

        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Update
        </button>
    </form>
</div>

@endsection