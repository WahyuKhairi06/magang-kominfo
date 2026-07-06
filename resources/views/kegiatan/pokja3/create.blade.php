@extends('template.layout')

@section('content')

<div class="p-6 max-w-5xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Tambah Data Pokja IV</h2>

    <form action="{{ url('kegiatanpokja3/store') }}" method="POST" class="space-y-6">
        @csrf

         <Select name="id_dusun"  class="rounded-lg w-full" required>
        <option >Pilih Dusun</option>
        @foreach ($dusun as $dusunku)
        <option value="{{ $dusunku->id }}">{{$dusunku->nama_dusun}}</option>
            
        @endforeach
    </Select>
        <input type="hidden" name="id_desa" value="{{ $id_dusun }}">

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Kader Posyandu</label>
                <input type="number" name="kader_posyandu" required class="w-full border p-2 rounded">
            </div>
            <div>
                <label>Kader Gizi</label>
                <input type="number" name="kader_gizi" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Kader Kesling</label>
                <input type="number" name="kader_kesling" required class="w-full border p-2 rounded">
            </div>
            <div>
                <label>Kader Pencegahan Narkoba</label>
                <input type="number" name="kader_penyuluhan_narkoba" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Kader PHBS</label>
                <input type="number" name="kader_phbs" required class="w-full border p-2 rounded">
            </div>
            <div>
                <label>Kader KB</label>
                <input type="number" name="kader_kb" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Posyandu Jumlah</label>
                <input type="number" name="posyandu_jumlah" required class="w-full border p-2 rounded">
            </div>
            <div>
                <label>Posyandu Terintegrasi</label>
                <input type="number" name="posyandu_terintegrasi" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Lansia Kelompok</label>
                <input type="number" name="lansia_jumlah_kelompok" required class="w-full border p-2 rounded">
            </div>
            <div>
                <label>Lansia Anggota</label>
                <input type="number" name="lansia_jumlah_anggota" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Kartu Obat Gratis</label>
                <input type="number" name="lansia_memiliki_kartu_obat_gratis" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Jamban</label>
                <input type="number" name="rumah_memiliki_jamban" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>SPAL</label>
                <input type="number" name="rumah_memiliki_spal" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Tempat Sampah</label>
                <input type="number" name="rumah_memiliki_tempat_sampah" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Jumlah MCK</label>
                <input type="number" name="jumlah_mck" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Air PDAM</label>
                <input type="number" name="air_pdam" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Air Sumur</label>
                <input type="number" name="air_sumur" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Air Lainnya</label>
                <input type="number" name="air_lainnya" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Jumlah PUS</label>
                <input type="number" name="jumlah_pus" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Jumlah WUS</label>
                <input type="number" name="jumlah_wus" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Akseptor KB L</label>
                <input type="number" name="akseptor_kb_l" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Akseptor KB P</label>
                <input type="number" name="akseptor_kb_p" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Tabungan Keluarga</label>
                <input type="number" name="kk_memiliki_tabungan_keluarga" required class="w-full border p-2 rounded">
            </div>
        </div>

        <div>
            <label>Keterangan</label>
            <textarea name="ket" required class="w-full border p-2 rounded"></textarea>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
</div>

@endsection