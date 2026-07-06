@extends('template.layout')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Struktur Organisasi
        </h1>

        <a href="{{ route('organisasi.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
            + Tambah Data
        </a>

    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow rounded-xl overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">No</th>
                    <th class="p-3">Foto</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Jabatan</th>
                    <th class="p-3">Urutan</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $i => $d)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3">{{ $i+1 }}</td>

                    <td class="p-3">
                        @if($d->foto)
                            <img src="{{ asset('storage/organisasi/'.$d->foto) }}"
                                 class="w-14 h-14 rounded-full object-cover border">
                        @else
                            <span class="text-gray-400">No Foto</span>
                        @endif
                    </td>

                    <td class="p-3 font-semibold">{{ $d->nama }}</td>

                    <td class="p-3">{{ $d->jabatan }}</td>

                    <td class="p-3">{{ $d->urutan }}</td>

                    <td class="p-3 flex gap-2">

                        <a href="{{ route('organisasi.edit',$d->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <form id="delete{{ $d->id }}"
                              action="{{ route('organisasi.delete',$d->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                    onclick="hapus({{ $d->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="text-center p-6 text-gray-400">
                        Data kosong
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
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete'+id).submit();
        }
    });
}
</script>

@endsection