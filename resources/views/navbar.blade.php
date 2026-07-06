<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Puskesmas Marunggi Kota Pariaman - Official Website</title>
<script src="{{ asset('tailwind.min.js') }}"></script>
<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Swiper.js CSS -->
<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet"/>
<!-- Swiper.js JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- fslightbox for the fullscreen effect -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>
<!-- GSAP for animations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-container": "#785a1a",
                        "tertiary": "#454735",
                        "inverse-primary": "#81d9a2",
                        "error": "#ba1a1a",
                        "on-secondary-fixed": "#261900",
                        "outline": "#6f7a71",
                        "secondary-fixed-dim": "#e9c176",
                        "surface-bright": "#f8f9fa",
                        "inverse-surface": "#2e3132",
                        "on-primary-container": "#91e9b1",
                        "on-tertiary": "#ffffff",
                        "surface-variant": "#e1e3e4",
                        "on-secondary": "#ffffff",
                        "surface": "#f8f9fa",
                        "surface-container-low": "#f3f4f5",
                        "tertiary-fixed": "#e4e4cc",
                        "on-error-container": "#93000a",
                        "on-surface-variant": "#3f4941",
                        "primary-fixed-dim": "#81d9a2",
                        "surface-container": "#edeeef",
                        "tertiary-fixed-dim": "#c8c8b0",
                        "surface-container-high": "#e7e8e9",
                        "secondary-fixed": "#ffdea5",
                        "surface-dim": "#d9dadb",
                        "on-tertiary-container": "#d7d7bf",
                        "primary": "#00502e",
                        "surface-container-highest": "#e1e3e4",
                        "outline-variant": "#bec9bf",
                        "on-primary-fixed": "#002110",
                        "on-secondary-fixed-variant": "#5d4201",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "on-primary-fixed-variant": "#00522f",
                        "primary-fixed": "#9df5bd",
                        "tertiary-container": "#5d5e4b",
                        "surface-container-lowest": "#ffffff",
                        "surface-tint": "#046d40",
                        "on-background": "#191c1d",
                        "secondary-container": "#fed488",
                        "on-tertiary-fixed": "#1b1d0e",
                        "on-tertiary-fixed-variant": "#474836",
                        "on-primary": "#ffffff",
                        "on-surface": "#191c1d",
                        "inverse-on-surface": "#f0f1f2",
                        "primary-container": "#006b3f",
                        "background": "#f8f9fa",
                        "secondary": "#775a19"
                    },
                    "fontFamily": {
                        "headline": ["Inter", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "label": ["Inter", "sans-serif"]
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "1.5rem",
                        "full": "9999px"
                    }
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .tonal-transition-surface-container-low {
            background-color: #f3f4f5;
        }
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }
        .dropdown-trigger:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .swiper-pagination-bullet-active {
            background: #fed488 !important;
            width: 32px !important;
            border-radius: 4px !important;
        }
        .mobile-menu-overlay {
            clip-path: circle(0% at 100% 0%);
            transition: clip-path 0.6s cubic-bezier(0.77, 0, 0.175, 1);
        }
        .mobile-menu-overlay.active {
            clip-path: circle(150% at 100% 0%);
        }
        /* Custom Swiper Styles */
        .heroSwiper .swiper-slide {
            opacity: 0 !important;
            transition: opacity 0.8s ease-in-out;
        }
        .heroSwiper .swiper-slide-active {
            opacity: 1 !important;
            z-index: 10;
        }
        .view-full-btn {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }
        .swiper-slide-active .view-full-btn {
            opacity: 1;
            transform: translateY(0);
        }
        .map-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.05) 2px, transparent 0);
            background-size: 30px 30px;
        }
        .footer-link-hover {
            position: relative;
        }
        .footer-link-hover::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: #fed488;
            transition: width 0.3s ease;
        }
        .footer-link-hover:hover::after {
            width: 100%;
        }

        /* Twinkling Star Animation */
        @keyframes twinkle {
            0%, 100% { opacity: 0.1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.2); }
        }
        .twinkle-star {
            position: absolute;
            width: 3px;
            height: 3px;
            background: white;
            border-radius: 50%;
            pointer-events: none;
            animation: twinkle var(--duration, 3s) infinite ease-in-out;
            animation-delay: var(--delay, 0s);
        }

        /* Pulsing Glow Animation */
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.4; }
        }
        .pulse-bg {
            animation: pulse-glow 5s infinite ease-in-out;
        }

        /* Gradient Shift */
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .hero-section {
            background-size: 200% 200%;
            animation: gradient-shift 15s infinite ease;
        }
    
        @keyframes orbit-rotate {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        .orbital-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 110%;
            height: 110%;
            border: 1px solid rgba(254, 212, 136, 0.2);
            border-radius: 35% 65% 70% 30% / 30% 30% 70% 70%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 0;
            animation: orbit-rotate 20s linear infinite;
        }
        .orbital-ring::after {
            content: '';
            position: absolute;
            top: -5px;
            left: 50%;
            width: 10px;
            height: 10px;
            background: #fed488;
            border-radius: 50%;
            box-shadow: 0 0 15px #fed488, 0 0 30px #fed488;
        }
        .orbital-ring-2 {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 120%;
            height: 120%;
            border: 1px dashed rgba(161, 233, 177, 0.15);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 0;
            animation: orbit-rotate 30s linear infinite reverse;
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface overflow-x-hidden">
<!-- Mobile Menu Overlay -->
<div class="fixed inset-0 z-[60] bg-primary mobile-menu-overlay md:hidden" id="mobileMenu">
<div class="flex flex-col h-full p-8">
<div class="flex justify-between items-center mb-12">
<div class="text-xl font-bold tracking-tighter text-white flex items-center gap-2">
<span class="material-symbols-outlined text-secondary-fixed" style="font-variation-settings: 'FILL' 1;"><img src="{{ asset('puskesmas.png') }}" width="50px" height="50px"></span>
<span>Puskesmas Kota Pariaman</span>
</div>
<button class="text-white" id="closeMenu">
<span class="material-symbols-outlined text-4xl">close</span>
</button>
</div>
<div class="flex flex-col gap-6 text-2xl font-bold text-white">
<a class="hover:text-secondary-fixed transition-colors" href="{{ url('/') }}">Beranda</a>
<div class="space-y-4">
<p class="text-sm uppercase tracking-widest text-white/50">Profil</p>
@foreach ($kategoris_halaman as $halaman )
    
<a class="block pl-4 hover:text-secondary-fixed transition-colors" href="{{ url('landing/halaman/'.encrypt($halaman->id)) }}">{{$halaman->nama}}</a>
@endforeach

</div>
<a class="hover:text-secondary-fixed transition-colors" href="{{url('landing/dasawisma')}}">Dasawisma</a>
<div class="space-y-4">
<p class="text-sm uppercase tracking-widest text-white/50">Inovasi</p>
<a class="block pl-4 hover:text-secondary-fixed transition-colors" href="{{ url('landing/inovasi/pokja1') }}">POKJA 1</a>
<a class="block pl-4 hover:text-secondary-fixed transition-colors" href="{{ url('landing/produk') }}">POKJA 2</a>
<a class="block pl-4 hover:text-secondary-fixed transition-colors" href="{{ url('landing/inovasi/pokja3') }}">POKJA 3</a>
<a class="block pl-4 hover:text-secondary-fixed transition-colors" href="{{ url('inovasi/pokja4/kurva') }}">POKJA 4</a>
</div>
<a class="hover:text-secondary-fixed transition-colors" href="{{ url('landing/galeri') }}">Kegiatan</a>
<a class="hover:text-secondary-fixed transition-colors" href="{{ url('landing/berita') }}">Berita</a>
<a class="hover:text-secondary-fixed transition-colors" href="{{ url('landing/galeri') }}">Galeri</a>
<a class="hover:text-secondary-fixed transition-colors" href="{{ url('landing/infografis') }}">Infografis</a>
<a class="hover:text-secondary-fixed transition-colors" href="{{ url('landing/dokumen') }}">Dokumen</a>
</div>
{{-- <button class="mt-auto w-full bg-secondary-fixed text-on-secondary-fixed py-4 rounded-xl font-bold">
            Layanan Publik
        </button> --}}
</div>
</div>
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 glass-nav shadow-sm">
<div class="flex justify-between items-center w-full px-6 py-4 max-w-7xl mx-auto">
<div class="text-xl font-bold tracking-tighter text-emerald-900 flex items-center gap-2">
<span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;"><img src="{{ asset('puskesmas.png') }}" width="50px" height="50px"></span>
<span>Puskesmas Marunggi</span>
</div>
<div class="hidden md:flex items-center gap-8 font-inter tracking-tight font-medium">
<a class="text-emerald-900 border-b-2 border-amber-600 pb-1" href="{{ url('/') }}">Beranda</a>
<!-- Profil Dropdown -->
<div class="relative dropdown-trigger h-full flex items-center group cursor-pointer">
<span class="text-emerald-800/70 group-hover:text-emerald-900 transition-colors flex items-center gap-1">
                    Profil <span class="material-symbols-outlined text-sm">expand_more</span>
</span>
<div class="absolute top-[100%] left-0 w-48 bg-white shadow-xl rounded-xl border border-outline-variant/30 py-2 dropdown-menu">
    @foreach ($kategoris_halaman as $halaman )

<a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container transition-colors" href="{{ url('landing/halaman/'.encrypt($halaman->id)) }}">{{ $halaman->nama }}</a>
@endforeach
</div>
</div>
<!-- <a class="text-emerald-800/70 hover:text-emerald-900 transition-colors" href="{{url('landing/dasawisma')}}">Dasawisma</a> -->
<!-- POK Dropdown -->
<!-- <div class="relative dropdown-trigger h-full flex items-center group cursor-pointer">
<span class="text-emerald-800/70 group-hover:text-emerald-900 transition-colors flex items-center gap-1">
                    Inovasi <span class="material-symbols-outlined text-sm">expand_more</span>
</span>
<div class="absolute top-[100%] left-0 w-48 bg-white shadow-xl rounded-xl border border-outline-variant/30 py-2 dropdown-menu">
<a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container transition-colors" href="{{ url('landing/inovasi/pokja1') }}">Inovasi 1</a>
<a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container transition-colors" href="{{ url('landing/produk') }}">Inovasi 2</a>
<a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container transition-colors" href="{{ url('landing/inovasi/pokja3') }}">Inovasi 3</a>
<a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container transition-colors" href="{{ url('inovasi/pokja4/kurva') }}">Inovasi 4</a>
<a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container transition-colors" href="{{ url('inovasi/sekre') }}">Inovasi 5</a>
</div>
</div> -->
<!-- <div class="relative dropdown-trigger h-full flex items-center group cursor-pointer">
<span class="text-emerald-800/70 group-hover:text-emerald-900 transition-colors flex items-center gap-1">
                    Kegiatan <span class="material-symbols-outlined text-sm">expand_more</span>
</span>
<div class="absolute top-[100%] left-0 w-48 bg-white shadow-xl rounded-xl border border-outline-variant/30 py-2 dropdown-menu">
<a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container transition-colors" href="{{url('pokja1/kurva')}}">Inovasi 1</a>
<a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container transition-colors" href="{{url('pokja2/kurva')}}">Inovasi 2</a>
<a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container transition-colors" href="{{url('pokja3/kurva')}}">Inovasi 3</a>
<a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container transition-colors" href="{{url('pokja4/kurva')}}">Inovasi 4</a>
<a class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container transition-colors" href="{{url('kegiatan/sekre')}}">Inovasi 5</a>
</div>
</div> -->
<a class="text-emerald-800/70 hover:text-emerald-900 transition-colors" href="{{ url('landing/inovasi1') }}">Inovasi</a>
<a class="text-emerald-800/70 hover:text-emerald-900 transition-colors" href="{{ url('landing/galeri') }}">Galeri</a>
<a class="text-emerald-800/70 hover:text-emerald-900 transition-colors" href="{{ url('landing/infografis') }}">Infografis</a>
<a class="text-emerald-800/70 hover:text-emerald-900 transition-colors" href="{{ url('landing/berita') }}">Berita</a>
<a class="text-emerald-800/70 hover:text-emerald-900 transition-colors" href="{{ url('landing/dokumen') }}">Dokumen</a>
<a class="text-emerald-800/70 hover:text-emerald-900 transition-colors"
   href="{{ route('pengaduan.form') }}">
   Pengaduan
</a>
<a class="text-emerald-800/70 hover:text-emerald-900 transition-colors" href="{{ route('faq') }}">FAQ</a>


</div>
<div class="flex items-center gap-4">
<!-- <button class="hidden md:flex bg-primary text-on-primary px-6 py-2 rounded-xl font-semibold scale-95 active:scale-90 transition-transform hover:bg-primary-container">
                Layanan
            </button> -->
<button class="md:hidden text-primary" id="openMenu">
<span class="material-symbols-outlined">menu</span>
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

        // klik luar (optional tapi bagus)
        menu.addEventListener("click", (e) => {
            if (e.target === menu) {
                menu.classList.remove("active");
                document.body.style.overflow = "";
            }
        });
    }
});
</script>