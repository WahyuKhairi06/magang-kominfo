@extends('template.layout')
@section('content')

<div class="p-6">

<div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-200">

    <!-- HEADER -->
    <div class="p-6 flex items-center justify-between border-b bg-slate-50">
        <h3 class="font-semibold text-lg text-slate-800 tracking-tight">
            📰 Data Berita
        </h3>

        <a href="{{ route('beritapage.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm shadow transition">
            + Tambah Berita
        </a>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">

            <thead>
                <tr class="bg-slate-100 text-xs uppercase text-slate-600 tracking-wide">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Judul</th>
                    <th class="p-4 text-left">Kategori</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($berita as $item)
                <tr class="hover:bg-slate-50 transition">

                    <td class="p-4 text-slate-500">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-4 font-medium text-slate-800">
                        {{ $item->judul }}
                    </td>

                    <td class="p-4 text-slate-600">
                        {{ $item->kategori->nama ?? '-' }}
                    </td>

                    <td class="p-4">
                        <span class="px-3 py-1 text-xs font-medium rounded-full
                        {{ $item->status == 'publish' 
                            ? 'bg-green-100 text-green-700' 
                            : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $item->status }}
                        </span>
                    </td>

                    <td class="p-4">
                        <div class="flex justify-center items-center gap-3">

                            <a href="{{ route('beritapage.edit',$item->id) }}"
                               class="text-blue-600 hover:underline text-sm">
                                ✏️ Edit
                            </a>

                            <button
                                class="p-2 rounded-lg hover:bg-red-50 text-red-500 transition"
                                onclick="openModal('modal-delete{{ $item->id }}')">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>

                        </div>
                    </td>

                </tr>

                @include('admin.beritapage.hapus')
                @endforeach
            </tbody>

        </table>
    </div>

</div>

</div>

@endsection