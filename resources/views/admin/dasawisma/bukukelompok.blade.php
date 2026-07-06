@extends('template.layout')
@section('content')

<div class="p-6">

<div class="bg-white rounded-2xl shadow-lg border border-gray-100">

<!-- HEADER -->
<div class="p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-3 border-b bg-gradient-to-r from-blue-50 to-white rounded-t-2xl">
    <h3 class="font-bold text-lg text-gray-800">📊 Data POKJA IV</h3>

    <a href="{{ route('dasawisma.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
        + Tambah
    </a>
</div>

<!-- FILTER -->
{{-- <form method="GET" class="p-4 grid grid-cols-1 md:grid-cols-5 gap-3 bg-gray-50 border-b" action="{{ url('pokjaiv/rekap') }}">

    <select name="kecamatan_id" class="border rounded-lg p-2">
        <option value="">Semua Kecamatan</option>
        @foreach($kecamatan as $k)
        <option value="{{ $k->id }}" {{ request('kecamatan_id') == $k->id ? 'selected' : '' }}>
            {{ $k->nama_kecamatan }}
        </option>
        @endforeach
    </select>

    <select name="desa_id" class="border rounded-lg p-2">
        <option value="">Semua Desa</option>
        @foreach($desa as $d)
        <option value="{{ $d->id }}" {{ request('desa_id') == $d->id ? 'selected' : '' }}>
            {{ $d->nama_desa }}
        </option>
        @endforeach
    </select>

    <select name="dusun_id" class="border rounded-lg p-2">
        <option value="">Semua Dusun</option>
        @foreach($dusun as $d)
        <option value="{{ $d->id }}" {{ request('dusun_id') == $d->id ? 'selected' : '' }}>
            {{ $d->nama_dusun }}
        </option>
        @endforeach
    </select>

    <select name="tahun" class="border rounded-lg p-2">
        <option value="">Pilih Tahun</option>
        <option value="2025" {{ request('tahun')=='2025'?'selected':'' }}>2025</option>
        <option value="2026" {{ request('tahun')=='2026'?'selected':'' }}>2026</option>
    </select>

    <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2">
    Cetak Kuisioner
    </button>

</form> --}}

<div class="bg-white p-5 rounded-2xl shadow border mb-4">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold flex items-center gap-2">
                📚 Panduan Pengisian Buku PKK
            </h1>
            <p class="text-sm text-gray-500">
                Klik tombol <b>Lihat Petunjuk</b> agar tidak salah input data
            </p>
        </div>

        <button onclick="openPetunjuk()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            📖 Lihat Petunjuk
        </button>
    </div>

</div>
<!-- TABLE -->
<div class="overflow-x-auto">
<table class="w-full text-sm">

<thead class="bg-gray-100 text-gray-700">
<tr>
<th class="p-3 text-left">Nama</th>
<th>Dusun</th>
<th>Desa</th>
<th>Kecamatan</th>
<th>Tahun</th>
<th class="text-center">Action</th>
</tr>
</thead>

<tbody>
@foreach($data as $d)
<tr class="border-t hover:bg-blue-50 transition">
<td class="p-3 font-medium">{{ $d->nama_dasawisma }}</td>
<td>{{ $d->nama_dusun }}</td>
<td>{{ $d->nama_desa }}</td>
<td>{{ $d->nama_kecamatan }}</td>
<td>
    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
        {{ $d->tahun }}
    </span>
</td>

<td class="flex justify-center gap-2 py-2 flex-wrap">

    <!-- 🔥 DETAIL BUTTON -->
    <button onclick="showDetail({{ $d->id }})"
        class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">
        🔍 Detail
    </button>

    <a href="{{ route('dasawisma.edit',$d->id) }}" class="text-yellow-600 text-xs">✏️</a>
    <a href="{{ route('buku.create',$d->id) }}" class="text-green-600 text-xs" title="tambah buku 1">📘1</a>
    <a href="{{ route('buku.index',$d->id) }}" class="text-green-800 text-xs" title="list buku 1">📋1</a>
    <a href="{{ route('buku2.create',$d->id) }}" class="text-purple-600 text-xs" title="tambah buku 2">📗 2</a>
    <a href="{{ route('buku2.index',$d->id) }}" class="text-purple-800 text-xs" title="list buku 2">📋2</a>
    <a href="{{ route('buku3.create',$d->id) }}" class="text-indigo-600 text-xs" title="tambah buku 3">📕3</a>
    <a href="{{ route('buku3.index',$d->id) }}" class="text-indigo-800 text-xs" title="list buku 3">📋3</a>
    {{-- <a href="{{ route('dasawisma.kuisioner', [$d->id, $d->tahun]) }}" class="text-indigo-800 text-xs">Kuesioner</a> --}}

    {{-- <a href="{{ route('dasawisma.kuisioner', [$d->id, $d->tahun]) }}" class="text-blue-600 hover:text-blue-800 text-sm"> 📝 Kuisioner </a> --}}

    <form action="{{ route('dasawisma.destroy',$d->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="button" onclick="hapus(this)"
            class="text-red-600 text-xs">🗑️</button>
    </form>

</td>
</tr>
@endforeach
</tbody>

</table>
</div>

</div>

<!-- 🔥 DETAIL BOX -->
<div id="detailBox" class="hidden mt-6">

    <div class="bg-white rounded-2xl shadow-xl border p-6">

        <div class="flex justify-between mb-4">
            <h2 class="font-bold text-lg">📋 Detail Dasawisma</h2>
            <button onclick="closeDetail()" class="text-red-500">✖</button>
        </div>

        <div id="detailContent"></div>

    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- 🔥 MODAL PETUNJUK -->
<div id="modalPetunjuk"
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white rounded-2xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">📖 Petunjuk Pengisian Buku PKK</h2>
            <button onclick="closePetunjuk()" class="text-red-500 text-xl">✖</button>
        </div>

        <!-- 🔥 BUKU 1 -->
        <div class="mb-4 p-3 bg-blue-50 rounded-lg">
            <h3 class="font-semibold text-blue-700">📘 Buku 1 - Anggota Keluarga</h3>
            <p class="text-sm text-gray-700">
                Isi <b>data per anggota keluarga</b> seperti nama, umur, pendidikan, pekerjaan,
                dan keikutsertaan kegiatan PKK.
            </p>
        </div>

        <!-- 🔥 BUKU 2 -->
        <div class="mb-4 p-3 bg-green-50 rounded-lg">
            <h3 class="font-semibold text-green-700">📗 Buku 2 - Data & Kegiatan Warga</h3>
            <p class="text-sm text-gray-700">
                Isi <b>data rekap satu keluarga</b> seperti jumlah anggota, kondisi rumah,
                sumber air, dan kegiatan warga.
            </p>
        </div>

        <!-- 🔥 BUKU 3 -->
        <div class="mb-4 p-3 bg-red-50 rounded-lg">
            <h3 class="font-semibold text-red-700">📕 Buku 3 - Kesehatan Ibu & Anak</h3>
            <p class="text-sm text-gray-700">
                Isi <b>data kesehatan</b> seperti ibu hamil, melahirkan, nifas,
                kelahiran bayi, dan kematian ibu/bayi/balita.
            </p>
        </div>

        <div class="text-right mt-4">
            <button onclick="closePetunjuk()"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Tutup
            </button>
        </div>

    </div>

</div>


<!-- 🔥 SCRIPT -->
<script>
function openPetunjuk(){
    document.getElementById('modalPetunjuk').classList.remove('hidden');
}

function closePetunjuk(){
    document.getElementById('modalPetunjuk').classList.add('hidden');
}

// klik luar modal = close
document.getElementById('modalPetunjuk').addEventListener('click', function(e){
    if(e.target === this){
        closePetunjuk();
    }
});

// ESC = close
document.addEventListener('keydown', function(e){
    if(e.key === "Escape"){
        closePetunjuk();
    }
});
</script>
<script>
// DELETE
function hapus(btn){
    let form = btn.closest('form');

    Swal.fire({
        title: 'Hapus?',
        icon: 'warning',
        showCancelButton: true
    }).then((r)=>{
        if(r.isConfirmed){
            form.submit();
        }
    });
}

// DETAIL
function showDetail(id){

    let data = @json($data);
    let d = data.find(x => x.id == id);

    let html = `
    <div class="grid md:grid-cols-3 gap-4 text-sm">

        <div class="bg-gray-50 p-3 rounded">
            <p>Nama</p>
            <b>${d.nama_dasawisma}</b>
        </div>

        <div class="bg-gray-50 p-3 rounded">
            <p>Dusun</p>
            <b>${d.nama_dusun}</b>
        </div>

        <div class="bg-gray-50 p-3 rounded">
            <p>Desa</p>
            <b>${d.nama_desa}</b>
        </div>

        <div class="bg-gray-50 p-3 rounded">
            <p>Kecamatan</p>
            <b>${d.nama_kecamatan}</b>
        </div>

        <div class="bg-blue-50 p-3 rounded">
            <p>Tahun</p>
            <b>${d.tahun}</b>
        </div>

    </div>

    <div class="mt-4 flex flex-wrap gap-2">

        <a href="/dasawisma/${d.id}/edit" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">Edit</a>
        <a href="/buku/create/${d.id}" class="bg-green-500 text-white px-3 py-1 rounded text-sm">Buku 1</a>
        <a href="/buku/${d.id}" class="bg-green-700 text-white px-3 py-1 rounded text-sm">List 1</a>
        <a href="/buku2/create/${d.id}" class="bg-purple-500 text-white px-3 py-1 rounded text-sm">Buku 2</a>
        <a href="/buku2/${d.id}" class="bg-purple-700 text-white px-3 py-1 rounded text-sm">List 2</a>
        <a href="/buku3/create/${d.id}" class="bg-indigo-500 text-white px-3 py-1 rounded text-sm">Buku 3</a>
        <a href="/buku3/${d.id}" class="bg-indigo-700 text-white px-3 py-1 rounded text-sm">List 3</a>

    </div>
    `;

    document.getElementById('detailContent').innerHTML = html;
    document.getElementById('detailBox').classList.remove('hidden');

    window.scrollTo({
        top: document.getElementById('detailBox').offsetTop - 80,
        behavior: 'smooth'
    });
}

function closeDetail(){
    document.getElementById('detailBox').classList.add('hidden');
}
</script>

@endsection