{{-- resources/views/admin/inovasipokja1/edit.blade.php --}}

@extends('template.layout')

@section('content')

<div class="max-w-4xl mx-auto p-4">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Edit Inovasi Pokja
        </h1>

    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <form action="{{ route('inovasipokja1.update',$data->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">

                {{-- POKJA --}}
                <!-- <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Pokja ID
                    </label>

                    <input type="number"
                           name="pokja_id"
                           value="{{ old('pokja_id',$data->pokja_id) }}"
                           class="w-full border border-gray-300 rounded-xl p-3">

                </div> -->

                {{-- KETERANGAN --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Keterangan
                    </label>

                    <textarea name="keterangan"
                              rows="5"
                              class="w-full border border-gray-300 rounded-xl p-3">{{ old('keterangan',$data->keterangan) }}</textarea>

                </div>

                {{-- FILE LAMA --}}
                @if($data->file)

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        File Saat Ini
                    </label>

                    <a href="{{ asset('storage/inovasi/'.$data->file) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-xl hover:bg-green-200">

                        📄 Lihat File

                    </a>

                </div>

                @endif

                {{-- FILE BARU --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Upload File Baru
                    </label>

                    <input type="file"
                           name="file"
                           class="w-full border border-gray-300 rounded-xl p-3">

                    <p class="text-sm text-gray-500 mt-2">
                        Kosongkan jika tidak ingin mengganti file.
                    </p>

                </div>

            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">

                <a href="{{ route('inovasipokja1.index') }}"
                   class="px-5 py-2 rounded-xl border border-gray-300">

                    Kembali

                </a>

                <button type="submit"
                        class="px-6 py-2 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-white font-semibold">

                    Update Data

                </button>

            </div>

        </form>

    </div>

</div>

@endsection