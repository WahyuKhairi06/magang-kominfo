@extends('template.layout')

@section('content')

<div class="p-6 max-w-5xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Tambah Data</h2>

    <form action="{{ url('kegiatanpokja3real/store') }}" method="POST" class="space-y-6">
        @csrf
 <Select name="id_dusun"  class="rounded-lg w-full" required>
        <option >Pilih Dusun</option>
        @foreach ($dusun as $dusunku)
        <option value="{{ $dusunku->id }}">{{$dusunku->nama_dusun}}</option>
            
        @endforeach
    </Select>
        <input type="hidden" name="id_desa" value="{{ $id_dusun }}">

        <div class="grid grid-cols-2 gap-4">

            <div><label>Kader Pangan</label>
                <input type="number" name="kader_pangan" required class="w-full border p-2 rounded"></div>

            <div><label>Kader Sandang</label>
                <input type="number" name="kader_sandang" required class="w-full border p-2 rounded"></div>

            <div><label>Kader Tata Laksana RT</label>
                <input type="number" name="kader_tata_laksana_rumah_tangga" required class="w-full border p-2 rounded"></div>

            <div><label>Beras</label>
                <input type="number" name="pangan_beras" required class="w-full border p-2 rounded"></div>

            <div><label>Non Beras</label>
                <input type="number" name="pangan_non_beras" required class="w-full border p-2 rounded"></div>

            <div><label>Peternakan</label>
                <input type="number" name="peternakan" required class="w-full border p-2 rounded"></div>

            <div><label>Perikanan</label>
                <input type="number" name="perikanan" required class="w-full border p-2 rounded"></div>

            <div><label>Warung Hidup</label>
                <input type="number" name="warung_hidup" required class="w-full border p-2 rounded"></div>

            <div><label>Lumbung Hidup</label>
                <input type="number" name="lumbung_hidup" required class="w-full border p-2 rounded"></div>

            <div><label>TOGA</label>
                <input type="number" name="toga" required class="w-full border p-2 rounded"></div>
            <div><label>Tanaman Keras</label>
                <input type="number" name="tanaman_keras" required class="w-full border p-2 rounded"></div>
            <div><label>Tanaman Lainnya</label>
                <input type="number" name="tanaman_lainnya" required class="w-full border p-2 rounded"></div>

            <div><label>Industri Pangan</label>
                <input type="number" name="industri_pangan" required class="w-full border p-2 rounded"></div>

            <div><label>Industri Sandang</label>
                <input type="number" name="industri_sandang" required class="w-full border p-2 rounded"></div>

            <div><label>Industri Jasa</label>
                <input type="number" name="industri_jasa" required class="w-full border p-2 rounded"></div>

            <div><label>Rumah Sehat Layak</label>
                <input type="number" name="rumah_sehat_layak" required class="w-full border p-2 rounded"></div>

            <div><label>Rumah Tidak Layak</label>
                <input type="number" name="rumah_tidak_sehat_tidak_layak" required class="w-full border p-2 rounded"></div>

        </div>

        <div>
            <label>Keterangan</label>
            <textarea name="keterangan" required class="w-full border p-2 rounded"></textarea>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
</div>

@endsection