@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 flex items-center justify-between border-b bg-slate-50">
      <h3 class="font-semibold text-lg text-slate-800 tracking-tight">
        📄 Data Halaman
      </h3>

      <a href="{{ url('halaman/create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-xl text-sm font-medium flex items-center gap-2 shadow transition">
        <span class="material-symbols-outlined text-[18px]">add_circle</span>
        Tambah Data
      </a>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
      <table class="w-full text-sm">

        <thead>
          <tr class="bg-slate-100 text-xs uppercase text-slate-600 tracking-wide">
            <th class="px-6 py-4 text-left">No</th>
            <th class="px-6 py-4 text-left">Judul</th>
            <th class="px-6 py-4 text-left">Kategori</th>
            <th class="px-6 py-4 text-center">Action</th>
          </tr>
        </thead>

        <tbody class="divide-y">
          @foreach ($data as $halaman)
          <tr class="hover:bg-slate-50 transition">

            <!-- NO -->
            <td class="px-6 py-4">
              <div class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-semibold text-xs">
                {{ $loop->iteration }}
              </div>
            </td>

            <!-- JUDUL -->
            <td class="px-6 py-4 font-medium text-slate-800">
              {{ $halaman->judul }}
            </td>

            <!-- KATEGORI -->
            <td class="px-6 py-4 text-slate-600">
              {{ $halaman->nama_kategori }}
            </td>

            <!-- ACTION -->
            <td class="px-6 py-4">
              <div class="flex justify-center items-center gap-2">

                <!-- EDIT -->
                <a href="{{ url('halaman/edit/'.$halaman->id) }}" 
                  class="p-2 rounded-lg hover:bg-blue-50 text-blue-600 transition">
                  <span class="material-symbols-outlined text-[18px]">edit</span>
                </a>

                <!-- DELETE -->
                <button
                  class="p-2 rounded-lg hover:bg-red-50 text-red-500 transition"
                  onclick="openModal('modal-delete{{ $halaman->id }}')">
                  <span class="material-symbols-outlined text-[18px]">delete</span>
                </button>

              </div>
            </td>

          </tr>

          @include('admin.halaman.hapus')
          @endforeach
        </tbody>

      </table>
    </div>

    <!-- FOOTER -->
    <div class="p-4 bg-slate-50 flex items-center justify-between border-t">
      <p class="text-sm text-slate-500"></p>

      <div class="flex gap-2">
        <button class="w-9 h-9 flex items-center justify-center rounded-lg border hover:bg-slate-100">
          <span class="material-symbols-outlined">chevron_left</span>
        </button>

        <button class="w-9 h-9 rounded-lg bg-blue-600 text-white font-semibold">1</button>

        <button class="w-9 h-9 flex items-center justify-center rounded-lg border hover:bg-slate-100">
          <span class="material-symbols-outlined">chevron_right</span>
        </button>
      </div>
    </div>

  </div>

</div>

@endsection