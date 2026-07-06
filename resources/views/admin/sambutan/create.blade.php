@extends('template.layout')

@section('content')

<div class="p-6 max-w-4xl mx-auto w-full">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Sambutan</h1>
        <p class="text-gray-500 text-sm">Isi data sambutan dengan lengkap</p>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow p-6">

        <form action="{{ route('sambutan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- JUDUL -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Judul</label>
                <input type="text" name="judul"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary"
                       placeholder="Masukkan judul">
            </div>

            <!-- NAMA -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Nama</label>
                <input type="text" name="nama"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary"
                       placeholder="Nama pejabat">
            </div>

            <!-- MOTTO -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Motto</label>
                <input type="text" name="motto"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary"
                       placeholder="Motto (opsional)">
            </div>

            <!-- ISI -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Isi Sambutan</label>
                <textarea name="isi" rows="5"
                          class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary"
                          placeholder="Isi sambutan..."></textarea>
            </div>

            <!-- FOTO -->
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2">Foto</label>

                <input type="file" name="foto" id="fotoInput"
                       class="w-full border rounded-lg px-4 py-2"
                       onchange="previewFoto(event)">

                <!-- PREVIEW -->
                <div class="mt-4">
                    <img id="previewImg"
                         class="hidden w-32 h-32 object-cover rounded-xl border">
                </div>
            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('sambutan.index') }}"
                   class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    Batal
                </a>

                <button type="submit"
                        class="bg-primary text-white px-6 py-2 rounded-lg shadow hover:bg-primary/90 transition">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection