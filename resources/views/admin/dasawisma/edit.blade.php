@extends('template.layout')
@section('content')

<div class="p-6 max-w-xl mx-auto">

  <div class="bg-white p-6 rounded-2xl shadow">

    <h3 class="font-bold mb-4 text-lg">Edit Kegiatan POKJA IV</h3>

    <form action="{{ route('dasawisma.update', $item->id) }}" method="POST">
      @csrf

      <!-- NAMA -->
      <div class="mb-3">
        <label class="text-sm text-gray-600">Nama Dasawisma</label>
        <input type="text" name="nama_dasawisma"
          value="{{ $item->nama_dasawisma }}"
          class="w-full mt-1 p-2 border rounded">
      </div>

      <!-- KECAMATAN -->
      <div class="mb-3">
        <select id="kecamatan" name="kecamatan_id"
          class="w-full p-2 border rounded">
          @foreach($kecamatan as $k)
          <option value="{{ $k->id }}"
            {{ $item->kecamatan_id == $k->id ? 'selected' : '' }}>
            {{ $k->nama_kecamatan }}
          </option>
          @endforeach
        </select>
      </div>

      <!-- DESA -->
      <div class="mb-3">
        <select id="desa" name="desa_id"
          class="w-full p-2 border rounded">
          @foreach($desa as $d)
          <option value="{{ $d->id }}"
            {{ $item->desa_id == $d->id ? 'selected' : '' }}>
            {{ $d->nama_desa }}
          </option>
          @endforeach
        </select>
      </div>

      <!-- DUSUN -->
      <div class="mb-3">
        <select id="dusun" name="dusun_id"
          class="w-full p-2 border rounded">
          @foreach($dusun as $d)
          <option value="{{ $d->id }}"
            {{ $item->dusun_id == $d->id ? 'selected' : '' }}>
            {{ $d->nama_dusun }}
          </option>
          @endforeach
        </select>
      </div>

      <!-- POKJA -->
      <div class="mb-3">
        <input type="number" name="pokja_id"
          value="{{ $item->pokja_id }}"
          class="w-full p-2 border rounded">
      </div>

      <!-- TAHUN -->
      <div class="mb-4">
        <input type="number" name="tahun"
          value="{{ $item->tahun }}"
          class="w-full p-2 border rounded">
      </div>

      <button class="w-full bg-green-600 text-white py-2 rounded-lg">
        Update
      </button>

    </form>

  </div>

</div>

@endsection