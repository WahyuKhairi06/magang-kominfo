@include('navbar')

<style>
/* 🧱 MASONRY LAYOUT */
.masonry {
  column-count: 4;
  column-gap: 16px;
}

@media (max-width: 1024px) {
  .masonry { column-count: 3; }
}

@media (max-width: 768px) {
  .masonry { column-count: 2; }
}

@media (max-width: 480px) {
  .masonry { column-count: 1; }
}

.masonry-item {
  break-inside: avoid;
  margin-bottom: 16px;
}

/* ✨ IMAGE EFFECT */
.masonry-item img {
  transition: transform 0.4s ease;
}

.masonry-item:hover img {
  transform: scale(1.05);
}
</style>

<main class="pt-28 md:pt-32 min-h-screen">

<!-- HEADER -->
<header class="px-6 md:px-8 py-16 bg-secondary mb-10">
  <div class="max-w-7xl mx-auto text-center">
    <span class="text-white/60 font-bold tracking-[0.14em] text-xs uppercase">Visualisasi Data</span>
    <h1 class="font-serif text-3xl md:text-4xl text-white mt-2">Infografis</h1>
    <p class="text-white/70 mt-3 max-w-xl mx-auto">Informasi visual seputar program dan kegiatan Puskesmas Marunggi.</p>
  </div>
</header>
<!-- FILTER -->
<div class="max-w-7xl mx-auto px-6 mb-6">

<form method="GET" class="flex flex-wrap gap-3 items-center">

    <select name="pokja_id"
        class="border border-border px-4 py-2.5 rounded-full text-sm text-secondary focus:ring-2 focus:ring-primary focus:border-primary">

        <option value="">Semua Kategori</option>

        @foreach($pokja as $p)
            <option value="{{ $p->id }}"
                {{ request('pokja_id') == $p->id ? 'selected' : '' }}>
                {{ $p->nama_pokja }}
            </option>
        @endforeach

    </select>

    <button class="bg-primary text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-secondary transition-colors">
        Filter
    </button>

</form>

</div>
<!-- GRID -->
<section class="max-w-7xl mx-auto px-6 mb-24">

<div class="masonry">

@foreach($galeri as $index => $item)

<div class="masonry-item bg-white rounded-xl overflow-hidden border border-border hover:shadow-lg transition cursor-pointer"
     onclick="openLightbox({{ $index }})">

    <img src="{{ asset('storage/'.$item->foto) }}" class="w-full" alt="{{ $item->judul_kegiatan }}">

    <div class="p-3">
      <p class="text-xs text-primary font-semibold">
        {{ $item->nama_pokja }}
    </p>
        <h3 class="text-sm font-bold text-secondary line-clamp-1 mt-1">
            {{ $item->judul_kegiatan }}
        </h3>
        <p class="text-xs text-muted mt-1">
            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
        </p>
    </div>

</div>

@endforeach

</div>

</section>

<!-- LIGHTBOX -->
<div id="lightbox"
     class="fixed inset-0 bg-secondary/95 hidden items-center justify-center z-50">

    <!-- CLOSE -->
    <button onclick="closeLightbox()"
        class="absolute top-5 right-5 text-white text-3xl">✕</button>

    <!-- IMAGE -->
    <img id="lightboxImg"
         class="max-w-[90%] max-h-[85vh] rounded-xl shadow-2xl">

    <!-- NAV -->
    <button onclick="prevImage()"
        class="absolute left-5 text-white text-4xl">‹</button>

    <button onclick="nextImage()"
        class="absolute right-5 text-white text-4xl">›</button>

</div>

</main>

@include('footer')

<script>
/* 📦 DATA IMAGE */
let images = @json($galeri->pluck('foto'));
let currentIndex = 0;

/* 🔥 OPEN LIGHTBOX */
function openLightbox(index) {
    currentIndex = index;
    document.getElementById('lightbox').classList.remove('hidden');
    document.getElementById('lightbox').classList.add('flex');
    showImage();
}

/* 🖼 SHOW IMAGE */
function showImage() {
    document.getElementById('lightboxImg').src = "/storage/" + images[currentIndex];
}

/* ❌ CLOSE */
function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.getElementById('lightbox').classList.remove('flex');
}

/* ➡ NEXT */
function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    showImage();
}

/* ⬅ PREV */
function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    showImage();
}

/* 📱 SWIPE SUPPORT */
let startX = 0;

document.getElementById('lightbox').addEventListener('touchstart', e => {
    startX = e.touches[0].clientX;
});

document.getElementById('lightbox').addEventListener('touchend', e => {
    let endX = e.changedTouches[0].clientX;

    if (startX - endX > 50) nextImage();
    if (endX - startX > 50) prevImage();
});
</script>