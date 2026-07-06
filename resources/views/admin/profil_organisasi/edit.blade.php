@extends('template.layout')

@section('content')

<div class="p-6 max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Edit Struktur Organisasi</h1>

    <form action="{{ route('organisasi.update',$data->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-4 bg-white p-6 rounded-xl shadow">

        @csrf

        <input type="text" name="nama"
               value="{{ $data->nama }}"
               class="w-full border p-2 rounded">

      <select name="jabatan" class="w-full border p-2 rounded">

    <option value="">-- Pilih Jabatan --</option>

    <option value="Direktur" {{ $data->jabatan == 'Direktur' ? 'selected' : '' }}>
        Direktur
    </option>

    <option value="Kepala UPT" {{ $data->jabatan == 'Kepala UPT' ? 'selected' : '' }}>
        Kepala UPT
    </option>

    <option value="Plt. Direktur" {{ $data->jabatan == 'Plt. Direktur' ? 'selected' : '' }}>
        Plt. Direktur
    </option>

    <option value="Ketua Pembina TP PKK" {{ $data->jabatan == 'Kelompok Jabatan Fungsional' ? 'selected' : '' }}>
        Kelompok Jabatan Fungsional
    </option>

    <option value="Wakil" {{ $data->jabatan == 'Wakil' ? 'selected' : '' }}>
        Wakil
    </option>

    <option value="Sekretaris" {{ $data->jabatan == 'Sekretaris' ? 'selected' : '' }}>
        Sekretaris
    </option>

    <option value="Wakil Sekretaris" {{ $data->jabatan == 'Wakil Sekretaris' ? 'selected' : '' }}>
        Wakil Sekretaris
    </option>

    <option value="Bendahara" {{ $data->jabatan == 'Bendahara' ? 'selected' : '' }}>
        Bendahara
    </option>

    <option value="Komite Medis" {{ $data->jabatan == 'Komite Medis' ? 'selected' : '' }}>
        Komite Medis
    </option>

    <option value="Komite Keperawatan" {{ $data->jabatan == 'Komite Keperawatan' ? 'selected' : '' }}>
        Komite Keperawatan
    </option>

    <option value="Komite Tenaga Kesehatan" {{ $data->jabatan == 'Komite Tenaga Kesehatan' ? 'selected' : '' }}>
        Komite Tenaga Kesehatan
    </option>

    <option value="Sub Bagian Administrasi Umum dan Keuangan" {{ $data->jabatan == 'Sub Bagian Administrasi Umum dan Keuangan' ? 'selected' : '' }}>
        Sub Bagian Administrasi Umum dan Keuangan
    </option>

    <option value="Kasi" {{ $data->jabatan == 'Kasi' ? 'selected' : '' }}>
        Kasi
    </option>

    <option value="Staff" {{ $data->jabatan == 'Staff' ? 'selected' : '' }}>
        Staff
    </option>

    

    <!-- {{-- POKJA I --}}
    <option value="Ketua Pokja I" {{ $data->jabatan == 'Ketua Pokja I' ? 'selected' : '' }}>Ketua Pokja I</option>
    <option value="Wakil Ketua Pokja I" {{ $data->jabatan == 'Wakil Ketua Pokja I' ? 'selected' : '' }}>Wakil Ketua Pokja I</option>
    <option value="Sekretaris Pokja I" {{ $data->jabatan == 'Sekretaris Pokja I' ? 'selected' : '' }}>Sekretaris Pokja I</option>
    <option value="Anggota Pokja I" {{ $data->jabatan == 'Anggota Pokja I' ? 'selected' : '' }}>Anggota Pokja I</option>

    {{-- POKJA II --}}
    <option value="Ketua Pokja II" {{ $data->jabatan == 'Ketua Pokja II' ? 'selected' : '' }}>Ketua Pokja II</option>
    <option value="Wakil Ketua Pokja II" {{ $data->jabatan == 'Wakil Ketua Pokja II' ? 'selected' : '' }}>Wakil Ketua Pokja II</option>
    <option value="Sekretaris Pokja II" {{ $data->jabatan == 'Sekretaris Pokja II' ? 'selected' : '' }}>Sekretaris Pokja II</option>
    <option value="Anggota Pokja II" {{ $data->jabatan == 'Anggota Pokja II' ? 'selected' : '' }}>Anggota Pokja II</option>

    {{-- POKJA III --}}
    <option value="Ketua Pokja III" {{ $data->jabatan == 'Ketua Pokja III' ? 'selected' : '' }}>Ketua Pokja III</option>
    <option value="Wakil Ketua Pokja III" {{ $data->jabatan == 'Wakil Ketua Pokja III' ? 'selected' : '' }}>Wakil Ketua Pokja III</option>
    <option value="Sekretaris Pokja III" {{ $data->jabatan == 'Sekretaris Pokja III' ? 'selected' : '' }}>Sekretaris Pokja III</option>
    <option value="Anggota Pokja III" {{ $data->jabatan == 'Anggota Pokja III' ? 'selected' : '' }}>Anggota Pokja III</option>

    {{-- POKJA IV --}}
    <option value="Ketua Pokja IV" {{ $data->jabatan == 'Ketua Pokja IV' ? 'selected' : '' }}>Ketua Pokja IV</option>
    <option value="Wakil Ketua Pokja IV" {{ $data->jabatan == 'Wakil Ketua Pokja IV' ? 'selected' : '' }}>Wakil Ketua Pokja IV</option>
    <option value="Sekretaris Pokja IV" {{ $data->jabatan == 'Sekretaris Pokja IV' ? 'selected' : '' }}>Sekretaris Pokja IV</option>
    <option value="Anggota Pokja IV" {{ $data->jabatan == 'Anggota Pokja IV' ? 'selected' : '' }}>Anggota Pokja IV</option> -->

</select>
        <input type="number" name="urutan"
               value="{{ $data->urutan }}"
               class="w-full border p-2 rounded">

        {{-- FOTO LAMA --}}
        @if($data->foto)
            <img src="{{ asset('storage/organisasi/'.$data->foto) }}"
                 class="w-20 h-20 rounded-full mb-2">
        @endif

        <input type="file" name="foto"
               class="w-full border p-2 rounded">

        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
            Update
        </button>

    </form>

</div>

@endsection