
<style>
.material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .active-tab {
            background-color: #fed488 !important;
            color: #785a1a !important;
            box-shadow: 0 4px 12px rgba(119, 90, 25, 0.1);
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: grid;
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
<!-- <header class="relative overflow-hidden pt-20 pb-12 px-6">
<div class="max-w-7xl mx-auto text-center relative z-10">
<span class="inline-block px-4 py-1.5 mb-6 rounded-full bg-secondary-container text-on-secondary-container text-sm font-semibold tracking-wider uppercase">Program Kerja Utama</span>
<h1 class="text-5xl md:text-7xl font-black text-primary tracking-tight mb-6 leading-tight">
                Membangun Keluarga <br/> Melalui <span class="text-secondary">Pemberdayaan</span>.
            </h1>
<p class="text-lg md:text-xl text-on-surface-variant max-w-2xl mx-auto leading-relaxed">
                Struktur organisasi PKK Kota Pariaman terbagi ke dalam Kelompok Kerja yang fokus pada berbagai aspek kesejahteraan masyarakat dari akar rumput.
            </p>
</div>
<div class="absolute top-0 right-0 -z-10 w-1/3 h-full opacity-10 blur-3xl pointer-events-none" style="background: linear-gradient(135deg, #00502e 0%, #fed488 100%)"></div>
</header> -->
<!-- Pokja Tabs Section -->
<!-- <main class="max-w-7xl mx-auto px-6 pb-24"> -->
<!-- Interactive Tab Navigation -->
<!-- <div class="flex flex-wrap justify-center gap-4 mb-16 p-2 bg-surface-container-low rounded-2xl md:inline-flex md:w-auto md:mx-auto md:flex-nowrap">
<button class="tab-btn active-tab px-6 py-3 rounded-xl font-bold transition-all text-sm md:text-base flex items-center gap-2" id="btn-pokja1" onclick="switchTab('pokja1')">
<span class="material-symbols-outlined text-xl" data-icon="temple_buddhist">temple_buddhist</span>
                Pokja I
            </button>
<button class="tab-btn px-6 py-3 rounded-xl font-medium text-on-surface-variant hover:bg-white transition-all text-sm md:text-base flex items-center gap-2" id="btn-pokja2" onclick="switchTab('pokja2')">
<span class="material-symbols-outlined text-xl" data-icon="school">school</span>
                Pokja II
            </button>
<button class="tab-btn px-6 py-3 rounded-xl font-medium text-on-surface-variant hover:bg-white transition-all text-sm md:text-base flex items-center gap-2" id="btn-pokja3" onclick="switchTab('pokja3')">
<span class="material-symbols-outlined text-xl" data-icon="grass">grass</span>
                Pokja III
            </button>
<button class="tab-btn px-6 py-3 rounded-xl font-medium text-on-surface-variant hover:bg-white transition-all text-sm md:text-base flex items-center gap-2" id="btn-pokja4" onclick="switchTab('pokja4')">
<span class="material-symbols-outlined text-xl" data-icon="health_and_safety">health_and_safety</span>
                Pokja IV
            </button>
<button class="tab-btn px-6 py-3 rounded-xl font-medium text-on-surface-variant hover:bg-white transition-all text-sm md:text-base flex items-center gap-2" id="btn-sekretariat" onclick="switchTab('sekretariat')">
<span class="material-symbols-outlined text-xl" data-icon="description">description</span>
                Sekretariat
            </button>
</div> -->
<!-- Tab Content Canvas -->
<!-- <div id="tab-container"> -->
<!-- POKJA I -->
<!-- <div class="tab-content active grid-cols-1 lg:grid-cols-12 gap-12 items-start" id="pokja1">
<div class="lg:col-span-5 relative group">
<div class="aspect-[4/5] rounded-[2rem] overflow-hidden shadow-2xl relative">
<img alt="Pokja I Activities" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBomaBNaA26VVx6vS8-RvwkFh8JYG-wieD-vn7rnrKDy6cB5_z4eqw6-KQrKOwaNZqht0gx0d2LcBBrWMt55QwVtL2UrXfWHhUxz0oad8OcDuaO6sx0d6JM5U1IEu_DUWxt_RTvvU_hZi9m9e_3D51hHuTylC8Yn0L3KN0gXKZqQUmmFMcA8QQ9TNYpdvKsHm4K1LJoYWiuAukqM9i2FpbFLFBwyCcmOext7epvKwNMY9sZ1C3d6CYpHcOzvztNf1bHDUqonIkfrkA"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent"></div>
<div class="absolute bottom-8 left-8 right-8">
<h3 class="text-white text-2xl font-bold italic">"Mewujudkan Lingkungan Harmonis"</h3>
</div>
</div>
</div>
<div class="lg:col-span-7 pt-4">
<div class="mb-8">
<h2 class="text-4xl font-bold text-primary mb-6">Pokja I</h2>
<p class="text-xl text-on-surface-variant font-medium leading-relaxed">Fokus pada pembinaan karakter dan moral sebagai landasan kehidupan bermasyarakat.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="auto_stories">auto_stories</span>
<h4 class="text-lg font-bold text-primary mb-2">Pembinaan Keagamaan</h4>
<p class="text-on-surface-variant text-sm">Meningkatkan nilai spiritual dan toleransi beragama.</p>
</div>
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="groups">groups</span>
<h4 class="text-lg font-bold text-primary mb-2">Gotong Royong</h4>
<p class="text-on-surface-variant text-sm">Melestarikan budaya bahu-membahu dalam kegiatan sosial.</p>
</div>
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="gavel">gavel</span>
<h4 class="text-lg font-bold text-primary mb-2">Kesadaran Hukum</h4>
<p class="text-on-surface-variant text-sm">Penyuluhan hak warga negara dan etika keluarga.</p>
</div>
</div>
</div>
</div> -->
<!-- POKJA II -->
<!-- <div class="tab-content grid-cols-1 lg:grid-cols-12 gap-12 items-start" id="pokja2">
<div class="lg:col-span-5 relative group">
<div class="aspect-[4/5] rounded-[2rem] overflow-hidden shadow-2xl relative">
<img alt="Pokja II Activities" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAtoZKPclKodErQZzETgzwL2-Yyz-Cwa3RSOe7liLDnmmyWsMX9iwjml-gJ-2eo8ifJquSrVE3OqNTCbLTIm8ZfeBwsHcU6v_fHoUxbsiF270T99rxOrJU1qZm-2O0-aZbVFH5s5-SLAbjg93e-RhXfMEkFRHoig5IFhMSSI_Q1uA4gpyyqO1_op8x-aEP3w9o7L9Xuo1k2JEj5nWMW970Dhm14Tmm4KzJIKf4n1KEimcvPh5aZneYCbaN1ZnScmpyz-Uw3YqTsW7Y"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent"></div>
<div class="absolute bottom-8 left-8 right-8">
<h3 class="text-white text-2xl font-bold italic">"Cerdas dan Berdaya Saing"</h3>
</div>
</div>
</div>
<div class="lg:col-span-7 pt-4">
<div class="mb-8">
<h2 class="text-4xl font-bold text-primary mb-6">Pokja II</h2>
<p class="text-xl text-on-surface-variant font-medium leading-relaxed">Fokus pada pendidikan dan penguatan ekonomi keluarga melalui keterampilan.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="school">school</span>
<h4 class="text-lg font-bold text-primary mb-2">Pendidikan PAUD</h4>
<p class="text-on-surface-variant text-sm">Peningkatan kualitas layanan pendidikan usia dini.</p>
</div>
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="palette">palette</span>
<h4 class="text-lg font-bold text-primary mb-2">Pelatihan Keterampilan</h4>
<p class="text-on-surface-variant text-sm">Workshop kerajinan dan tata boga untuk ibu rumah tangga.</p>
</div>
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="storefront">storefront</span>
<h4 class="text-lg font-bold text-primary mb-2">Koperasi &amp; UMKM</h4>
<p class="text-on-surface-variant text-sm">Pengembangan usaha kecil dan kemandirian ekonomi.</p>
</div>
</div>
</div>
</div> -->
<!-- POKJA III -->
<!-- <div class="tab-content grid-cols-1 lg:grid-cols-12 gap-12 items-start" id="pokja3">
<div class="lg:col-span-5 relative group">
<div class="aspect-[4/5] rounded-[2rem] overflow-hidden shadow-2xl relative">
<img alt="Pokja III Activities" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD3X1_M3IqC0UjX9NBV0n3Gayy9-UPJMQh3OlnjIV8gJ2WP-2KfalrzRDDDeGL-NGeDj9zBhJN3VSAzh-qhWReP1L4MHlfiOfugrUuRvMcC_Hh9Bm0UZkAD1oSt-YhVdRi8RM8mt4WSqIUPs1G8eQYJgzmmd4WG0mR9gH5G_ZPW1VLnn1mU9lFNqtazj2KHCEgefcV2e5tq-iNyLcGUk3vJ14dBJBdL5wVUu5s1AAs1tUSTbGo2J-g_Q6sI-hqIkDQ6ltM2yv-jSLc"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent"></div>
<div class="absolute bottom-8 left-8 right-8">
<h3 class="text-white text-2xl font-bold italic">"Mandiri Dalam Pangan"</h3>
</div>
</div>
</div>
<div class="lg:col-span-7 pt-4">
<div class="mb-8">
<h2 class="text-4xl font-bold text-primary mb-6">Pokja III</h2>
<p class="text-xl text-on-surface-variant font-medium leading-relaxed">Fokus pada pemenuhan kebutuhan dasar keluarga dan ketahanan pangan.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="restaurant">restaurant</span>
<h4 class="text-lg font-bold text-primary mb-2">Ketahanan Pangan</h4>
<p class="text-on-surface-variant text-sm">Program lumbung hidup dan ketersediaan pangan bergizi.</p>
</div>
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="potted_plant">potted_plant</span>
<h4 class="text-lg font-bold text-primary mb-2">Pemanfaatan Pekarangan</h4>
<p class="text-on-surface-variant text-sm">Optimalisasi lahan untuk sayuran dan tanaman obat.</p>
</div>
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="home_repair_service">home_repair_service</span>
<h4 class="text-lg font-bold text-primary mb-2">Manajemen Rumah Tangga</h4>
<p class="text-on-surface-variant text-sm">Pengelolaan rumah tangga yang sehat, bersih, dan hemat.</p>
</div>
</div>
</div>
</div> -->
<!-- POKJA IV -->
<!-- <div class="tab-content grid-cols-1 lg:grid-cols-12 gap-12 items-start" id="pokja4">
<div class="lg:col-span-5 relative group">
<div class="aspect-[4/5] rounded-[2rem] overflow-hidden shadow-2xl relative">
<img alt="Pokja IV Activities" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC_raI1RblogF0_jQqSj1es-9fC8M2zGf4rx6U9fddGEJx817WJngEFpfDq_9WayepPYmQdcJvDxfHa6mPJIFaGmBNzdbWK2n8R9V2FIx2MXXq7_m-5ASzOxwN29GKe_pySsBP7TmgMtXK4TX_kxA3LOn5CUXcXXUXIdlLwg5a-35ShfFNnaf1TVFIOgGyP1nBdDphx6x8Htl-pRJ0kB7z37N1X6uZYi2FER3TfXoGWEyoej6pJeUwmFpZVk7srxZbrwbSHC1sTqVs"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent"></div>
<div class="absolute bottom-8 left-8 right-8">
<h3 class="text-white text-2xl font-bold italic">"Sehat Untuk Semua"</h3>
</div>
</div>
</div>
<div class="lg:col-span-7 pt-4">
<div class="mb-8">
<h2 class="text-4xl font-bold text-primary mb-6">Pokja IV</h2>
<p class="text-xl text-on-surface-variant font-medium leading-relaxed">Fokus pada kesehatan keluarga dan kelestarian lingkungan hidup.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="monitor_heart">monitor_heart</span>
<h4 class="text-lg font-bold text-primary mb-2">Kesehatan (Posyandu)</h4>
<p class="text-on-surface-variant text-sm">Pemantauan kesehatan ibu, anak, dan lansia secara rutin.</p>
</div>
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="clean_hands">clean_hands</span>
<h4 class="text-lg font-bold text-primary mb-2">Sanitasi &amp; Kebersihan</h4>
<p class="text-on-surface-variant text-sm">Kampanye lingkungan bersih dan pengelolaan sampah.</p>
</div>
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="family_restroom">family_restroom</span>
<h4 class="text-lg font-bold text-primary mb-2">Keluarga Berencana</h4>
<p class="text-on-surface-variant text-sm">Sosialisasi program KB dan kesehatan reproduksi.</p>
</div>
</div>
</div>
</div> -->
<!-- SEKRETARIAT -->
<!-- <div class="tab-content grid-cols-1 lg:grid-cols-12 gap-12 items-start" id="sekretariat">
<div class="lg:col-span-5 relative group">
<div class="aspect-[4/5] rounded-[2rem] overflow-hidden shadow-2xl relative bg-emerald-800 flex items-center justify-center p-12">
<div class="text-center">
<span class="material-symbols-outlined text-white text-9xl opacity-20 mb-4" data-icon="folder_managed">folder_managed</span>
<h3 class="text-white text-3xl font-bold">Administrasi PKK</h3>
</div>
</div>
</div>
<div class="lg:col-span-7 pt-4">
<div class="mb-8">
<h2 class="text-4xl font-bold text-primary mb-6">Sekretariat</h2>
<p class="text-xl text-on-surface-variant font-medium leading-relaxed">Pusat koordinasi, administrasi, dan manajemen data organisasi.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="inventory">inventory</span>
<h4 class="text-lg font-bold text-primary mb-2">Pendataan</h4>
<p class="text-on-surface-variant text-sm">Pengelolaan data warga dan rekapitulasi buku administrasi.</p>
</div>
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="history_edu">history_edu</span>
<h4 class="text-lg font-bold text-primary mb-2">Laporan Kegiatan</h4>
<p class="text-on-surface-variant text-sm">Penyusunan laporan berkala dan dokumentasi program.</p>
</div>
<div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
<span class="material-symbols-outlined text-primary mb-4" data-icon="settings_account_box">settings_account_box</span>
<h4 class="text-lg font-bold text-primary mb-2">Manajemen Organisasi</h4>
<p class="text-on-surface-variant text-sm">Tata kelola internal dan koordinasi antar Pokja.</p>
</div>
</div>
</div>
</div>
</div>
</main> -->

<script>
        function switchTab(tabId) {
            // Hide all contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Deactivate all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active-tab');
                btn.classList.add('font-medium', 'text-on-surface-variant');
                btn.classList.remove('font-bold');
            });

            // Show target content
            document.getElementById(tabId).classList.add('active');
            
            // Activate target button
            const activeBtn = document.getElementById('btn-' + tabId);
            activeBtn.classList.add('active-tab', 'font-bold');
            activeBtn.classList.remove('font-medium', 'text-on-surface-variant');
        }
    </script>