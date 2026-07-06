@extends('template.layout')

@section('content')

<div class="p-6">

    <div class="flex justify-between mb-4 items-center">
        <h2 class="text-2xl font-bold text-gray-800">Data Kegiatan Pokja 2</h2>

        <a href="{{ url('kegiatanpokja2/create/'.$id_dusun) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Tambah
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left border border-gray-200">

            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 border">No</th>
                    <th class="px-4 py-3 border">Dusun</th>
                    <th class="px-4 py-3 border">Buta Huruf</th>
                    <th class="px-4 py-3 border">Paket A</th>
                    <th class="px-4 py-3 border">Paket B</th>
                    <th class="px-4 py-3 border">Paket C</th>
                    <th class="px-4 py-3 border">KF</th>
                    <th class="px-4 py-3 border">PAUD</th>
                    <th class="px-4 py-3 border">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @foreach($data as $i => $d)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2 border">{{ $i+1 }}</td>
                    <td class="px-4 py-2 border font-medium text-gray-700">{{ $d->nama_dusun }}</td>
                    <td class="px-4 py-2 border">{{ $d->jumlah_warga_masih_buta }}</td>
                    <td class="px-4 py-2 border">{{ $d->paket_a_kelompok }}</td>
                    <td class="px-4 py-2 border">{{ $d->paket_b_kelompok }}</td>
                    <td class="px-4 py-2 border">{{ $d->paket_c_kelompok }}</td>
                    <td class="px-4 py-2 border">{{ $d->kf_kelompok }}</td>
                    <td class="px-4 py-2 border">{{ $d->paud_sejenis }}</td>

                    <td class="px-4 py-2 border">
                        <a href="{{ url('kegiatanpokja2/edit/'.$d->id) }}"
                           class="text-blue-600 hover:underline font-medium">
                            Edit
                        </a>

                        <button onclick="hapus({{ $d->id }})"
                            class="text-red-600 hover:underline ml-2 font-medium">
                            Hapus
                        </button>
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
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if(result.isConfirmed){
            window.location.href = "/kegiatanpokja2/delete/" + id;
        }
    })
}
</script>

@endsection