@extends('template.layout')

@section('content')

<div class="p-6">

    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold">Data Kegiatan Pokja III</h2>

        <a href="{{ url('kegiatanpokja3real/create/'.$id_dusun) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Tambah
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">No</th>
                    <th class="p-2">Dusun</th>
                    <th class="p-2">Kader Pangan</th>
                    <th class="p-2">Beras</th>
                    <th class="p-2">Industri</th>
                    <th class="p-2">Rumah Sehat</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $i => $d)
                <!-- ROW UTAMA -->
                <tr class="hover:bg-gray-50">
                    <td class="p-2">{{ $i+1 }}</td>
                    <td class="p-2">{{ $d->nama_dusun }}</td>
                    <td class="p-2">{{ $d->kader_pangan }}</td>
                    <td class="p-2">{{ $d->pangan_beras }}</td>
                    <td class="p-2">{{ $d->industri_pangan }}</td>
                    <td class="p-2">{{ $d->rumah_sehat_layak }}</td>

                    <td class="p-2 space-x-2">
                        <button onclick="toggleDetail({{ $d->id }})"
                            class="text-green-600 font-semibold">
                            Detail
                        </button>

                        <a href="{{ url('kegiatanpokja3real/edit/'.$d->id) }}"
                           class="text-blue-600">Edit</a>

                        <button onclick="hapus({{ $d->id }})"
                            class="text-red-600">Hapus</button>
                    </td>
                </tr>

                <!-- DETAIL (HIDDEN) -->
                <tr id="detail-{{ $d->id }}" class="hidden bg-gray-50">
                    <td colspan="7" class="p-4">

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm">

                            <!-- KADER -->
                            <div><b>Kader Pangan:</b> {{ $d->kader_pangan }}</div>
                            <div><b>Kader Sandang:</b> {{ $d->kader_sandang }}</div>
                            <div><b>Kader Tata Laksana:</b> {{ $d->kader_tata_laksana_rumah_tangga }}</div>

                            <!-- PANGAN -->
                            <div><b>Beras:</b> {{ $d->pangan_beras }}</div>
                            <div><b>Non Beras:</b> {{ $d->pangan_non_beras }}</div>

                            <!-- PEKARANGAN -->
                            <div><b>Peternakan:</b> {{ $d->peternakan }}</div>
                            <div><b>Perikanan:</b> {{ $d->perikanan }}</div>
                            <div><b>Warung Hidup:</b> {{ $d->warung_hidup }}</div>
                            <div><b>Lumbung Hidup:</b> {{ $d->lumbung_hidup }}</div>
                            <div><b>TOGA:</b> {{ $d->toga }}</div>

                            <!-- INDUSTRI -->
                            <div><b>Industri Pangan:</b> {{ $d->industri_pangan }}</div>
                            <div><b>Industri Sandang:</b> {{ $d->industri_sandang }}</div>
                            <div><b>Industri Jasa:</b> {{ $d->industri_jasa }}</div>

                            <!-- RUMAH -->
                            <div><b>Rumah Sehat:</b> {{ $d->rumah_sehat_layak }}</div>
                            <div><b>Rumah Tidak Layak:</b> {{ $d->rumah_tidak_sehat_tidak_layak }}</div>

                            <!-- KETERANGAN -->
                            <div class="col-span-2">
                                <b>Keterangan:</b> {{ $d->keterangan }}
                            </div>

                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function toggleDetail(id){
    let el = document.getElementById('detail-' + id);
    el.classList.toggle('hidden');
}

function hapus(id){
    Swal.fire({
        title: 'Yakin hapus?',
        text: 'Data tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!'
    }).then((result)=>{
        if(result.isConfirmed){
            window.location.href = "/kegiatanpokja3real/delete/" + id;
        }
    })
}
</script>

@endsection