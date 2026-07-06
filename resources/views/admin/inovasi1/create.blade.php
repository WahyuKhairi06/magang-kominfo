{{-- resources/views/admin/inovasi1/create.blade.php --}}

@extends('template.layout')

@section('content')

<div class="max-w-4xl mx-auto p-4">

    {{-- HEADER --}}
    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Tambah Inovasi
        </h1>

        <p class="text-gray-500 mt-1">
            Upload dokumen atau gambar inovasi kegiatan.
        </p>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <form action="{{ route('inovasi1.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="p-6 space-y-6">

                {{--  --}}
                <div>

                  {{-- JUDUL --}}
                <div>

                    <label class="block w-full mb-2 font-semibold text-gray-700">
                        Judul Inovasi
                    </label>

                    <textarea name="judul"
                              rows="5"
                              placeholder="Masukkan judul inovasi..."
                              class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('judul') }}</textarea>

                    @error('judul')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- DESKRIPSI --}}
                <div>

                    <label class="block w-full mb-2 font-semibold text-gray-700">
                        Deskripsi
                    </label>

                    <textarea name="deskripsi"
                              rows="5"
                              placeholder="Masukkan deskripsi inovasi..."
                              class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>                

                {{-- TAHUN --}}
                <div>

    <label class="block w-full mb-2 font-semibold text-gray-700">
        Tahun Inovasi
    </label>

    <select name="tahun"
            class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

        <option value="">-- Pilih Tahun --</option>

        @for($i = date('Y'); $i >= 2000; $i--)
            <option value="{{ $i }}" {{ old('tahun') == $i ? 'selected' : '' }}>
                {{ $i }}
            </option>
        @endfor

    </select>

    @error('tahun')
        <p class="text-red-500 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror

        </div>

                {{-- Upload Foto --}}
                <div>

                    <label class="block mb-3 font-semibold text-gray-700">
                        Upload Foto Dokumentasi
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 bg-gray-50 hover:bg-gray-100 transition">

                        <div class="flex flex-col items-center justify-center text-center">

                            {{-- ICON --}}
                            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-10 h-10 text-blue-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>

                                </svg>

                            </div>

                            <p class="text-lg font-semibold text-gray-700">
                                Klik atau tarik file ke sini
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Support:
                                JPG, PNG
                            </p>

                            <p class="text-sm text-red-500 mt-1">
                                Maksimal ukuran file 2MB
                            </p>

                            <input type="file"
                                   name="foto_inovasi"
                                   id="fotoInput"
                                   class="hidden">

                            <button type="button"
                                    onclick="document.getElementById('fotoInput').click()"
                                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition">

                                Pilih File

                            </button>

                            {{-- PREVIEW --}}
                            <div id="fotoPreview"
                                 class="mt-5 hidden w-full">

                                <div class="bg-white border rounded-xl p-4 flex items-center gap-4 shadow-sm">

                                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">

                                        📄

                                    </div>

                                    <div class="flex-1 text-left">

                                        <p id="fotoName"
                                           class="font-semibold text-gray-700"></p>

                                        <p id="fotoSize"
                                           class="text-sm text-gray-500"></p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Upload Manual Book --}}
                <div>

                    <label class="block mb-3 font-semibold text-gray-700">
                        Upload Manual Book
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 bg-gray-50 hover:bg-gray-100 transition">

                        <div class="flex flex-col items-center justify-center text-center">

                            {{-- ICON --}}
                            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-10 h-10 text-blue-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>

                                </svg>

                            </div>

                            <p class="text-lg font-semibold text-gray-700">
                                Klik atau tarik file ke sini
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Support:
                                JPG, PNG, PDF, DOC, DOCX, XLS, XLSX
                            </p>

                            <p class="text-sm text-red-500 mt-1">
                                Maksimal ukuran file 2MB
                            </p>

                            <input type="file"
                                   name="manual_book"
                                   id="manualBookInput"
                                   class="hidden">

                            <button type="button"
                                    onclick="document.getElementById('manualBookInput').click()"
                                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition">

                                Pilih File

                            </button>

                            {{-- PREVIEW --}}
                            <div id="manualBookPreview"
                                 class="mt-5 hidden w-full">

                                <div class="bg-white border rounded-xl p-4 flex items-center gap-4 shadow-sm">

                                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">

                                        📄

                                    </div>

                                    <div class="flex-1 text-left">

                                        <p id="manualBookName"
                                           class="font-semibold text-gray-700"></p>

                                        <p id="manualBookSize"
                                           class="text-sm text-gray-500"></p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

              
            {{-- Upload KAK --}}
                <div>

                    <label class="block mb-3 font-semibold text-gray-700">
                        Upload KAK
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 bg-gray-50 hover:bg-gray-100 transition">

                        <div class="flex flex-col items-center justify-center text-center">

                            {{-- ICON --}}
                            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-10 h-10 text-blue-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>

                                </svg>

                            </div>

                            <p class="text-lg font-semibold text-gray-700">
                                Klik atau tarik file ke sini
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Support:
                                JPG, PNG, PDF, DOC, DOCX, XLS, XLSX
                            </p>

                            <p class="text-sm text-red-500 mt-1">
                                Maksimal ukuran file 2MB
                            </p>

                            <input type="file"
                                   name="kak"
                                   id="kakInput"
                                   class="hidden">

                            <button type="button"
                                    onclick="document.getElementById('kakInput').click()"
                                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition">

                                Pilih File

                            </button>

                            {{-- PREVIEW --}}
                            <div id="kakPreview"
                                 class="mt-5 hidden w-full">

                                <div class="bg-white border rounded-xl p-4 flex items-center gap-4 shadow-sm">

                                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">

                                        📄

                                    </div>

                                    <div class="flex-1 text-left">

                                        <p id="kakName"
                                           class="font-semibold text-gray-700"></p>

                                        <p id="kakSize"
                                           class="text-sm text-gray-500"></p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Upload SOP --}}
                <div>

                    <label class="block mb-3 font-semibold text-gray-700">
                        Upload SOP
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 bg-gray-50 hover:bg-gray-100 transition">

                        <div class="flex flex-col items-center justify-center text-center">

                            {{-- ICON --}}
                            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-10 h-10 text-blue-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>

                                </svg>

                            </div>

                            <p class="text-lg font-semibold text-gray-700">
                                Klik atau tarik file ke sini
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Support:
                                JPG, PNG, PDF, DOC, DOCX, XLS, XLSX
                            </p>

                            <p class="text-sm text-red-500 mt-1">
                                Maksimal ukuran file 2MB
                            </p>

                            <input type="file"
                                   name="sop"
                                   id="sopInput"
                                   class="hidden">

                            <button type="button"
                                    onclick="document.getElementById('sopInput').click()"
                                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition">

                                Pilih File

                            </button>

                            {{-- PREVIEW --}}
                            <div id="SopPreview"
                                 class="mt-5 hidden w-full">

                                <div class="bg-white border rounded-xl p-4 flex items-center gap-4 shadow-sm">

                                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">

                                        📄

                                    </div>

                                    <div class="flex-1 text-left">

                                        <p id="SopName"
                                           class="font-semibold text-gray-700"></p>

                                        <p id="SopSize"
                                           class="text-sm text-gray-500"></p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Upload Makalah --}}
                <div>

                    <label class="block mb-3 font-semibold text-gray-700">
                        Upload Makalah/Proposal
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 bg-gray-50 hover:bg-gray-100 transition">

                        <div class="flex flex-col items-center justify-center text-center">

                            {{-- ICON --}}
                            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-10 h-10 text-blue-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>

                                </svg>

                            </div>

                            <p class="text-lg font-semibold text-gray-700">
                                Klik atau tarik file ke sini
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Support:
                                JPG, PNG, PDF, DOC, DOCX, XLS, XLSX
                            </p>

                            <p class="text-sm text-red-500 mt-1">
                                Maksimal ukuran file 2MB
                            </p>

                            <input type="file"
                                   name="makalah"
                                   id="makalahInput"
                                   class="hidden">

                            <button type="button"
                                    onclick="document.getElementById('makalahInput').click()"
                                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition">

                                Pilih File

                            </button>

                            {{-- PREVIEW --}}
                            <div id="makalahPreview"
                                 class="mt-5 hidden w-full">

                                <div class="bg-white border rounded-xl p-4 flex items-center gap-4 shadow-sm">

                                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">

                                        📄

                                    </div>

                                    <div class="flex-1 text-left">

                                        <p id="makalahName"
                                           class="font-semibold text-gray-700"></p>

                                        <p id="makalahSize"
                                           class="text-sm text-gray-500"></p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>
                {{-- LINK VIDEO --}}
                <div>

                    <label class="block w-full mb-2 font-semibold text-gray-700">
                        Link Video
                    </label>

                    <textarea name="link"
                              rows="5"
                              placeholder="Masukkan link video..."
                              class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('link') }}</textarea>

                    @error('link')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>
                {{-- Upload SK --}}
                <div>

                    <label class="block mb-3 font-semibold text-gray-700">
                        Upload SK/DPA/RKPD
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 bg-gray-50 hover:bg-gray-100 transition">

                        <div class="flex flex-col items-center justify-center text-center">

                            {{-- ICON --}}
                            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-10 h-10 text-blue-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>

                                </svg>

                            </div>

                            <p class="text-lg font-semibold text-gray-700">
                                Klik atau tarik file ke sini
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Support:
                                JPG, PNG, PDF, DOC, DOCX, XLS, XLSX
                            </p>

                            <p class="text-sm text-red-500 mt-1">
                                Maksimal ukuran file 2MB
                            </p>

                            <input type="file"
                                   name="skdpa"
                                   id="skInput"
                                   class="hidden">

                            <button type="button"
                                    onclick="document.getElementById('skInput').click()"
                                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition">

                                Pilih File

                            </button>

                            {{-- PREVIEW --}}
                            <div id="skPreview"
                                 class="mt-5 hidden w-full">

                                <div class="bg-white border rounded-xl p-4 flex items-center gap-4 shadow-sm">

                                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">

                                        📄

                                    </div>

                                    <div class="flex-1 text-left">

                                        <p id="skName"
                                           class="font-semibold text-gray-700"></p>

                                        <p id="skSize"
                                           class="text-sm text-gray-500"></p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Upload Dokumen Lain --}}
                <div>

                    <label class="block mb-3 font-semibold text-gray-700">
                        Upload Dokumen Lainnya
                        (Jika Tidak Ada, Abaikan)
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 bg-gray-50 hover:bg-gray-100 transition">

                        <div class="flex flex-col items-center justify-center text-center">

                            {{-- ICON --}}
                            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-10 h-10 text-blue-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>

                                </svg>

                            </div>

                            <p class="text-lg font-semibold text-gray-700">
                                Klik atau tarik file ke sini
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Support:
                                JPG, PNG, PDF, DOC, DOCX, XLS, XLSX
                            </p>

                            <p class="text-sm text-red-500 mt-1">
                                Maksimal ukuran file 2MB
                            </p>

                            <input type="file"
                                   name="doklain"
                                   id="doklainInput"
                                   class="hidden">

                            <button type="button"
                                    onclick="document.getElementById('doklainInput').click()"
                                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition">

                                Pilih File

                            </button>

                            {{-- PREVIEW --}}
                            <div id="doklainPreview"
                                 class="mt-5 hidden w-full">

                                <div class="bg-white border rounded-xl p-4 flex items-center gap-4 shadow-sm">

                                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">

                                        📄

                                    </div>

                                    <div class="flex-1 text-left">

                                        <p id="doklainName"
                                           class="font-semibold text-gray-700"></p>

                                        <p id="doklainSize"
                                           class="text-sm text-gray-500"></p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>  
            
                      

            {{-- FOOTER --}}
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">

                <a href="{{ route('inovasi1.index') }}"
                   class="px-5 py-2 rounded-xl border border-gray-300 hover:bg-gray-100">

                    Kembali

                </a>

                <button type="submit"
                        class="px-6 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow">

                    Simpan Data

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function previewFile(inputId, previewId, nameId, sizeId) {

    const input = document.getElementById(inputId);

    if (!input) return;

    input.addEventListener('change', function(e){

        const file = e.target.files[0];

        if(file){

            document.getElementById(previewId).classList.remove('hidden');

            document.getElementById(nameId).innerText = file.name;

            document.getElementById(sizeId).innerText =
                (file.size / 1024 / 1024).toFixed(2) + ' MB';

        }

    });

}

// Manual Book (kalau pakai ini)
previewFile(
    'manualBookInput',
    'manualBookPreview',
    'manualBookName',
    'manualBookSize'
);

// KAK
previewFile(
    'kakInput',
    'kakPreview',
    'kakName',
    'kakSize'
);

previewFile(
    'sopInput',
    'SopPreview',
    'SopName',
    'SopSize'
);

previewFile(
    'makalahInput',
    'makalahPreview',
    'makalahName',
    'makalahSize'
);

previewFile(
    'skInput',
    'skPreview',
    'skName',
    'skSize'
);

previewFile(
    'doklainInput',
    'doklainPreview',
    'doklainName',
    'doklainSize'
);

previewFile(
    'fotoInput',
    'fotoPreview',
    'fotoName',
    'fotoSize'
);

</script>

@endsection