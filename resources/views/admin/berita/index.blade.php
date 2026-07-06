@extends('template.layout')
@section('content')

<div class="p-6"> <!-- 🔥 kasih jarak dari tepi layar -->

  <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 flex items-center justify-between border-b border-slate-100">
      <h3 class="font-bold text-slate-800">Data Kategori Berita</h3>

      <button 
        class="bg-primary text-white py-2 px-4 rounded-xl text-sm font-semibold flex items-center gap-2 shadow hover:opacity-90 transition"
        onclick="openModal('modal-kategori-berita')">
        <span class="material-symbols-outlined text-sm">add_circle</span>
        Tambah Data
      </button>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead>
          <tr class="bg-slate-50">
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">No</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Nama Kategori</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Keterangan</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-center">Action</th>
          </tr>
        </thead>

        <tbody class="divide-y">
          @foreach ($berita_kategori as $berita)
          <tr class="hover:bg-slate-50 transition">

            <!-- NO -->
            <td class="px-6 py-4">
              <div class="w-8 h-8 flex items-center justify-center rounded-full bg-primary/10 text-primary font-bold text-sm">
                {{ $loop->iteration }}
              </div>
            </td>

            <!-- ROLE -->
            <td class="px-6 py-4 font-semibold text-slate-700">
              {{ $berita->nama}}
            </td>

            <!-- KETERANGAN -->
            <td class="px-6 py-4 text-slate-500">
              {{ $berita->keterangan }}
            </td>

            <!-- ACTION -->
            <td class="px-6 py-4 text-center">

    <!-- Edit -->
    <button
        class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-primary transition"
        onclick="openModal('modal-edit{{ $berita->id }}')">
        <span class="material-symbols-outlined">edit</span>
    </button>

    <!-- Delete -->
    <form action="{{ route('kategori-berita.destroy', $berita->id) }}"
          method="POST"
          style="display:inline-block;"
          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="p-2 rounded-lg hover:bg-red-100 text-red-500 hover:text-red-700 transition">

            <span class="material-symbols-outlined">
                delete
            </span>

        </button>

    </form>

</td>

          </tr>

          @include('admin.berita.edit')
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- FOOTER -->
    <div class="p-4 bg-slate-50 flex items-center justify-between border-t">
      <p class="text-sm text-slate-500">
        {{-- Total: <span class="font-bold text-slate-800">{{ count($beritas) }}</span> --}}
      </p>

      <div class="flex gap-2">
        <button class="w-9 h-9 flex items-center justify-center rounded-lg border hover:bg-slate-100">
          <span class="material-symbols-outlined">chevron_left</span>
        </button>

        <button class="w-9 h-9 rounded-lg bg-primary text-white font-bold">1</button>

        <button class="w-9 h-9 flex items-center justify-center rounded-lg border hover:bg-slate-100">
          <span class="material-symbols-outlined">chevron_right</span>
        </button>
      </div>
    </div>

  </div>

</div>

@include('admin.berita.tambah')

@endsection