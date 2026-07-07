
<!DOCTYPE html>

<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="{{ asset('tailwind.min.js') }}"></script>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "primary": "var(--primary)",
                      "on-primary": "var(--on-primary)",
                      "primary-container": "var(--primary-container)",
                      "on-primary-container": "var(--on-primary-container)",
                      "secondary": "var(--secondary)",
                      "on-secondary": "var(--on-secondary)",
                      "secondary-container": "var(--secondary-container)",
                      "on-secondary-container": "var(--on-secondary-container)",
                      "surface": "var(--surface)",
                      "on-surface": "var(--on-surface)",
                      "surface-variant": "var(--tertiary)",
                      "on-surface-variant": "var(--muted)",
                      "outline": "var(--border)",
                      "error": "var(--error)",
              },
              "borderRadius": {
                      "DEFAULT": "0.25rem",
                      "lg": "0.5rem",
                      "xl": "0.75rem",
                      "full": "9999px"
              },
              "fontFamily": {
                      "headline": ["Inter"],
                      "body": ["Inter"],
                      "label": ["Inter"]
              }
            },
          },
        }
    </script>
<style>
    html, body {
    height: auto;
    min-height: 100%;
    overflow-y: auto !important;
}
        :root {
            --primary: #2D6A4F;
            --on-primary: #FFFFFF;
            --primary-container: #0B3D26;
            --on-primary-container: #EEF3EF;
            --secondary: #0B3D26;
            --on-secondary: #FFFFFF;
            --secondary-container: #D9E4DC;
            --on-secondary-container: #0B3D26;
            --tertiary: #EEF3EF;
            --surface: #EEF3EF;
            --on-surface: #0B3D26;
            --muted: #6B7D72;
            --border: #D9E4DC;
            --error: #D92D20;
            --bg-gradient: radial-gradient(circle at 0% 0%, rgba(45, 106, 79, 0.05) 0%, transparent 50%), radial-gradient(circle at 100% 100%, rgba(11, 61, 38, 0.05) 0%, transparent 50%);
        }
        body { font-family: 'Inter', sans-serif; transition: background 0.5s ease; }
        .glass-effect { backdrop-filter: blur(20px); }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .submenu-container { height: 0; overflow: hidden; }
        .rotate-180 { transform: rotate(180deg); }
        .modal-overlay { opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
        .modal-overlay.active { opacity: 1; pointer-events: auto; }
        .modal-content { transform: scale(0.9); transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .modal-overlay.active .modal-content { transform: scale(1); }
        .table-row { opacity: 0; transform: translateY(10px); transition: opacity 0.3s ease, transform 0.3s ease; }
        #canvas-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
{{-- <body class="bg-surface text-on-surface min-h-screen flex overflow-hidden" id="main-body"> --}}
    <body class="bg-surface text-on-surface min-h-screen flex overflow-x-hidden">
<canvas id="canvas-bg"></canvas>
{{-- <div class="fixed inset-0 z-[200] bg-white flex items-center justify-center transition-opacity duration-500" id="global-loader">
<div class="relative flex items-center justify-center">
<div class="w-24 h-24 rounded-full border-4 border-primary/10 absolute"></div>
<div class="w-24 h-24 rounded-full border-t-4 border-primary animate-spin absolute shadow-[0_0_15px_rgba(0,107,63,0.3)]"></div>
<div class="w-16 h-16 rounded-full border-b-4 border-secondary animate-[spin_1.5s_linear_infinite_reverse] absolute"></div>
<div class="w-8 h-8 rounded-full bg-primary/20 animate-pulse"></div>
<div class="absolute -bottom-12 font-black text-primary tracking-widest text-[10px] uppercase animate-pulse">Memuat Data...</div>
</div>
</div> --}}
<!-- SideNavBar -->
<aside class="hidden md:flex flex-col h-screen w-64 fixed left-0 top-0 overflow-y-auto bg-white/80 backdrop-blur-md border-r border-slate-100 p-4 gap-2 z-50">
<div class="flex items-center gap-3 px-2 mb-8 mt-2">
<div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-on-primary transition-colors duration-500">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;"><img src="{{ asset('puskesmas.png') }}" width="50px" height="50px"></span>
</div>
<div>
<h2 class="font-black text-primary leading-none transition-colors duration-500">PUSKESMAS</h2>
<span class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Marunggi</span>
</div>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100" href="{{ url('dashboard') }}">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-medium text-sm">Dashboard</span>
</a>
<div>
<button class="w-full flex items-right justify-between px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100" onclick="toggleSubmenu('submenu-master', this)">
<div class="flex items-right gap-3">
<span class="material-symbols-outlined">storage</span>
<span class="font-medium text-sm">Data Master</span>
</div>
<span class="material-symbols-outlined text-sm transition-transform duration-300 chevron">expand_more</span>
</button>
<div class="submenu-container ml-6 space-y-1" id="submenu-master">
<!-- <a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('role') }}">Daftar Role</a> -->
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('kategori-berita') }}">Kategori Berita</a>
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('kategori-halaman') }}">Kategori Profil</a>
<!-- <a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('kecamatan') }}">Kecamatan</a>
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('desa') }}">Desa</a>
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('dusun') }}">Dusun</a> -->
<!-- <a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('pokja') }}">Tambah Pokja</a>
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('rumah') }}">Tambah Rumah</a> -->

</div>
</div>
<div>
<div>
<button class="w-full flex items-right justify-between px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100" onclick="toggleSubmenu('submenu-landing', this)">
<div class="flex items-right gap-3">
<span class="material-symbols-outlined">rocket_launch</span>
<span class="font-medium text-sm">Landing Page</span>
</div>
<span class="material-symbols-outlined text-sm transition-transform duration-300 chevron">expand_more</span>
</button>
<div class="submenu-container ml-6 space-y-1" id="submenu-landing">
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('berita') }}">Berita</a>
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('halaman') }}">Halaman Profil</a>
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('galeri') }}">Galeri Kegiatan</a>
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('agenda') }}">Agenda</a>
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('slider') }}">Slider</a>
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('dokumen') }}">Dokumen</a>
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('sambutan') }}">Sambutan</a>
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('organisasi') }}">Profil User Organisasi</a>
{{-- <a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('admin/infografis') }}">Infografis</a> --}}
</div>
</div>
<div>
<!-- <div>
<button class="w-full flex items-center justify-between px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100" onclick="toggleSubmenu('submenu-pkk', this)">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined">account_tree</span>
<span class="font-medium text-sm">Data Kegiatan </span>
</div>
<span class="material-symbols-outlined text-sm transition-transform duration-300 chevron">expand_more</span>
</button>
<div class="submenu-container ml-6 space-y-1" id="submenu-pkk">
<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('umum') }}">Data Umum</a> -->
<!-- @php
    $pokja=DB::table('pokjas')->get();
@endphp
    
@foreach ($pokja as $pok )

<a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg"
   href="{{ url('pokja') .'/'. encrypt($pok->id)}}">
   {{ $pok->nama_pokja }}
</a>@endforeach -->

<!-- </div>
</div>
<div>
<button class="w-full flex items-center justify-between px-4 py-3 bg-primary/5 text-primary rounded-xl shadow-sm font-semibold transition-all duration-150" onclick="toggleSubmenu('submenu-kependudukan', this)">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">groups</span>
<span class="font-medium text-sm">Inovasi</span>
</div>
<span class="material-symbols-outlined text-sm transition-transform duration-300 chevron">expand_more</span>
</button>
<div class="submenu-container ml-6 space-y-1" id="submenu-kependudukan">
<a class="block px-4 py-2 text-xs font-medium text-primary bg-primary/5 rounded-lg" href="{{ url('inovasipokja1') }}">Inovasi 1</a> -->
<!-- <a class="block px-4 py-2 text-xs font-medium text-slate-500 hover:text-primary rounded-lg" href="{{ url('admin/produk/pokja II') }}">Inovasi 2</a>
<a class="block px-4 py-2 text-xs font-medium text-primary bg-primary/5 rounded-lg" href="{{ url('inovasipokja3') }}">Inovasi 3</a>
<a class="block px-4 py-2 text-xs font-medium text-primary bg-primary/5 rounded-lg" href="{{ url('dasawisma') }}">Inovasi 4</a>
<a class="block px-4 py-2 text-xs font-medium text-primary bg-primary/5 rounded-lg" href="{{ url('inovasisekre') }}">Inovasi 5</a> -->
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100" href="{{ url('inovasi1') }}">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">emoji_objects</span>
<span class="font-medium text-sm">Inovasi</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100" href="{{ url('admin/pengaduan') }}">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">campaign</span>
<span class="font-medium text-sm">Pengaduan</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100" href="{{ url('admin/faq') }}">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">quiz</span>
<span class="font-medium text-sm">FAQ</span>
</a>

</div>

<button class="w-full flex items-center gap-3 px-4 py-2 text-error text-sm hover:bg-error/5 rounded-lg transition-colors" onclick="openModal('logout-modal')">
<span class="material-symbols-outlined">logout</span>
<span>Log Keluar</span>
</button>
</div>


<!-- <a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100"
   href="{{ url('bukupkk') }}">
    <span class="material-symbols-outlined">groups</span>
    <span class="font-medium text-sm">Buku</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100"
   href="{{ url('buku-agenda') }}">
    <span class="material-symbols-outlined">mail</span>
    <span class="font-medium text-sm">Buku Agenda Surat</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100"
   href="{{ url('/data/buku/dasawisma') }}">
    <span class="material-symbols-outlined">home</span>
    <span class="font-medium text-sm">Buku</span>
</a> -->
{{--
<span class="material-symbols-outlined">collections_bookmark</span>
<span class="font-medium text-sm">Galeri Kegiatan</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100" href="{{ url('agenda') }}">
<span class="material-symbols-outlined">admin_panel_settings</span>
<span class="font-medium text-sm">Agenda</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100" href="{{ url('slider') }}">
<span class="material-symbols-outlined">admin_panel_settings</span>
<span class="font-medium text-sm">Slider</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-primary/10 hover:text-primary rounded-xl transition-all duration-150 scale-95 hover:scale-100" href="{{ url('dokumen') }}">
<span class="material-symbols-outlined">admin_panel_settings</span>
<span class="font-medium text-sm">Dokumen</span>
</a> --}}
</nav>
<div class="mt-5 space-y-1">

</div>
</aside>
<!-- Main Content Wrapper -->
{{-- <main class="flex-1 md:ml-64 flex flex-col h-screen overflow-hidden relative"> --}}
    <main class="flex-1 md:ml-64 flex flex-col min-h-screen relative overflow-x-hidden">
<!-- TopAppBar -->
<header class="sticky top-0 z-50 bg-white/70 backdrop-blur-xl flex justify-between items-center w-full px-6 py-3 shadow-sm border-b border-slate-100">
<div class="flex items-center gap-8 flex-1">
<span class="text-xl font-bold tracking-tighter text-primary font-['Inter'] leading-tight hidden lg:block transition-colors duration-500">Puskesmas Marunggi</span>
<div class="relative flex-1 max-w-md">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
<input class="w-full bg-slate-100 border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-slate-400" id="table-search" placeholder="Cari Nama atau NIK..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6 ml-4">
<!-- Theme Switcher - Expanded to 12 as requested by visuals of grid, but providing 6 main variations here -->
<div class="flex items-center gap-1.5 p-1.5 bg-slate-100 rounded-full">
<button class="w-5 h-5 rounded-full bg-[#2D6A4F] border-2 border-white shadow-sm hover:scale-110 transition-transform" onclick="setTheme('#2D6A4F', '#FFFFFF', '#0B3D26', '#EEF3EF', '#0B3D26', '#FFFFFF', '#D9E4DC', '#0B3D26', '#EEF3EF')" title="Clinical Academic"></button>
<button class="w-5 h-5 rounded-full bg-[#0056b3] border-2 border-white shadow-sm hover:scale-110 transition-transform" onclick="setTheme('#0056b3', '#ffffff', '#004494', '#d1e4ff', '#003366', '#ffffff', '#cce5ff', '#004085', '#eff6ff')" title="Blue"></button>
<button class="w-5 h-5 rounded-full bg-[#6b21a8] border-2 border-white shadow-sm hover:scale-110 transition-transform" onclick="setTheme('#6b21a8', '#ffffff', '#581c87', '#f3e8ff', '#4c1d95', '#ffffff', '#ede9fe', '#2e1065', '#faf5ff')" title="Purple"></button>
<button class="w-5 h-5 rounded-full bg-[#c2410c] border-2 border-white shadow-sm hover:scale-110 transition-transform" onclick="setTheme('#c2410c', '#ffffff', '#9a3412', '#ffedd5', '#7c2d12', '#ffffff', '#ffedd5', '#431407', '#fff7ed')" title="Amber"></button>
<button class="w-5 h-5 rounded-full bg-[#be123c] border-2 border-white shadow-sm hover:scale-110 transition-transform" onclick="setTheme('#be123c', '#ffffff', '#9f1239', '#ffe4e6', '#881337', '#ffffff', '#fecdd3', '#4c0519', '#fff1f2')" title="Rose"></button>
<button class="w-5 h-5 rounded-full bg-[#0369a1] border-2 border-white shadow-sm hover:scale-110 transition-transform" onclick="setTheme('#0369a1', '#ffffff', '#075985', '#e0f2fe', '#0c4a6e', '#ffffff', '#bae6fd', '#082f49', '#f0f9ff')" title="Sky"></button>
</div>
<div class="flex items-center gap-4">
<button class="p-2 text-slate-500 hover:text-primary transition-colors">
<!-- <span class="material-symbols-outlined">notifications</span> -->
</button>
<div class="flex items-center gap-3 pl-4 border-l border-slate-200">
<div class="text-right hidden sm:block">
<p class="text-xs font-bold text-primary transition-colors duration-500">{{ auth()->user()->nama }}</p>
<p class="text-[10px] text-slate-500">{{ auth()->user()->email }}</p>
</div>
<div class="w-9 h-9 rounded-full bg-slate-200 border-2 border-white shadow-sm overflow-hidden">
<a href="{{ asset('iwan.jpg') }}" target="_blank">
    <img alt="Admin" class="w-full h-full object-cover" src="{{ asset('iwan.jpg') }}"/>
    </a>
</div>
</div>
</div>
</div>
</header>

<!-- Table Section -->
@yield('content')

</main>
<!-- Modal Form Tambah Kader -->

<!-- Polished Logout Modal -->
<div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md modal-overlay" id="logout-modal">
<div class="bg-white w-full max-w-sm rounded-[32px] shadow-2xl overflow-hidden modal-content p-8 text-center">
<div class="w-20 h-20 bg-error/10 text-error rounded-full flex items-center justify-center mx-auto mb-6">
<span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'wght' 700;">logout</span>
</div>
<h3 class="text-2xl font-black text-slate-900 mb-2">Konfirmasi Keluar</h3>
<p class="text-slate-500 text-sm mb-8 leading-relaxed">Apakah Anda yakin ingin mengakhiri sesi ini?</p>
<div class="flex flex-col gap-3">
<!-- <button class="w-full py-4 bg-error text-white font-bold rounded-2xl shadow-lg shadow-error/20 hover:scale-[1.02] active:scale-[0.98] transition-all" onclick="window.location.reload()">Ya, Keluar Sekarang</button> -->
<form method="POST" action="{{ route('logout') }}">
    @csrf

    <button
        type="submit"
        class="w-full py-4 bg-error text-white font-bold rounded-2xl shadow-lg shadow-error/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
        Ya, Keluar Sekarang
    </button>
</form>

<button
    class="w-full py-4 bg-slate-50 text-slate-600 font-bold rounded-2xl hover:bg-slate-100 transition-all"
    onclick="closeModal('logout-modal')">
    Batal
</button>
<!-- <button class="w-full py-4 bg-slate-50 text-slate-600 font-bold rounded-2xl hover:bg-slate-100 transition-all" onclick="closeModal('logout-modal')">Batal</button> -->
</div>
</div>
</div>
<!-- Floating Action Button (FAB) Mobile -->
<button class="md:hidden fixed bottom-6 right-6 w-14 h-14 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center shadow-xl z-50" onclick="openModal('modal')">
<span class="material-symbols-outlined text-2xl">add</span>
</button>
<script>
        // Enhanced Theme Engine & Three.js Background Integration
        let currentThemeColor = 0x2D6A4F;
        let scene, camera, renderer, particles;

        function initThree() {
            scene = new THREE.Scene();
            camera = new THREE.Camera();
            camera.position.z = 1;

            const geometry = new THREE.PlaneGeometry(2, 2);
            const uniforms = {
                u_time: { type: "f", value: 1.0 },
                u_resolution: { type: "v2", value: new THREE.Vector2() },
                u_color: { type: "c", value: new THREE.Color(currentThemeColor) }
            };

            const material = new THREE.ShaderMaterial({
                uniforms: uniforms,
                vertexShader: `
                    void main() {
                        gl_Position = vec4(position, 1.0);
                    }
                `,
                fragmentShader: `
                    uniform float u_time;
                    uniform vec2 u_resolution;
                    uniform vec3 u_color;
                    void main() {
                        vec2 st = gl_FragCoord.xy/u_resolution.xy;
                        float d = distance(st, vec2(0.5)) * 0.5;
                        vec3 color = mix(vec3(1.0), u_color, 0.08 - d);
                        gl_FragColor = vec4(color, 1.0);
                    }
                `
            });

            const mesh = new THREE.Mesh(geometry, material);
            scene.add(mesh);

            renderer = new THREE.WebGLRenderer({ canvas: document.getElementById('canvas-bg'), antialias: true });
            renderer.setPixelRatio(window.devicePixelRatio);
            
            function resize() {
                renderer.setSize(window.innerWidth, window.innerHeight);
                uniforms.u_resolution.value.x = renderer.domElement.width;
                uniforms.u_resolution.value.y = renderer.domElement.height;
            }
            window.addEventListener('resize', resize);
            resize();

            function animate(time) {
                requestAnimationFrame(animate);
                uniforms.u_time.value = time * 0.001;
                uniforms.u_color.value.set(currentThemeColor);
                renderer.render(scene, camera);
            }
            animate();
        }

        function setTheme(p, op, pc, opc, s, os, sc, osc, surface) {
            const root = document.documentElement;
            root.style.setProperty('--primary', p);
            root.style.setProperty('--on-primary', op);
            root.style.setProperty('--primary-container', pc);
            root.style.setProperty('--on-primary-container', opc);
            root.style.setProperty('--secondary', s);
            root.style.setProperty('--on-secondary', os);
            root.style.setProperty('--secondary-container', sc);
            root.style.setProperty('--on-secondary-container', osc);
            root.style.setProperty('--surface', surface);
            
            currentThemeColor = parseInt(p.replace('#', '0x'), 16);
            
            // Visual transition for background
            gsap.to('body', { backgroundColor: surface, duration: 0.8 });
        }

        // Submenu Toggle with GSAP
        function toggleSubmenu(id, btn) {
            const submenu = document.getElementById(id);
            const chevron = btn.querySelector('.chevron');
            const isOpen = submenu.classList.contains('open');

            if (isOpen) {
                gsap.to(submenu, { height: 0, duration: 0.3, ease: "power2.inOut" });
                chevron.classList.remove('rotate-180');
                submenu.classList.remove('open');
            } else {
                document.querySelectorAll('.submenu-container.open').forEach(openSub => {
                    if (openSub.id !== id) {
                        gsap.to(openSub, { height: 0, duration: 0.3 });
                        openSub.previousElementSibling.querySelector('.chevron').classList.remove('rotate-180');
                        openSub.classList.remove('open');
                    }
                });
                gsap.set(submenu, { height: "auto" });
                const autoHeight = submenu.offsetHeight;
                gsap.fromTo(submenu, { height: 0 }, { height: autoHeight, duration: 0.4, ease: "back.out(1.2)" });
                chevron.classList.add('rotate-180');
                submenu.classList.add('open');
            }
        }

        // Modal Controls
        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        // Initial Load & Search
        window.addEventListener('DOMContentLoaded', () => {
            initThree();

            const loader = document.getElementById('global-loader');
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => loader.classList.add('hidden'), 500);
                gsap.to('.table-row', {
                    opacity: 1,
                    y: 0,
                    stagger: 0.1,
                    duration: 0.6,
                    ease: "power2.out"
                });
            }, 1200);

            // Live Search Implementation
            const searchInput = document.getElementById('table-search');
            const tableRows = document.querySelectorAll('#kader-table tbody tr');
            const resultsText = document.getElementById('results-count');

            searchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                let visibleCount = 0;

                tableRows.forEach(row => {
                    const name = row.querySelector('.cadre-name').textContent.toLowerCase();
                    const nik = row.querySelector('.cadre-nik').textContent.toLowerCase();
                    
                    if (name.includes(term) || nik.includes(term)) {
                        row.style.display = 'table-row';
                        gsap.to(row, { opacity: 1, scale: 1, duration: 0.3 });
                        visibleCount++;
                    } else {
                        gsap.to(row, { 
                            opacity: 0, 
                            scale: 0.98, 
                            duration: 0.2, 
                            onComplete: () => row.style.display = 'none' 
                        });
                    }
                });
                
                resultsText.innerHTML = `Menampilkan <span class="text-slate-900 font-bold">${visibleCount}</span> dari <span class="text-slate-900 font-bold">1,248</span> kader`;
            });
        });

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal('modal');
                closeModal('logout-modal');
            }
        });
    </script>
    @include('sweetalert::alert')

</body></html>