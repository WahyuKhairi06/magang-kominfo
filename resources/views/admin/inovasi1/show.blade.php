@extends('template.layout')

@section('content')

<div class="max-w-5xl mx-auto p-6">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Detail Inovasi
        </h1>
        <p class="text-gray-500 mt-1">
            Informasi lengkap mengenai data inovasi.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        {{-- Judul Card --}}
        <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">
                {{ $data->judul_inovasi }}
            </h2>
        </div>

        <div class="p-6">

            {{-- Informasi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="text-sm font-semibold text-gray-500">
                        Judul Inovasi
                    </label>
                    <p class="mt-1 text-gray-800">
                        {{ $data->judul_inovasi }}
                    </p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-500">
                        Tahun Inovasi
                    </label>
                    <p class="mt-1 text-gray-800">
                        {{ $data->tahun_inovasi }}
                    </p>
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-gray-500">
                        Deskripsi
                    </label>
                    <p class="mt-1 text-gray-800 whitespace-pre-line">
                        {{ $data->deskripsi_inovasi }}
                    </p>
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-gray-500">
                        Link Video
                    </label>

                    @if($data->linkvideo)
                        <a href="{{ $data->linkvideo }}"
                           target="_blank"
                           class="block mt-2 text-blue-600 hover:text-blue-800 underline break-all">
                            {{ $data->linkvideo }}
                        </a>
                    @else
                        <p class="text-gray-400 mt-2">
                            Tidak ada link video.
                        </p>
                    @endif
                </div>

            </div>

            {{-- Dokumen --}}
            <div class="mt-10">

                <h3 class="text-xl font-semibold text-gray-700 mb-5">
                    Dokumen Pendukung
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Foto --}}
                    <div class="border rounded-xl p-4 flex justify-between items-center">
                        <span class="font-medium text-gray-700">
                            📘 Foto
                        </span>

                        @if($data->foto)
                            <a href="{{ asset('storage/'.$data->foto) }}"
                               target="_blank"
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </div>

                    {{-- Manual Book --}}
                    <div class="border rounded-xl p-4 flex justify-between items-center">
                        <span class="font-medium text-gray-700">
                            📘 Manual Book
                        </span>

                        @if($data->manual_book)
                            <a href="{{ asset('storage/'.$data->manual_book) }}"
                               target="_blank"
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </div>

                    {{-- KAK --}}
                    <div class="border rounded-xl p-4 flex justify-between items-center">
                        <span class="font-medium text-gray-700">
                            📑 KAK
                        </span>

                        @if($data->kak)
                            <a href="{{ asset('storage/'.$data->kak) }}"
                               target="_blank"
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </div>

                    {{-- SOP --}}
                    <div class="border rounded-xl p-4 flex justify-between items-center">
                        <span class="font-medium text-gray-700">
                            📋 SOP
                        </span>

                        @if($data->sop)
                            <a href="{{ asset('storage/'.$data->sop) }}"
                               target="_blank"
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </div>

                    {{-- Makalah --}}
                    <div class="border rounded-xl p-4 flex justify-between items-center">
                        <span class="font-medium text-gray-700">
                            📄 Makalah
                        </span>

                        @if($data->makalah)
                            <a href="{{ asset('storage/'.$data->makalah) }}"
                               target="_blank"
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </div>

                    {{-- SK --}}
                    <div class="border rounded-xl p-4 flex justify-between items-center">
                        <span class="font-medium text-gray-700">
                            🏛 SK / DPA / RKPD
                        </span>

                        @if($data->sk)
                            <a href="{{ asset('storage/'.$data->sk) }}"
                               target="_blank"
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </div>

                    {{-- Dokumen Lain --}}
                    <div class="border rounded-xl p-4 flex justify-between items-center">
                        <span class="font-medium text-gray-700">
                            📁 Dokumen Lain
                        </span>

                        @if($data->dokumen_lain)
                            <a href="{{ asset('storage/'.$data->dokumen_lain) }}"
                               target="_blank"
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </div>

                </div>

            </div>

            {{-- Tombol --}}
            <div class="mt-10 flex justify-end">

                <a href="{{ route('inovasi1.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl shadow">
                    ← Kembali
                </a>

            </div>

        </div>

    </div>

</div>

@endsection