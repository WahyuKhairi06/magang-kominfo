@extends('template.layout')

@section('content')
<div class="p-6">

<div class="bg-white rounded-2xl shadow-lg border border-gray-100">

    <!-- HEADER -->
    <div class="p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-3 border-b bg-gradient-to-r from-blue-50 to-white rounded-t-2xl">
        <h3 class="font-bold text-lg text-gray-800">📊 Data POKJA IV</h3>

        <a href="{{ route('dasawisma.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            + Tambah
        </a>
    </div>

    <!-- FILTER -->
    <form method="GET"
          action="{{ url('pokjaiv/rekap') }}"
          class="p-4 grid grid-cols-1 md:grid-cols-5 gap-3 bg-gray-50 border-b">

        <select name="kecamatan_id" class="border rounded-lg p-2 focus:ring focus:ring-blue-200">
            <option value="">Semua Kecamatan</option>
            @foreach($kecamatan as $k)
            <option value="{{ $k->id }}" {{ request('kecamatan_id') == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kecamatan }}
            </option>
            @endforeach
        </select>

        <select name="desa_id" class="border rounded-lg p-2 focus:ring focus:ring-blue-200">
            <option value="">Semua Desa</option>
            @foreach($desa as $d)
            <option value="{{ $d->id }}" {{ request('desa_id') == $d->id ? 'selected' : '' }}>
                {{ $d->nama_desa }}
            </option>
            @endforeach
        </select>

        <select name="dusun_id" class="border rounded-lg p-2 focus:ring focus:ring-blue-200">
            <option value="">Semua Dusun</option>
            @foreach($dusun as $d)
            <option value="{{ $d->id }}" {{ request('dusun_id') == $d->id ? 'selected' : '' }}>
                {{ $d->nama_dusun }}
            </option>
            @endforeach
        </select>

        <select name="tahun" class="border rounded-lg p-2 focus:ring focus:ring-blue-200">
            <option value="">Pilih Tahun</option>
            <option value="2025" {{ request('tahun')=='2025'?'selected':'' }}>2025</option>
            <option value="2026" {{ request('tahun')=='2026'?'selected':'' }}>2026</option>
        </select>

        <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 shadow">
            🔍 Filter
        </button>
    </form>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-left">Nama</th>
                    <th>Dusun</th>
                    <th>Desa</th>
                    <th>Kecamatan</th>
                    <th>Tahun</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $d)
                <tr class="border-t hover:bg-blue-50 transition">

                    <td class="p-3 font-medium text-gray-800">
                        {{ $d->nama_dasawisma }}
                    </td>

                    <td>{{ $d->nama_dusun }}</td>
                    <td>{{ $d->nama_desa }}</td>
                    <td>{{ $d->nama_kecamatan }}</td>

                    <td>
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                            {{ $d->tahun }}
                        </span>
                    </td>

                    <td class="flex flex-wrap justify-center gap-2 py-2">

                        <a href="{{ route('dasawisma.edit',$d->id) }}"
                           class="text-yellow-600 hover:text-yellow-800 text-sm">
                            ✏️ Edit
                        </a>

                        {{-- <a href="{{ route('buku.create',$d->id) }}"
                           class="text-green-600 hover:text-green-800 text-sm">
                            ➕ Buku 1
                        </a>

                        <a href="{{ route('buku.index',$d->id) }}"
                           class="text-green-800 hover:text-green-900 text-sm">
                            📋 List 1
                        </a>

                        <a href="{{ route('buku2.create',$d->id) }}"
                           class="text-purple-600 hover:text-purple-800 text-sm">
                            ➕ Buku 2
                        </a>

                        <a href="{{ route('buku2.index',$d->id) }}"
                           class="text-purple-800 hover:text-purple-900 text-sm">
                            📋 List 2
                        </a>

                        <a href="{{ route('buku3.create',$d->id) }}"
                           class="text-indigo-600 hover:text-indigo-800 text-sm">
                            ➕ Buku 3
                        </a>

                        <a href="{{ route('buku3.index',$d->id) }}"
                           class="text-indigo-800 hover:text-indigo-900 text-sm">
                            📋 List 3
                        </a> --}}

                        <a href="{{ route('dasawisma.kuisioner', [$d->id, $d->tahun]) }}"
                           class="text-blue-600 hover:text-blue-800 text-sm">
                            📝 Kuisioner
                        </a>

                        <form action="{{ route('dasawisma.destroy',$d->id) }}" method="POST" class="form-hapus">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="btn-hapus text-red-600 hover:text-red-800 text-sm">
                                🗑️ Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function () {
        let form = this.closest('form');

        Swal.fire({
            title: 'Yakin hapus data?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

@endsection