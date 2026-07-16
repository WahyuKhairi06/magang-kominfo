@extends('template.layout')
@section('title', 'Setting AI Chatbot')
@section('content')
<!-- Tambahkan AlpineJS khusus untuk halaman admin ini -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="p-6 space-y-6" x-data="chatbotSettings()" x-init="init()">
    @if(session('success'))
      <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
        {{ session('success') }}
      </div>
    @endif

    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-xl">smart_toy</span>
          Setting AI Chatbot
        </h2>
        <p class="text-sm text-slate-500 mt-1 ml-[60px]">Kelola tampilan dan identitas chatbot yang akan dilihat pengunjung</p>
      </div>
      <div>
        <a href="{{ route('chat') }}" target="_blank" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors flex items-center gap-2 border border-slate-200 shadow-sm">
          <span class="material-symbols-outlined text-[18px]">open_in_new</span>
          Lihat Chatbot
        </a>
      </div>
    </div>

    <!-- Main Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <form method="POST" action="{{ route('chatbot-setting.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 divide-y lg:divide-y-0 lg:divide-x divide-slate-100">
          
          <!-- Left Column: Form Inputs -->
          <div class="lg:col-span-2 p-6 space-y-8">
            
            <!-- Section 1: Identitas -->
            <div>
              <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">badge</span>
                Identitas Chatbot
              </h3>
              
              <div class="space-y-5">
                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1">Nama AI (Virtual Assistant)</label>
                  <input type="text" name="ai_name" x-model="aiName" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="Contoh: Asisten Puskesmas" required>
                  <p class="text-xs text-slate-400 mt-1">Nama yang akan tampil sebagai pengirim pesan bot</p>
                  @error('ai_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1">Nama Puskesmas</label>
                  <input type="text" name="puskesmas_display_name" x-model="puskesmasName" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm" placeholder="Contoh: Puskesmas Marunggi" required>
                  <p class="text-xs text-slate-400 mt-1">Nama Puskesmas yang muncul di judul chatbot & system prompt AI</p>
                  @error('puskesmas_display_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>


              </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 2: Visual -->
            <div>
              <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">palette</span>
                Tampilan Visual
              </h3>

              <div class="space-y-6">
                <!-- Color Settings -->
                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Template Warna</label>
                    <div class="flex flex-wrap gap-3">
                      <button type="button" @click="primaryColor = '#1e6b4d'" class="w-10 h-10 rounded-full bg-[#1e6b4d] border-2 shadow-sm transition-all hover:scale-110" :class="primaryColor.toLowerCase() === '#1e6b4d' ? 'ring-2 ring-offset-2 ring-slate-800 scale-110' : 'border-transparent'"></button>
                      <button type="button" @click="primaryColor = '#ef4444'" class="w-10 h-10 rounded-full bg-[#ef4444] border-2 shadow-sm transition-all hover:scale-110" :class="primaryColor.toLowerCase() === '#ef4444' ? 'ring-2 ring-offset-2 ring-slate-800 scale-110' : 'border-transparent'"></button>
                      <button type="button" @click="primaryColor = '#3b82f6'" class="w-10 h-10 rounded-full bg-[#3b82f6] border-2 shadow-sm transition-all hover:scale-110" :class="primaryColor.toLowerCase() === '#3b82f6' ? 'ring-2 ring-offset-2 ring-slate-800 scale-110' : 'border-transparent'"></button>
                      <button type="button" @click="primaryColor = '#8b5cf6'" class="w-10 h-10 rounded-full bg-[#8b5cf6] border-2 shadow-sm transition-all hover:scale-110" :class="primaryColor.toLowerCase() === '#8b5cf6' ? 'ring-2 ring-offset-2 ring-slate-800 scale-110' : 'border-transparent'"></button>
                      <button type="button" @click="primaryColor = '#f97316'" class="w-10 h-10 rounded-full bg-[#f97316] border-2 shadow-sm transition-all hover:scale-110" :class="primaryColor.toLowerCase() === '#f97316' ? 'ring-2 ring-offset-2 ring-slate-800 scale-110' : 'border-transparent'"></button>
                    </div>
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Atur Warna Manual</label>
                    <div class="flex items-center gap-4">
                      <input type="color" x-model="primaryColor" class="h-10 w-20 rounded cursor-pointer border border-slate-200">
                      <div class="flex-1">
                        <input type="text" name="primary_color" x-model="primaryColor" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-primary focus:ring-primary focus:ring-2 shadow-sm text-sm font-mono" placeholder="#000000">
                      </div>
                    </div>

                    <!-- Tampilan Validasi Warna -->
                    <div class="mt-2">
                      <template x-if="isValidColor">
                        <div class="inline-flex items-center gap-1.5 text-xs text-green-600 bg-green-50 px-2.5 py-1 rounded-lg border border-green-200">
                          <span class="w-2.5 h-2.5 rounded-full inline-block shadow-sm" :style="`background-color: ${primaryColor}`"></span>
                          <span>Format Warna Valid: <strong class="font-mono" x-text="primaryColor"></strong></span>
                        </div>
                      </template>
                      <template x-if="!isValidColor">
                        <div class="inline-flex items-center gap-1.5 text-xs text-red-500 bg-red-50 px-2.5 py-1 rounded-lg border border-red-200">
                          <span class="material-symbols-outlined text-[14px]">error</span>
                          <span>Format warna tidak valid (Gunakan format HEX, contoh: #1E6B4D)</span>
                        </div>
                      </template>
                    </div>

                    @error('primary_color') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                  </div>
                </div>
              </div>
            </div>
            
            <hr class="border-slate-100">

            <!-- Section 3: Status -->
            <div>
              <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">toggle_on</span>
                Status Layanan
              </h3>

              <div class="flex items-center gap-6">
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="radio" name="status" value="active" x-model="status" class="w-5 h-5 text-primary border-slate-300 focus:ring-primary">
                  <div>
                    <p class="font-semibold text-slate-700 text-sm">Aktif</p>
                    <p class="text-xs text-slate-500">Chatbot akan ditampilkan di website</p>
                  </div>
                </label>
                <label class="flex items-center gap-3 cursor-pointer opacity-70 hover:opacity-100 transition-opacity">
                  <input type="radio" name="status" value="inactive" x-model="status" class="w-5 h-5 text-red-500 border-slate-300 focus:ring-red-500">
                  <div>
                    <p class="font-semibold text-slate-700 text-sm">Nonaktif</p>
                    <p class="text-xs text-slate-500">Sembunyikan chatbot untuk sementara</p>
                  </div>
                </label>
              </div>
              @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="pt-4 flex justify-end">
              <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-secondary text-white font-semibold rounded-xl shadow-sm transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan Pengaturan
              </button>
            </div>

          </div>

          <!-- Right Column: Live Preview -->
          <div class="bg-slate-50 p-6 flex flex-col items-center">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-6 w-full text-center">Live Preview</h3>
            
            <!-- Phone Mockup Container -->
            <div class="w-full max-w-[320px] bg-white rounded-[2rem] shadow-xl border-4 border-slate-200 overflow-hidden relative" style="height: 600px;">
              
              <!-- Inactive State -->
              <template x-if="status === 'inactive'">
                <div class="absolute inset-0 bg-slate-50 flex flex-col items-center justify-center p-6 text-center z-20">
                  <span class="material-symbols-outlined text-slate-300 text-6xl mb-4">smart_toy</span>
                  <p class="font-bold text-slate-600 mb-2">Chatbot Nonaktif</p>
                  <p class="text-xs text-slate-400">Layanan ini sedang dimatikan dari pengaturan.</p>
                </div>
              </template>

              <!-- Header Preview -->
              <div class="px-4 py-3 flex items-center gap-3 relative z-10" :style="`background-color: ${primaryColor}; color: ${contrastColor}`">
                <div class="w-8 h-8 rounded-full bg-black/10 flex items-center justify-center overflow-hidden shrink-0">
                  <span class="material-symbols-outlined text-[18px]">smart_toy</span>
                </div>
                <div class="flex-1 min-w-0">
                  <h4 class="font-bold text-[13px] leading-tight truncate" x-text="aiName"></h4>
                  <p class="text-[9px] truncate opacity-80" x-text="puskesmasName"></p>
                </div>
              </div>

              <!-- Chat Body Preview -->
              <div class="p-4 bg-slate-50 flex flex-col gap-4 h-full">
                <!-- Bot Msg -->
                <div class="flex gap-2">
                  <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 overflow-hidden" :style="`background-color: ${primaryColor}20; color: ${primaryColor}`">
                     <span class="material-symbols-outlined text-[14px]">smart_toy</span>
                  </div>
                  <div class="bg-white p-3 rounded-xl rounded-tl-sm shadow-sm border border-slate-100 text-[11px] text-slate-600 leading-relaxed max-w-[85%]">
                     Halo! Saya adalah <strong x-text="aiName"></strong>, asisten virtual resmi Puskesmas <strong x-text="puskesmasName"></strong>. Saya siap membantu Anda mendapatkan informasi seputar layanan Puskesmas <strong x-text="puskesmasName"></strong>.<br><br>Sebagai AI Assistant yang dikembangkan membantu masyarakat mencari informasi resmi seputar Puskesmas <strong x-text="puskesmasName"></strong>. Saya bukan manusia dan bukan tenaga medis, sehingga tidak dapat melakukan diagnosis penyakit atau memberikan resep obat.<br><br>Ada yang bisa saya bantu terkait layanan Puskesmas <strong x-text="puskesmasName"></strong>?
                  </div>
                </div>
                <!-- User Msg -->
                <div class="flex gap-2 flex-row-reverse mt-2">
                  <div class="w-6 h-6 rounded-full bg-slate-300 flex items-center justify-center shrink-0 text-white">
                     <span class="material-symbols-outlined text-[14px]">person</span>
                  </div>
                  <div class="p-3 rounded-xl rounded-tr-sm shadow-sm text-[11px] leading-relaxed max-w-[85%]" :style="`background-color: ${primaryColor}; color: ${contrastColor}`">
                    Halo, Saya mau menanyakan apakah bisa berobat BPJS di Puskesmas?
                  </div>
                </div>
              </div>

              <!-- Input Preview -->
              <div class="absolute bottom-0 left-0 right-0 p-3 bg-white border-t border-slate-100">
                <div class="relative flex items-center">
                  <div class="w-full h-9 bg-slate-100 rounded-full px-4 flex items-center">
                    <span class="text-[11px] text-slate-400">Ketik pesan...</span>
                  </div>
                  <div class="absolute right-1 w-7 h-7 rounded-full flex items-center justify-center" :style="`background-color: ${primaryColor}; color: ${contrastColor}`">
                    <span class="material-symbols-outlined text-[14px] ml-0.5">send</span>
                  </div>
                </div>
              </div>

            </div>
            
            <p class="text-[10px] text-slate-400 mt-4 text-center">Preview ini hanya ilustrasi desain.<br>Fungsi chat sebenarnya ada di halaman utama.</p>
          </div>
        </div>
      </form>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('chatbotSettings', () => ({
        aiName: '{{ old('ai_name', $setting->ai_name) }}',
        puskesmasName: '{{ old('puskesmas_display_name', $setting->puskesmas_display_name) }}',
        greeting: '{{ old('greeting_message', $setting->greeting_message) }}',
        primaryColor: '{{ old('primary_color', $setting->primary_color) }}',
        status: '{{ old('status', $setting->status) }}',
        
        get contrastColor() {
            if (!this.isValidColor) return '#ffffff';
            let hex = String(this.primaryColor).replace('#', '');
            if (hex.length === 3) {
                hex = hex.split('').map(c => c + c).join('');
            }
            if (hex.length !== 6) return '#ffffff';
            const r = parseInt(hex.substring(0, 2), 16);
            const g = parseInt(hex.substring(2, 4), 16);
            const b = parseInt(hex.substring(4, 6), 16);
            const yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
            return (yiq >= 128) ? '#0f172a' : '#ffffff';
        },

        get isValidColor() {
            if (!this.primaryColor) return false;
            return /^#[0-9A-F]{6}$/i.test(this.primaryColor);
        },
        
        init() {
        }
    }))
})
</script>
@endsection
