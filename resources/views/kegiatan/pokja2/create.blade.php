@extends('template.layout')

@section('content')

<div class="p-6 max-w-5xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Tambah Data Kegiatan Pokja 2</h2>

    <form action="{{ url('kegiatanpokja2/store') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" readonly name="id_desa" value="{{ $id_dusun }}">
   <Select name="id_dusun"  class="rounded-lg w-full" required>
        <option >Pilih Dusun</option>
        @foreach ($dusun as $dusunku)
        <option value="{{ $dusunku->id }}">{{$dusunku->nama_dusun}}</option>
            
        @endforeach
    </Select>
        <!-- BUTA HURUF -->
        <div>
            <label class="block font-medium mb-1">Jumlah Warga Masih Buta Huruf</label>
            <input type="number" name="jumlah_warga_masih_buta" required
                class="w-full border rounded p-2 focus:ring focus:ring-blue-200">
        </div>
        

        <!-- PAKET A -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Paket A - Jumlah Kelompok</label>
                <input type="number" name="paket_a_kelompok" required
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Paket A - Jumlah Warga</label>
                <input type="number" name="paket_a_warga" required
                    class="w-full border rounded p-2">
            </div>
        </div>

        <!-- PAKET B -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Paket B - Jumlah Kelompok</label>
                <input type="number" name="paket_b_kelompok" required
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Paket B - Jumlah Warga</label>
                <input type="number" name="paket_b_warga" required
                    class="w-full border rounded p-2">
            </div>
        </div>

        <!-- PAKET C -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Paket C - Jumlah Kelompok</label>
                <input type="number" name="paket_c_kelompok" required
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Paket C - Jumlah Warga</label>
                <input type="number" name="paket_c_warga" required
                    class="w-full border rounded p-2">
            </div>
        </div>

        <!-- KF -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">KF - Jumlah Kelompok</label>
                <input type="number" name="kf_kelompok" required
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">KF - Jumlah Warga</label>
                <input type="number" name="kf_warga" required
                    class="w-full border rounded p-2">
            </div>
        </div>

        <!-- PAUD -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">PAUD Sejenis</label>
                <input type="number" name="paud_sejenis" required
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Taman Bacaan</label>
                <input type="number" name="taman_bacaan" required
                    class="w-full border rounded p-2">
            </div>
        </div>

        <!-- BKB -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">BKB - Jumlah Kelompok</label>
                <input type="number" name="bkb_kelompok" required
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">BKB - Jumlah Ibu</label>
                <input type="number" name="bkb_ibu" required
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">BKB - APE</label>
                <input type="number" name="bkb_ape" required
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">BKB - Simulasi</label>
                <input type="number" name="bkb_simulasi" required
                    class="w-full border rounded p-2">
            </div>
        </div>

        <!-- KADER -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Kader KF</label>
                <input type="number" name="kader_kf" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Kader PAUD</label>
                <input type="number" name="kader_paud" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Kader BKB</label>
                <input type="number" name="kader_bkb" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Kader Koperasi</label>
                <input type="number" name="kader_koperasi" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Kader Keterampilan</label>
                <input type="number" name="kader_keterampilan" required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- LATIH -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block font-medium mb-1">LP3 PKK</label>
                <input type="number" name="lp3_pkk" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">TPK3 PKK</label>
                <input type="number" name="tpk3_pkk" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">DAMAS PKK</label>
                <input type="number" name="damas_pkk" required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- KOPERASI -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Koperasi Pemula - Kelompok</label>
                <input type="number" name="koperasi_pemula_kelompok" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Pemula - Peserta</label>
                <input type="number" name="koperasi_pemula_peserta" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Madya - Kelompok</label>
                <input type="number" name="koperasi_madya_kelompok" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Madya - Peserta</label>
                <input type="number" name="koperasi_madya_peserta" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Utama - Kelompok</label>
                <input type="number" name="koperasi_utama_kelompok" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Utama - Peserta</label>
                <input type="number" name="koperasi_utama_peserta" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Mandiri - Kelompok</label>
                <input type="number" name="koperasi_mandiri_kelompok" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Mandiri - Peserta</label>
                <input type="number" name="koperasi_mandiri_peserta" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Hukum - Kelompok</label>
                <input type="number" name="koperasi_hukum_kelompok" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Hukum - Anggota</label>
                <input type="number" name="koperasi_hukum_anggota" required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- KETERANGAN -->
        <div>
            <label class="block font-medium mb-1">Keterangan</label>
            <textarea name="ket" required
                class="w-full border rounded p-2"
                placeholder="Isi keterangan tambahan"></textarea>
        </div>

        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
            Simpan Data
        </button>
    </form>
</div>

@endsection