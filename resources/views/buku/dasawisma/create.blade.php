@extends('template.layout')

@section('content')
<div class="container mx-auto p-4">
<h1 class="text-xl font-bold mb-4">Tambah Data Buku 1  Catatan Anggota Keluarga</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
    <ul>
        @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('buku.store') }}" method="POST" class="bg-white p-4 rounded shadow grid grid-cols-2 gap-3">
@csrf

 <select name="rumah_id" class="border p-2 w-full mb-3 rounded">
                <option value="">Pilih  Rumah</option>
                @foreach ($data_rumah as $rumah)
                    <option value="{{ $rumah->id }}">{{ $rumah->nama_rumah }}</option>
                @endforeach
            </select>
<input type="hidden" name="id_dasawisma" placeholder="Nama" value="{{ $dasawisma->id }}" class="border p-2" required>

<input type="text" name="nama_anggota_keluarga" placeholder="Nama" class="border p-2" required>

<select name="jenis_kelamin" class="border p-2" required>
    <option value="">Jenis Kelamin</option>
    <option value="Laki-laki">Laki-laki</option>
    <option value="Perempuan">Perempuan</option>
</select>

<select name="status_perkawinan" class="border p-2">
    <option value="">Status Perkawinan</option>
    <option value="Kawin">Kawin</option>
    <option value="Belum Kawin">Belum Kawin</option>
    <option value="Cerai Mati">Cerai Mati</option>
    <option value="Cerai Hidup">Cerai Hidup</option>
</select>

<input type="text" name="tempat_lahir" placeholder="Tempat Lahir" class="border p-2">
<input type="date" name="tgl_lahir" class="border p-2">

<select name="agama" class="border p-2">
    <option value="">Pilih Agama</option>
    <option value="Islam">Islam</option>
    <option value="Kristen">Kristen</option>
    <option value="Katolik">Katolik</option>
    <option value="Hindu">Hindu</option>
    <option value="Buddha">Buddha</option>
    <option value="Konghucu">Konghucu</option>
    <option value="Kepercayaan">Kepercayaan</option>
</select>


<select name="pendidikan" class="border p-2">
    <option value="">Pilih Pendidikan</option>
    <option value="Tidak Sekolah">Tidak Sekolah</option>
    <option value="Belum Sekolah">Belum Sekolah</option>
    <option value="SD">SD</option>
    <option value="SMP">SMP</option>
    <option value="SMA">SMA</option>
    <option value="SMK">SMK</option>
    <option value="D1">D1</option>
    <option value="D2">D2</option>
    <option value="D3">D3</option>
    <option value="D4">D4</option>
    <option value="S1">S1</option>
    <option value="S2">S2</option>
    <option value="S3">S3</option>
</select>


<select name="pekerjaan" class="border p-2">
    <option value="">Pilih Pekerjaan</option>
    <option value="Tidak Bekerja">Tidak Bekerja</option>
    <option value="Pelajar">Pelajar</option>
    <option value="Mahasiswa">Mahasiswa</option>
    <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
    <option value="Petani">Petani</option>
    <option value="Nelayan">Nelayan</option>
    <option value="Pedagang">Pedagang</option>
    <option value="Wiraswasta">Wiraswasta</option>
    <option value="Buruh">Buruh</option>
    <option value="Karyawan Swasta">Karyawan Swasta</option>
    <option value="ASN">ASN</option>
    <option value="TNI">TNI</option>
    <option value="POLRI">POLRI</option>
    <option value="Pensiunan">Pensiunan</option>
    <option value="Lainnya">Lainnya</option>
</select>


<!-- CHECKBOX -->
<div class="col-span-2 space-y-3">

    <!-- CHECKBOX UTAMA -->
    <div class="flex items-center gap-2">
        <input type="checkbox" name="berkebutuhan_khusus" value="1"
            class="w-4 h-4 text-blue-600 border-gray-300 rounded">
        <label class="text-sm font-medium text-gray-700">
            Berkebutuhan Khusus
        </label>
    </div>

    <!-- JUDUL KEGIATAN -->
    <p class="text-sm font-semibold text-gray-600 border-b pb-1">
        Kegiatan PKK yang diikuti
    </p>

    <!-- LIST KEGIATAN -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="pancasila" value="1"
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Pancasila
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="goro" value="1"
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Gotong Royong
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="pendidikan_keterampilan" value="1"
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Pendidikan & Keterampilan
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="penghidupan_berkoperasi" value="1"
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Koperasi
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="pangan" value="1"
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Pangan
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="sandang" value="1"
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Sandang
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="kesehatan" value="1"
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Kesehatan
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="perencanaan_sehat" value="1"
                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
            Perencanaan Sehat
        </label>


    </div>
</div>
<select name="kriteria_rumah" class="border p-2">
    <option value="">Kriteria Rumah</option>
    <option value="Layak Huni">Layak Huni</option>
    <option value="Tidak Layak Huni">Tidak Layak Huni</option>
</select>

<select name="jamban_keluarga" class="border p-2">
    <option value="">Jamban</option>
    <option value="Ada">Ada</option>
    <option value="Tidak Ada">Tidak Ada</option>
</select>

<select name="sumber_air" class="border p-2">
    <option value="">Sumber Air</option>
    <option value="PDAM">PDAM</option>
    <option value="Sumur">Sumur</option>
    <option value="Lainnya">Lainnya</option>
</select>

<select name="tempat_sampah" class="border p-2">
    <option value="">Tempat Sampah</option>
    <option value="Ada">Ada</option>
    <option value="Tidak">Tidak</option>
</select>

<textarea name="ket" placeholder="Keterangan" class="border p-2 col-span-2"></textarea>

<button class="bg-blue-500 text-white px-4 py-2 rounded col-span-2">Simpan</button>

</form>
</div>
@endsection