@extends('template.layout')
@section('content')

<div class="p-6 max-w-xl mx-auto">

  <div class="bg-white p-6 rounded-2xl shadow">

    <h3 class="font-bold mb-4">Edit Kecamatan</h3>

    <form action="{{ route('kecamatan.update', $kecamatan->id) }}" method="POST">
      @csrf

      <input type="text" name="nama_kecamatan"
        value="{{ $kecamatan->nama_kecamatan }}"
        class="w-full mb-3 p-2 border rounded">

      <button class="bg-green-600 text-white px-4 py-2 rounded">
        Update
      </button>

    </form>

  </div>

</div>

@endsection