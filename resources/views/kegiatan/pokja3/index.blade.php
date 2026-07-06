@extends('template.layout')

@section('content')

<div class="p-6">

    <div class="flex justify-between mb-4 items-center">
        <h2 class="text-2xl font-bold">Data Kegiatan Pokja IV</h2>

        <a href="{{ url('kegiatanpokja3/create/'.$id_dusun) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Tambah
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">No</th>
                    <th class="p-2">Dusun</th>
                    <th class="p-2">Posyandu</th>
                    <th class="p-2">Lansia</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $i => $d)
                <tr class="hover:bg-gray-50">
                    <td class="p-2">{{ $i+1 }}</td>
                    <td class="p-2">{{ $d->nama_dusun }}</td>
                    <td class="p-2">{{ $d->posyandu_jumlah }}</td>
                    <td class="p-2">{{ $d->lansia_jumlah_anggota }}</td>

                    <td class="p-2 space-x-2">
                        <button onclick="toggleDetail({{ $d->id }})"
                            class="text-green-600">Detail</button>

                        <a href="{{ url('kegiatanpokja3/edit/'.$d->id) }}"
                           class="text-blue-600">Edit</a>

                        <button onclick="hapus({{ $d->id }})"
                            class="text-red-600">Hapus</button>
                    </td>
                </tr>

                <!-- DETAIL -->
                <tr id="detail-{{ $d->id }}" class="hidden bg-gray-50">
                    <td colspan="5" class="p-4">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm">

                            <div><b>Kader Posyandu:</b> {{ $d->kader_posyandu }}</div>
                            <div><b>Kader Gizi:</b> {{ $d->kader_gizi }}</div>
                            <div><b>Kader Kesling:</b> {{ $d->kader_kesling }}</div>
                            <div><b>Kader Narkoba:</b> {{ $d->kader_penyuluhan_narkoba }}</div>
                            <div><b>Kader PHBS:</b> {{ $d->kader_phbs }}</div>
                            <div><b>Kader KB:</b> {{ $d->kader_kb }}</div>

                            <div><b>Posyandu Terintegrasi:</b> {{ $d->posyandu_terintegrasi }}</div>

                            <div><b>Lansia Kelompok:</b> {{ $d->lansia_jumlah_kelompok }}</div>
                            <div><b>Kartu Obat:</b> {{ $d->lansia_memiliki_kartu_obat_gratis }}</div>

                            <div><b>Jamban:</b> {{ $d->rumah_memiliki_jamban }}</div>
                            <div><b>SPAL:</b> {{ $d->rumah_memiliki_spal }}</div>
                            <div><b>Sampah:</b> {{ $d->rumah_memiliki_tempat_sampah }}</div>

                            <div><b>MCK:</b> {{ $d->jumlah_mck }}</div>

                            <div><b>Air PDAM:</b> {{ $d->air_pdam }}</div>
                            <div><b>Air Sumur:</b> {{ $d->air_sumur }}</div>
                            <div><b>Air Lain:</b> {{ $d->air_lainnya }}</div>

                            <div><b>PUS:</b> {{ $d->jumlah_pus }}</div>
                            <div><b>WUS:</b> {{ $d->jumlah_wus }}</div>

                            <div><b>KB L:</b> {{ $d->akseptor_kb_l }}</div>
                            <div><b>KB P:</b> {{ $d->akseptor_kb_p }}</div>

                            <div><b>Tabungan:</b> {{ $d->kk_memiliki_tabungan_keluarga }}</div>

                            <div class="col-span-2"><b>Keterangan:</b> {{ $d->ket }}</div>

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
    let el = document.getElementById('detail-'+id);
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
            window.location.href = "/kegiatanpokja3/delete/" + id;
        }
    })
}
</script>

@endsection