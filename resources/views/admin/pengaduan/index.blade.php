@extends('template.layout')

@section('content')

<div class="p-4 md:p-6">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Data Pengaduan
            </h1>
            <p class="text-gray-500 mt-1">
                Daftar semua pengaduan dari masyarakat beserta hasil triage AI.
            </p>
        </div>

        {{-- TOMBOL CETAK PDF --}}
        <div>
            <a href="{{ route('admin.pengaduan.cetak-pdf', request()->query()) }}" 
               target="_blank"
               class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2.5 rounded-xl text-sm shadow transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak PDF (Rentang Tanggal)
            </a>
        </div>
    </div>

    {{-- FILTER & BARIS PER HALAMAN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('pengaduan.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
            
            {{-- TANGGAL MULAI --}}
            <div class="lg:col-span-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Mulai</label>
                <input type="date" 
                       name="start_date" 
                       value="{{ request('start_date') }}"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#2D6A4F]">
            </div>

            {{-- TANGGAL AKHIR --}}
            <div class="lg:col-span-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Sampai</label>
                <input type="date" 
                       name="end_date" 
                       value="{{ request('end_date') }}"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#2D6A4F]">
            </div>

            {{-- JUMLAH PER HALAMAN --}}
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Per Halaman</label>
                <select name="per_page" 
                        onchange="this.form.submit()"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#2D6A4F]">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 data</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 data</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 data</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 data</option>
                </select>
            </div>

            {{-- TOMBOL AKSI FILTER --}}
            <div class="lg:col-span-4 flex items-center gap-2">
                <button type="submit" 
                        class="flex-1 bg-[#2D6A4F] hover:bg-[#0B3D26] text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow transition text-center">
                    Filter
                </button>
                
                @if(request('start_date') || request('end_date') || request('per_page'))
                    <a href="{{ route('pengaduan.index') }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium px-4 py-2.5 rounded-xl transition">
                        Reset
                    </a>
                @endif
            </div>

        </form>
    </div>

    {{-- CARD TABEL --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px]">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700 w-12">
                            No
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            Nama
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            No HP
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            Isi Pengaduan
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            Tanggal
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold text-gray-700">
                            Klasifikasi
                        </th>
                        <th class="px-4 py-4 text-center text-sm font-bold text-gray-700">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            {{-- NO --}}
                            <td class="px-4 py-4 text-sm text-gray-700 font-medium">
                                {{ $data->firstItem() + $i }}
                            </td>

                            {{-- NAMA --}}
                            <td class="px-4 py-4 text-sm font-semibold text-gray-800">
                                {{ $item->nama }}
                            </td>

                            {{-- NO HP --}}
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $item->no_hp }}
                            </td>

                            {{-- ISI --}}
                            <td class="px-4 py-4 text-sm text-gray-600 max-w-md">
                                <div class="line-clamp-2">
                                    {{ $item->isi_pengaduan }}
                                </div>
                            </td>

                            {{-- TANGGAL --}}
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('DD/MM/YYYY HH:mm') }}
                            </td>

                            {{-- KLASIFIKASI --}}
                            <td class="px-4 py-4 text-sm text-gray-600">
                                @include('admin.pengaduan._badge_klasifikasi', ['pengaduan' => $item])
                            </td>

                            {{-- AKSI --}}
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.pengaduan.edit', $item->id) }}"
                                       class="bg-[#2D6A4F] hover:bg-[#0B3D26] text-white px-4 py-2 rounded-xl text-sm shadow transition">
                                        Detail
                                    </a>

                                    <form id="delete{{ $item->id }}"
                                          action="{{ route('pengaduan.delete', $item->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                                onclick="hapus({{ $item->id }})"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm shadow transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-500">
                                Belum ada data pengaduan yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINASI --}}
        @if($data->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $data->links() }}
            </div>
        @endif
    </div>

</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function hapus(id){
    Swal.fire({
        title: 'Yakin hapus pengaduan?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if(result.isConfirmed){
            document.getElementById('delete'+id).submit();
        }
    });
}
</script>

@endsection