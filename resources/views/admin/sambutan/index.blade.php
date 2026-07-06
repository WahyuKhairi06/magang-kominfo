@extends('template.layout')

@section('content')

<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Sambutan</h1>

        {{-- <a href="{{ route('sambutan.create') }}"
           class="bg-primary text-white px-4 py-2 rounded-lg shadow hover:bg-primary/90 transition">
            + Tambah
        </a> --}}
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">

                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Foto</th>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Motto</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($data as $d)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 font-medium">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            <img src="{{ asset('storage/'.$d->foto) }}"
                                 class="w-14 h-14 object-cover rounded-lg border">
                        </td>

                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $d->judul }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $d->nama }}
                        </td>

                        <td class="px-6 py-4 text-gray-500 text-sm">
                            {{ $d->motto }}
                        </td>

                        <td class="px-6 py-4 text-center space-x-2">

                            <!-- EDIT -->
                            <a href="{{ route('sambutan.edit',$d->id) }}"
                               class="inline-block px-3 py-1 text-sm bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition">
                                Edit
                            </a>

                            <!-- DELETE -->
                            {{-- <form action="{{ route('sambutan.destroy',$d->id) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="delete-btn px-3 py-1 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            </form> --}}

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400">
                            Belum ada data
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection