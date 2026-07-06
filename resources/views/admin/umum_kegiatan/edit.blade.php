@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

    <h1 class="text-xl font-bold mb-4">Edit Data</h1>

    <form action="{{ route('umum.update',$data->id) }}" method="POST" class="space-y-3">
        @csrf

        <select name="desa_id" class="border p-2 w-full">
            @foreach($desa as $d)
                <option value="{{ $d->id }}"
                    {{ $data->desa_id == $d->id ? 'selected' : '' }}>
                    {{ $d->nama_desa }}
                </option>
            @endforeach
        </select>

        <select name="kecamatan_id" class="border p-2 w-full">
            @foreach($kecamatan as $k)
                <option value="{{ $k->id }}"
                    {{ $data->kecamatan_id == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kecamatan }}
                </option>
            @endforeach
        </select>

        <select name="dusun_id" class="border p-2 w-full">
            @foreach($dusun as $d)
                <option value="{{ $d->id }}"
                    {{ $data->dusun_id == $d->id ? 'selected' : '' }}>
                    {{ $d->nama_dusun }}
                </option>
            @endforeach
        </select>

       

        <input type="number" name="tahun"
               value="{{ $data->tahun }}"
               class="border p-2 w-full">

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Update
        </button>

    </form>

</div>

@endsection