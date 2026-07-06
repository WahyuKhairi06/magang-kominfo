@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Data Wilayah PKK</h1>

        <a href="{{ route('wilayah.pdf',$id) }}"
           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            Cetak PDF
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">No</th>
                    <th class="p-2">Dusun</th>
                    <th class="p-2">RW</th>
                    <th class="p-2">RT</th>
                    <th class="p-2">Dasawisma</th>
                    <th class="p-2">KK</th>
                    <th class="p-2">Jiwa (L/P)</th>
                    <th class="p-2">Kader TP</th>
                    <th class="p-2">Kader Umum</th>
                    <th class="p-2">Kader Khusus</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $i => $d)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-2">{{ $i+1 }}</td>
                    <td class="p-2">{{ $d->nama_dusun }}</td>

                    <td class="p-2 text-center">{{ $d->pkk_rw }}</td>
                    <td class="p-2 text-center">{{ $d->pkk_rt }}</td>
                    <td class="p-2 text-center">{{ $d->dasawisma }}</td>
                    <td class="p-2 text-center">{{ $d->kk }}</td>

                    <td class="p-2 text-center">
                        {{ $d->jiwa_l }} / {{ $d->jiwa_p }}
                    </td>

                    <td class="p-2 text-center">
                        {{ $d->kader_tp_l }} / {{ $d->kader_tp_p }}
                    </td>

                    <td class="p-2 text-center">
                        {{ $d->kader_umum_l }} / {{ $d->kader_umum_p }}
                    </td>

                    <td class="p-2 text-center">
                        {{ $d->kader_khusus_l }} / {{ $d->kader_khusus_p }}
                    </td>

                    <td class="p-2">
                        <div class="flex gap-2 justify-center">

                            <a href="{{ route('wilayah.edit',$d->id) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Edit
                            </a>

                            <form id="delete{{ $d->id }}"
                                  action="{{ route('wilayah.delete',$d->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    onclick="hapus({{ $d->id }})"
                                    class="bg-red-500 text-white px-3 py-1 rounded">
                                    Hapus
                                </button>
                            </form>

                        </div>
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