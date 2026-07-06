@extends('template.layout')
@section('content')

<div class="p-6">

<div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

<!-- HEADER -->
<div class="p-5 flex justify-between items-center border-b bg-slate-50">
    <h3 class="font-semibold text-lg text-slate-800 flex items-center gap-2">
        📘 Buku Agenda Surat
    </h3>

    <a href="{{ route('bukuagenda.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow text-sm flex items-center gap-2 transition">
        <span class="material-symbols-outlined text-[18px]">add</span>
        Tambah
    </a>
</div>

<!-- TABLE -->
<div class="overflow-x-auto">
<table class="w-full text-sm">

<thead>
<tr class="bg-slate-100 text-xs uppercase text-slate-600">
<th class="px-6 py-4 text-left">No</th>
<th class="px-6 py-4 text-left">Desa</th>
<th class="px-6 py-4 text-left">Kecamatan</th>
<th class="px-6 py-4 text-left">Dusun</th>
<th class="px-6 py-4 text-left">Tahun</th>
<th class="px-6 py-4 text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y">

@foreach($data as $d)
<tr class="hover:bg-slate-50 transition">

<!-- NO -->
<td class="px-6 py-4">
    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-semibold text-xs">
        {{ $loop->iteration }}
    </div>
</td>

<!-- DATA -->
<td class="px-6 py-4 font-medium text-slate-800">{{ $d->nama_desa }}</td>
<td class="px-6 py-4 text-slate-600">{{ $d->nama_kecamatan }}</td>
<td class="px-6 py-4 text-slate-600">{{ $d->nama_dusun ?? '-' }}</td>
<td class="px-6 py-4">
    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
        {{ $d->tahun }}
    </span>
</td>

<!-- ACTION -->
<td class="px-6 py-4">
<div class="flex justify-center items-center gap-2">

<!-- EDIT -->
<a href="{{ route('bukuagenda.edit',$d->id) }}"
   class="p-2 rounded-lg hover:bg-blue-50 text-blue-600 transition"
   title="Edit">
    <span class="material-symbols-outlined text-[18px]">edit</span>
</a>

<!-- TAMBAH SURAT -->
<a href="{{ route('agendaanggota.create',$d->id) }}"
   class="p-2 rounded-lg hover:bg-green-50 text-green-600 transition"
   title="Tambah Surat">
    <span class="material-symbols-outlined text-[18px]">note_add</span>
</a>

<!-- LIST -->
<a href="{{ route('agendaanggota.index',$d->id) }}"
   class="p-2 rounded-lg hover:bg-purple-50 text-purple-600 transition"
   title="Lihat Data">
    <span class="material-symbols-outlined text-[18px]">list</span>
</a>

<!-- PDF -->
<a href="{{ route('agendaanggota.cetak',$d->id) }}"
   class="p-2 rounded-lg hover:bg-orange-50 text-orange-600 transition"
   title="Cetak PDF">
    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
</a>

<!-- DELETE -->
<form action="{{ route('bukuagenda.destroy',$d->id) }}" method="POST" class="form-hapus">
@csrf
@method('DELETE')
<button type="submit"
    class="p-2 rounded-lg hover:bg-red-50 text-red-500 transition"
    title="Hapus">
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

</div>
</div>

<!-- ICON GOOGLE -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin hapus?',
            text: 'Data akan dihapus permanen!',
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