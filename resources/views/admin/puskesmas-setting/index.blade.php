@extends('template.layout')
@section('title', 'Setting Identitas Puskesmas')
@section('content')

<div class="p-6 space-y-6">
    @if(session('success'))
      <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
        {{ session('success') }}
      </div>
    @endif

    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-xl">domain</span>
          Setting Identitas Puskesmas
        </h2>
        <p class="text-sm text-slate-500 mt-1 ml-[60px]">Kelola informasi umum puskesmas yang akan tampil di seluruh halaman website (Navbar, Footer, Landing Page)</p>
      </div>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <form method="POST" action="{{ route('puskesmas-setting.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="p-8 space-y-8">
          
          <!-- Grid Layout -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Column 1: Identitas & Logo -->
            <div class="space-y-6">
              <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2 pb-2 border-b border-slate-100">
                <span class="material-symbols-outlined text-[18px]">badge</span>
                Identitas Utama
              </h3>
              
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Puskesmas</label>
                <input type="text" name="nama_puskesmas" value="{{ old('nama_puskesmas', $setting->nama_puskesmas) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="Contoh: Puskesmas Marunggi" required>
                @error('nama_puskesmas') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kabupaten / Kota</label>
                <input type="text" name="kabupaten_kota" value="{{ old('kabupaten_kota', $setting->kabupaten_kota) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="Contoh: Kota Pariaman" required>
                @error('kabupaten_kota') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Logo Puskesmas</label>
                <div class="flex items-center gap-4 mt-2">
                  <div class="w-16 h-16 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden shrink-0">
                    @if($setting->logo)
                      <img src="{{ asset($setting->logo) }}" alt="Logo" class="w-full h-full object-contain">
                    @else
                      <span class="material-symbols-outlined text-slate-300 text-3xl">image</span>
                    @endif
                  </div>
                  <div class="flex-1">
                    <input type="file" name="logo" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                  </div>
                </div>
                @error('logo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
              </div>
            </div>

            <!-- Column 2: Jam Pelayanan -->
            <div class="space-y-6">
              <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2 pb-2 border-b border-slate-100">
                <span class="material-symbols-outlined text-[18px]">schedule</span>
                Jam Pelayanan
              </h3>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Senin - Kamis</label>
                <input type="text" name="jam_senin_kamis" value="{{ old('jam_senin_kamis', $setting->jam_senin_kamis) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="Contoh: 08:00 - 14:00" required>
                @error('jam_senin_kamis') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Jumat</label>
                <input type="text" name="jam_jumat" value="{{ old('jam_jumat', $setting->jam_jumat) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="Contoh: 08:00 - 11:00" required>
                @error('jam_jumat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Sabtu</label>
                <input type="text" name="jam_sabtu" value="{{ old('jam_sabtu', $setting->jam_sabtu) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="Contoh: 08:00 - 13:00" required>
                @error('jam_sabtu') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
              </div>
            </div>

          </div>

          <hr class="border-slate-100">

          <!-- Section 3: Alamat & Kontak -->
          <div class="space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2 pb-2 border-b border-slate-100">
              <span class="material-symbols-outlined text-[18px]">contact_mail</span>
              Kontak & Media Sosial
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="Alamat lengkap puskesmas..." required>{{ old('alamat', $setting->alamat) }}</textarea>
                @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
              </div>

              <div class="space-y-5">
                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
                  <input type="text" name="no_telp" value="{{ old('no_telp', $setting->no_telp) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="Contoh: (0751) 123-456" required>
                  @error('no_telp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1">Email Resmi</label>
                  <input type="email" name="email" value="{{ old('email', $setting->email) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="Contoh: info@puskesmas.go.id" required>
                  @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Link Facebook</label>
                <div class="relative flex items-center">
                  <span class="absolute left-3 text-slate-400 text-sm font-semibold">URL</span>
                  <input type="url" name="link_facebook" value="{{ old('link_facebook', $setting->link_facebook) }}" class="w-full rounded-xl border border-slate-200 pl-12 pr-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="https://facebook.com/nama-puskesmas">
                </div>
                @error('link_facebook') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Link Instagram</label>
                <div class="relative flex items-center">
                  <span class="absolute left-3 text-slate-400 text-sm font-semibold">URL</span>
                  <input type="url" name="link_instagram" value="{{ old('link_instagram', $setting->link_instagram) }}" class="w-full rounded-xl border border-slate-200 pl-12 pr-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="https://instagram.com/nama-puskesmas">
                </div>
                @error('link_instagram') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
              </div>
            </div>

          </div>

          <!-- Submit Button -->
          <div class="pt-6 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-6 py-3 bg-primary hover:bg-secondary text-white font-bold rounded-xl shadow-md transition-all flex items-center gap-2 hover:-translate-y-0.5 active:translate-y-0">
              <span class="material-symbols-outlined text-[18px]">save</span>
              Simpan Identitas Puskesmas
            </button>
          </div>

        </div>
      </form>
    </div>
</div>

@endsection
