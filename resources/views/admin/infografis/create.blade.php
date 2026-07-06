@extends('template.layout')

@section('content')

<div class="p-6 max-w-xl">

    <h1 class="text-xl font-bold mb-4">Tambah Infografis</h1>

    <form action="{{ route('infografis.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-4">

        @csrf

        <input type="text"
               name="nama"
               placeholder="Nama"
               class="w-full border p-2 rounded">

        <textarea name="keterangan"
                  placeholder="Keterangan"
                  class="w-full border p-2 rounded"></textarea>

        <input type="file"
               name="foto"
               class="w-full border p-2 rounded">

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>

    </form>

</div>

@endsection