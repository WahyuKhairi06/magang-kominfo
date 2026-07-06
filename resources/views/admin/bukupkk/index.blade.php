@extends('template.layout')
@section('content')

<div class="p-6">

<div class="bg-white rounded-3xl shadow-lg border overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 flex justify-between items-center border-b bg-gradient-to-r from-blue-50 to-white">
        <h2 class="font-bold text-lg text-gray-800">📘 Data Buku PKK</h2>

        <a href="{{ route('bukupkk.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow flex items-center gap-2 transition">
            <span class="material-symbols-outlined text-sm">add</span>
            Tambah
        </a>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm table-auto">

            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr class="text-left">
                    <th class="p-4 w-16 text-center">No</th>
                    <th class="p-4">Desa</th>
                    <th class="p-4">Dusun</th>
                    <th class="p-4">Kecamatan</th>
                    <th class="p-4">Masa Bhakti</th>
                    <th class="p-4 text-center w-72">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @foreach($data as $i => $d)
                <tr class="hover:bg-gray-50 transition">

                    <td class="p-4 text-center font-semibold text-gray-700">
                        {{ $i+1 }}
                    </td>

                    <td class="p-4 font-semibold text-gray-800">
                        {{ $d->nama_desa }}
                    </td>

                    <td class="p-4 text-gray-600">
                        {{ $d->nama_dusun ?? '-' }}
                    </td>

                    <td class="p-4 text-gray-600">
                        {{ $d->nama_kecamatan }}
                    </td>

                    <td class="p-4">
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-600 rounded-full">
                            {{ $d->masa_mulai }} - {{ $d->masa_selesai }}
                        </span>
                    </td>

                    <!-- AKSI -->
                    <td class="p-4">
                        <div class="flex flex-wrap justify-center gap-2">

                            <!-- EDIT -->
                            <a href="{{ route('bukupkk.edit',$d->id) }}"
                                class="px-3 py-1.5 text-xs bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">edit</span>
                                Edit
                            </a>

                            <!-- TAMBAH -->
                            <a href="{{ route('rekapbuku.create',$d->id) }}"
                                class="px-3 py-1.5 text-xs bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">person_add</span>
                                Tambah
                            </a>

                            <!-- LIST -->
                            <a href="{{ route('rekapbuku.index',$d->id) }}"
                                class="px-3 py-1.5 text-xs bg-emerald-100 text-emerald-600 rounded-lg hover:bg-emerald-200 transition flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">list</span>
                                List
                            </a>

                            <!-- PDF -->
                            <a href="{{ route('rekapbuku.cetak',$d->id) }}"
                                class="px-3 py-1.5 text-xs bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                                PDF
                            </a>

                            <!-- HAPUS -->
                            <form action="{{ route('bukupkk.destroy',$d->id) }}" method="POST" class="form-hapus">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1.5 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">delete</span>
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

</div>

<!-- ICON GOOGLE -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Yakin hapus?',
            text: 'Data akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, hapus!'
        }).then((result)=>{
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});
</script>

@endsection