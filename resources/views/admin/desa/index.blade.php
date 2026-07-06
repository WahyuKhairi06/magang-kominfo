@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="bg-white rounded-3xl shadow-lg border overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 flex justify-between border-b">
      <h3 class="font-bold text-lg">Data Desa</h3>

      <a href="{{ route('desa.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm">
        + Tambah Desa
      </a>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead>
          <tr class="bg-gray-50 text-sm">
            <th class="px-6 py-3">No</th>
            <th class="px-6 py-3">Nama Desa</th>
            <th class="px-6 py-3">Kecamatan</th>
            <th class="px-6 py-3 text-center">Action</th>
          </tr>
        </thead>

        <tbody>
          @foreach($data as $item)
          <tr class="border-t hover:bg-gray-50">

            <td class="px-6 py-3">{{ $loop->iteration }}</td>

            <td class="px-6 py-3 font-semibold">
              {{ $item->nama_desa }}
            </td>

            <td class="px-6 py-3">
              {{ $item->nama_kecamatan }}
            </td>

            <td class="px-6 py-3 text-center flex justify-center gap-2">

              <a href="{{ route('desa.edit', $item->id) }}"
                class="text-blue-500">Edit</a>

              <form action="{{ route('desa.destroy', $item->id) }}" method="POST" class="form-hapus">
                @csrf
                @method('DELETE')
                <button class="text-red-500">Hapus</button>
              </form>

            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>

</div>

<script>
document.querySelectorAll('.form-hapus').forEach(form => {
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Hapus?',
      icon: 'warning',
      showCancelButton: true
    }).then(res => {
      if(res.isConfirmed) form.submit();
    });
  });
});
</script>

@endsection