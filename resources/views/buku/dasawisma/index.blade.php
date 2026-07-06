@extends('template.layout')

@section('content')

{{-- FILTER --}}
<form method="GET" class="mb-4 flex flex-wrap gap-2 items-center">

    <input type="text" name="search"
        value="{{ request('search') }}"
        placeholder="Cari nama..."
        class="border p-2 rounded w-48">

    <select name="rumah_id" class="border p-2 rounded">
        <option value="">Semua Rumah</option>
        @foreach ($data_rumah as $rumah)
            <option value="{{ $rumah->id }}"
                {{ request('rumah_id') == $rumah->id ? 'selected' : '' }}>
                {{ $rumah->nama_rumah }}
            </option>
        @endforeach
    </select>

    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
        Filter
    </button>

</form>

<div class="container mx-auto p-4">

    <div class="flex justify-between mb-4">
        <h1 class="text-xl font-bold">Buku 1 Catatan Anggota Keluarga</h1>

        <div class="flex gap-2">
            <button onclick="openFilter_rumah()"
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                🖨 Cetak PDF Per Rumah
            </button>

            <button onclick="openFilter()"
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                🖨 Cetak PDF
            </button>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">No</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">JK</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Umur</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $i => $d)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $i+1 }}</td>
                    <td class="p-2">{{ $d->nama_anggota_keluarga }}</td>
                    <td class="p-2">{{ $d->jenis_kelamin }}</td>
                    <td class="p-2">{{ $d->status_perkawinan }}</td>
                    <td class="p-2">
                        {{ $d->tgl_lahir ? \Carbon\Carbon::parse($d->tgl_lahir)->age.' th' : '-' }}
                    </td>

                    <td class="p-2 flex gap-2">

                        <button onclick="showDetail({{ $d->id }})"
                            class="bg-green-500 text-white px-2 py-1 rounded">
                            Detail
                        </button>

                        <a href="{{ route('buku.edit',$d->id) }}"
                            class="bg-yellow-500 text-white px-2 py-1 rounded">
                            Edit
                        </a>

                        <form id="delete{{ $d->id }}"
                              action="{{ route('buku.delete',$d->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                onclick="confirmDelete({{ $d->id }})"
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

{{-- MODAL DETAIL --}}
@foreach($data as $d)
<div id="modal{{ $d->id }}"
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

        <h2 class="text-lg font-bold mb-4">Detail Anggota</h2>

        <div class="grid grid-cols-2 gap-3 text-sm">
            <p><b>Nama:</b> {{ $d->nama_anggota_keluarga }}</p>
            <p><b>JK:</b> {{ $d->jenis_kelamin }}</p>
            <p><b>Status:</b> {{ $d->status_perkawinan }}</p>
            <p><b>TTL:</b> {{ $d->tempat_lahir }}, {{ $d->tgl_lahir }}</p>
            <p><b>Agama:</b> {{ $d->agama }}</p>
            <p><b>Pendidikan:</b> {{ $d->pendidikan }}</p>
            <p><b>Pekerjaan:</b> {{ $d->pekerjaan }}</p>
            <p><b>Berkebutuhan:</b> {{ $d->berkebutuhan_khusus ? 'Ya' : 'Tidak' }}</p>
        </div>

        <hr class="my-3">

        <h3 class="font-semibold mb-2">Program PKK</h3>
        <div class="grid grid-cols-3 text-sm gap-2">
            <p>Pancasila: {{ $d->pancasila ? '✔' : '-' }}</p>
            <p>Goro: {{ $d->goro ? '✔' : '-' }}</p>
            <p>Pendidikan: {{ $d->pendidikan_keterampilan ? '✔' : '-' }}</p>
            <p>Koperasi: {{ $d->penghidupan_berkoperasi ? '✔' : '-' }}</p>
            <p>Pangan: {{ $d->pangan ? '✔' : '-' }}</p>
            <p>Sandang: {{ $d->sandang ? '✔' : '-' }}</p>
            <p>Kesehatan: {{ $d->kesehatan ? '✔' : '-' }}</p>
            <p>Perencanaan: {{ $d->perencanaan_sehat ? '✔' : '-' }}</p>
        </div>

        <hr class="my-3">

        <h3 class="font-semibold mb-2">Kondisi Rumah</h3>
        <div class="grid grid-cols-2 gap-2 text-sm">
            <p>Kriteria: {{ $d->kriteria_rumah }}</p>
            <p>Jamban: {{ $d->jamban_keluarga }}</p>
            <p>Sumber Air: {{ $d->sumber_air }}</p>
            <p>Tempat Sampah: {{ $d->tempat_sampah }}</p>
        </div>

        <button onclick="closeModal({{ $d->id }})"
            class="mt-4 bg-gray-500 text-white px-4 py-2 rounded">
            Tutup
        </button>

    </div>
</div>
@endforeach

{{-- MODAL FILTER PDF --}}
<div id="modalFilter"
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-xl w-96">

        <h2 class="text-lg font-bold mb-3">Filter Cetak PDF</h2>

        <form action="{{ route('buku.pdf.all',$data_dasa->id) }}" method="GET">

           <select name="kriteria_rumah" class="border p-2 w-full mb-2">
                <option value="">Kriteria Rumah</option>
                <option value="Layak Huni">Layak Huni</option>
                <option value="Tidak Layak Huni">Tidak Layak Huni</option>
            </select>

            <select name="jamban_keluarga" class="border p-2 w-full mb-2">
                <option value="">Jamban</option>
                <option value="Ada">Ada</option>
                <option value="Tidak Ada">Tidak Ada</option>
            </select>

            <select name="sumber_air" class="border p-2 w-full mb-2">
                <option value="">Sumber Air</option>
                <option value="PDAM">PDAM</option>
                <option value="Sumur">Sumur</option>
                <option value="Lainnya">Lainnya</option>
            </select>

            <select name="tempat_sampah" class="border p-2 w-full mb-3">
                <option value="">Tempat Sampah</option>
                <option value="Ada">Ada</option>
                <option value="Tidak">Tidak</option>
            </select>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeFilter()" class="bg-gray-400 px-3 py-1 rounded">Batal</button>
                <button class="bg-blue-600 text-white px-3 py-1 rounded">Cetak</button>
            </div>

        </form>
    </div>
</div>

{{-- MODAL FILTER RUMAH --}}
<div id="modalFilter_rumah"
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-xl w-96">

        <h2 class="text-lg font-bold mb-3">Filter Cetak PDF Per Rumah</h2>

        <form action="{{ route('buku.cetakPdfrumah.all',$data_dasa->id) }}" method="GET">

            <select name="rumah_id" class="border p-2 w-full mb-3 rounded">
                <option value="">Semua Rumah</option>
                @foreach ($data_rumah as $rumah)
                    <option value="{{ $rumah->id }}">{{ $rumah->nama_rumah }}</option>
                @endforeach
            </select>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeFilter_rumah()" class="bg-gray-400 px-3 py-1 rounded">Batal</button>
                <button class="bg-blue-600 text-white px-3 py-1 rounded">Cetak</button>
            </div>

        </form>
    </div>
</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function openFilter(){
    document.getElementById('modalFilter').classList.remove('hidden');
}

function closeFilter(){
    document.getElementById('modalFilter').classList.add('hidden');
}

function openFilter_rumah(){
    document.getElementById('modalFilter_rumah').classList.remove('hidden');
}

function closeFilter_rumah(){
    document.getElementById('modalFilter_rumah').classList.add('hidden');
}

function confirmDelete(id){
    Swal.fire({
        title: 'Yakin hapus?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if(result.isConfirmed){
            document.getElementById('delete'+id).submit();
        }
    });
}

function showDetail(id){
    const modal = document.getElementById('modal'+id);
    modal.classList.remove('hidden');

    modal.onclick = function(e){
        if(e.target === modal){
            closeModal(id);
        }
    }
}

function closeModal(id){
    document.getElementById('modal'+id).classList.add('hidden');
}

document.addEventListener('keydown', function(e){
    if(e.key === "Escape"){
        document.querySelectorAll('[id^="modal"]').forEach(m=>{
            m.classList.add('hidden');
        });
    }
});

</script>

@endsection