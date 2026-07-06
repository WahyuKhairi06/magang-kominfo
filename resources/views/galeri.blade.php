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

<main class="pt-24 min-h-screen">

<!-- HEADER -->
<header class="px-8 py-16 bg-primary-container mb-10">
  <div class="max-w-7xl mx-auto">
    <h1 class="text-4xl font-bold text-on-primary">Galeri Kegiatan</h1>
    <p class="text-on-primary-container/80 mt-2">Dokumentasi kegiatan PKK</p>
  </div>
</header>
<!-- FILTER -->
<div class="max-w-7xl mx-auto px-6 mb-6">

<form method="GET" class="flex flex-wrap gap-3 items-center">

    <select name="pokja_id"
        class="border px-4 py-2 rounded-lg focus:ring-2 focus:ring-primary">

        <option value="">Semua Kategori</option>

        @foreach($pokja as $p)
            <option value="{{ $p->id }}"
                {{ request('pokja_id') == $p->id ? 'selected' : '' }}>
                {{ $p->nama_pokja }}
            </option>
        @endforeach

    </select>

    <button class="bg-primary text-white px-4 py-2 rounded-lg">
        Filter
    </button>

</form>

</div>
<!-- GRID -->
<section class="max-w-7xl mx-auto px-6 mb-24">

<div class="masonry">

@foreach($galeri as $index => $item)

<div class="masonry-item bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition cursor-pointer"
     onclick="openLightbox({{ $index }})">

    <img src="{{ asset('storage/'.$item->foto) }}" class="w-full">

    <div class="p-3">
      <p class="text-xs text-primary font-semibold">
        {{ $item->nama_pokja }}
    </p>
        <h3 class="text-sm font-bold text-emerald-900 line-clamp-1">
            {{ $item->judul_kegiatan }}
        </h3>
        <p class="text-xs text-gray-500">
            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
        </p>
    </div>

</div>

@endforeach

</div>

</section>

<!-- LIGHTBOX -->
<div id="lightbox"
     class="fixed inset-0 bg-black/95 hidden items-center justify-center z-50">

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