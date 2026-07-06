@extends('template.layout')
@section('content')

<div class="p-6">

<div class="bg-white rounded-2xl shadow border overflow-hidden">

<!-- HEADER -->
<div class="p-5 flex justify-between items-center border-b bg-slate-50">
    <h3 class="font-bold text-lg text-slate-700">📊 Data Anggota Buku PKK</h3>
</div>

<!-- TABLE -->
<div class="overflow-x-auto">
<table class="w-full text-sm">

<thead class="bg-slate-100 text-xs uppercase text-slate-600">
<tr>
<th class="p-4 text-left">No</th>
<th>Nama</th>
<th>JK</th>
<th>Keanggotaan</th>
<th>Pendidikan</th>
<th>Pekerjaan</th>
<th class="text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y">

@foreach($data as $d)
<tr class="hover:bg-slate-50 transition text-center">
<td class="p-4 font-medium">{{ $loop->iteration }}</td>
<td class="font-semibold text-slate-700">{{ $d->nama }}</td>
<td>
    <span class="px-2 py-1 text-xs rounded-full 
    {{ $d->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }}">
    {{ $d->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
    </span>
</td>
<td>{{ $d->dalam_keanggotaan_tp_pkk }}</td>
<td>{{ $d->pendidikan ?? '-' }}</td>
<td>{{ $d->pekerjaan ?? '-' }}</td>

<td class="flex justify-center items-center gap-2 p-3">

<!-- DETAIL -->
<button onclick="toggleDetail({{ $d->id }})"
class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600">
<span class="material-symbols-outlined text-[18px]">visibility</span>
</button>

<!-- EDIT -->
<a href="{{ route('rekapbuku.edit',$d->id) }}"
class="p-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-600">
<span class="material-symbols-outlined text-[18px]">edit</span>
</a>

<!-- DELETE -->
<form action="{{ route('rekapbuku.delete',$d->id) }}" method="POST" class="form-hapus">
@csrf
@method('DELETE')
<button class="p-2 rounded-lg bg-red-100 hover:bg-red-200 text-red-600">
<span class="material-symbols-outlined text-[18px]">delete</span>
</button>
</form>

</td>
</tr>

<!-- 🔽 DETAIL DROPDOWN -->
<tr id="detail-{{ $d->id }}" class="hidden bg-slate-50">
<td colspan="7" class="p-4">

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-slate-600">

<div>
<b>Kader Umum:</b><br>
{{ $d->kader_umum ?? '-' }}
</div>

<div>
<b>Kader Khusus:</b><br>
{{ $d->kader_khusus ?? '-' }}
</div>

<div>
<b>Status:</b><br>
{{ $d->status ?? '-' }}
</div>

<div>
<b>Tanggal Lahir:</b><br>
{{ $d->tanggal_lahir ?? '-' }}
</div>

<div>
<b>Alamat:</b><br>
{{ $d->alamat ?? '-' }}
</div>

<div>
<b>Keterangan:</b><br>
{{ $d->keterangan ?? '-' }}
</div>

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
// DELETE
document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin hapus?',
            text: 'Data tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});

// TOGGLE DETAIL
function toggleDetail(id){
    let el = document.getElementById('detail-'+id);
    el.classList.toggle('hidden');
}
</script>

@endsection