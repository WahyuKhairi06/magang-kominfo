<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>{{ $puskesmasSetting->nama_puskesmas }} {{ $puskesmasSetting->kabupaten_kota }} - Website Resmi</title>
<meta name="description" content="Website resmi {{ $puskesmasSetting->nama_puskesmas }}, {{ $puskesmasSetting->kabupaten_kota }}. Informasi layanan kesehatan, jadwal, berita, dan informasi publik.">
<link rel="icon" type="image/png" href="{{ $puskesmasSetting->logo ? asset($puskesmasSetting->logo) : asset('logo.png') }}">

<!-- Fonts: Fraunces (headline serif editorial) + Inter (sans utilitas) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

<!-- Alpine.js untuk state management (Navbar scroll dll) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Swiper (hero slider) -->
<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- fslightbox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>
<!-- GSAP (reveal halus saja, tanpa efek berlebihan) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <script src="{{ asset('tailwind.min.js') }}"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#2D6A4F",
                        secondary: "#0B3D26",
                        tertiary: "#EEF3EF",
                        neutral: "#FFFFFF",
                        surface: "#EEF3EF",
                        "on-surface": "#0B3D26",
                        border: "#D9E4DC",
                        muted: "#6B7D72",
                        error: "#D92D20",
                    },
                    fontFamily: {
                        serif: ["Fraunces", "serif"],
                        sans: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        none: "0px",
                        sm: "4px",
                        DEFAULT: "4px",
                        md: "8px",
                        lg: "16px",
                        xl: "32px",
                        full: "9999px",
                    },
                    letterSpacing: {
                        tightest: "-0.04em",
                    },
                },
            },
        }
    </script>
@endif
<style>
    html { scroll-behavior: smooth; }
    body { font-family: 'Inter', sans-serif; }
    .font-serif { font-family: 'Fraunces', serif; }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
    }
    .dropdown-menu {
        opacity: 0; visibility: hidden; transform: translateY(6px);
        transition: all .2s ease;
    }
    .dropdown-trigger:hover .dropdown-menu {
        opacity: 1; visibility: visible; transform: translateY(0);
    }
    .mobile-menu-overlay {
        clip-path: circle(0% at 100% 0%);
        transition: clip-path .5s cubic-bezier(.77,0,.175,1);
    }
    .mobile-menu-overlay.active { clip-path: circle(150% at 100% 0%); }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    /* Hero background slider - tanpa efek zoom dramatis, cukup crossfade tenang */
    .heroSwiper .swiper-slide { opacity: 0 !important; transition: opacity 1s ease-in-out; }
    .heroSwiper .swiper-slide-active { opacity: 1 !important; z-index: 10; }
    .swiper-pagination-bullet { background:#fff; opacity:.5; }
    .swiper-pagination-bullet-active { background:#fff; opacity:1; width:20px; border-radius:4px; }
</style>
</head>
<body class="bg-white font-sans text-on-surface antialiased">

<!-- Mobile Menu Overlay -->
<div class="fixed inset-0 z-[60] bg-secondary mobile-menu-overlay md:hidden" id="mobileMenu">
    <div class="flex flex-col h-full p-8 overflow-y-auto no-scrollbar">
        <div class="flex justify-between items-center mb-12">
            <div class="text-lg font-bold tracking-tight text-white flex items-center gap-3">
                <img src="{{ $puskesmasSetting->logo ? asset($puskesmasSetting->logo) : asset('puskesmas.png') }}" class="w-10 h-10 rounded-md bg-white p-1" alt="Logo">
                <span>{{ $puskesmasSetting->nama_puskesmas }}</span>
            </div>
            <button class="text-white" id="closeMenu" aria-label="Tutup menu">
                <span class="material-symbols-outlined text-3xl">close</span>
            </button>
        </div>
        <div class="flex flex-col gap-6 text-xl font-medium text-white">
            <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Beranda</a>

            <div class="space-y-3">
                <p class="text-xs uppercase tracking-[0.15em] text-white/50 font-semibold">Profil</p>
                @foreach ($kategoris_halaman as $halaman )
                <a class="block pl-4 hover:text-primary transition-colors" href="{{ url('landing/halaman/'.encrypt($halaman->id)) }}">{{ $halaman->nama }}</a>
                @endforeach
            </div>

            <a class="hover:text-primary transition-colors" href="{{ url('landing/inovasi1') }}">Inovasi &amp; Program</a>
            <a class="hover:text-primary transition-colors" href="{{ url('landing/galeri') }}">Galeri</a>
            <a class="hover:text-primary transition-colors" href="{{ url('landing/infografis') }}">Infografis</a>
            <a class="hover:text-primary transition-colors" href="{{ url('landing/berita') }}">Berita</a>
            <a class="hover:text-primary transition-colors" href="{{ url('landing/dokumen') }}">Dokumen</a>
            <a class="hover:text-primary transition-colors" href="{{ route('pengaduan.form') }}">Pengaduan</a>
            <a class="hover:text-primary transition-colors" href="{{ route('faq') }}">FAQ</a>
            <a class="text-primary font-bold transition-colors mt-2" href="{{ route('chat') }}">
                <span class="flex items-center gap-2"><span class="material-symbols-outlined">smart_toy</span> Chat Bot AI</span>
            </a>        </div>
    </div>
</div>

<!-- Topbar utilitas -->
<div class="hidden md:block bg-secondary text-white text-xs">
    <div class="max-w-7xl mx-auto px-6 h-9 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <!-- <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px]">call</span> (0751) 123-456</span>
            <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px]">mail</span> info@puskesmasmarunggi.pariamankota.go.id</span> -->
        </div>
    </div>
</div>

<!-- Nav Utama -->
<nav x-data="{ scrolled: false }"
     @scroll.window="scrolled = (window.pageYOffset > 40)"
     :class="scrolled 
        ? 'top-2 md:top-4 w-[calc(100%-2rem)] md:w-[calc(100%-4rem)] max-w-[80rem] rounded-2xl md:rounded-full shadow-lg border border-border/50 bg-white/95 backdrop-blur-xl' 
        : 'top-0 md:top-9 w-full max-w-[100vw] rounded-none shadow-none border border-transparent border-b-border bg-[rgba(255,255,255,0.92)] backdrop-blur-md'"
     class="fixed left-0 right-0 mx-auto z-50 transition-all duration-500 ease-in-out">
    
    <div :class="scrolled ? 'py-2' : 'py-3'"
         class="flex justify-between items-center w-full px-6 max-w-7xl mx-auto transition-all duration-500 ease-in-out">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ $puskesmasSetting->logo ? asset($puskesmasSetting->logo) : asset('puskesmas.png') }}" class="w-11 h-11 object-contain" alt="Logo {{ $puskesmasSetting->nama_puskesmas }}">
            <span class="leading-tight">
                <span class="block font-serif font-semibold text-secondary text-lg leading-none">{{ $puskesmasSetting->nama_puskesmas }}</span>
                <span class="block text-[11px] uppercase tracking-[0.14em] text-muted font-semibold mt-0.5">{{ $puskesmasSetting->kabupaten_kota }}</span>
            </span>
        </a>

        <div class="hidden lg:flex items-center gap-4 xl:gap-8 text-[15px] font-medium">
            <a class="text-secondary hover:text-primary transition-colors" href="{{ url('/') }}">Beranda</a>

            <div class="relative dropdown-trigger h-full flex items-center group cursor-pointer">
                <span class="text-secondary/80 group-hover:text-primary transition-colors flex items-center gap-1">
                    Profil <span class="material-symbols-outlined text-base">expand_more</span>
                </span>
                <div class="absolute top-[100%] left-0 w-56 bg-white shadow-xl rounded-md border border-border py-2 dropdown-menu">
                    @foreach ($kategoris_halaman as $halaman )
                    <a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface transition-colors" href="{{ url('landing/halaman/'.encrypt($halaman->id)) }}">{{ $halaman->nama }}</a>
                    @endforeach
                </div>
            </div>

            <a class="text-secondary/80 hover:text-primary transition-colors" href="{{ url('landing/inovasi1') }}">Inovasi</a>
            <a class="text-secondary/80 hover:text-primary transition-colors" href="{{ url('landing/galeri') }}">Galeri</a>
            <a class="text-secondary/80 hover:text-primary transition-colors" href="{{ url('landing/infografis') }}">Infografis</a>
            <a class="text-secondary/80 hover:text-primary transition-colors" href="{{ url('landing/berita') }}">Berita</a>
            <a class="text-secondary/80 hover:text-primary transition-colors" href="{{ url('landing/dokumen') }}">Dokumen</a>
            <a class="text-secondary/80 hover:text-primary transition-colors" href="{{ route('faq') }}">FAQ</a>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('chat') }}" class="hidden lg:inline-flex items-center h-11 px-6 rounded-full bg-primary text-white font-semibold text-sm hover:bg-secondary transition-colors shadow-sm gap-2">
                Chat Bot <span class="material-symbols-outlined text-[18px]">smart_toy</span>
            </a>
            <a href="{{ route('pengaduan.form') }}" class="hidden lg:inline-flex items-center h-11 px-6 rounded-full border border-primary text-primary font-semibold text-sm hover:bg-primary hover:text-white transition-colors">
                Pengaduan
            </a>
            <button class="lg:hidden text-secondary" id="openMenu" aria-label="Buka menu">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
        </div>
    </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const openBtn = document.getElementById("openMenu");
    const closeBtn = document.getElementById("closeMenu");
    const menu = document.getElementById("mobileMenu");

    if (openBtn && closeBtn && menu) {
        openBtn.addEventListener("click", () => {
            menu.classList.add("active");
            document.body.style.overflow = "hidden";
        });
        closeBtn.addEventListener("click", () => {
            menu.classList.remove("active");
            document.body.style.overflow = "";
        });
        menu.addEventListener("click", (e) => {
            if (e.target === menu) {
                menu.classList.remove("active");
                document.body.style.overflow = "";
            }
        });
    }

    if (window.gsap && window.ScrollTrigger) {
        gsap.registerPlugin(ScrollTrigger);
        gsap.utils.toArray('.reveal-up').forEach((el) => {
            gsap.from(el, {
                opacity: 0, y: 30, duration: .8, ease: "power2.out",
                scrollTrigger: { trigger: el, start: "top 88%" }
            });
        });
    }
});
</script>
