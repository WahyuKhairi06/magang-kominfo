@extends('template.layout')

@section('content')

<div class="p-4 md:p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Data Pengaduan
            </h1>

            <p class="text-gray-500 mt-1">
                Daftar semua pengaduan dari pengguna.
            </p>
        </div>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead class="bg-gray-100 border-b">

                    <tr>

                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            No
                        </th>

                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            Nama
                        </th>

                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            No HP
                        </th>

                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            Isi Pengaduan
                        </th>

                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            Tanggal
                        </th>

                        <th class="px-4 py-4 text-center text-sm font-bold text-gray-700">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $i => $item)

                        <tr class="border-b hover:bg-gray-50 transition">

                            {{-- NO --}}
                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ $i + 1 }}
                            </td>

                            {{-- NAMA --}}
                            <td class="px-4 py-4 text-sm font-semibold text-gray-800">
                                {{ $item->nama }}
                            </td>

                            {{-- NO HP --}}
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $item->no_hp }}
                            </td>

                            {{-- ISI --}}
                            <td class="px-4 py-4 text-sm text-gray-600 max-w-md">
                                <div class="line-clamp-2">
                                    {{ $item->isi_pengaduan }}
                                </div>
                            </td>

                            {{-- TANGGAL --}}
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $item->created_at }}
                            </td>

                            {{-- AKSI --}}
                            <td class="px-4 py-4 text-center">

                                <form id="delete{{ $item->id }}"
                                      action="{{ route('pengaduan.delete', $item->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            onclick="hapus({{ $item->id }})"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm shadow">

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                Belum ada data pengaduan.
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

        title: 'Yakin hapus pengaduan?',
        text: "Data tidak bisa dikembalikan!",
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