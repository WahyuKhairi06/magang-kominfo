@extends('template.layout')

@section('content')

<div class="p-6 max-w-xl mx-auto">

  <div class="bg-white p-6 rounded-2xl shadow">

    <h3 class="font-bold mb-4">Tambah Desa</h3>

    <!-- 🔴 ERROR GLOBAL -->
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('desa.store') }}" method="POST">
      @csrf

      <!-- NAMA DESA -->
      <input type="text" name="nama_desa"
        placeholder="Nama Desa"
        class="w-full mb-1 p-2 border rounded">

      <!-- ERROR FIELD -->
      @error('nama_desa')
        <p class="text-sm text-red-600 mb-3">{{ $message }}</p>
      @enderror

      <!-- KECAMATAN -->
      <select name="kecamatan_id" class="w-full mb-1 p-2 border rounded">
        <option value="">Pilih Kecamatan</option>
        @foreach($kecamatan as $k)
        <option value="{{ $k->id }}">{{ $k->nama_kecamatan }}</option>
        @endforeach
      </select>

      <!-- ERROR FIELD -->
      @error('kecamatan_id')
        <p class="text-sm text-red-600 mb-3">{{ $message }}</p>
      @enderror

      <!-- BUTTON -->
      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        Simpan
      </button>

    </form>

  </div>

</div>

@endsection