@extends('template.layout')
@section('content')


<div class="max-w-xl w-full mx-auto mt-10 bg-white p-6 rounded-xl shadow">

    <h1 class="text-xl font-bold mb-4 text-gray-700">Tambah Rumah</h1>

    <form action="{{ route('rumah.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-600">
                Nama Rumah
            </label>

            <input type="text" name="nama_rumah"
                value="{{ old('nama_rumah') }}"
                placeholder="Masukkan nama rumah..."
                class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">

            @error('nama_rumah')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('rumah.index') }}"
               class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">
               Kembali
            </a>

            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Simpan
            </button>
        </div>

    </form>
</div>

@include('sweetalert::alert')

@endsection