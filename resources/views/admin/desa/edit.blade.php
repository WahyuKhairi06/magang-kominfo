@extends('template.layout')
@section('content')

<div class="p-6 max-w-xl mx-auto">

  <div class="bg-white p-6 rounded-2xl shadow">

    <h3 class="font-bold mb-4">Edit Desa</h3>

    <form action="{{ route('desa.update', $desa->id) }}" method="POST">
      @csrf
      @method('PUT')

      <input type="text" name="nama_desa"
        value="{{ $desa->nama_desa }}"
        class="w-full mb-3 p-2 border rounded">

      <select name="kecamatan_id" class="w-full mb-3 p-2 border rounded">
        @foreach($kecamatan as $k)
        <option value="{{ $k->id }}"
          {{ $desa->kecamatan_id == $k->id ? 'selected' : '' }}>
          {{ $k->nama_kecamatan }}
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