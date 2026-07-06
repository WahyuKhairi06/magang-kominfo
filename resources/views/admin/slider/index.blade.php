@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 flex items-center justify-between border-b bg-slate-50">
      <h3 class="font-semibold text-lg text-slate-800 tracking-tight">
        🖼️ Slider Banner
      </h3>

      <a href="{{ route('slider.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-xl text-sm font-medium flex items-center gap-2 shadow transition">
        <span class="material-symbols-outlined text-[18px]">add_circle</span>
        Tambah Slider
      </a>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
      <table class="w-full text-sm">

        <thead>
          <tr class="bg-slate-100 text-xs uppercase text-slate-600 tracking-wide">
            <th class="px-6 py-4 text-left">No</th>
            <th class="px-6 py-4 text-left">Gambar</th>
            <th class="px-6 py-4 text-left">Judul</th>
            <th class="px-6 py-4 text-left">Sub Judul</th>
            <th class="px-6 py-4 text-left">Urutan</th>
            <th class="px-6 py-4 text-left">Status</th>
            <th class="px-6 py-4 text-center">Action</th>
          </tr>
        </thead>

        <tbody class="divide-y">
          @foreach ($data as $item)
          <tr class="hover:bg-slate-50 transition">

            <!-- NO -->
            <td class="px-6 py-4">
              <div class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-semibold text-xs">
                {{ $loop->iteration }}
              </div>
            </td>

            <!-- GAMBAR -->
            <td class="px-6 py-4">
              <img src="{{ asset('storage/' . $item->gambar) }}"
                   class="w-28 h-16 object-cover rounded-lg border shadow-sm">
            </td>

            <!-- JUDUL -->
            <td class="px-6 py-4 font-medium text-slate-800">
              {{ $item->judul ?? '-' }}
            </td>

            <!-- SUB JUDUL -->
            <td class="px-6 py-4 text-slate-500">
              {{ $item->sub_judul ?? '-' }}
            </td>

            <!-- URUTAN -->
            <td class="px-6 py-4 text-slate-600 font-medium">
              {{ $item->urutan }}
            </td>

            <!-- STATUS -->
            <td class="px-6 py-4">
              @if($item->is_active)
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                  Aktif
                </span>
              @else
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-600">
                  Nonaktif
                </span>
              @endif
            </td>

            <!-- ACTION -->
            <td class="px-6 py-4">
              <div class="flex justify-center items-center gap-2">

                <!-- EDIT -->
                <a href="{{ route('slider.edit', $item->id) }}"
                  class="p-2 rounded-lg hover:bg-blue-50 text-blue-600 transition">
                  <span class="material-symbols-outlined text-[18px]">edit</span>
                </a>

                <!-- DELETE -->
                <form action="{{ route('slider.destroy', $item->id) }}" method="POST" class="form-hapus">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                    class="p-2 rounded-lg hover:bg-red-50 text-red-500 transition">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                  </button>
                </form>

              </div>
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- FOOTER -->
    <div class="p-4 bg-slate-50 flex items-center justify-between border-t">
      <p class="text-sm text-slate-500">
        Total: <span class="font-semibold text-slate-800">{{ count($data) }}</span>
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
            text: 'Slider akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
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