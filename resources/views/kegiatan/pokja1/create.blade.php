@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

    <h1 class="text-xl font-bold mb-4">
        Tambah Data {{ $pokjas->nama_pokja }}
    </h1>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="bg-red-200 text-red-800 p-3 mb-3 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pokja.storedata') }}" method="POST" class="space-y-3">
        @csrf

        {{-- DESA --}}
        <select name="desa_id" class="border p-2 w-full">
            <option value="">Pilih Desa</option>
            @foreach($desa as $d)
                <option value="{{ $d->id }}">{{ $d->nama_desa }}</option>
            @endforeach
        </select>

        {{-- KECAMATAN --}}
        <select name="kecamatan_id" class="border p-2 w-full">
            <option value="">Pilih Kecamatan</option>
            @foreach($kecamatan as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kecamatan }}</option>
            @endforeach
        </select>

        {{-- DUSUN --}}
        <select name="dusun_id" class="border p-2 w-full">
            <option value="">Pilih Dusun</option>
            @foreach($dusun as $d)
                <option value="{{ $d->id }}">{{ $d->nama_dusun }}</option>
            @endforeach
        </select>

        {{-- HIDDEN --}}
        <input type="hidden" name="pokja_id" value="{{ $pokjas->id }}">

        {{-- TAHUN --}}
        <input type="number" name="tahun"
               class="border p-2 w-full"
               placeholder="Masukkan Tahun">

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
            Simpan
        </button>

    </form>

</div>

@endsection