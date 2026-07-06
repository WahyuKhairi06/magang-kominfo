@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Data Umum Kegiatan {{ $cek_pokja->nama_pokja }}</h1>

        <a href="{{ route('pokja.create',$id) }}"
           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">
            + Tambah
        </a>
    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow rounded-lg overflow-x-auto">

        <table class="w-full text-sm border-collapse">

            {{-- HEADER TABLE --}}
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-center">No</th>
                    <th class="p-3 text-left">Desa</th>
                    <th class="p-3 text-left">Kecamatan</th>
                    <th class="p-3 text-left">Dusun</th>
                    <th class="p-3 text-center">Tahun</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            {{-- BODY TABLE --}}
            <tbody class="divide-y">

                @foreach($data as $i => $d)
                <tr class="hover:bg-gray-50">

                    <td class="p-3 text-center">{{ $i+1 }}</td>
                    <td class="p-3">{{ $d->nama_desa }}</td>
                    <td class="p-3">{{ $d->nama_kecamatan }}</td>
                    <td class="p-3">{{ $d->nama_dusun }}</td>
                    <td class="p-3 text-center">{{ $d->tahun }}</td>

                    <td class="p-3">
                        <div class="flex flex-wrap justify-center gap-2">

                            {{-- EDIT --}}
                            <a href="{{ route('umum.edit',$d->id) }}"
                               class="flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow text-xs">
                                ✏️ Edit
                            </a>

                            {{-- DELETE --}}
                            <form id="delete{{ $d->id }}"
                                  action="{{ route('umum.delete',$d->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    onclick="hapus({{ $d->id }})"
                                    class="flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow text-xs">
                                    🗑 Hapus
                                </button>

                            </form>

                            {{-- POKJA ACTION --}}
                            @if($cek_pokja->id == 6)

                                <a href="{{ url('kegiatanpokja1/'.$d->id_desa) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs shadow">
                                    📊 Kegiatan
                                </a>

                                <a href="{{ url('kegiatanpokja1/create/'.$d->id_desa) }}"
                                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs shadow">
                                    ➕ Tambah
                                </a>

                                <a href="{{ url('kegiatanpokja1/pdf/'.$d->id_desa) }}"
                                   class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded text-xs shadow">
                                    🖨 Cetak
                                </a>

                            @elseif($cek_pokja->id == 7)

                                <a href="{{ url('kegiatanpokja2/'.$d->id_desa) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs shadow">
                                    📊 Kegiatan
                                </a>

                                <a href="{{ url('kegiatanpokja2/create/'.$d->id_desa) }}"
                                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs shadow">
                                    ➕ Tambah
                                </a>

                                <a href="{{ url('kegiatanpokja2/pdf/'.$d->id_desa) }}"
                                   class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded text-xs shadow">
                                    🖨 Cetak
                                </a>

                            @elseif($cek_pokja->id == 8)

                                <a href="{{ url('kegiatanpokja3real/'.$d->id_desa) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs shadow">
                                    📊 Kegiatan
                                </a>

                                <a href="{{ url('kegiatanpokja3real/create/'.$d->id_desa) }}"
                                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs shadow">
                                    ➕ Tambah
                                </a>

                                <a href="{{ url('kegiatanpokja3real/pdf/'.$d->id_desa) }}"
                                   class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded text-xs shadow">
                                    🖨 Cetak
                                </a>

                            @elseif($cek_pokja->id == 9)

                                <a href="{{ url('kegiatanpokja3/'.$d->id_desa) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs shadow">
                                    📊 Kegiatan
                                </a>

                                <a href="{{ url('kegiatanpokja3/create/'.$d->id_desa) }}"
                                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs shadow">
                                    ➕ Tambah
                                </a>

                                <a href="{{ url('kegiatanpokja3/pdf/'.$d->id_desa) }}"
                                   class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded text-xs shadow">
                                    🖨 Cetak
                                </a>

                            @endif

                        </div>
                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function hapus(id){
    Swal.fire({
        title: 'Yakin hapus?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result)=>{
        if(result.isConfirmed){
            document.getElementById('delete'+id).submit();
        }
    });
}
</script>

@endsection