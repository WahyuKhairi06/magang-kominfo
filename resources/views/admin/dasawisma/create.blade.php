@extends('template.layout')
@section('content')

<div class="p-6 max-w-xl mx-auto">

  <div class="bg-white p-6 rounded-2xl shadow">

    <h3 class="font-bold mb-4 text-lg">Tambah Kegiatan Pokja IV</h3>

    <form action="{{ route('dasawisma.store') }}" method="POST">
      @csrf

      <!-- NAMA -->
      <div class="mb-3">
        <label class="text-sm text-gray-600">Nama Dasawisma</label>
        <input type="text" name="nama_dasawisma"
          class="w-full mt-1 p-2 border rounded"
          required>
      </div>

      <!-- KECAMATAN -->
      <div class="mb-3">
        <label class="text-sm text-gray-600">Kecamatan</label>
        <select id="kecamatan" name="kecamatan_id"
          class="w-full mt-1 p-2 border rounded" required>
          <option value="">Pilih Kecamatan</option>
          @foreach($kecamatan as $k)
          <option value="{{ $k->id }}">{{ $k->nama_kecamatan }}</option>
          @endforeach
        </select>
      </div>

      <!-- DESA -->
      <div class="mb-3">
        <label class="text-sm text-gray-600">Desa</label>
        <select id="desa" name="desa_id"
          class="w-full mt-1 p-2 border rounded" required>
<option value="">Pilih Desa</option>
          @foreach($desa as $k)
          <option value="{{ $k->id }}">{{ $k->nama_desa }}</option>
          @endforeach        </select>
      </div>

      <!-- DUSUN -->
      <div class="mb-3">
        <label class="text-sm text-gray-600">Dusun</label>
        <select id="dusun" name="dusun_id"
          class="w-full mt-1 p-2 border rounded" required>
<option value="">Pilih Dusun</option>
          @foreach($dusun as $k)
          <option value="{{ $k->id }}">{{ $k->nama_dusun }}</option>
          @endforeach        </select>
      </div>

      <!-- POKJA -->
      <div class="mb-3">
        <label class="text-sm text-gray-600">Dusun</label>
        <select id="dusun" name="pokja_id"
          class="w-full mt-1 p-2 border rounded" required>
<option value="">Pilih Pokja</option>
          @foreach($pokja as $k)
          <option value="{{ $k->id }}">{{ $k->nama_pokja }}</option>
          @endforeach        </select>
      </div>

     
      <!-- TAHUN -->
      <div class="mb-4">
        <label class="text-sm text-gray-600">Tahun</label>
        <input type="number" name="tahun"
          class="w-full mt-1 p-2 border rounded"
          value="{{ date('Y') }}">
      </div>

      <button class="w-full bg-blue-600 text-white py-2 rounded-lg">
        Simpan
      </button>

    </form>

  </div>

</div>

<script>
// filter desa berdasarkan kecamatan
document.getElementById('kecamatan').addEventListener('change', function(){
    fetch('/api/desa/'+this.value)
    .then(res => res.json())
    .then(data => {
        let desa = document.getElementById('desa');
        desa.innerHTML = '<option value="">Pilih Desa</option>';
        data.forEach(d => {
            desa.innerHTML += `<option value="${d.id}">${d.nama_desa}</option>`;
        });
    });
});

// filter dusun berdasarkan desa
document.getElementById('desa').addEventListener('change', function(){
    fetch('/api/dusun/'+this.value)
    .then(res => res.json())
    .then(data => {
        let dusun = document.getElementById('dusun');
        dusun.innerHTML = '<option value="">Pilih Dusun</option>';
        data.forEach(d => {
            dusun.innerHTML += `<option value="${d.id}">${d.nama_dusun}</option>`;
        });
    });
});
</script>

@endsection