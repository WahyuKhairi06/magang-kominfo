@extends('template.layout')

@section('content')
<div class="container mx-auto p-4">

<div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Data Buku 2 Catatan Data dan Kegiatan Warga</h1>

    <a href="{{ route('buku2.cetak',$dasa->id) }}"
       class="bg-blue-500 text-white px-4 py-2 rounded">
       Cetak PDF
    </a>
</div>

<div class="bg-white shadow rounded overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-gray-100">
<tr>
    <th class="p-2">No</th>
    <th class="p-2">Nama</th>
    <th class="p-2">KK</th>
    <th class="p-2">L / P</th>
    <th class="p-2">Aksi</th>
</tr>
</thead>

<tbody>
@foreach($data as $i => $d)
<tr class="border-b hover:bg-gray-50">
    <td class="p-2">{{ $i+1 }}</td>
    <td class="p-2">{{ $d->nama_kepala_rumah_tangga }}</td>
    <td class="p-2">{{ $d->jumlah_kk }}</td>
    <td class="p-2">{{ $d->total_l }} / {{ $d->total_p }}</td>

    <td class="p-2 flex gap-2">
        <button onclick="showDetail({{ $d->id }})"
            class="bg-green-500 text-white px-2 py-1 rounded">
            Detail
        </button>

        <a href="{{ route('buku2.edit',$d->id) }}"
            class="bg-yellow-500 text-white px-2 py-1 rounded">
            Edit
        </a>

        <form id="delete{{ $d->id }}" method="POST"
            action="{{ route('buku2.delete',$d->id) }}">
            @csrf
            @method('DELETE')
            <button type="button"
                onclick="confirmDelete({{ $d->id }})"
                class="bg-red-500 text-white px-2 py-1 rounded">
                Hapus
            </button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>

</div>

<!-- 🔥 MODAL DETAIL -->
@foreach($data as $d)
<div id="modal{{ $d->id }}"
    class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">

        <h2 class="text-lg font-bold mb-4">Detail Rekap</h2>

        <!-- DATA UMUM -->
        <div class="grid grid-cols-2 gap-2 text-sm">
            <p><b>Nama:</b> {{ $d->nama_kepala_rumah_tangga }}</p>
            <p><b>KK:</b> {{ $d->jumlah_kk }}</p>
        </div>

        <hr class="my-3">

        <!-- ANGGOTA -->
        <h3 class="font-semibold">Anggota</h3>
        <div class="grid grid-cols-3 text-sm gap-2">
            <p>L: {{ $d->total_l }}</p>
            <p>P: {{ $d->total_p }}</p>
            <p>Balita L: {{ $d->balita_l }}</p>
            <p>Balita P: {{ $d->balita_p }}</p>
            <p>PUS: {{ $d->pus }}</p>
            <p>WUS: {{ $d->wus }}</p>
            <p>Ibu Hamil: {{ $d->ibu_hamil }}</p>
            <p>Menyusui: {{ $d->ibu_menyusui }}</p>
            <p>Lansia: {{ $d->lansia }}</p>
            <p>3 Buta: {{ $d->buta }}</p>
            <p>Khusus: {{ $d->berkebutuhan_khusus }}</p>
        </div>

        <hr class="my-3">

        <!-- RUMAH -->
        <h3 class="font-semibold">Kondisi Rumah</h3>
        <div class="grid grid-cols-2 text-sm gap-2">
            <p>Layak: {{ $d->sehat_layak_huni }}</p>
            <p>Tidak Layak: {{ $d->tidak_sehat_layak_huni }}</p>
            <p>Sampah: {{ $d->ada_tempat_buang_sampah ? '✔' : '-' }}</p>
            <p>SPAL: {{ $d->spal ? '✔' : '-' }}</p>
            <p>MCK: {{ $d->mck_septik_tank ? '✔' : '-' }}</p>
            <p>PDAM: {{ $d->pdam ? '✔' : '-' }}</p>
        </div>

        <hr class="my-3">

        <!-- LAINNYA -->
        <div class="text-sm">
            <p>Sumber Air: {{ $d->sumber_air }}</p>
            <p>Makanan: {{ $d->makanan_pokok }}</p>
        </div>

        <hr class="my-3">

        <!-- KEGIATAN -->
        <h3 class="font-semibold">Kegiatan</h3>
        <div class="grid grid-cols-2 text-sm">
            <p>UP2K: {{ $d->up2k ? '✔' : '-' }}</p>
            <p>Perkarangan: {{ $d->pemanfataan_perkarangan ? '✔' : '-' }}</p>
            <p>Industri: {{ $d->industri_rumah_tanggal ? '✔' : '-' }}</p>
            <p>Kesehatan: {{ $d->kesehatan_lingkungan ? '✔' : '-' }}</p>
        </div>

        <p class="mt-3"><b>Ket:</b> {{ $d->ket }}</p>

        <button onclick="closeModal({{ $d->id }})"
            class="mt-4 bg-gray-500 text-white px-4 py-2 rounded">
            Tutup
        </button>

    </div>
</div>
@endforeach

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id){
    Swal.fire({
        title:'Hapus?',
        icon:'warning',
        showCancelButton:true
    }).then((r)=>{
        if(r.isConfirmed){
            document.getElementById('delete'+id).submit();
        }
    });
}

function showDetail(id){
    document.getElementById('modal'+id).classList.remove('hidden');
}

function closeModal(id){
    document.getElementById('modal'+id).classList.add('hidden');
}
</script>

@endsection