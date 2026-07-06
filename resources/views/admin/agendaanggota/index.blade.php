@extends('template.layout')
@section('content')

<div class="p-6">

<div class="bg-white rounded-3xl shadow border overflow-hidden">

<!-- HEADER -->
<div class="p-5 flex justify-between items-center border-b bg-slate-50">
    <h3 class="font-bold text-lg">📑 Agenda Surat</h3>
</div>

<!-- TABLE -->
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-100 text-xs uppercase">
<tr>
<th class="p-3">No</th>
<th>Dari</th>
<th>Perihal Masuk</th>
<th>Kepada</th>
<th>Perihal Keluar</th>
<th class="text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y">

@foreach($data as $d)

<!-- ROW UTAMA -->
<tr class="hover:bg-slate-50">
<td class="p-3">{{ $loop->iteration }}</td>
<td>{{ $d->dari }}</td>
<td>{{ $d->perihal_masuk }}</td>
<td>{{ $d->kepada }}</td>
<td>{{ $d->perihal_keluar }}</td>

<td class="flex justify-center gap-2 p-2">

<!-- DETAIL BUTTON -->
<button onclick="toggleDetail({{ $d->id }})"
class="px-3 py-1 bg-gray-500 text-white rounded-lg text-xs">
Detail
</button>

<a href="{{ route('agendaanggota.edit',$d->id) }}"
class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs">
Edit
</a>

<form action="{{ route('agendaanggota.destroy',$d->id) }}" method="POST" class="form-hapus">
@csrf @method('DELETE')
<button class="px-3 py-1 bg-red-500 text-white rounded-lg text-xs">
Hapus
</button>
</form>

</td>
</tr>

<!-- DETAIL (HIDDEN) -->
<tr id="detail-{{ $d->id }}" class="hidden bg-gray-50">
<td colspan="6" class="p-4 text-sm">

<div class="grid grid-cols-2 md:grid-cols-3 gap-3">

<div><b>Tgl Terima:</b> {{ $d->tanggal_terima_surat }}</div>
<div><b>Tgl Masuk:</b> {{ $d->tanggal_surat_masuk }}</div>
<div><b>No Surat Masuk:</b> {{ $d->nomor_surat_diterima }}</div>

<div><b>Lampiran Masuk:</b> {{ $d->lampiran_masuk }}</div>
<div><b>Diteruskan:</b> {{ $d->diteruskan_kepada }}</div>

<div><b>No Surat Keluar:</b> {{ $d->nomor_surat }}</div>
<div><b>Tgl Keluar:</b> {{ $d->tanggal_surat_keluar }}</div>

<div><b>Lampiran Keluar:</b> {{ $d->lampiran_keluar }}</div>
<div><b>Tembusan:</b> {{ $d->tembusan }}</div>

</div>

</td>
</tr>

@endforeach

</tbody>
</table>
</div>

</div>
</div>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// DELETE CONFIRM
document.querySelectorAll('.form-hapus').forEach(form => {
form.addEventListener('submit', function(e){
e.preventDefault();

Swal.fire({
title:'Yakin hapus?',
text:'Data akan dihapus!',
icon:'warning',
showCancelButton:true,
confirmButtonText:'Ya',
cancelButtonText:'Batal'
}).then((result)=>{
if(result.isConfirmed){
form.submit();
}
});
});
});

// TOGGLE DETAIL
function toggleDetail(id) {
    let el = document.getElementById('detail-' + id);
    el.classList.toggle('hidden');
}
</script>

@endsection