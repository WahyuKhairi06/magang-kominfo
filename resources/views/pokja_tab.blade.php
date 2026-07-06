<style>
    .tab-content { display: none; }
    .tab-content.active { display: grid; animation: fadeInTab .4s ease-out; }
    @keyframes fadeInTab {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .tab-btn.active-tab { background-color: #006BE9; color: #fff; }
</style>

<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center max-w-2xl mx-auto mb-14 reveal-up">
            <span class="text-primary font-bold tracking-[0.14em] text-xs uppercase">Layanan Kami</span>
            <h2 class="font-serif text-3xl md:text-4xl text-secondary mt-2">Layanan Unggulan Puskesmas Marunggi</h2>
            <p class="text-muted mt-4">Melayani kebutuhan kesehatan dasar masyarakat Kota Pariaman dari usia dini hingga lanjut usia.</p>
        </div>

        <!-- Tab Navigation -->
        <div class="flex flex-wrap justify-center gap-3 mb-12 reveal-up">
            <button class="tab-btn active-tab px-5 py-2.5 rounded-full font-semibold text-sm transition-all border border-primary" id="btn-umum" onclick="switchLayanan('umum')">Poli Umum</button>
            <button class="tab-btn px-5 py-2.5 rounded-full font-semibold text-sm transition-all border border-border text-secondary hover:border-primary" id="btn-kia" onclick="switchLayanan('kia')">KIA &amp; KB</button>
            <button class="tab-btn px-5 py-2.5 rounded-full font-semibold text-sm transition-all border border-border text-secondary hover:border-primary" id="btn-gigi" onclick="switchLayanan('gigi')">Poli Gigi</button>
            <button class="tab-btn px-5 py-2.5 rounded-full font-semibold text-sm transition-all border border-border text-secondary hover:border-primary" id="btn-gizi" onclick="switchLayanan('gizi')">Gizi &amp; Imunisasi</button>
            <button class="tab-btn px-5 py-2.5 rounded-full font-semibold text-sm transition-all border border-border text-secondary hover:border-primary" id="btn-ugd" onclick="switchLayanan('ugd')">UGD 24 Jam</button>
        </div>

        <!-- POLI UMUM -->
        <div class="tab-content active grid-cols-1 lg:grid-cols-12 gap-10 items-start" id="tab-umum">
            <div class="lg:col-span-4">
                <h3 class="font-serif text-2xl text-secondary mb-3">Poli Umum</h3>
                <p class="text-muted leading-relaxed">Pemeriksaan dan pengobatan penyakit umum untuk semua usia, dengan rujukan lanjutan bila diperlukan.</p>
            </div>
            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">stethoscope</span>
                    <h4 class="font-bold text-secondary mb-1">Konsultasi Umum</h4>
                    <p class="text-sm text-muted">Pemeriksaan keluhan kesehatan sehari-hari.</p>
                </div>
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">vaccines</span>
                    <h4 class="font-bold text-secondary mb-1">Tindakan Ringan</h4>
                    <p class="text-sm text-muted">Perawatan luka dan tindakan medis dasar.</p>
                </div>
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">description</span>
                    <h4 class="font-bold text-secondary mb-1">Surat Rujukan</h4>
                    <p class="text-sm text-muted">Rujukan ke fasilitas kesehatan lanjutan.</p>
                </div>
            </div>
        </div>

        <!-- KIA & KB -->
        <div class="tab-content grid-cols-1 lg:grid-cols-12 gap-10 items-start" id="tab-kia">
            <div class="lg:col-span-4">
                <h3 class="font-serif text-2xl text-secondary mb-3">KIA &amp; KB</h3>
                <p class="text-muted leading-relaxed">Kesehatan Ibu dan Anak serta layanan Keluarga Berencana untuk mendukung keluarga sehat.</p>
            </div>
            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">pregnant_woman</span>
                    <h4 class="font-bold text-secondary mb-1">Pemeriksaan Kehamilan</h4>
                    <p class="text-sm text-muted">Pemantauan rutin kesehatan ibu hamil.</p>
                </div>
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">child_care</span>
                    <h4 class="font-bold text-secondary mb-1">Tumbuh Kembang Anak</h4>
                    <p class="text-sm text-muted">Pemantauan berat, tinggi, dan imunisasi anak.</p>
                </div>
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">family_restroom</span>
                    <h4 class="font-bold text-secondary mb-1">Keluarga Berencana</h4>
                    <p class="text-sm text-muted">Konsultasi dan layanan kontrasepsi.</p>
                </div>
            </div>
        </div>

        <!-- GIGI -->
        <div class="tab-content grid-cols-1 lg:grid-cols-12 gap-10 items-start" id="tab-gigi">
            <div class="lg:col-span-4">
                <h3 class="font-serif text-2xl text-secondary mb-3">Poli Gigi</h3>
                <p class="text-muted leading-relaxed">Perawatan kesehatan gigi dan mulut untuk mencegah dan mengatasi masalah gigi.</p>
            </div>
            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">dentistry</span>
                    <h4 class="font-bold text-secondary mb-1">Pemeriksaan Gigi</h4>
                    <p class="text-sm text-muted">Konsultasi dan pemeriksaan rutin.</p>
                </div>
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">healing</span>
                    <h4 class="font-bold text-secondary mb-1">Penambalan &amp; Pencabutan</h4>
                    <p class="text-sm text-muted">Tindakan dasar perawatan gigi.</p>
                </div>
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">sentiment_satisfied</span>
                    <h4 class="font-bold text-secondary mb-1">Edukasi Kesehatan Mulut</h4>
                    <p class="text-sm text-muted">Penyuluhan kebersihan gigi dan mulut.</p>
                </div>
            </div>
        </div>

        <!-- GIZI -->
        <div class="tab-content grid-cols-1 lg:grid-cols-12 gap-10 items-start" id="tab-gizi">
            <div class="lg:col-span-4">
                <h3 class="font-serif text-2xl text-secondary mb-3">Gizi &amp; Imunisasi</h3>
                <p class="text-muted leading-relaxed">Program pemenuhan gizi masyarakat dan imunisasi lengkap sesuai jadwal nasional.</p>
            </div>
            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">nutrition</span>
                    <h4 class="font-bold text-secondary mb-1">Konsultasi Gizi</h4>
                    <p class="text-sm text-muted">Pemantauan status gizi balita dan ibu hamil.</p>
                </div>
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">syringe</span>
                    <h4 class="font-bold text-secondary mb-1">Imunisasi Rutin</h4>
                    <p class="text-sm text-muted">Imunisasi dasar lengkap untuk bayi &amp; anak.</p>
                </div>
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">monitor_weight</span>
                    <h4 class="font-bold text-secondary mb-1">Posyandu</h4>
                    <p class="text-sm text-muted">Pemantauan tumbuh kembang rutin bulanan.</p>
                </div>
            </div>
        </div>

        <!-- UGD -->
        <div class="tab-content grid-cols-1 lg:grid-cols-12 gap-10 items-start" id="tab-ugd">
            <div class="lg:col-span-4">
                <h3 class="font-serif text-2xl text-secondary mb-3">UGD 24 Jam</h3>
                <p class="text-muted leading-relaxed">Layanan gawat darurat siaga 24 jam untuk penanganan kondisi darurat medis.</p>
            </div>
            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">emergency</span>
                    <h4 class="font-bold text-secondary mb-1">Penanganan Darurat</h4>
                    <p class="text-sm text-muted">Siaga 24 jam setiap hari.</p>
                </div>
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">local_shipping</span>
                    <h4 class="font-bold text-secondary mb-1">Rujukan Cepat</h4>
                    <p class="text-sm text-muted">Koordinasi rujukan ke rumah sakit rekanan.</p>
                </div>
                <div class="bg-surface p-6 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-3">call</span>
                    <h4 class="font-bold text-secondary mb-1">Hotline Darurat</h4>
                    <p class="text-sm text-muted">(0751) 123-456</p>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
function switchLayanan(id) {
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('active-tab', 'border-primary');
        b.classList.add('border-border', 'text-secondary');
    });
    document.getElementById('tab-' + id).classList.add('active');
    const btn = document.getElementById('btn-' + id);
    btn.classList.add('active-tab', 'border-primary');
    btn.classList.remove('border-border', 'text-secondary');
}
</script>
