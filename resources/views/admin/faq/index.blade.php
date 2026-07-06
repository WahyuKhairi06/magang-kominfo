@extends('template.layout')

@section('content')

<div class="p-6">

  <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 flex items-center justify-between border-b border-slate-100">

      <div>
        <h3 class="font-bold text-slate-800">Daftar FAQ</h3>
        <p class="text-sm text-slate-500">Kelola Pertanyaan dan Jawaban</p>
      </div>

      <a href="{{ route('faq.create') }}"
         class="bg-primary text-white py-2 px-4 rounded-xl text-sm font-semibold flex items-center gap-2 shadow hover:opacity-90 transition">
        <span class="material-symbols-outlined text-sm">add_circle</span>
        Tambah FAQ
      </a>

    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">

      <table class="w-full text-left">

        <thead>
          <tr class="bg-slate-50">
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">No</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Pertanyaan</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Jawaban</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-center">Action</th>
          </tr>
        </thead>

        <tbody class="divide-y">

          @foreach ($data as $item)
          <tr class="hover:bg-slate-50 transition">

            <!-- NO -->
            <td class="px-6 py-4">
              <div class="w-8 h-8 flex items-center justify-center rounded-full bg-primary/10 text-primary font-bold text-sm">
                {{ $loop->iteration }}
              </div>
            </td>

            <!-- PERTANYAAN -->
            <td class="px-6 py-4 font-semibold text-slate-700">
              {{ $item->pertanyaan }}
            </td>

            <!-- JAWABAN -->
            <td class="px-6 py-4 text-slate-500">
              {{ \Illuminate\Support\Str::limit($item->jawaban, 80) }}
            </td>

            <!-- ACTION -->
            <td class="px-6 py-4 text-center">

              <a href="{{ route('faq.edit', $item->id) }}"
                 class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-yellow-500 transition">
                <span class="material-symbols-outlined">edit</span>
              </a>

              <form action="{{ route('faq.delete', $item->id) }}" method="POST"
                    class="inline"
                    onsubmit="return confirm('Yakin ingin hapus FAQ ini?')">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="p-2 rounded-lg hover:bg-red-50 text-red-500 transition">
                  <span class="material-symbols-outlined">delete</span>
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

@endsection