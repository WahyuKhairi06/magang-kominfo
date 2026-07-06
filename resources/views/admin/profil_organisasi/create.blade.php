@extends('template.layout')

@section('content')

<div class="p-6 max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Tambah Struktur Organisasi</h1>

    <form action="{{ route('organisasi.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-4 bg-white p-6 rounded-xl shadow">

        @csrf

        <input type="text" name="nama"
               placeholder="Nama"
               class="w-full border p-2 rounded">

       <select name="jabatan" class="w-full border p-2 rounded">

    <option value="">-- Pilih Jabatan --</option>

    {{-- LEVEL ATAS --}}
    <option value="Ketua TP PKK">Ketua TP PKK</option>
    <option value="Ketua Pembina TP PKK">Ketua Pembina TP PKK</option>
    <option value="Wakil Ketua">Wakil Ketua</option>
    <option value="Sekretaris">Sekretaris</option>
    <option value="Wakil Sekretaris">Wakil Sekretaris</option>
    <option value="Bendahara">Bendahara</option>

    {{-- POKJA I --}}
    <option value="Ketua Pokja I">Ketua Pokja I</option>
    <option value="Wakil Ketua Pokja I">Wakil Ketua Pokja I</option>
    <option value="Sekretaris Pokja I">Sekretaris Pokja I</option>
    <option value="Anggota Pokja I">Anggota Pokja I</option>

    {{-- POKJA II --}}
    <option value="Ketua Pokja II">Ketua Pokja II</option>
    <option value="Wakil Ketua Pokja II">Wakil Ketua Pokja II</option>
    <option value="Sekretaris Pokja II">Sekretaris Pokja II</option>
    <option value="Anggota Pokja II">Anggota Pokja II</option>

    {{-- POKJA III --}}
    <option value="Ketua Pokja III">Ketua Pokja III</option>
    <option value="Wakil Ketua Pokja III">Wakil Ketua Pokja III</option>
    <option value="Sekretaris Pokja III">Sekretaris Pokja III</option>
    <option value="Anggota Pokja III">Anggota Pokja III</option>

    {{-- POKJA IV --}}
    <option value="Ketua Pokja IV">Ketua Pokja IV</option>
    <option value="Wakil Ketua Pokja IV">Wakil Ketua Pokja IV</option>
    <option value="Sekretaris Pokja IV">Sekretaris Pokja IV</option>
    <option value="Anggota Pokja IV">Anggota Pokja IV</option>

</select>
        <input type="number" name="urutan"
               placeholder="Urutan"
               class="w-full border p-2 rounded">

        <input type="file" name="foto"
               class="w-full border p-2 rounded">

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Simpan
        </button>

    </form>

</div>

@endsection