{{-- resources/views/admin/inovasipokja3/create.blade.php --}}

@extends('template.layout')

@section('content')

<div class="max-w-4xl mx-auto p-4">

    {{-- HEADER --}}
    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Tambah Inovasi Pokja
        </h1>

        <p class="text-gray-500 mt-1">
            Upload dokumen atau gambar inovasi kegiatan pokja.
        </p>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <form action="{{ route('inovasipokja3.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="p-6 space-y-6">

                {{-- POKJA --}}
                <div>

                  

                {{-- KETERANGAN --}}
                <div>

                    <label class="block w-full mb-2 font-semibold text-gray-700">
                        Keterangan
                    </label>

                    <textarea name="keterangan"
                              rows="5"
                              placeholder="Masukkan keterangan inovasi..."
                              class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('keterangan') }}</textarea>

                    @error('keterangan')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- UPLOAD FILE --}}
                <div>

                    <label class="block mb-3 font-semibold text-gray-700">
                        Upload File
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
                                   name="file"
                                   id="fileInput"
                                   class="hidden">

                            <button type="button"
                                    onclick="document.getElementById('fileInput').click()"
                                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition">

                                Pilih File

                            </button>

                            {{-- PREVIEW --}}
                            <div id="previewArea"
                                 class="mt-5 hidden w-full">

                                <div class="bg-white border rounded-xl p-4 flex items-center gap-4 shadow-sm">

                                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">

                                        📄

                                    </div>

                                    <div class="flex-1 text-left">

                                        <p id="fileName"
                                           class="font-semibold text-gray-700"></p>

                                        <p id="fileSize"
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

                <a href="{{ route('inovasipokja3.index') }}"
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

{{-- PREVIEW FILE --}}
<script>

document.getElementById('fileInput').addEventListener('change', function(e){

    const file = e.target.files[0];

    if(file){

        document.getElementById('previewArea').classList.remove('hidden');

        document.getElementById('fileName').innerText = file.name;

        document.getElementById('fileSize').innerText =
            (file.size / 1024 / 1024).toFixed(2) + ' MB';

    }

});

</script>

@endsection