@extends('template.layout')
@section('content')
<div class="max-w-5xl w-full mx-auto mt-10 bg-white p-6 rounded-xl shadow">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-700">Data Rumah</h1>
        <a href="{{ route('rumah.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
           + Tambah
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left text-sm font-semibold">No</th>
                    <th class="p-3 text-left text-sm font-semibold">Nama Rumah</th>
                    <th class="p-3 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $i+1 }}</td>
                    <td class="p-3">{{ $d->nama_rumah }}</td>
                    <td class="p-3 text-center space-x-2">

                        <!-- Edit -->
                        <a href="{{ route('rumah.edit', $d->id) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm">
                           Edit
                        </a>

                        <!-- Delete -->
                        <button onclick="confirmDelete({{ $d->id }})"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">
                            Hapus
                        </button>

                        <form id="delete-form-{{ $d->id }}"
                              action="{{ route('rumah.delete', $d->id) }}"
                              method="GET" class="hidden">
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center p-4 text-gray-500">
                        Data kosong
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('sweetalert::alert')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Yakin hapus?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection