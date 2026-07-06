@extends('template.layout')

@section('content')

<div class="p-6 max-w-xl">

    <h1 class="text-xl font-bold mb-4">Edit Infografis</h1>

    <form action="{{ route('infografis.update',$data->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-4">

        @csrf

        <input type="text"
               name="nama"
               value="{{ $data->nama }}"
               class="w-full border p-2 rounded">

        <textarea name="keterangan"
                  class="w-full border p-2 rounded">{{ $data->keterangan }}</textarea>

        @if($data->foto)
            <img src="{{ asset('storage/infografis/'.$data->foto) }}"
                 class="w-32 h-32 object-cover mb-2 rounded">
        @endif

        <input type="file"
               name="foto"
               class="w-full border p-2 rounded">

        <button class="bg-yellow-500 text-white px-4 py-2 rounded">
            Update
        </button>

    </form>

</div>

@endsection