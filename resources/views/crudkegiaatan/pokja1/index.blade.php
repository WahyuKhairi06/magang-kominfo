@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

    <div class="flex justify-between mb-4">
        <h1 class="text-xl font-bold">Data Kegiatan Pokja 1</h1>

        <a href="{{ route('kegiatanpokja1.create',$id) }}"
           class="bg-green-500 text-white px-4 py-2 rounded">
            + Tambah
        </a>
    </div>

    <div class="bg-white shadow rounded overflow-x-auto">

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">No</th>
                    <th class="p-2">Wilayah</th>
                    <th class="p-2">PKBN</th>
                    <th class="p-2">PKDRT</th>
                    <th class="p-2">Pola Asuh</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $i => $d)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $i+1 }}</td>
                    <td class="p-2">{{ $d->nama_dusun }}</td>
                    <td class="p-2">{{ $d->kader_pkbn }}</td>
                    <td class="p-2">{{ $d->kader_pkdrt }}</td>
                    <td class="p-2">{{ $d->kader_pola_asuh }}</td>

                    <td class="p-2 flex gap-2">

                        <a href="{{ route('kegiatanpokja1.edit',$d->id) }}"
                           class="bg-yellow-500 text-white px-2 py-1 rounded">
                            Edit
                        </a>

                        <form id="delete{{ $d->id }}"
                              action="{{ route('kegiatanpokja1.delete',$d->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                onclick="hapus({{ $d->id }})"
                                class="bg-red-500 text-white px-2 py-1 rounded">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function hapus(id){
    Swal.fire({
        title: 'Hapus data?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya hapus',
        cancelButtonText: 'Batal'
    }).then((res)=>{
        if(res.isConfirmed){
            document.getElementById('delete'+id).submit();
        }
    });
}
</script>

@endsection