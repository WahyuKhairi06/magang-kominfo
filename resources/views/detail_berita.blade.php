@include('navbar')

<main class="pt-24 pb-12 px-6 max-w-7xl mx-auto">
<!-- Breadcrumb -->
<nav class="flex items-center space-x-3 text-sm font-medium mb-12 text-on-surface-variant">
<a class="hover:text-primary transition-colors" href="#">Beranda</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<a class="hover:text-primary transition-colors" href="#">Berita</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<span class="text-primary truncate max-w-[200px] md:max-w-none">{{ $beritas->judul }}</span>
</nav>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
<!-- Article Canvas -->
<article class="lg:col-span-8">
<!-- Header Section -->
<header class="mb-10">
<div class="inline-flex items-center px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-xs font-bold uppercase tracking-wider mb-6">
                        {{ $beritas->kategori }}
                    </div>
<h1 class="text-4xl md:text-5xl font-extrabold text-primary leading-[1.1] tracking-tight mb-8">
 {{ $beritas->judul }}
</h1>
<div class="flex flex-wrap items-center gap-6 text-on-surface-variant border-y border-outline-variant/20 py-6">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-secondary">calendar_today</span>
<span class="text-sm">{{$beritas->tanggal_publish}}</span>
</div>
<div class="flex items-center gap-2 border-l border-outline-variant/30 pl-6">
<span class="material-symbols-outlined text-secondary">person</span>
<span class="text-sm">Pokja IV Pariaman</span>
</div>
<div class="flex items-center gap-2 border-l border-outline-variant/30 pl-6">
<span class="material-symbols-outlined text-secondary">visibility</span>
<span class="text-sm">{{ $beritas->views }} Dilihat</span>
</div>
</div>
</header>
<!-- Featured Image Card -->
<div class="relative rounded-3xl overflow-hidden mb-12 shadow-2xl shadow-primary/5">
<img alt="Ketahanan Pangan" class="w-full h-[500px] object-cover" data-alt="lush organic vegetable garden in a suburban backyard with vibrant green spinach and tomatoes in warm morning sunlight" src="{{ asset('storage/' .$beritas->gambar) }}"/>
<div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-8">
<p class="text-white/90 text-sm italic">Foto: {{ $beritas->judul }}</p>
</div>
</div>
<!-- Content Body -->
<div class="content-body text-lg">
{!! $beritas->isi !!}
</div>
<!-- Sharing Section -->
<div class="mt-16 pt-8 border-t border-outline-variant/30 flex flex-col md:flex-row md:items-center justify-between gap-6">
<div class="flex items-center gap-4">
<span class="text-sm font-bold text-primary tracking-widest uppercase">Bagikan:</span>
<div class="flex gap-2">
<button class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all">
<span class="material-symbols-outlined text-[18px]">share</span>
</button>
<button class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all">
<span class="material-symbols-outlined text-[18px]">social_leaderboard</span>
</button>
<button class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all">
<span class="material-symbols-outlined text-[18px]">link</span>
</button>
</div>
</div>
<div class="flex flex-wrap gap-2">
<span class="px-3 py-1 bg-surface-container text-on-surface-variant text-xs rounded-lg">#KetahananPangan</span>
<span class="px-3 py-1 bg-surface-container text-on-surface-variant text-xs rounded-lg">#PariamanHebat</span>
<span class="px-3 py-1 bg-surface-container text-on-surface-variant text-xs rounded-lg">#PKKIndonesa</span>
</div>
</div>
</article>
<!-- Sidebar -->
<aside class="lg:col-span-4 space-y-12">
<!-- Popular News -->
<div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm border border-outline-variant/10">
<h3 class="text-xl font-bold text-primary mb-6 flex items-center gap-2">
<span class="material-symbols-outlined">trending_up</span>
                        Berita Terpopuler
                    </h3>
<div class="space-y-6">
    @foreach ($berita_populer as $populer )
        
<a class="group flex gap-4" href="#">
<div class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden bg-surface-container">
<img alt="Posyandu" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" data-alt="healthcare professional examining a baby in a clean clinic setting with soft focus background" src="{{ asset('storage/' . $populer->gambar) }}"/>
</div>
<div class="flex-1">
<h4 class="text-sm font-bold leading-snug group-hover:text-secondary transition-colors line-clamp-2">{{ $populer->judul }}</h4>
<span class="text-[11px] text-on-surface-variant uppercase tracking-tighter">{{ $populer->created_at }}</span>
</div>
</a>

    @endforeach

</div>
</div>
<!-- Categories -->
<div class="bg-primary-container text-on-primary rounded-3xl p-8 shadow-sm relative overflow-hidden">
<div class="absolute -right-8 -top-8 w-32 h-32 bg-primary/20 rounded-full blur-3xl"></div>
<h3 class="text-xl font-bold mb-6 relative z-10">Kategori Berita</h3>
<ul class="space-y-2 relative z-10">
 @foreach($kategoris_berita as $kat)
    <li>
      <a class="flex justify-between items-center py-2 px-4 rounded-xl hover:bg-white/10 transition-colors"
         href="#">

        <span>{{ $kat->nama }}</span>

        <span class="bg-white/20 px-2 py-0.5 rounded text-xs">
          {{ $kat->total }}
        </span>

      </a>
    </li>
    @endforeach
</ul>
</div>
<!-- Newsletter / CTA -->

</aside>
</div>
<!-- Related News Section -->
<section class="mt-24">
<div class="flex items-end justify-between mb-10">
<div>
<span class="text-xs font-bold text-secondary uppercase tracking-[0.2em] block mb-2">Artikel Lainnya</span>
<h2 class="text-3xl font-black text-primary">Berita Terkait</h2>
</div>
<a class="text-primary font-bold flex items-center gap-2 hover:translate-x-2 transition-transform" href="#">
                    Lihat Semua Berita <span class="material-symbols-outlined">arrow_forward</span>
</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<!-- Related Card 1 -->
@foreach($beritas_isi as $item)

<div class="bg-white rounded-3xl overflow-hidden group shadow-sm hover:shadow-xl transition-all duration-500">

  <!-- IMAGE -->
  <div class="relative h-48 overflow-hidden">

    <img
      src="{{ asset('storage/' . $item->gambar) }}"
      class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
    >

    <!-- KATEGORI -->
    <div class="absolute top-4 left-4">
      <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-[10px] font-bold text-primary uppercase">
        {{ $item->kategori ?? 'Umum' }}
      </span>
    </div>

  </div>

  <!-- CONTENT -->
  <div class="p-6">

    <!-- TITLE -->
    <h3 class="font-bold text-primary text-lg leading-snug group-hover:text-secondary transition-colors mb-3">
      {{ $item->judul }}
    </h3>

    <!-- DESKRIPSI -->
    <p class="text-sm text-on-surface-variant line-clamp-2 mb-4">
      {{ $item->deskripsi ?? Str::limit(strip_tags($item->isi), 120) }}
    </p>

    <!-- DATE -->
    <div class="text-xs font-medium text-on-surface-variant/60">
      {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
    </div>

  </div>

</div>

@endforeach

</div>
</section>
</main>
@include('footer')