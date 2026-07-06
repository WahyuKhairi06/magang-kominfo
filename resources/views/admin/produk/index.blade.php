@extends('template.layout')
@section('content')

<div class="p-6">

    <div class="flex justify-between mb-6 items-center">
        <h2 class="text-xl font-bold">Produk</h2>

        <a href="{{ route('produk.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
            + Tambah
        </a>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-lg border overflow-x-auto">

        <table class="w-full text-sm text-gray-700">

            <!-- HEADER -->
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="p-3 text-left">Foto</th>
                    <th class="p-3 text-left">Nama Produk</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Harga</th>
                    <th class="p-3">Stok</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <!-- BODY -->
            <tbody>
                @foreach($data as $d)
                <tr class="border-t hover:bg-gray-50 transition">

                    <!-- FOTO -->
                    <td class="p-3">
                        <img src="{{ $d->foto ? asset('storage/'.$d->foto) : 'https://via.placeholder.com/100' }}"
                             class="w-16 h-16 object-cover rounded-lg">
                    </td>

                    <!-- NAMA -->
                    <td class="p-3 font-semibold text-gray-800">
                        {{ $d->nama_produk }}
                    </td>

                    <!-- KATEGORI -->
                    <td class="p-3 text-center">
                        <span class="bg-gray-100 px-2 py-1 rounded text-xs">
                            {{ $d->kategori }}
                        </span>
                    </td>

                    <!-- HARGA -->
                    <td class="p-3 text-center text-blue-600 font-bold">
                        Rp {{ number_format($d->harga) }}
                    </td>

                    <!-- STOK -->
                    <td class="p-3 text-center">
                        <span class="px-2 py-1 rounded text-xs
                            {{ $d->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $d->stok }}
                        </span>
                    </td>

                    <!-- AKSI -->
                    <td class="p-3">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('produk.edit', $d->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-xs shadow">
                                Edit
                            </a>

                            <form action="{{ route('produk.delete', $d->id) }}" method="POST" class="form-hapus">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs shadow">
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

<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus?',
            text: 'Data akan dihapus',
            icon: 'warning',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>

@endsection