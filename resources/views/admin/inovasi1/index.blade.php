{{-- resources/views/admin/inovasi1/index.blade.php --}}

@extends('template.layout')

@section('content')

<div class="p-4 md:p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Data Inovasi
            </h1>

            <p class="text-gray-500 mt-1">
                Daftar dokumen dan file inovasi.
            </p>

        </div>

        <div>

            <a href="{{ route('inovasi1.create') }}"
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
                            Judul Inovasi
                        </th>

                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            Deskripsi Inovasi
                        </th>

                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            Tahun Inovasi
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

                        

                        {{-- JUDUL --}}
                        <td class="px-4 py-4 text-sm text-gray-700">

                            <div class="max-w-xs whitespace-pre-line">
                                {{$d->judul_inovasi}}
                            </div>

                        </td>

                        {{-- DESKRIPSI --}}
                        <td class="px-4 py-4 text-sm text-gray-700">

                            <div class="max-w-xs whitespace-pre-line">
                                {{$d->deskripsi_inovasi}}
                            </div>

                        </td>
                        
                        {{-- TAHUN --}}
                        <td class="px-4 py-4 text-sm text-gray-700">

                            <div class="max-w-xs whitespace-pre-line">
                                {{$d->tahun_inovasi}}
                            </div>

                        </td>

                        {{-- AKSI --}}
                        <td class="px-4 py-4">

                            <div class="flex items-center justify-center gap-2">
                        
                                {{-- VIEW --}}
                                <a href="{{ route('inovasi1.show', $d->id_inovasi) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm shadow">

                                    Lihat

                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('inovasi1.edit',$d->id_inovasi) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-xl text-sm shadow">

                                    Edit

                                </a>

                                {{-- DELETE --}}
                                <form id="delete{{ $d->id_inovasi }}"
                                      action="{{ route('inovasi1.delete',$d->id_inovasi) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            onclick="hapus({{ $d->id_inovasi}})"
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