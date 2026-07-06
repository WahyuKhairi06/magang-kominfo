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
<header class="bg-gradient-to-r from-emerald-700 to-teal-600 text-white py-5">
    <div class="max-w-5xl mx-auto px-6">

        <p class="uppercase tracking-widest text-sm opacity-80">
            Inovasi Puskesmas
        </p>

        <h1 class="text-2xl md:text-3xl font-bold mt-3">
            {{ $inovasi->judul_inovasi }}
        </h1>

    </div>
</header>
<!-- FILTER -->
<div class="max-w-7xl mx-auto px-6 mb-6">



</div>
<!-- GRID -->
<section class="max-w-2xl mx-auto px-6 mb-24">

    @php
        $ext = strtolower(pathinfo($inovasi->foto, PATHINFO_EXTENSION));
    @endphp

    {{-- FOTO (HANYA JIKA GAMBAR) --}}
    @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
        <div class="flex justify-center -mt-12">
    <img
        src="{{ asset('storage/'.$inovasi->foto) }}"
        class="w-96 h-auto rounded-3xl shadow-2xl object-cover">
</div>
    @endif    


    {{-- DESKRIPSI --}}
    <div class="max-w-5xl mx-auto px-6 py-14">

        <div class="bg-white rounded-3xl shadow-lg p-10">

            <h2 class="text-2xl font-bold text-emerald-700 mb-6">
                Deskripsi Inovasi
            </h2>

            <div class="prose max-w-none leading-8 text-gray-700">

                {!! nl2br(e($inovasi->deskripsi_inovasi)) !!}

            </div>

        </div>

    </div>
    {{-- MANUAL BOOK PDF --}}
    @if(!empty($inovasi->manual_book))
    @php
        $manualExt = strtolower(pathinfo($inovasi->manual_book, PATHINFO_EXTENSION));
    @endphp

    @if($manualExt == 'pdf')
        <div class="max-w-5xl mx-auto mt-1">
            <h2 class="text-2xl font-bold text-emerald-700 mb-6">
                Manual Book
            </h2>
            <iframe
                src="{{ asset('storage/'.$inovasi->manual_book) }}"
                class="w-full h-[500px] rounded-2xl shadow-2xl border">
            </iframe>
        </div>
    @endif
    @endif

    {{-- KAK PDF --}}
    @if(!empty($inovasi->kak))
    @php
        $manualExt = strtolower(pathinfo($inovasi->kak, PATHINFO_EXTENSION));
    @endphp

    @if($manualExt == 'pdf')
        <div class="max-w-5xl mx-auto mt-1">
            <h2 class="text-2xl font-bold text-emerald-700 mb-6">
                KAK
            </h2>
            <iframe
                src="{{ asset('storage/'.$inovasi->kak) }}"
                class="w-full h-[500px] rounded-2xl shadow-2xl border">
            </iframe>
        </div>
    @endif
    @endif

    {{-- SOP PDF --}}
    @if(!empty($inovasi->sop))
    @php
        $manualExt = strtolower(pathinfo($inovasi->sop, PATHINFO_EXTENSION));
    @endphp

    @if($manualExt == 'pdf')
        <div class="max-w-5xl mx-auto mt-1">
            <h2 class="text-2xl font-bold text-emerald-700 mb-6">
                SOP
            </h2>
            <iframe
                src="{{ asset('storage/'.$inovasi->sop) }}"
                class="w-full h-[500px] rounded-2xl shadow-2xl border">
            </iframe>
        </div>
    @endif
    @endif

    {{-- MAKALAH PDF --}}
    @if(!empty($inovasi->makalah))
    @php
        $manualExt = strtolower(pathinfo($inovasi->makalah, PATHINFO_EXTENSION));
    @endphp

    @if($manualExt == 'pdf')
        <div class="max-w-5xl mx-auto mt-1">
            <h2 class="text-2xl font-bold text-emerald-700 mb-6">
                MAKALAH
            </h2>
            <iframe
                src="{{ asset('storage/'.$inovasi->makalah) }}"
                class="w-full h-[500px] rounded-2xl shadow-2xl border">
            </iframe>
        </div>
    @endif
    @endif
    

    {{-- LINK VIDEO --}}
    @if(!empty($inovasi->linkvideo))
    <div class="max-w-5xl mx-auto mt-8">
    <h2 class="text-2xl font-bold text-emerald-700 mb-3">
        Link Video
    </h2>

    <a href="{{ $inovasi->linkvideo }}"
       target="_blank"
       class="text-blue-600 hover:text-blue-800 underline break-all">
        {{ $inovasi->linkvideo }}
    </a>
    </div>
    @endif

    {{-- SK PDF --}}
    @if(!empty($inovasi->sk))
    @php
        $manualExt = strtolower(pathinfo($inovasi->sk, PATHINFO_EXTENSION));
    @endphp

    @if($manualExt == 'pdf')
        <div class="max-w-5xl mx-auto mt-1">
            <h2 class="text-2xl font-bold text-emerald-700 mb-6">
                SK/DPA/RKPD
            </h2>
            <iframe
                src="{{ asset('storage/'.$inovasi->sk) }}"
                class="w-full h-[500px] rounded-2xl shadow-2xl border">
            </iframe>
        </div>
    @endif
    @endif

    {{-- DOKUMEN LAIN --}}
    @if(!empty($inovasi->dokumen_lain))
    @php
        $manualExt = strtolower(pathinfo($inovasi->dokumen_lain, PATHINFO_EXTENSION));
    @endphp

    @if($manualExt == 'pdf')
        <div class="max-w-5xl mx-auto mt-1">
            <h2 class="text-2xl font-bold text-emerald-700 mb-6">
                Dokumen Lainnya
            </h2>
            <iframe
                src="{{ asset('storage/'.$inovasi->dokumen_lain) }}"
                class="w-full h-[500px] rounded-2xl shadow-2xl border">
            </iframe>
        </div>
    @endif
    @endif

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