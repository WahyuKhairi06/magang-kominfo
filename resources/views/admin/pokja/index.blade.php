@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 flex items-center justify-between border-b">
      <h3 class="font-bold text-slate-800 text-lg">Data Pokja</h3>

      <a href="{{ route('pokja.create') }}"
        class="bg-primary text-white py-2 px-4 rounded-xl text-sm font-semibold flex items-center gap-2 shadow hover:opacity-90 transition">
        <span class="material-symbols-outlined text-sm">add_circle</span>
        Tambah Pokja
      </a>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead>
          <tr class="bg-slate-50">
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">No</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Nama Pokja</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Keterangan</th>
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

            <!-- NAMA -->
            <td class="px-6 py-4 font-semibold text-slate-700">
              {{ $item->nama_pokja }}
            </td>

            <!-- KETERANGAN -->
            <td class="px-6 py-4 text-slate-500">
              {{ $item->keterangan ?? '-' }}
            </td>

            <!-- ACTION -->
            <td class="px-6 py-4 text-center flex justify-center gap-2">

              <!-- EDIT -->
              <a href="{{ route('pokja.edit', $item->id) }}"
                class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-primary transition">
                <span class="material-symbols-outlined">edit</span>
              </a>

              <!-- DELETE -->
              <form action="{{ route('pokja.destroy', $item->id) }}" method="POST" class="form-hapus">
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

<!-- SWEET ALERT DELETE -->
<script>
document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin hapus?',
            text: 'Data pokja akan dihapus!',
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