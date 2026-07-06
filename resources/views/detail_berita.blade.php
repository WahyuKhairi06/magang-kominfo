@include('navbar')

<main class="pt-28 md:pt-32 pb-20 px-6 max-w-7xl mx-auto">

    <!-- Breadcrumb -->
    <nav class="flex items-center flex-wrap gap-2 text-sm font-medium mb-10 text-muted">
        <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Beranda</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ url('landing/berita') }}">Berita</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-secondary truncate max-w-[200px] md:max-w-none">{{ $beritas->judul }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Article -->
        <article class="lg:col-span-8">
            <header class="mb-10">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-surface text-secondary text-xs font-bold uppercase tracking-wider mb-6">
                    {{ $beritas->kategori }}
                </span>
                <h1 class="font-serif text-3xl md:text-5xl text-secondary leading-[1.1] tracking-tight mb-8">
                    {{ $beritas->judul }}
                </h1>
                <div class="flex flex-wrap items-center gap-6 text-muted border-y border-border py-6">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">calendar_today</span>
                        <span class="text-sm">{{ \Carbon\Carbon::parse($beritas->tanggal_publish)->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 border-l border-border pl-6">
                        <span class="material-symbols-outlined text-primary text-lg">person</span>
                        <span class="text-sm">Puskesmas Marunggi</span>
                    </div>
                    <div class="flex items-center gap-2 border-l border-border pl-6">
                        <span class="material-symbols-outlined text-primary text-lg">visibility</span>
                        <span class="text-sm">{{ $beritas->views }} Dilihat</span>
                    </div>
                </div>
            </header>

            <div class="relative rounded-2xl overflow-hidden mb-12 shadow-lg">
                <img alt="{{ $beritas->judul }}" class="w-full h-[420px] md:h-[500px] object-cover" src="{{ asset('storage/' .$beritas->gambar) }}">
            </div>

            <div class="content-body prose prose-lg max-w-none text-on-surface">
                {!! $beritas->isi !!}
            </div>

            <div class="mt-16 pt-8 border-t border-border flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <span class="text-sm font-bold text-secondary tracking-widest uppercase">Bagikan:</span>
                    <div class="flex gap-2">
                        <button class="w-10 h-10 rounded-full bg-surface flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[18px]">share</span>
                        </button>
                        <button class="w-10 h-10 rounded-full bg-surface flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[18px]">link</span>
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <!-- Sidebar -->
        <aside class="lg:col-span-4 space-y-10">
            <div class="bg-white rounded-2xl p-7 border border-border">
                <h3 class="text-lg font-bold text-secondary mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">trending_up</span>
                    Berita Terpopuler
                </h3>
                <div class="space-y-5">
                    @foreach ($berita_populer as $populer )
                    <a class="group flex gap-4" href="{{ url('landing/berita/'.encrypt($populer->id)) }}">
                        <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-surface">
                            <img alt="{{ $populer->judul }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" src="{{ asset('storage/' . $populer->gambar) }}">
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-secondary leading-snug group-hover:text-primary transition-colors line-clamp-2">{{ $populer->judul }}</h4>
                            <span class="text-[11px] text-muted uppercase tracking-tight">{{ \Carbon\Carbon::parse($populer->created_at)->format('d M Y') }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="bg-secondary text-white rounded-2xl p-7">
                <h3 class="text-lg font-bold mb-5">Kategori Berita</h3>
                <ul class="space-y-1">
                    @foreach($kategoris_berita as $kat)
                    <li>
                        <a class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-white/10 transition-colors" href="#">
                            <span class="text-sm">{{ $kat->nama }}</span>
                            <span class="bg-white/15 px-2 py-0.5 rounded text-xs">{{ $kat->total }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>

    <!-- Related -->
    @if(count($beritas_isi))
    <section class="mt-24">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-xs font-bold text-primary uppercase tracking-[0.14em] block mb-2">Artikel Lainnya</span>
                <h2 class="font-serif text-2xl md:text-3xl text-secondary">Berita Terkait</h2>
            </div>
            <a class="text-primary font-semibold flex items-center gap-2 hover:gap-3 transition-all" href="{{ url('landing/berita') }}">
                Lihat Semua <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($beritas_isi as $item)
            <a href="{{ url('landing/berita/'.encrypt($item->id)) }}" class="bg-white rounded-2xl overflow-hidden group border border-border hover:shadow-lg transition-all duration-300">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ $item->judul }}">
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-[10px] font-bold text-secondary uppercase">
                        {{ $item->kategori ?? 'Umum' }}
                    </span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-secondary text-lg leading-snug group-hover:text-primary transition-colors mb-2 line-clamp-2">{{ $item->judul }}</h3>
                    <p class="text-sm text-muted line-clamp-2 mb-3">{{ $item->deskripsi ?? Str::limit(strip_tags($item->isi), 110) }}</p>
                    <div class="text-xs font-medium text-muted/70">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
</main>

@include('footer')
