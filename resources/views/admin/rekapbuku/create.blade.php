@extends('template.layout')
@section('content')

<div class="p-6 max-w-5xl mx-auto">

<div class="bg-white p-6 rounded-2xl shadow">

<h3 class="font-bold text-lg mb-4">Tambah Data</h3>

<form action="{{ route('rekapbuku.store') }}" method="POST">
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

<!-- BUKU PKK -->
<input type="hidden" readonly name="buku_pkk_id" value="{{ $buku->id }}" class="border p-2 rounded" required>

<!-- NAMA -->
<div>
<label class="text-sm font-medium">Nama</label>
<input type="text" name="nama" placeholder="Nama" class="border p-2 rounded w-full">
</div>

<!-- JENIS KELAMIN -->
<div>
<label class="text-sm font-medium">Jenis Kelamin</label>
<select name="jenis_kelamin" class="border p-2 rounded w-full">
<option value="">Pilih</option>
<option value="L">Laki-laki</option>
<option value="P">Perempuan</option>
</select>
</div>

<!-- KEANGGOTAAN -->
<div>
<label class="text-sm font-medium">Keanggotaan PKK</label>
<input type="text" name="dalam_keanggotaan_tp_pkk" placeholder="Keanggotaan PKK" class="border p-2 rounded w-full">
</div>

<!-- KADER UMUM -->
<div>
<label class="text-sm font-medium">Kader Umum</label>
<input type="text" name="kader_umum" placeholder="Kader Umum" class="border p-2 rounded w-full">
</div>

<!-- KADER KHUSUS -->
<div>
<label class="text-sm font-medium">Kader Khusus</label>
<input type="text" name="kader_khusus" placeholder="Kader Khusus" class="border p-2 rounded w-full">
</div>

<!-- TANGGAL LAHIR -->
<div>
<label class="text-sm font-medium">Tanggal Lahir</label>
<input type="date" name="tanggal_lahir" class="border p-2 rounded w-full">
</div>

<!-- STATUS -->
<div>
<label class="text-sm font-medium">Status</label>
<select name="status" class="border p-2 rounded w-full">
    <option value="">Pilih Status</option>
    <option value="Belum Menikah">Belum Menikah</option>
    <option value="Menikah">Menikah</option>
    <option value="Cerai Hidup">Cerai Hidup</option>
    <option value="Cerai Mati">Cerai Mati</option>
</select>
</div>
<!-- PENDIDIKAN -->
<div>
<label class="text-sm font-medium">Pendidikan</label>
<select name="pendidikan" class="border p-2 rounded w-full">
    <option value="">Pilih Pendidikan</option>
    <option value="Tidak Sekolah">Tidak Sekolah</option>
    <option value="SD">SD / Sederajat</option>
    <option value="SMP">SMP / Sederajat</option>
    <option value="SMA">SMA / SMK</option>
    <option value="D1">Diploma 1 (D1)</option>
    <option value="D2">Diploma 2 (D2)</option>
    <option value="D3">Diploma 3 (D3)</option>
    <option value="D4">Diploma 4 (D4)</option>
    <option value="S1">Sarjana (S1)</option>
    <option value="S2">Magister (S2)</option>
    <option value="S3">Doktor (S3)</option>
    <option value="Lainnya">Lainnya</option>
</select>
</div>

<!-- PEKERJAAN -->
<div>
<label class="text-sm font-medium">Pekerjaan</label>
<select name="pekerjaan" class="border p-2 rounded w-full">
    <option value="">Pilih Pekerjaan</option>
    <option value="IRT">Ibu Rumah Tangga</option>
    <option value="PNS">PNS</option>
    <option value="ASN">ASN</option>
    <option value="Swasta">Karyawan Swasta</option>
    <option value="Wiraswasta">Wiraswasta</option>
    <option value="Petani">Petani</option>
    <option value="Nelayan">Nelayan</option>
    <option value="Guru">Guru</option>
    <option value="Tenaga Kesehatan">Tenaga Kesehatan</option>
    <option value="Pelajar">Pelajar/Mahasiswa</option>
    <option value="Tidak Bekerja">Tidak Bekerja</option>
    <option value="Lainnya">Lainnya</option>
</select>
</div>

<!-- ALAMAT -->
<div class="col-span-2">
<label class="text-sm font-medium">Alamat</label>
<textarea name="alamat" class="border p-2 rounded w-full" placeholder="Alamat"></textarea>
</div>

<!-- KETERANGAN -->
<div class="col-span-2">
<label class="text-sm font-medium">Keterangan</label>
<textarea name="keterangan" class="border p-2 rounded w-full" placeholder="Keterangan"></textarea>
</div>

</div>

<button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
Simpan
</button>

</form>

</div>
</div>

@endsection