@extends('template.layout')

@section('content')

<div class="p-6 max-w-5xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Edit Data Kegiatan Pokja 2</h2>

    <form action="{{ url('kegiatanpokja2/update/'.$data->id) }}" method="POST" class="space-y-6">
        @csrf

        <!-- BUTA HURUF -->
        <div>
            <label class="block font-medium mb-1">Jumlah Warga Masih Buta Huruf</label>
            <input type="number" name="jumlah_warga_masih_buta"
                value="{{ $data->jumlah_warga_masih_buta }}"
                required
                class="w-full border rounded p-2">
        </div>

        <!-- PAKET A -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Paket A - Kelompok</label>
                <input type="number" name="paket_a_kelompok"
                    value="{{ $data->paket_a_kelompok }}"
                    required
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Paket A - Warga</label>
                <input type="number" name="paket_a_warga"
                    value="{{ $data->paket_a_warga }}"
                    required
                    class="w-full border rounded p-2">
            </div>
        </div>

        <!-- PAKET B -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Paket B - Kelompok</label>
                <input type="number" name="paket_b_kelompok"
                    value="{{ $data->paket_b_kelompok }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Paket B - Warga</label>
                <input type="number" name="paket_b_warga"
                    value="{{ $data->paket_b_warga }}"
                    required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- PAKET C -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Paket C - Kelompok</label>
                <input type="number" name="paket_c_kelompok"
                    value="{{ $data->paket_c_kelompok }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Paket C - Warga</label>
                <input type="number" name="paket_c_warga"
                    value="{{ $data->paket_c_warga }}"
                    required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- KF -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">KF - Kelompok</label>
                <input type="number" name="kf_kelompok"
                    value="{{ $data->kf_kelompok }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">KF - Warga</label>
                <input type="number" name="kf_warga"
                    value="{{ $data->kf_warga }}"
                    required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- PAUD -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">PAUD Sejenis</label>
                <input type="number" name="paud_sejenis"
                    value="{{ $data->paud_sejenis }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Taman Bacaan</label>
                <input type="number" name="taman_bacaan"
                    value="{{ $data->taman_bacaan }}"
                    required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- BKB -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">BKB - Kelompok</label>
                <input type="number" name="bkb_kelompok"
                    value="{{ $data->bkb_kelompok }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">BKB - Ibu</label>
                <input type="number" name="bkb_ibu"
                    value="{{ $data->bkb_ibu }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">BKB - APE</label>
                <input type="number" name="bkb_ape"
                    value="{{ $data->bkb_ape }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">BKB - Simulasi</label>
                <input type="number" name="bkb_simulasi"
                    value="{{ $data->bkb_simulasi }}"
                    required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- KADER -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Kader KF</label>
                <input type="number" name="kader_kf"
                    value="{{ $data->kader_kf }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Kader PAUD</label>
                <input type="number" name="kader_paud"
                    value="{{ $data->kader_paud }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Kader BKB</label>
                <input type="number" name="kader_bkb"
                    value="{{ $data->kader_bkb }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Kader Koperasi</label>
                <input type="number" name="kader_koperasi"
                    value="{{ $data->kader_koperasi }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Kader Keterampilan</label>
                <input type="number" name="kader_keterampilan"
                    value="{{ $data->kader_keterampilan }}"
                    required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- LATIH -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block font-medium mb-1">LP3 PKK</label>
                <input type="number" name="lp3_pkk"
                    value="{{ $data->lp3_pkk }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">TPK3 PKK</label>
                <input type="number" name="tpk3_pkk"
                    value="{{ $data->tpk3_pkk }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">DAMAS PKK</label>
                <input type="number" name="damas_pkk"
                    value="{{ $data->damas_pkk }}"
                    required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- KOPERASI -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Koperasi Pemula - Kelompok</label>
                <input type="number" name="koperasi_pemula_kelompok"
                    value="{{ $data->koperasi_pemula_kelompok }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Pemula - Peserta</label>
                <input type="number" name="koperasi_pemula_peserta"
                    value="{{ $data->koperasi_pemula_peserta }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Madya - Kelompok</label>
                <input type="number" name="koperasi_madya_kelompok"
                    value="{{ $data->koperasi_madya_kelompok }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Madya - Peserta</label>
                <input type="number" name="koperasi_madya_peserta"
                    value="{{ $data->koperasi_madya_peserta }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Utama - Kelompok</label>
                <input type="number" name="koperasi_utama_kelompok"
                    value="{{ $data->koperasi_utama_kelompok }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Utama - Peserta</label>
                <input type="number" name="koperasi_utama_peserta"
                    value="{{ $data->koperasi_utama_peserta }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Mandiri - Kelompok</label>
                <input type="number" name="koperasi_mandiri_kelompok"
                    value="{{ $data->koperasi_mandiri_kelompok }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Mandiri - Peserta</label>
                <input type="number" name="koperasi_mandiri_peserta"
                    value="{{ $data->koperasi_mandiri_peserta }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Hukum - Kelompok</label>
                <input type="number" name="koperasi_hukum_kelompok"
                    value="{{ $data->koperasi_hukum_kelompok }}"
                    required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Koperasi Hukum - Anggota</label>
                <input type="number" name="koperasi_hukum_anggota"
                    value="{{ $data->koperasi_hukum_anggota }}"
                    required class="w-full border rounded p-2">
            </div>
        </div>

        <!-- KETERANGAN -->
        <div>
            <label class="block font-medium mb-1">Keterangan</label>
            <textarea name="ket"
                required
                class="w-full border rounded p-2">{{ $data->ket }}</textarea>
        </div>

        <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
            Update Data
        </button>
    </form>
</div>

@endsection