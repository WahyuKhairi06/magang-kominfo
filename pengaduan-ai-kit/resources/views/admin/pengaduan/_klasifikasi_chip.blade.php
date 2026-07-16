{{--
    Partial: Chip Selector Klasifikasi Pengaduan
    Include di halaman detail pengaduan admin, contoh:
        @include('admin.pengaduan._klasifikasi_chip', ['pengaduan' => $pengaduan])

    PENTING: Daftar kategori di bawah WAJIB SAMA PERSIS dengan
    ai-service/taxonomy.py (CATEGORIES) dan
    app/Http/Controllers/Admin/PengaduanController.php (kategoriOptions()).
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
    $urgensiOptions = ['rendah' => 'Rendah', 'sedang' => 'Sedang', 'tinggi' => 'Tinggi'];
@endphp

<div x-data="klasifikasiChip({
        pengaduanId: {{ $pengaduan->id }},
        kategoriFinal: '{{ $pengaduan->kategori_final }}',
        urgensiFinal: '{{ $pengaduan->urgensi_final }}',
        updateUrl: '{{ route('admin.pengaduan.klasifikasi.update', $pengaduan->id) }}',
    })" class="space-y-6">

    @if ($pengaduan->status_klasifikasi === 'pending')
        <div class="text-sm text-gray-500 flex items-center gap-2">
            <span class="animate-spin">⏳</span> Sedang diproses AI, mohon tunggu sebentar...
        </div>
    @elseif ($pengaduan->status_klasifikasi === 'gagal')
        <div class="text-sm text-amber-600">
            ⚠️ Klasifikasi otomatis gagal (kemungkinan kuota AI habis). Silakan pilih kategori & urgensi secara manual.
        </div>
    @endif

    {{-- Kategori --}}
    <div>
        <p class="font-medium mb-2">Kategori Pengaduan</p>
        <div class="flex flex-wrap gap-2">
            @foreach ($kategoriOptions as $kategori)
                <button
                    type="button"
                    @click="pilihKategori('{{ $kategori }}')"
                    :class="kategoriFinal === '{{ $kategori }}'
                        ? 'bg-green-600 text-white border-green-700'
                        : 'bg-gray-100 text-gray-500 border-gray-200'"
                    class="px-3 py-1.5 rounded-full border text-sm flex items-center gap-1 transition"
                >
                    <span x-show="kategoriFinal === '{{ $kategori }}'">✓</span>
                    {{ $kategori }}
                </button>
            @endforeach
        </div>

        @if ($pengaduan->kategori_ai)
            <p class="text-xs text-gray-500 mt-2">
                🤖 Disarankan AI: <strong>{{ $pengaduan->kategori_ai }}</strong>
                @if ($pengaduan->alasan_ai)
                    — "{{ $pengaduan->alasan_ai }}"
                @endif
            </p>
        @endif
    </div>

    {{-- Urgensi --}}
    <div>
        <p class="font-medium mb-2">Urgensi</p>
        <div class="flex gap-2">
            @foreach ($urgensiOptions as $value => $label)
                <button
                    type="button"
                    @click="pilihUrgensi('{{ $value }}')"
                    :class="urgensiFinal === '{{ $value }}'
                        ? 'bg-green-600 text-white border-green-700'
                        : 'bg-gray-100 text-gray-500 border-gray-200'"
                    class="px-4 py-1.5 rounded-full border text-sm transition"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    <p x-show="savedMessage" x-text="savedMessage" class="text-xs text-green-600"></p>
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
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            kategori_final: this.kategoriFinal,
                            urgensi_final: this.urgensiFinal,
                        }),
                    });
                    if (!res.ok) throw new Error('Gagal menyimpan');
                    this.savedMessage = 'Tersimpan otomatis.';
                    setTimeout(() => (this.savedMessage = ''), 2000);
                } catch (e) {
                    this.savedMessage = 'Gagal menyimpan, coba lagi.';
                }
            },
        };
    }
</script>
