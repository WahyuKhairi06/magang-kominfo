@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

    <h1 class="text-xl font-bold mb-4">Tambah Data Umum Kegiatan</h1>

    <form action="{{ route('umum.store') }}" method="POST" class="space-y-3">
        @csrf

        <select name="desa_id" class="border p-2 w-full">
            <option>Desa</option>
            @foreach($desa as $d)
                <option value="{{ $d->id }}">{{ $d->nama_desa }}</option>
            @endforeach
        </select>

        <select name="kecamatan_id" class="border p-2 w-full">
            <option>Kecamatan</option>
            @foreach($kecamatan as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kecamatan }}</option>
            @endforeach
        </select>

        <select name="dusun_id" class="border p-2 w-full">
            <option>Dusun</option>
            @foreach($dusun as $d)
                <option value="{{ $d->id }}">{{ $d->nama_dusun }}</option>
            @endforeach
        </select>

       

        <input type="number" name="tahun"
               class="border p-2 w-full"
               placeholder="Tahun">

        <button class="bg-green-500 text-white px-4 py-2 rounded">
            Simpan
        </button>

    </form>

</div>

@endsection