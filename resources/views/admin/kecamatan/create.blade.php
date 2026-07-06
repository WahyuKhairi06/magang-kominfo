@extends('template.layout')
@section('content')

<div class="p-6 max-w-xl mx-auto">

  <div class="bg-white p-6 rounded-2xl shadow">

    <h3 class="font-bold mb-4">Tambah Kecamatan</h3>

    <form action="{{ route('kecamatan.store') }}" method="POST">
      @csrf

      <input type="text" name="nama_kecamatan"
        placeholder="Nama Kecamatan"
        class="w-full mb-3 p-2 border rounded">

      <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
      </button>

    </form>

  </div>

</div>

@endsection