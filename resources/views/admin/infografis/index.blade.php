@extends('template.layout')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Infografis</h1>
            <p class="text-gray-500 text-sm">Kelola data infografis dan dokumentasi</p>
        </div>

        <a href="{{ route('infografis.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            + Tambah Data
        </a>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Foto</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Keterangan</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $i => $d)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3">{{ $i+1 }}</td>

                    {{-- FOTO --}}
                    <td class="p-3">

                        @if($d->foto)

                            <a href="{{ asset('storage/infografis/'.$d->foto) }}" target="_blank">
                                <img src="{{ asset('storage/infografis/'.$d->foto) }}"
                                     class="w-16 h-16 object-cover rounded-lg border">
                            </a>

                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif

                    </td>

                    {{-- NAMA --}}
                    <td class="p-3 font-semibold text-gray-800">
                        {{ $d->nama }}
                    </td>

                    {{-- KETERANGAN --}}
                    <td class="p-3 text-gray-600">
                        {{ $d->keterangan ?? '-' }}
                    </td>

                    {{-- AKSI --}}
                    <td class="p-3 text-center">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('infografis.edit',$d->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                Edit
                            </a>

                            <form id="delete{{ $d->id }}"
                                  action="{{ route('infografis.delete',$d->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        onclick="hapus({{ $d->id }})"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                    Hapus
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center p-6 text-gray-500">
                        Data belum tersedia
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function hapus(id){
    Swal.fire({
        title: 'Yakin hapus data?',
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