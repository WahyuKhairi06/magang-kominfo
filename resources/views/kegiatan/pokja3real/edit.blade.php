@extends('template.layout')

@section('content')

<div class="p-6 max-w-5xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Edit Data</h2>

    <form action="{{ url('kegiatanpokja3real/update/'.$data->id) }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-semibold">Kader Pangan</label>
                <input type="number" name="kader_pangan" value="{{ $data->kader_pangan }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Kader Sandang</label>
                <input type="number" name="kader_sandang" value="{{ $data->kader_sandang }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Kader Tata Laksana Rumah Tangga</label>
                <input type="number" name="kader_tata_laksana_rumah_tangga" value="{{ $data->kader_tata_laksana_rumah_tangga }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Pangan Beras</label>
                <input type="number" name="pangan_beras" value="{{ $data->pangan_beras }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Pangan Non Beras</label>
                <input type="number" name="pangan_non_beras" value="{{ $data->pangan_non_beras }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Peternakan</label>
                <input type="number" name="peternakan" value="{{ $data->peternakan }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Perikanan</label>
                <input type="number" name="perikanan" value="{{ $data->perikanan }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Warung Hidup</label>
                <input type="number" name="warung_hidup" value="{{ $data->warung_hidup }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Lumbung Hidup</label>
                <input type="number" name="lumbung_hidup" value="{{ $data->lumbung_hidup }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">TOGA</label>
                <input type="number" name="toga" value="{{ $data->toga }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Tanaman Keras</label>
                <input type="number" name="tanaman_keras" value="{{ $data->tanaman_keras }}" required class="border p-2 rounded w-full">
            </div>
            <div>
                <label class="block text-sm font-semibold">Tanaman Lainnya</label>
                <input type="number" name="tanaman_lainnya" value="{{ $data->tanaman_lainnya }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Industri Pangan</label>
                <input type="number" name="industri_pangan" value="{{ $data->industri_pangan }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Industri Sandang</label>
                <input type="number" name="industri_sandang" value="{{ $data->industri_sandang }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Industri Jasa</label>
                <input type="number" name="industri_jasa" value="{{ $data->industri_jasa }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Rumah Sehat Layak</label>
                <input type="number" name="rumah_sehat_layak" value="{{ $data->rumah_sehat_layak }}" required class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold">Rumah Tidak Sehat / Tidak Layak</label>
                <input type="number" name="rumah_tidak_sehat_tidak_layak" value="{{ $data->rumah_tidak_sehat_tidak_layak }}" required class="border p-2 rounded w-full">
            </div>

        </div>

        <div>
            <label class="block text-sm font-semibold">Keterangan</label>
            <textarea name="keterangan" required class="w-full border p-2 rounded mt-1">{{ $data->keterangan }}</textarea>
        </div>

        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mt-3">
            Update
        </button>
    </form>
</div>

@endsection