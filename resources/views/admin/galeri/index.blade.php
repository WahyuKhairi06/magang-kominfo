@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 flex items-center justify-between border-b border-slate-100">
      <h3 class="font-bold text-slate-800">Galeri Kegiatan</h3>

      <a href="{{ route('galeri.create') }}"
        class="bg-primary text-white py-2 px-4 rounded-xl text-sm font-semibold flex items-center gap-2 shadow hover:opacity-90 transition">
        <span class="material-symbols-outlined text-sm">add_circle</span>
        Tambah Galeri
      </a>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead>
          <tr class="bg-slate-50">
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">No</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Foto</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Judul</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Tanggal</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Lokasi</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Jenis</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Pokja</th>
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

            <!-- FOTO -->
            <td class="px-6 py-4">
              <img src="{{ asset('storage/' . $item->foto) }}"
                   class="w-16 h-16 object-cover rounded-xl border">
            </td>

            <!-- JUDUL -->
            <td class="px-6 py-4 font-semibold text-slate-700">
              {{ $item->judul_kegiatan }}
            </td>

            <!-- TANGGAL -->
            <td class="px-6 py-4 text-slate-500">
              {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
            </td>

            <!-- LOKASI -->
            <td class="px-6 py-4 text-slate-500">
              {{ $item->lokasi }}
            </td>
            <td> @if($item->jenis == NULL)

<div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl 
            bg-gradient-to-r from-pink-500 to-rose-500 
            text-white shadow-lg shadow-pink-500/30">

    <svg xmlns="http://www.w3.org/2000/svg" 
         class="w-5 h-5" 
         fill="none" 
         viewBox="0 0 24 24" 
         stroke="currentColor">

        <path stroke-linecap="round" 
              stroke-linejoin="round" 
              stroke-width="2" 
              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />

    </svg>

    <span class="font-semibold tracking-wide">
        Galeri
    </span>

</div>

@else

<div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl 
            bg-gradient-to-r from-blue-600 to-cyan-500 
            text-white shadow-lg shadow-blue-500/30">

    <svg xmlns="http://www.w3.org/2000/svg" 
         class="w-5 h-5" 
         fill="none" 
         viewBox="0 0 24 24" 
         stroke="currentColor">

        <path stroke-linecap="round" 
              stroke-linejoin="round" 
              stroke-width="2" 
              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

    </svg>

    <span class="font-semibold tracking-wide">
        Infografis
    </span>

</div>

@endif
            </td>
            <td class="px-6 py-4 text-slate-500">
              {{ $item->nama_pokja }}
            </td>

            <!-- ACTION -->
            <td class="px-6 py-4 text-center flex justify-center gap-2">

              <!-- EDIT -->
              <a href="{{ route('galeri.edit', $item->id) }}"
                class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-primary transition">
                <span class="material-symbols-outlined">edit</span>
              </a>

              <!-- DELETE -->
              <form action="{{ route('galeri.destroy', $item->id) }}" method="POST" class="form-hapus">
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

    <!-- FOOTER -->
    <div class="p-4 bg-slate-50 flex items-center justify-between border-t">
      <p class="text-sm text-slate-500">
        Total: <span class="font-bold text-slate-800">{{ count($data) }}</span>
      </p>
    </div>

  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- SWEET ALERT DELETE -->
<script>
document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin hapus?',
            text: 'Data galeri akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
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