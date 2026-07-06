@extends('template.layout')

@section('content')
<div class="container mx-auto p-4">
<h1 class="text-xl font-bold mb-4">Edit Data Buku 1  Catatan Anggota Keluarga</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
    <ul>
        @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('buku.update',$data->id) }}" method="POST" class="bg-white p-4 rounded shadow grid grid-cols-2 gap-3">
@csrf
@method('PUT')

 <select name="rumah_id" class="border p-2 w-full mb-3 rounded">
                <option value="">Semua Rumah</option>
                @foreach ($data_rumah as $rumah)
<option value="{{ $rumah->id }}"
    {{ $data->rumah_id == $rumah->id ? 'selected' : '' }}>
    {{ $rumah->nama_rumah }}
</option>                @endforeach
            </select>

<input type="text" name="nama_anggota_keluarga" value="{{ $data->nama_anggota_keluarga }}" class="border p-2" required>

<select name="jenis_kelamin" class="border p-2">
    <option value="Laki-laki" {{ $data->jenis_kelamin=='Laki-laki'?'selected':'' }}>Laki-laki</option>
    <option value="Perempuan" {{ $data->jenis_kelamin=='Perempuan'?'selected':'' }}>Perempuan</option>
</select>

<select name="status_perkawinan" class="border p-2">
    <option value="Kawin" {{ $data->status_perkawinan=='Kawin'?'selected':'' }}>Kawin</option>
    <option value="Belum Kawin" {{ $data->status_perkawinan=='Belum Kawin'?'selected':'' }}>Belum Kawin</option>
</select>

<input type="text" name="tempat_lahir" value="{{ $data->tempat_lahir }}" class="border p-2">
<input type="date" name="tgl_lahir" value="{{ $data->tgl_lahir }}" class="border p-2">

<select name="agama" class="border p-2">
    <option value="">Pilih Agama</option>
    <option value="Islam" {{ $data->agama=='Islam'?'selected':'' }}>Islam</option>
    <option value="Kristen" {{ $data->agama=='Kristen'?'selected':'' }}>Kristen</option>
    <option value="Katolik" {{ $data->agama=='Katolik'?'selected':'' }}>Katolik</option>
    <option value="Hindu" {{ $data->agama=='Hindu'?'selected':'' }}>Hindu</option>
    <option value="Buddha" {{ $data->agama=='Buddha'?'selected':'' }}>Buddha</option>
    <option value="Konghucu" {{ $data->agama=='Konghucu'?'selected':'' }}>Konghucu</option>
    <option value="Kepercayaan" {{ $data->agama=='Kepercayaan'?'selected':'' }}>Kepercayaan</option>
</select>
<select name="pendidikan" class="border p-2">
    <option value="">Pilih Pendidikan</option>
    <option value="Tidak Sekolah" {{ $data->pendidikan=='Tidak Sekolah'?'selected':'' }}>Tidak Sekolah</option>
    <option value="Belum Sekolah" {{ $data->pendidikan=='Belum Sekolah'?'selected':'' }}>Belum Sekolah</option>
    <option value="SD" {{ $data->pendidikan=='SD'?'selected':'' }}>SD</option>
    <option value="SMP" {{ $data->pendidikan=='SMP'?'selected':'' }}>SMP</option>
    <option value="SMA" {{ $data->pendidikan=='SMA'?'selected':'' }}>SMA</option>
    <option value="SMK" {{ $data->pendidikan=='SMK'?'selected':'' }}>SMK</option>
    <option value="D1" {{ $data->pendidikan=='D1'?'selected':'' }}>D1</option>
    <option value="D2" {{ $data->pendidikan=='D2'?'selected':'' }}>D2</option>
    <option value="D3" {{ $data->pendidikan=='D3'?'selected':'' }}>D3</option>
    <option value="D4" {{ $data->pendidikan=='D4'?'selected':'' }}>D4</option>
    <option value="S1" {{ $data->pendidikan=='S1'?'selected':'' }}>S1</option>
    <option value="S2" {{ $data->pendidikan=='S2'?'selected':'' }}>S2</option>
    <option value="S3" {{ $data->pendidikan=='S3'?'selected':'' }}>S3</option>
</select>
<select name="pekerjaan" class="border p-2">
    <option value="">Pilih Pekerjaan</option>
    <option value="Tidak Bekerja" {{ $data->pekerjaan=='Tidak Bekerja'?'selected':'' }}>Tidak Bekerja</option>
    <option value="Pelajar" {{ $data->pekerjaan=='Pelajar'?'selected':'' }}>Pelajar</option>
    <option value="Mahasiswa" {{ $data->pekerjaan=='Mahasiswa'?'selected':'' }}>Mahasiswa</option>
    <option value="Ibu Rumah Tangga" {{ $data->pekerjaan=='Ibu Rumah Tangga'?'selected':'' }}>Ibu Rumah Tangga</option>
    <option value="Petani" {{ $data->pekerjaan=='Petani'?'selected':'' }}>Petani</option>
    <option value="Nelayan" {{ $data->pekerjaan=='Nelayan'?'selected':'' }}>Nelayan</option>
    <option value="Pedagang" {{ $data->pekerjaan=='Pedagang'?'selected':'' }}>Pedagang</option>
    <option value="Wiraswasta" {{ $data->pekerjaan=='Wiraswasta'?'selected':'' }}>Wiraswasta</option>
    <option value="Buruh" {{ $data->pekerjaan=='Buruh'?'selected':'' }}>Buruh</option>
    <option value="Karyawan Swasta" {{ $data->pekerjaan=='Karyawan Swasta'?'selected':'' }}>Karyawan Swasta</option>
    <option value="ASN" {{ $data->pekerjaan=='ASN'?'selected':'' }}>ASN</option>
    <option value="TNI" {{ $data->pekerjaan=='TNI'?'selected':'' }}>TNI</option>
    <option value="POLRI" {{ $data->pekerjaan=='POLRI'?'selected':'' }}>POLRI</option>
    <option value="Pensiunan" {{ $data->pekerjaan=='Pensiunan'?'selected':'' }}>Pensiunan</option>
    <option value="Lainnya" {{ $data->pekerjaan=='Lainnya'?'selected':'' }}>Lainnya</option>
</select>
<!-- CHECKBOX --><div class="col-span-2 space-y-3">

    <!-- BERKEBUTUHAN KHUSUS -->
    <div class="flex items-center gap-2">
        <input type="checkbox" name="berkebutuhan_khusus" value="1"
            {{ $data->berkebutuhan_khusus ? 'checked' : '' }}
            class="w-4 h-4 text-blue-600 border-gray-300 rounded">

        <label class="text-sm font-medium text-gray-700">
            Berkebutuhan Khusus
        </label>
    </div>

    <!-- JUDUL -->
    <p class="text-sm font-semibold text-gray-600 border-b pb-1">
        Kegiatan PKK yang diikuti
    </p>

    <!-- LIST -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="pancasila" value="1"
                {{ $data->pancasila ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Pancasila
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="goro" value="1"
                {{ $data->goro ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Gotong Royong
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="pendidikan_keterampilan" value="1"
                {{ $data->pendidikan_keterampilan ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Pendidikan & Keterampilan
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="penghidupan_berkoperasi" value="1"
                {{ $data->penghidupan_berkoperasi ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Koperasi
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="pangan" value="1"
                {{ $data->pangan ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Pangan
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="sandang" value="1"
                {{ $data->sandang ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Sandang
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="kesehatan" value="1"
                {{ $data->kesehatan ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Kesehatan
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="perencanaan_sehat" value="1"
                {{ $data->perencanaan_sehat ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Perencanaan Sehat
        </label>

    </div>

</div>

<select name="kriteria_rumah" class="border p-2">
    <option value="Layak Huni" {{ $data->kriteria_rumah=='Layak Huni'?'selected':'' }}>Layak Huni</option>
    <option value="Tidak Layak Huni" {{ $data->kriteria_rumah=='Tidak Layak Huni'?'selected':'' }}>Tidak Layak Huni</option>
</select>

<select name="jamban_keluarga" class="border p-2">
    <option value="Ada" {{ $data->jamban_keluarga=='Ada'?'selected':'' }}>Ada</option>
    <option value="Tidak Ada" {{ $data->jamban_keluarga=='Tidak Ada'?'selected':'' }}>Tidak Ada</option>
</select>

<select name="sumber_air" class="border p-2">
    <option value="PDAM" {{ $data->sumber_air=='PDAM'?'selected':'' }}>PDAM</option>
    <option value="Sumur" {{ $data->sumber_air=='Sumur'?'selected':'' }}>Sumur</option>
    <option value="Lainnya" {{ $data->sumber_air=='Lainnya'?'selected':'' }}>Lainnya</option>
</select>

<select name="tempat_sampah" class="border p-2">
    <option value="Ada" {{ $data->tempat_sampah=='Ada'?'selected':'' }}>Ada</option>
    <option value="Tidak" {{ $data->tempat_sampah=='Tidak'?'selected':'' }}>Tidak</option>
</select>

<textarea name="ket" class="border p-2 col-span-2">{{ $data->ket }}</textarea>

<button class="bg-yellow-500 text-white px-4 py-2 rounded col-span-2">Update</button>

</form>
</div>
@endsection