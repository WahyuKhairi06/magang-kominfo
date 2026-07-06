@extends('template.layout')
@section('content')

<div class="p-6"> <!-- 🔥 kasih jarak dari tepi layar -->

  <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 flex items-center justify-between border-b border-slate-100">
      <h3 class="font-bold text-slate-800">Data Role</h3>

      <button 
        class="bg-primary text-white py-2 px-4 rounded-xl text-sm font-semibold flex items-center gap-2 shadow hover:opacity-90 transition"
        onclick="openModal('modal-role')">
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
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Role</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Keterangan</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-center">Action</th>
          </tr>
        </thead>

        <tbody class="divide-y">
          @foreach ($roles as $role)
          <tr class="hover:bg-slate-50 transition">

            <!-- NO -->
            <td class="px-6 py-4">
              <div class="w-8 h-8 flex items-center justify-center rounded-full bg-primary/10 text-primary font-bold text-sm">
                {{ $loop->iteration }}
              </div>
            </td>

            <!-- ROLE -->
            <td class="px-6 py-4 font-semibold text-slate-700">
              {{ $role->nama_role }}
            </td>

            <!-- KETERANGAN -->
            <td class="px-6 py-4 text-slate-500">
              {{ $role->keterangan }}
            </td>

            <!-- ACTION -->
            <td class="px-6 py-4 text-center">
              <button 
                class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-primary transition"
                onclick="openModal('modal-edit{{ $role->id }}')">
                <span class="material-symbols-outlined">edit</span>
              </button>
            </td>

          </tr>

          @include('admin.role.edit')
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- FOOTER -->
    <div class="p-4 bg-slate-50 flex items-center justify-between border-t">
      <p class="text-sm text-slate-500">
        Total: <span class="font-bold text-slate-800">{{ count($roles) }}</span>
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

@include('admin.role.tambah')

@endsection