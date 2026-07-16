<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{--
    Partial: Chip Selector Klasifikasi Pengaduan
    Include di halaman detail pengaduan admin
--}}

@php
    $kategoriOptions = [
        'Pendaftaran & Administrasi',
        'Pelayanan Petugas/Medis',
        'Waktu Tunggu & Antrean',
        'Kebersihan & Fasilitas',
        'Ketersediaan Obat',
        'Sarana & Prasarana',
        'Lainnya',
    ];
@endphp

<div x-data="klasifikasiChip({
        pengaduanId: {{ $pengaduan->id }},
        kategoriFinal: '{{ $pengaduan->kategori_final }}',
        urgensiFinal: '{{ $pengaduan->urgensi_final }}',
        updateUrl: '{{ route('admin.pengaduan.klasifikasi.update', $pengaduan->id) }}',
    })" class="space-y-6">

    {{-- STATUS ALERTS --}}
    @if ($pengaduan->status_klasifikasi === 'pending')
        <div class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-100 text-slate-600 animate-pulse">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
            </span>
            <span class="text-xs font-semibold">Sedang diproses AI, mohon tunggu sebentar...</span>
        </div>
    @elseif ($pengaduan->status_klasifikasi === 'gagal')
        <div class="flex items-start gap-2.5 p-4 rounded-2xl bg-amber-50 border border-amber-100 text-amber-800 text-xs leading-relaxed font-semibold">
            <span class="material-symbols-outlined text-amber-600 text-lg leading-none">warning</span>
            <span>Klasifikasi otomatis gagal (kuota harian API gratis Gemini Anda habis). Silakan lakukan triage manual di bawah ini.</span>
        </div>
    @endif

    {{-- Kategori --}}
    <div class="space-y-2.5">
        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Kategori Pengaduan</label>
        <div class="flex flex-wrap gap-2">
            @foreach ($kategoriOptions as $kategori)
                <button
                    type="button"
                    @click="pilihKategori('{{ $kategori }}')"
                    :class="kategoriFinal === '{{ $kategori }}'
                        ? 'bg-[#2D6A4F] text-white border-[#2D6A4F] shadow-sm font-semibold'
                        : 'bg-slate-50 text-slate-600 border-slate-100 hover:bg-slate-100 font-medium'"
                    class="px-3.5 py-2 rounded-2xl border text-xs flex items-center gap-1.5 transition-all duration-200"
                >
                    <span x-show="kategoriFinal === '{{ $kategori }}'" class="text-[10px]">✓</span>
                    <span>{{ $kategori }}</span>
                </button>
            @endforeach
        </div>

        @if ($pengaduan->kategori_ai)
            <div class="mt-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                @if (str_contains(strtolower($pengaduan->alasan_ai), 'kata kunci') || str_contains(strtolower($pengaduan->alasan_ai), 'cadangan'))
                    <div class="mb-2 flex items-start gap-2 p-2.5 rounded-xl bg-amber-50 border border-amber-100 text-amber-800 text-[11px] leading-relaxed font-semibold">
                        <span class="material-symbols-outlined text-amber-600 text-sm leading-none">warning</span>
                        <span>Klasifikasi otomatis gagal (kuota harian API gratis Gemini Anda habis). Sistem menggunakan klasifikasi cadangan berbasis kata kunci lokal. Silakan lakukan triage manual jika diperlukan.</span>
                    </div>
                @endif
                <div class="flex items-center gap-1 text-slate-500 font-bold text-[10px] uppercase tracking-wider">
                    <span class="material-symbols-outlined text-sm">smart_toy</span>
                    <span>Saran Asisten AI</span>
                </div>
                <p class="text-xs font-bold text-slate-800">{{ $pengaduan->kategori_ai }}</p>
                @if ($pengaduan->alasan_ai)
                    <p class="text-[11px] text-slate-500 italic leading-relaxed">"{{ $pengaduan->alasan_ai }}"</p>
                @endif
            </div>
        @endif
    </div>

    {{-- Urgensi --}}
    <div class="space-y-2.5">
        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Tingkat Urgensi</label>
        <div class="grid grid-cols-3 gap-2">
            {{-- RENDAH --}}
            <button
                type="button"
                @click="pilihUrgensi('rendah')"
                :class="urgensiFinal === 'rendah'
                    ? 'bg-emerald-600 text-white border-emerald-700 font-bold shadow-sm'
                    : 'bg-slate-50 text-slate-600 border-slate-100 hover:bg-slate-100 font-semibold'"
                class="py-2.5 rounded-2xl border text-xs text-center transition-all duration-200"
            >
                Rendah
            </button>
            {{-- SEDANG --}}
            <button
                type="button"
                @click="pilihUrgensi('sedang')"
                :class="urgensiFinal === 'sedang'
                    ? 'bg-amber-500 text-white border-amber-600 font-bold shadow-sm'
                    : 'bg-slate-50 text-slate-600 border-slate-100 hover:bg-slate-100 font-semibold'"
                class="py-2.5 rounded-2xl border text-xs text-center transition-all duration-200"
            >
                Sedang
            </button>
            {{-- TINGGI --}}
            <button
                type="button"
                @click="pilihUrgensi('tinggi')"
                :class="urgensiFinal === 'tinggi'
                    ? 'bg-rose-600 text-white border-rose-700 font-bold shadow-sm'
                    : 'bg-slate-50 text-slate-600 border-slate-100 hover:bg-slate-100 font-semibold'"
                class="py-2.5 rounded-2xl border text-xs text-center transition-all duration-200"
            >
                Tinggi
            </button>
        </div>
    </div>

    {{-- AUTO-SAVE STATE --}}
    <div class="h-5 flex items-center justify-center">
        <p x-show="savedMessage" x-text="savedMessage" class="text-xs text-emerald-600 font-bold tracking-tight"></p>
    </div>

</div>

<script>
    function klasifikasiChip({ pengaduanId, kategoriFinal, urgensiFinal, updateUrl }) {
        return {
            kategoriFinal,
            urgensiFinal,
            savedMessage: '',

            async pilihKategori(kategori) {
                this.kategoriFinal = kategori;
                await this.save();
            },
            async pilihUrgensi(urgensi) {
                this.urgensiFinal = urgensi;
                await this.save();
            },
            async save() {
                try {
                    const res = await fetch(updateUrl, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            kategori_final: this.kategoriFinal,
                            urgensi_final: this.urgensiFinal,
                        }),
                    });
                    if (!res.ok) throw new Error('Gagal menyimpan');
                    this.savedMessage = '✓ Tersimpan otomatis';
                    setTimeout(() => (this.savedMessage = ''), 2000);
                } catch (e) {
                    this.savedMessage = '⚠️ Gagal menyimpan, silakan coba lagi';
                }
            },
        };
    }
</script>
