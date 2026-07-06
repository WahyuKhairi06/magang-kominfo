@extends('template.layout')
@section('content')

<div class="max-w-5xl mx-auto p-6">

    <!-- CARD WRAPPER -->
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6 md:p-10">

        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                {{ $cek_id->nama_dasawisma }}
            </h2>
            <p class="text-sm text-gray-500">Form Input Data Dasawisma</p>
        </div>

        <form action="{{ route('dasawisma.simpan', $id) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- KESEHATAN -->
                <h3 class="col-span-2 font-bold text-lg text-blue-700 mt-2">KESEHATAN</h3>

                @foreach([
                    'protokol_kesehatan' => 'Protokol Kesehatan',
                    'jamban_sehat' => 'Jamban Sehat',
                    'bak_penampungan_air' => 'Bak Penampungan Air',
                    'penurunan_penyakit_diare' => 'Penurunan Diare',
                    'keluarga_sadar_gizi' => 'Keluarga Sadar Gizi',
                    'rumah_tanpa_asap_rokok' => 'Rumah Tanpa Asap Rokok',
                    'bab_sembarangan' => 'BAB Sembarangan',
                    'memiliki_bak_sampah' => 'Memiliki Bak Sampah',
                    'spal' => 'SPAL',
                    'tbc'=>'TBC',
                    'mbg'=>'MBG',
                    'sampah_terpilah'=>'Sampah Terpilah',
                    'ckg'=>'CKG',
                ] as $name => $label)

                    <div>
                        <label class="block text-sm font-medium mb-1">{{ $label }}</label>
                        <input type="number" name="{{ $name }}"
                            value="{{ old($name, $data->$name ?? '') }}"
                            class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200 
                            @error($name) border-red-500 @enderror">

                        @error($name)
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                @endforeach


                <!-- IBU & ANAK -->
                <h3 class="col-span-2 font-bold text-lg text-blue-700 mt-6">IBU & ANAK</h3>

                @foreach([
                    'persalinan_di_faskes' => 'Persalinan di Faskes',
                    'asi_ekslusif' => 'ASI Eksklusif',
                    'timbang_balita' => 'Timbang Balita',
                    'berantas_jentik' => 'Berantas Jentik'
                ] as $name => $label)

                    <div>
                        <label class="block text-sm font-medium mb-1">{{ $label }}</label>
                        <input type="number" name="{{ $name }}"
                            value="{{ old($name, $data->$name ?? '') }}"
                            class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200 
                            @error($name) border-red-500 @enderror">

                        @error($name)
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                @endforeach


                <!-- POLA HIDUP -->
                <h3 class="col-span-2 font-bold text-lg text-blue-700 mt-6">POLA HIDUP</h3>

                @foreach([
                    'makan_buah_dan_sayur' => 'Makan Buah & Sayur',
                    'aktivitas_fisik' => 'Aktivitas Fisik'
                ] as $name => $label)

                    <div>
                        <label class="block text-sm font-medium mb-1">{{ $label }}</label>
                        <input type="number" name="{{ $name }}"
                            value="{{ old($name, $data->$name ?? '') }}"
                            class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200 
                            @error($name) border-red-500 @enderror">

                        @error($name)
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                @endforeach


                <!-- STATUS -->
                <h3 class="col-span-2 font-bold text-lg text-blue-700 mt-6">STATUS</h3>

                @foreach([
                    'balita_stunting' => 'Balita Stunting',
                    'kb' => 'KB'
                ] as $name => $label)

                    <div>
                        <label class="block text-sm font-medium mb-1">{{ $label }}</label>
                        <input type="number" name="{{ $name }}"
                            value="{{ old($name, $data->$name ?? '') }}"
                            class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200 
                            @error($name) border-red-500 @enderror">

                        @error($name)
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                @endforeach


                <!-- EKONOMI -->
                <h3 class="col-span-2 font-bold text-lg text-blue-700 mt-6">EKONOMI</h3>

                <div>
                    <label class="block text-sm font-medium mb-1">Berpenghasilan Tetap</label>
                    <input type="number" name="berpenghasilan_tetap"
                        value="{{ old('berpenghasilan_tetap', $data->berpenghasilan_tetap ?? '') }}"
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200 
                        @error('berpenghasilan_tetap') border-red-500 @enderror">

                    @error('berpenghasilan_tetap')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                <!-- KETERANGAN -->
                <h3 class="col-span-2 font-bold text-lg text-blue-700 mt-6">Keterangan</h3>

                <div class="col-span-2">
                    <textarea name="ket"
                        class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200 
                        @error('ket') border-red-500 @enderror"
                        placeholder="Catatan">{{ old('ket', $data->ket ?? '') }}</textarea>

                    @error('ket')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <!-- BUTTON -->
            <button class="mt-8 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition">
                💾 Simpan
            </button>

        </form>

    </div>
</div>

@endsection