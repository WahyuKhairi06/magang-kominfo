
@include('navbar')
<style>
/* background zoom effect */
.bgSwiper .swiper-slide img {
    transform: scale(1);
    transition: transform 6s ease;
}

.bgSwiper .swiper-slide-active img {
    transform: scale(1.1);
}
</style>
<style id="bookstyle01">
.heroSwiper {
    padding-top: 40px;
    padding-bottom: 40px;
}

.heroSwiper .swiper-slide {
    width: 300px;
    height: 380px;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s ease;
}

/* efek kartu */
.heroSwiper .swiper-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* bayangan biar “ngangkat” */
.heroSwiper .swiper-slide {
    box-shadow: 0 15px 40px rgba(0,0,0,0.4);
}

/* aktif (tengah) */
.heroSwiper .swiper-slide-active {
    transform: scale(1.1);
}
</style>
<style>
.heroSwiper {
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* background zoom effect */
.bgSwiper .swiper-slide img {
    transform: scale(1);
    transition: transform 6s ease;
}

.bgSwiper .swiper-slide-active img {
    transform: scale(1.1);
}
</style>
<!-- Hero Section -->
{{-- <section class="hero-section relative min-h-screen flex items-center pt-20 overflow-hidden">

    <!-- 🔥 BACKGROUND SLIDER -->
    <div class="absolute inset-0 z-0">
        <div class="swiper bgSwiper w-full h-full">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                <div class="swiper-slide">
                    <img src="{{ asset('storage/' . $slider->gambar) }}"
                        class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
        </div>

        <!-- overlay -->
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <!-- CONTENT -->
    <div class="relative w-full max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center z-10">
        <div class="relative w-full max-w-7xl mx-auto px-6 flex flex-col lg:flex-row justify-center items-center z-10 min-h-[70vh] text-center lg:text-left">

        <!-- TEXT -->
        <div class="text-white space-y-6">

            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-sm">
                <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                SIAP MELAYANI MASYARAKAT DENGAN C.I.N.T.A
            </div>

            <h1 class="text-5xl md:text-7xl font-bold leading-tight">
                <span id="typing-title"></span>
            </h1>

            <p class="text-lg text-white/80 max-w-xl">
                <span id="typing-desc"></span>
            </p>

            <div class="flex gap-4">
                <button class="bg-yellow-400 text-black px-6 py-3 rounded-xl font-bold">
                    Jelajahi Program
                </button>
                <button class="bg-white/10 border border-white/30 px-6 py-3 rounded-xl">
                    Struktur Organisasi
                </button>
            </div>

        </div>

        <!-- 🔥 SLIDER KECIL (KANAN, TIDAK MEPEt) -->
       <!-- SLIDER KECIL (KANAN, FLOATING ENAK DILIHAT) -->
<!-- <div class="hidden lg:flex lg:absolute lg:right-2 lg:top-[58%] lg:-translate-y-1/6 z-20">

    <div class="p-3 bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 shadow-2xl">
        <div class="swiper heroSwiper w-[320px] xl:w-[360px] rounded-3xl overflow-hidden">

            <div class="swiper-wrapper">
                foreach ($sliders as $slider)
                <div class="swiper-slide relative">
                    <img src=" asset('storage/' . $slider->gambar) }}"
                        class="w-full h-[360px] object-cover">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>

                    <div class="absolute bottom-5 left-5 text-white">
                        <p class="text-sm text-yellow-400">$slider->judul }}</p>
                        <h3 class="font-bold text-lg">{$slider->sub_judul }}</h3>
                    </div>
                </div>
                endforeach
            </div>

            <div class="swiper-pagination"></div>
        </div>

    </div>
</div> -->

    </div>
</section> --}}


<section class="hero-section relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- BACKGROUND SLIDER -->
    <div class="absolute inset-0 z-0">
        <div class="swiper bgSwiper w-full h-full">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                <div class="swiper-slide">
                    <img src="{{ asset('storage/' . $slider->gambar) }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
        </div>
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <!-- CONTENT HERO -->
    <div class="relative z-10 w-full max-w-4xl px-6 flex flex-col items-center text-center space-y-6">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-sm">
            <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
            SIAP MELAYANI MASYARAKAT DENGAN C.I.N.T.A
        </div>

        <h1 class="text-5xl md:text-7xl font-bold leading-tight">
            <span id="typing-title"></span>
        </h1>

        <p class="text-lg text-white/80 max-w-xl">
            <span id="typing-desc"></span>
        </p>

        <!-- BUTTONS tetap di bawah teks -->
        <!-- <div class="flex gap-4 mt-6">
            <button class="bg-yellow-400 text-black px-6 py-3 rounded-xl font-bold">
                Jelajahi Program
            </button>
            <button class="bg-white/10 border border-white/30 px-6 py-3 rounded-xl">
                Struktur Organisasi
            </button>
        </div> -->
    </div>
</section>
<!-- Sambutan Ketua -->
<section class="py-24 bg-surface scroll-section overflow-hidden">
<div class="max-w-7xl mx-auto px-6">
<div class="grid md:grid-cols-12 gap-16 items-center">
<div class="md:col-span-5 relative animate-on-scroll" data-animation="fade-right">
<div class="aspect-[3/4] rounded-3xl overflow-hidden shadow-xl parallax-container">
<img alt="Ketua PKK Kota Pariaman" class="w-full h-full object-cover parallax-img"
src="{{ $sambutan && $sambutan->foto 
            ? asset('storage/'.$sambutan->foto) 
            : asset('no-image.png') }}"
/>
</div>
<div class="absolute -bottom-6 -right-6 bg-secondary-fixed p-8 rounded-2xl shadow-xl max-w-[240px] z-20">
<p class="text-on-secondary-fixed font-bold text-lg leading-tight">{{$sambutan->motto ?? '-'}}</p>
</div>
</div>
<div class="md:col-span-7 space-y-8 animate-on-scroll" data-animation="fade-left">
<div class="space-y-4">
<span class="text-secondary font-bold tracking-widest text-sm uppercase">Kata Sambutan</span>
<h2 class="text-4xl font-bold text-primary">Direktur</h2>
</div>
<div class="prose prose-lg text-on-surface-variant leading-relaxed space-y-4">
{{ $sambutan->isi ?? '-'}}
</div>
<div class="pt-4 border-t border-outline-variant flex items-center gap-4">
<div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
<span class="material-symbols-outlined">signature</span>
</div>
<div>
<p class="font-bold text-primary">{{ $sambutan->nama ?? '-'}}</p>
<p class="text-sm text-on-surface-variant">Direktur</p>
</div>
</div>
</div>
</div>
</div>
</section>


@php
use Carbon\Carbon;

// mapping agenda berdasarkan tanggal
$agendaMap = [];
foreach ($agendas as $a) {
    $agendaMap[$a->tanggal][] = $a;
}

// bulan sekarang
$month = Carbon::now()->month;
$year = Carbon::now()->year;

// jumlah hari di bulan ini
$totalDays = Carbon::create($year, $month)->daysInMonth;
@endphp

<main class="pt-20">

<!-- HERO -->
<section class="relative h-[100px] flex items-center">

    <!-- WRAPPER biar ada jarak -->
    <div class="w-full pl-[60px] md:pl-16">

        <!-- BACKGROUND -->
        <div class="relative h-full bg-gradient-to-r from-primary to-primary-container/80
                    rounded-l-[60px] overflow-hidden">

            <div class="absolute inset-0"></div>

            <!-- CONTENT -->
            <div class="container mx-auto px-6 relative z-10 h-full flex items-center">
                <h1 class="text-4xl font-bold text-white">
                    Agenda Kegiatan
                </h1>
            </div>

        </div>

    </div>

</section>

<!-- CONTENT -->
<section class="container mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-12 gap-8">

<!-- LEFT: CALENDAR -->
<div class="lg:col-span-7 bg-white p-6 rounded-2xl shadow">

    <div class="flex justify-between mb-6">
        <h2 class="text-xl font-bold">
            {{ Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}
        </h2>
    </div>

    <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold mb-2">
        <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
    </div>

    <div class="grid grid-cols-7 gap-2">

        @for($i = 1; $i <= $totalDays; $i++)
            @php
                $date = sprintf('%04d-%02d-%02d', $year, $month, $i);
                $hasAgenda = isset($agendaMap[$date]);
            @endphp

            <div
                onclick="openAgenda('{{ $date }}')"
                class="h-20 border rounded-lg p-2 cursor-pointer transition
                {{ $hasAgenda ? 'bg-green-100 border-green-500' : 'bg-white hover:bg-gray-50' }}"
            >
                <div class="font-bold">{{ $i }}</div>

                @if($hasAgenda)
                    <div class="text-[10px] text-green-700">
                        {{ count($agendaMap[$date]) }} agenda
                    </div>
                @endif
            </div>
        @endfor

    </div>
</div>

<!-- RIGHT: ALL AGENDA -->
<div class="lg:col-span-5 bg-white p-6 rounded-2xl shadow">

    <h2 class="text-xl font-bold mb-4">Semua Agenda</h2>

    <div class="space-y-4 max-h-[600px] overflow-y-auto">

        @foreach($agendas as $a)
        <div class="border rounded-xl p-4 hover:shadow cursor-pointer"
             onclick="openAgenda('{{ $a->tanggal }}')">

            <div class="flex justify-between">
                <div class="font-bold">{{ $a->judul_agenda }}</div>
                <div class="text-xs text-gray-500">{{ $a->tanggal }}</div>
            </div>

            <div class="text-sm text-gray-500">{{ $a->lokasi }}</div>
            <div class="text-xs text-blue-600 mt-1">
                {{ $a->jam_mulai }} - {{ $a->jam_selesai }}
            </div>

        </div>
        @endforeach

    </div>

</div>

</section>

</main>

<!-- MODAL -->
<div id="agendaModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-[90%] max-w-lg rounded-xl p-6 relative">

        <button onclick="closeModal()" class="absolute right-3 top-3 text-xl">×</button>

        <h2 class="text-xl font-bold mb-4">Detail Agenda</h2>

        <div id="agendaContent" class="space-y-3"></div>

    </div>
</div>

<script>
const agendaData = @json($agendaMap);

function openAgenda(date){
    let modal = document.getElementById('agendaModal');
    let content = document.getElementById('agendaContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    let data = agendaData[date];

    if(!data){
        content.innerHTML = `<p class="text-gray-500">Tidak ada agenda</p>`;
        return;
    }

    let html = '';

    data.forEach(a => {
        html += `
        <div class="p-4 border rounded-lg">
            <div class="font-bold">${a.judul_agenda}</div>
            <div class="text-sm text-gray-500">${a.lokasi}</div>
            <div class="text-xs mt-1">${a.deskripsi}</div>
            <div class="text-xs text-blue-600 mt-2">
                ${a.jam_mulai} - ${a.jam_selesai}
            </div>
        </div>`;
    });

    content.innerHTML = html;
}

function closeModal(){
    document.getElementById('agendaModal').classList.add('hidden');
}
</script>

<!-- Highlight Kegiatan (Bento Grid) -->
<section class="py-24 bg-surface-container-low scroll-section">
<div class="max-w-7xl mx-auto px-6">
<div class="flex justify-between items-end mb-12 animate-on-scroll" data-animation="fade-up">
<div class="space-y-2">
<span class="text-secondary font-bold tracking-widest text-sm uppercase">Program Unggulan</span>
<h2 class="text-4xl font-bold text-primary">Aksi &amp; Kontribusi Nyata</h2>
</div>
<!-- <button class="text-primary font-semibold flex items-center gap-2 group">
                Semua Kegiatan <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
</button> -->
</div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        
<!-- <div class="md:col-span-2 md:row-span-2 relative group rounded-3xl overflow-hidden h-[500px] animate-on-scroll parallax-container" data-animation="zoom-in" data-delay="0">
<img alt="Revitalisasi Posyandu" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 parallax-img" 
{{-- src="{{ $galeris->foto ? asset('storage/'.$galeris->foto) : asset('no-image.png') }}" --}}
{{ $galeris && $galeris->foto 
            ? asset('storage/'.$galeris->foto) 
            : asset('no-image.png') }}"
/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent"></div>
<div class="absolute bottom-0 p-8 text-white z-20">
<div class="bg-secondary px-3 py-1 rounded-full text-xs font-bold inline-block mb-3">{{ $galeris->lokasi ?? '-' }}</div>
<h3 class="text-2xl font-bold mb-2">{{ $galeris->judul_kegiatan ?? '-'}}</h3>
<p class="text-white/80 line-clamp-2">{{ $galeris->deskripsi ?? '-'}}</p>
</div>
</div>  -->

@foreach ($galeris_double as $galer)
    
<div class="relative group rounded-3xl overflow-hidden h-[240px] animate-on-scroll parallax-container" data-animation="zoom-in" data-delay="0.2">
<img alt="HATINYA PKK" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 parallax-img" src="{{ asset('storage/'. $galer->foto) }}"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/90 to-transparent"></div>
<div class="absolute bottom-0 p-6 text-white z-20">
<h3 class="font-bold">{{ $galer->judul_kegiatan }}</h3>
</div>
</div>
@endforeach

</div>
</div>
</section>

@include('pokja_tab')
<!-- Data & Dasawisma Dashboard -->
<!-- <section class="py-24 bg-green-700 overflow-hidden relative scroll-section">
    
    <div class="parallax-element absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-12 transform translate-x-1/2"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        
        <div class="text-center mb-16 space-y-4">
            <h2 class="text-4xl font-bold text-white tracking-tight">
                Statistik Dasawisma Kota Pariaman
            </h2>
            <p class="text-white/70 max-w-2xl mx-auto">
                Data real-time cakupan pemberdayaan dan kesejahteraan keluarga di seluruh wilayah Kota Pariaman.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8"> -->

            <!-- CARD 1 -->
            <!-- <div class="stat-card bg-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/10 transition-all opacity-0">
                <div class="flex justify-between items-start mb-6">
                    <div class="p-3 rounded-2xl bg-yellow-400 text-black">
                        <span class="material-symbols-outlined">groups</span>
                    </div>
                    <span class="text-white/40 text-xs uppercase">Update 2024</span>
                </div>

                <h4 class="text-white/60 mb-1">Total Kelompok Dasawisma</h4>
                <div class="text-5xl font-bold text-white mb-4">1,248</div>

                <div class="w-full bg-white/10 h-1.5 rounded-full">
                    <div class="bg-yellow-400 h-full w-[85%]"></div>
                </div>

                <p class="text-white/40 text-sm mt-4">+12% Dari tahun lalu</p>
            </div> -->

            <!-- CARD 2 -->
            <!-- <div class="stat-card bg-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/10 transition-all opacity-0">
                <div class="flex justify-between items-start mb-6">
                    <div class="p-3 rounded-2xl bg-blue-400 text-black">
                        <span class="material-symbols-outlined">family_restroom</span>
                    </div>
                    <span class="text-white/40 text-xs uppercase">Data Keluarga</span>
                </div>

                <h4 class="text-white/60 mb-1">Keluarga Binaan</h4>
                <div class="text-5xl font-bold text-white mb-4">18,540</div>

                <div class="flex gap-1 items-end h-12">
                    <div class="flex-1 bg-blue-400/30 h-4"></div>
                    <div class="flex-1 bg-blue-400/50 h-8"></div>
                    <div class="flex-1 bg-blue-400/70 h-6"></div>
                    <div class="flex-1 bg-blue-400 h-10"></div>
                    <div class="flex-1 bg-blue-400/40 h-5"></div>
                </div>

                <p class="text-white/40 text-sm mt-4">Tersebar di 71 Desa/Kelurahan</p>
            </div> -->

            <!-- CARD 3 -->
            <!-- <div class="stat-card bg-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/10 transition-all opacity-0">
                <div class="flex justify-between items-start mb-6">
                    <div class="p-3 rounded-2xl bg-orange-400 text-black">
                        <span class="material-symbols-outlined">volunteer_activism</span>
                    </div>
                    <span class="text-white/40 text-xs uppercase">Relawan PKK</span>
                </div>

                <h4 class="text-white/60 mb-1">Kader Aktif</h4>
                <div class="text-5xl font-bold text-white mb-4">6,312</div>

                <p class="text-white/40 text-sm">Kader terlatih tersertifikasi</p>
            </div>

        </div>
    </div>
</section> -->

<!-- GSAP -->
<script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
<script src="https://unpkg.com/gsap@3/dist/ScrollTrigger.min.js"></script>

<script>
gsap.registerPlugin(ScrollTrigger);

// animasi aman (tidak bikin hilang)
gsap.utils.toArray('.stat-card').forEach((el, i) => {
    gsap.to(el, {
        opacity: 1,
        y: 0,
        duration: 1,
        delay: i * 0.2,
        ease: "power2.out",
        scrollTrigger: {
            trigger: el,
            start: "top 90%",
            toggleActions: "play none none none"
        }
    });
});
</script>
<!-- Warta Pariaman -->
<section class="py-24 bg-surface scroll-section">
<div class="max-w-7xl mx-auto px-6">
<div class="flex items-center gap-4 mb-12 animate-on-scroll" data-animation="fade-up">
<h2 class="text-3xl font-bold text-primary">Berita</h2>
<div class="h-px flex-1 bg-outline-variant"></div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-10">
<!-- News Card 1 -->
@foreach ($beritas as $berita )
    
<article class="flex flex-col group animate-on-scroll" data-animation="fade-up" data-delay="0">
<div class="aspect-[16/9] rounded-2xl overflow-hidden mb-6">
<img alt="Rakorwil PKK" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('storage/' . $berita->gambar) }}"/>
</div>
<div class="flex items-center gap-3 text-sm text-on-surface-variant mb-3">
<span class="px-2 py-0.5 rounded bg-surface-container-high font-medium">{{ $berita->nama }}</span>
<span>{{$berita->created_at}}</span>
</div>
<h3 class="text-xl font-bold text-primary mb-3 leading-snug group-hover:text-secondary transition-colors">{{ $berita->judul }}</h3>
<p class="text-on-surface-variant text-sm mb-4 line-clamp-3">{!! Str::limit($berita->isi, 20) !!}</p>
<a class="mt-auto inline-flex items-center gap-2 font-bold text-primary text-sm" href="#">
                    Baca Selengkapnya
                    <span class="material-symbols-outlined text-sm">arrow_forward_ios</span>
</a>
</article>
@endforeach

</div>
</div>
</section>


@include('footer')

<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script>
new Typed("#typing-title", {
    strings: [
        "<span class='text-white'>PUSKESMAS</span> <br> <span class='text-white'>MARUNGGI </span>  <span class='text-yellow-400'>KOTA PARIAMAN</span>"
    ],
    typeSpeed: 80,     // ⬅️ lebih lambat (default kamu tadi 50)
    backSpeed: 40,     // ⬅️ hapus juga lebih pelan
    backDelay: 2500,   // ⬅️ jeda sebelum hapus
    startDelay: 500,
    loop: true,
    cursorChar: "|"
});

new Typed("#typing-desc", {
    strings: [
        "Sistem Informasi Puskesmas Marunggi"
    ],
    typeSpeed: 45,     // ⬅️ deskripsi lebih pelan biar nyaman
    backSpeed: 25,
    backDelay: 2500,
    startDelay: 1500,
    loop: true,
    showCursor: false
});
</script>

<script>
    // Initialize Swiper with cross-fade and autoplay
    



    

    // Mobile Menu Toggle
    const mobileMenu = document.getElementById('mobileMenu');
    const openMenu = document.getElementById('openMenu');
    const closeMenu = document.getElementById('closeMenu');

    openMenu.addEventListener('click', () => {
        mobileMenu.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    closeMenu.addEventListener('click', () => {
        mobileMenu.classList.remove('active');
        document.body.style.overflow = '';
    });

    // GSAP Scroll Animations
    gsap.registerPlugin(ScrollTrigger);

    // Parallax Effect
    document.addEventListener('mousemove', (e) => {
        const elements = document.querySelectorAll('.parallax-element');
        const x = (window.innerWidth - e.pageX * 2) / 100;
        const y = (window.innerHeight - e.pageY * 2) / 100;

        elements.forEach(el => {
            const depth = el.getAttribute('data-depth');
            const moveX = x * depth;
            const moveY = y * depth;
            gsap.to(el, { x: moveX, y: moveY, duration: 0.5 });
        });
    });

    // Refresh-preserved entrance animations
    const animations = {
        'fade-up': { y: 50, opacity: 0 },
        'fade-left': { x: 50, opacity: 0 },
        'fade-right': { x: -50, opacity: 0 },
        'zoom-in': { scale: 0.8, opacity: 0 }
    };

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        const animType = el.getAttribute('data-animation');
        const delay = el.getAttribute('data-delay') || 0;
        const animConfig = animations[animType];

        gsap.from(el, {
            scrollTrigger: {
                trigger: el,
                start: "top 85%",
            },
            ...animConfig,
            duration: 1,
            delay: delay,
            ease: "power2.out"
        });
    });

    // Star Field Generation
    const starField = document.getElementById('starField');
    const starCount = 60;
    for (let i = 0; i < starCount; i++) {
        const star = document.createElement('div');
        star.className = 'twinkle-star';
        star.style.top = `${Math.random() * 100}%`;
        star.style.left = `${Math.random() * 100}%`;
        star.style.setProperty('--duration', `${2 + Math.random() * 3}s`);
        star.style.setProperty('--delay', `${Math.random() * 5}s`);
        starField.appendChild(star);
    }

    // GSAP Hover Effects enhancement
    document.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            gsap.to(btn, { scale: 1.05, duration: 0.3, ease: "power1.out" });
        });
        btn.addEventListener('mouseleave', () => {
            gsap.to(btn, { scale: 1, duration: 0.3, ease: "power1.out" });
        });
    });

    // Parallax on Scroll (Images)
    document.querySelectorAll('.parallax-container').forEach(container => {
        const img = container.querySelector('.parallax-img');
        gsap.to(img, {
            yPercent: 15,
            ease: "none",
            scrollTrigger: {
                trigger: container,
                start: "top bottom",
                end: "bottom top",
                scrub: true
            }
        });
    });

    // Polish gradient transitions
    gsap.to(".hero-section", {
        backgroundPosition: "100% 100%",
        duration: 20,
        repeat: -1,
        yoyo: true,
        ease: "linear"
    });
</script>


<script>
/* BACKGROUND SLIDER (BG SWIPER) */
const bgSwiper = new Swiper('.bgSwiper', {
    effect: 'fade',
    fadeEffect: {
        crossFade: true
    },
    speed: 1000,
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});


/* HERO SWIPER (slider kecil kanan) */
const heroSwiper = new Swiper('.heroSwiper', {
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    loop: true,

    coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 200,
        modifier: 2,
        slideShadows: true,
    },

    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },

    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});
</script>

</body></html>