@include('navbar')

<header class="pt-28 md:pt-32 pb-16 bg-secondary">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <span class="text-white/60 font-bold tracking-[0.14em] text-xs uppercase">Informasi Publik</span>
        <h1 class="font-serif text-4xl md:text-5xl text-white mt-3">Pusat Unduh Dokumen</h1>
        <p class="text-white/70 mt-4 max-w-xl mx-auto">SK, SOP, dan dokumen transparansi publik Puskesmas Marunggi.</p>
    </div>
</header>

<section class="max-w-5xl mx-auto px-6 -mt-8 relative z-10 pb-24">
    <div class="bg-white rounded-2xl shadow-lg border border-border p-6 md:p-8">

        <!-- SEARCH -->
        <div class="mb-6">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted">search</span>
                <input id="searchDoc" type="text" placeholder="Cari dokumen..."
                       class="w-full pl-12 pr-4 py-3 rounded-lg border border-border focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-surface text-secondary text-left text-sm">
                        <th class="w-12 px-4 py-3 text-center font-bold">No</th>
                        <th class="px-4 py-3 font-bold">Judul Dokumen</th>
                        <th class="px-4 py-3 font-bold hidden md:table-cell">Deskripsi</th>
                        <th class="w-32 px-4 py-3 text-center font-bold">Unduh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border text-sm">
                    @php $no = 1; @endphp
                    @forelse($dokumen as $item)
                        @if($item->is_active == 1)
                        <tr class="doc-row hover:bg-surface transition-colors" data-kategori="{{ $item->kategori }}">
                            <td class="px-4 py-4 text-center text-muted">{{ $no++ }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0
                                        @if($item->kategori == 'PDF') bg-red-50 text-red-600
                                        @elseif($item->kategori == 'DOCX') bg-blue-50 text-blue-600
                                        @elseif($item->kategori == 'XLSX') bg-green-50 text-green-600
                                        @else bg-surface text-muted
                                        @endif">
                                        <span class="material-symbols-outlined text-xl">
                                            @if($item->kategori == 'PDF') picture_as_pdf
                                            @elseif($item->kategori == 'DOCX') description
                                            @elseif($item->kategori == 'XLSX') table_chart
                                            @else description
                                            @endif
                                        </span>
                                    </div>
                                    <span class="font-semibold text-secondary">{{ $item->judul }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-muted hidden md:table-cell">{{ $item->deskripsi }}</td>
                            <td class="px-4 py-4 text-center">
                                <a href="{{ url('/download/'.$item->id) }}"
                                   class="inline-flex items-center gap-1.5 bg-primary text-white px-4 py-2 rounded-full text-xs font-semibold hover:bg-secondary transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">download</span> Unduh
                                </a>
                            </td>
                        </tr>
                        @endif
                    @empty
                        <tr><td colspan="4" class="px-4 py-10 text-center text-muted">Belum ada dokumen tersedia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

@include('footer')

<script>
document.getElementById('searchDoc').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll('.doc-row').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});
</script>
