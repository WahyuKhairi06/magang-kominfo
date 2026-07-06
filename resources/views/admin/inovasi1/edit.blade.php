{{-- resources/views/admin/inovasipokja1/edit.blade.php --}}

@extends('template.layout')

@section('content')

<div class="max-w-4xl mx-auto p-4">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Edit Inovasi
        </h1>

    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <form action="{{ route('inovasi1.update',$data->id_inovasi) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">

                {{-- JUDUL --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Judul Inovasi
                    </label>

                    <textarea name="judul"
                              rows="5"
                              class="w-full border border-gray-300 rounded-xl p-3">{{ old('judul',$data->judul_inovasi) }}</textarea>

                </div>
                

                {{-- DESKRIPSI --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Deskripsi
                    </label>

                    <textarea name="deskripsi"
                              rows="5"
                              class="w-full border border-gray-300 rounded-xl p-3">{{ old('deskripsi',$data->deskripsi_inovasi) }}</textarea>

                </div>

                {{-- TAHUN --}}
<div>

    <label class="block mb-2 font-semibold text-gray-700">
        Tahun Inovasi
    </label>

    <select name="tahun"
            class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

        <option value="">-- Pilih Tahun --</option>

        @for($i = date('Y'); $i >= 2000; $i--)
            <option value="{{ $i }}"
                {{ old('tahun', $data->tahun_inovasi) == $i ? 'selected' : '' }}>
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

                {{-- FILE LAMA FOTO --}}
                @if($data->foto)

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        File Foto Dokumentasi Saat Ini
                    </label>

                    <a href="{{ asset('storage/'.$data->foto) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-xl hover:bg-green-200">

                        📄 Lihat File

                    </a>

                </div>

                @endif

                {{-- FILE BARU --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Upload Foto Dokumentasi Baru
                    </label>

                    <input type="file"
                           name="foto_inovasi"
                           class="w-full border border-gray-300 rounded-xl p-3">

                    <p class="text-sm text-gray-500 mt-2">
                        Kosongkan jika tidak ingin mengganti file.
                    </p>

                </div>

                {{-- FILE LAMA MANUAL BOOK --}}
                @if($data->manual_book)

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        File Manual Book Saat Ini
                    </label>

                    <a href="{{ asset('storage/'.$data->manual_book) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-xl hover:bg-green-200">

                        📄 Lihat File

                    </a>

                </div>

                @endif

                {{-- FILE BARU --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Upload Manual Book Baru
                    </label>

                    <input type="file"
                           name="manual_book"
                           class="w-full border border-gray-300 rounded-xl p-3">

                    <p class="text-sm text-gray-500 mt-2">
                        Kosongkan jika tidak ingin mengganti file.
                    </p>

                </div>

                {{-- FILE LAMA KAK --}}
                @if($data->kak)

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        File KAK Saat Ini
                    </label>

                    <a href="{{ asset('storage/'.$data->kak) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-xl hover:bg-green-200">

                        📄 Lihat File

                    </a>

                </div>

                @endif

                {{-- FILE BARU --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Upload KAK Baru
                    </label>

                    <input type="file"
                           name="kak"
                           class="w-full border border-gray-300 rounded-xl p-3">

                    <p class="text-sm text-gray-500 mt-2">
                        Kosongkan jika tidak ingin mengganti file.
                    </p>

                </div>
                {{-- FILE LAMA SOP --}}
                @if($data->sop)

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        File SOP Saat Ini
                    </label>

                    <a href="{{ asset('storage/'.$data->sop) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-xl hover:bg-green-200">

                        📄 Lihat File

                    </a>

                </div>

                @endif

                {{-- FILE BARU --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Upload SOP Baru
                    </label>

                    <input type="file"
                           name="sop"
                           class="w-full border border-gray-300 rounded-xl p-3">

                    <p class="text-sm text-gray-500 mt-2">
                        Kosongkan jika tidak ingin mengganti file.
                    </p>

                </div>
                {{-- FILE LAMA MAKALAH --}}
                @if($data->makalah)

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        File Makalah Saat Ini
                    </label>

                    <a href="{{ asset('storage/'.$data->makalah) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-xl hover:bg-green-200">

                        📄 Lihat File

                    </a>

                </div>

                @endif

                {{-- FILE BARU --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Upload Makalah Baru
                    </label>

                    <input type="file"
                           name="makalah"
                           class="w-full border border-gray-300 rounded-xl p-3">

                    <p class="text-sm text-gray-500 mt-2">
                        Kosongkan jika tidak ingin mengganti file.
                    </p>

                </div>
                {{-- LINK VIDEO --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Link Video
                    </label>

                    <textarea name="link"
                              rows="5"
                              class="w-full border border-gray-300 rounded-xl p-3">{{ old('link',$data->linkvideo) }}</textarea>

                </div>
                {{-- FILE LAMA SK --}}
                @if($data->sk)

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        File SK/DPA/RKPD Saat Ini
                    </label>

                    <a href="{{ asset('storage/'.$data->sk) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-xl hover:bg-green-200">

                        📄 Lihat File

                    </a>

                </div>

                @endif

                {{-- FILE BARU --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Upload SK/DPA/RKPD Baru
                    </label>

                    <input type="file"
                           name="skdpa"
                           class="w-full border border-gray-300 rounded-xl p-3">

                    <p class="text-sm text-gray-500 mt-2">
                        Kosongkan jika tidak ingin mengganti file.
                    </p>

                </div>
                {{-- FILE LAMA DOKUMEN LAIN --}}
                @if($data->dokumen_lain)

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        File Dokumen Lain Saat Ini
                    </label>

                    <a href="{{ asset('storage/'.$data->dokumen_lain) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-xl hover:bg-green-200">

                        📄 Lihat File

                    </a>

                </div>

                @endif

                {{-- FILE BARU --}}
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Upload Dokumen Lain Baru
                    </label>

                    <input type="file"
                           name="doklain"
                           class="w-full border border-gray-300 rounded-xl p-3">

                    <p class="text-sm text-gray-500 mt-2">
                        Kosongkan jika tidak ingin mengganti file.
                    </p>

                </div>

            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">

                <a href="{{ route('inovasi1.index') }}"
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