@extends('template.layout')

@section('content')

<div class="p-6 max-w-5xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Edit Data Pokja IV</h2>

    <form action="{{ url('kegiatanpokja3/update/'.$data->id) }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label>Kader Posyandu</label>
                <input type="number" name="kader_posyandu"
                    value="{{ $data->kader_posyandu }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Kader Gizi</label>
                <input type="number" name="kader_gizi"
                    value="{{ $data->kader_gizi }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Kader Kesling</label>
                <input type="number" name="kader_kesling"
                    value="{{ $data->kader_kesling }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Kader Pencegahan Narkoba</label>
                <input type="number" name="kader_penyuluhan_narkoba"
                    value="{{ $data->kader_penyuluhan_narkoba }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Kader PHBS</label>
                <input type="number" name="kader_phbs"
                    value="{{ $data->kader_phbs }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Kader KB</label>
                <input type="number" name="kader_kb"
                    value="{{ $data->kader_kb }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Posyandu Jumlah</label>
                <input type="number" name="posyandu_jumlah"
                    value="{{ $data->posyandu_jumlah }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Posyandu Terintegrasi</label>
                <input type="number" name="posyandu_terintegrasi"
                    value="{{ $data->posyandu_terintegrasi }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Lansia Kelompok</label>
                <input type="number" name="lansia_jumlah_kelompok"
                    value="{{ $data->lansia_jumlah_kelompok }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Lansia Anggota</label>
                <input type="number" name="lansia_jumlah_anggota"
                    value="{{ $data->lansia_jumlah_anggota }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Kartu Obat Gratis</label>
                <input type="number" name="lansia_memiliki_kartu_obat_gratis"
                    value="{{ $data->lansia_memiliki_kartu_obat_gratis }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Jamban</label>
                <input type="number" name="rumah_memiliki_jamban"
                    value="{{ $data->rumah_memiliki_jamban }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>SPAL</label>
                <input type="number" name="rumah_memiliki_spal"
                    value="{{ $data->rumah_memiliki_spal }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Tempat Sampah</label>
                <input type="number" name="rumah_memiliki_tempat_sampah"
                    value="{{ $data->rumah_memiliki_tempat_sampah }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Jumlah MCK</label>
                <input type="number" name="jumlah_mck"
                    value="{{ $data->jumlah_mck }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Air PDAM</label>
                <input type="number" name="air_pdam"
                    value="{{ $data->air_pdam }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Air Sumur</label>
                <input type="number" name="air_sumur"
                    value="{{ $data->air_sumur }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Air Lainnya</label>
                <input type="number" name="air_lainnya"
                    value="{{ $data->air_lainnya }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Jumlah PUS</label>
                <input type="number" name="jumlah_pus"
                    value="{{ $data->jumlah_pus }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Jumlah WUS</label>
                <input type="number" name="jumlah_wus"
                    value="{{ $data->jumlah_wus }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Akseptor KB L</label>
                <input type="number" name="akseptor_kb_l"
                    value="{{ $data->akseptor_kb_l }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Akseptor KB P</label>
                <input type="number" name="akseptor_kb_p"
                    value="{{ $data->akseptor_kb_p }}" required
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Tabungan Keluarga</label>
                <input type="number" name="kk_memiliki_tabungan_keluarga"
                    value="{{ $data->kk_memiliki_tabungan_keluarga }}" required
                    class="w-full border p-2 rounded">
            </div>

        </div>

        <div>
            <label>Keterangan</label>
            <textarea name="ket" required class="w-full border p-2 rounded">{{ $data->ket }}</textarea>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>
</div>

@endsection