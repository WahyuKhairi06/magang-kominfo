@extends('template.layout')
@section('content')

<div class="p-6">

  <div class="bg-white rounded-3xl shadow border overflow-hidden">

    <div class="p-6 flex justify-between border-b">
      <h3 class="font-bold text-lg">Data Kecamatan</h3>

      <a href="{{ route('kecamatan.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-xl">
        + Tambah
      </a>
    </div>

    <table class="w-full">
      <thead class="bg-gray-50 text-sm">
        <tr>
          <th class="px-6 py-3">No</th>
          <th class="px-6 py-3">Nama Kecamatan</th>
          <th class="px-6 py-3 text-center">Action</th>
        </tr>
      </thead>

      <tbody>
        @foreach($data as $item)
        <tr class="border-t hover:bg-gray-50">

          <td class="px-6 py-3">{{ $loop->iteration }}</td>

          <td class="px-6 py-3 font-semibold">
            {{ $item->nama_kecamatan }}
          </td>

          <td class="px-6 py-3 text-center flex justify-center gap-2">

            <a href="{{ route('kecamatan.edit', $item->id) }}"
              class="text-blue-500">Edit</a>

            <form action="{{ route('kecamatan.destroy', $item->id) }}" method="POST" class="form-hapus">
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

<script>
document.querySelectorAll('.form-hapus').forEach(form => {
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Yakin hapus?',
      icon: 'warning',
      showCancelButton: true
    }).then(res => {
      if(res.isConfirmed) form.submit();
    });
  });
});
</script>

@endsection