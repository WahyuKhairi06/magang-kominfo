@extends('template.layout')
@section('content')

<div class="p-6 max-w-xl mx-auto">

  <div class="bg-white p-6 rounded-2xl shadow">

    <h3 class="font-bold mb-4">Edit Dusun</h3>

    <form action="{{ route('dusun.update', $dusun->id) }}" method="POST">
      @csrf

      <input type="text" name="nama_dusun"
        value="{{ $dusun->nama_dusun }}"
        class="w-full mb-3 p-2 border rounded">

      <select name="desa_id" class="w-full mb-3 p-2 border rounded">
        @foreach($desa as $d)
        <option value="{{ $d->id }}"
          {{ $dusun->desa_id == $d->id ? 'selected' : '' }}>
          {{ $d->nama_desa }}
        </option>
        @endforeach
      </select>

      <button class="bg-green-600 text-white px-4 py-2 rounded">
        Update
      </button>

    </form>

  </div>

</div>

@endsection