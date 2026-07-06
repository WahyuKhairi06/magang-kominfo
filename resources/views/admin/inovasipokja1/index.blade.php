{{-- resources/views/admin/inovasipokja1/index.blade.php --}}

@extends('template.layout')

@section('content')

<div class="p-4 md:p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Data Inovasi I
            </h1>

            <p class="text-gray-500 mt-1">
                Daftar dokumen dan file inovasi.
            </p>

        </div>

        <div>

            <a href="{{ route('inovasipokja1.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow transition">

                <span class="text-lg">+</span>
                Tambah Data

            </a>

        </div>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        {{-- TABLE RESPONSIVE --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead class="bg-gray-100 border-b">

                    <tr>

                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            No
                        </th>

                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            File
                        </th>

                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            Keterangan
                        </th>

                        <th class="px-4 py-4 text-center text-sm font-bold text-gray-700">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $i => $d)

                    <tr class="border-b hover:bg-gray-50 transition">

                        {{-- NO --}}
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ $i+1 }}
                        </td>

                        {{-- FILE --}}
                        <td class="px-4 py-4">

                            @if($d->file)

                                @php
                                    $ext = strtolower(pathinfo($d->file, PATHINFO_EXTENSION));

                                    $url = asset('storage/'.$d->file);

                                    $imageExt = ['jpg','jpeg','png','webp'];
                                    $docExt   = ['pdf','doc','docx','xls','xlsx','ppt','pptx'];

                                    $badgeColor = match($ext){
                                        'pdf' => 'bg-red-100 text-red-700',
                                        'doc','docx' => 'bg-blue-100 text-blue-700',
                                        'xls','xlsx' => 'bg-green-100 text-green-700',
                                        'ppt','pptx' => 'bg-orange-100 text-orange-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp

                                <div class="space-y-3">

                                    {{-- IMAGE --}}
                                    @if(in_array($ext, $imageExt))

                                        <a href="{{ $url }}"
                                           target="_blank"
                                           class="block group">

                                            <img src="{{ $url }}"
                                                 class="w-24 h-24 object-cover rounded-2xl border shadow-sm
                                                        group-hover:scale-105 transition duration-300">

                                        </a>

                                        <div class="flex items-center gap-2 flex-wrap">

                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 uppercase">
                                                {{ $ext }}
                                            </span>

                                            <a href="{{ $url }}"
                                               target="_blank"
                                               class="text-sm text-blue-600 hover:underline">

                                                👁 Lihat Gambar

                                            </a>

                                        </div>

                                    {{-- DOCUMENT --}}
                                    @elseif(in_array($ext, $docExt))

                                        <div class="flex flex-col gap-3">

                                            <div class="flex items-center gap-3">

                                                <div class="w-14 h-14 rounded-2xl bg-gray-100 flex items-center justify-center text-2xl shadow-sm">
                                                    📄
                                                </div>

                                                <div>

                                                    <div class="font-semibold text-gray-700 uppercase text-sm">
                                                        {{ $ext }}
                                                    </div>

                                                    <div class="text-xs text-gray-400">
                                                        Dokumen File
                                                    </div>

                                                </div>

                                            </div>

                                            <a href="{{ $url }}"
                                               target="_blank"
                                               class="inline-flex items-center justify-center gap-2
                                                      bg-blue-600 hover:bg-blue-700
                                                      text-white px-4 py-2 rounded-xl
                                                      text-sm font-medium shadow transition">

                                                👁 Lihat Dokumen

                                            </a>

                                        </div>

                                    {{-- FILE LAIN --}}
                                    @else

                                        <div class="space-y-2">

                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                                {{ $ext }}
                                            </span>

                                            <div>

                                                <a href="{{ $url }}"
                                                   target="_blank"
                                                   class="inline-flex items-center gap-2
                                                          bg-gray-700 hover:bg-gray-800
                                                          text-white px-4 py-2 rounded-xl text-sm shadow">

                                                    📁 Buka File

                                                </a>

                                            </div>

                                        </div>

                                    @endif

                                </div>

                            @else

                                <span class="text-gray-400 italic">
                                    Tidak ada file
                                </span>

                            @endif

                        </td>

                        {{-- KETERANGAN --}}
                        <td class="px-4 py-4 text-sm text-gray-700">

                            <div class="max-w-xs whitespace-pre-line">
                                {{ $d->keterangan ?? '-' }}
                            </div>

                        </td>

                        {{-- AKSI --}}
                        <td class="px-4 py-4">

                            <div class="flex items-center justify-center gap-2">

                                {{-- EDIT --}}
                                <a href="{{ route('inovasipokja1.edit',$d->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-xl text-sm shadow">

                                    Edit

                                </a>

                                {{-- DELETE --}}
                                <form id="delete{{ $d->id }}"
                                      action="{{ route('inovasipokja1.delete',$d->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            onclick="hapus({{ $d->id }})"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm shadow">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4"
                            class="text-center py-10 text-gray-500">

                            Belum ada data inovasi.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function hapus(id){

    Swal.fire({

        title: 'Yakin hapus data?',
        text: "File juga akan ikut terhapus!",
        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',

        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'

    }).then((result) => {

        if(result.isConfirmed){

            document.getElementById('delete'+id).submit();

        }

    });

}

</script>

@endsection