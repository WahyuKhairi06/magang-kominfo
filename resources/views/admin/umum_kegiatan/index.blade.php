@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Data Umum</h1>

        <a href="{{ route('umum.create') }}"
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

                            {{-- DATA UMUM --}}
                            <a href="{{ url('wilayah/'.$d->desa_id) }}"
                               class="flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow text-xs">
                                📊 Data Umum
                            </a>

                            {{-- TAMBAH UMUM --}}
                            <a href="{{ url('wilayah/create/'.$d->desa_id) }}"
                               class="flex items-center gap-1 bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded shadow text-xs">
                                ➕ Tambah
                            </a>

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