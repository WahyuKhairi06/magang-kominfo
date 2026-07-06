@extends('template.layout')
@section('content')

<div class="p-6 max-w-xl mx-auto">

  <div class="bg-white p-6 rounded-2xl shadow">

    <h3 class="font-bold mb-4">Tambah Dusun</h3>

    <form action="{{ route('dusun.store') }}" method="POST">
      @csrf

      <input type="text" name="nama_dusun"
        placeholder="Nama Dusun"
        class="w-full mb-3 p-2 border rounded">

      <select name="desa_id" class="w-full mb-3 p-2 border rounded">
        <option value="">Pilih Desa</option>
        @foreach($desa as $d)
        <option value="{{ $d->id }}">{{ $d->nama_desa }}</option>
        @endforeach
      </select>

      <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
      </button>

    </form>

  </div>

</div>

@endsection