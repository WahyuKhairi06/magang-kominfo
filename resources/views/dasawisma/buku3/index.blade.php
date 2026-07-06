@extends('template.layout')

@section('content')

<div class="container mx-auto p-4">

    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-6">

        <h1 class="text-xl font-bold leading-snug">
            Tambah Data Buku 3 Ibu Hamil, Melahirkan, Nifas <br>
            Ibu Meninggal, Kelahiran Bayi, Bayi Meninggal, dan Kematian Balita
        </h1>

        {{-- <div class="flex gap-2">

            <a href="{{ route('buku3.pdf',$id) }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded">
                Cetak PDF
            </a>

        </div> --}}
    </div>

    {{-- FILTER DATA --}}
    <div class="flex flex-wrap gap-4 mb-4">

        <form method="GET" action="{{ route('buku3.index',$id) }}"
              class="flex gap-2 items-center">

            <select name="bulan_id" class="border p-2 rounded">
                <option value="">-- Semua Bulan --</option>
                @foreach($bulans as $b)
                    <option value="{{ $b->id }}"
                        {{ request('bulan_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->nama_bulan }}
                    </option>
                @endforeach
            </select>

            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Filter
            </button>

        </form>

        {{-- CETAK PDF PER BULAN --}}
        <form method="GET" action="{{ route('buku3.pdfbulan',$id) }}"
              class="flex gap-2 items-center">

            <select name="bulan_id" class="border p-2 rounded">
                <option value="">-- Semua Bulan --</option>
                @foreach($bulans as $b)
                    <option value="{{ $b->id }}"
                        {{ request('bulan_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->nama_bulan }}
                    </option>
                @endforeach
            </select>

            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                Cetak
            </button>

        </form>

    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow rounded-lg overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">No</th>
                    <th class="p-2">Nama Ibu</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Bayi</th>
                    <th class="p-2">Meninggal</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $i => $d)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-2">{{ $i+1 }}</td>
                    <td class="p-2">{{ $d->nama_ibu }}</td>
                    <td class="p-2">{{ $d->status }}</td>
                    <td class="p-2">{{ $d->nama_bayi ?? '-' }}</td>
                    <td class="p-2">{{ $d->nama_meninggal ?? '-' }}</td>

                    <td class="p-2 flex gap-2">

                        <a href="{{ route('buku3.edit',$d->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">
                            Edit
                        </a>

                        <form id="delete{{ $d->id }}"
                              action="{{ route('buku3.delete',$d->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                onclick="hapus({{ $d->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">
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
    }).then((res)=>{
        if(res.isConfirmed){
            document.getElementById('delete'+id).submit();
        }
    });
}
</script>

@endsection