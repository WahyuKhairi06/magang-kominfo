<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- CTA Pengaduan sebelum footer -->
<section class="bg-surface py-16 border-t border-border">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
        <div>
            <h2 class="font-serif text-2xl md:text-3xl text-secondary font-medium">Ada masukan atau keluhan layanan?</h2>
            <p class="text-muted mt-1">Sampaikan langsung kepada kami, akan kami tindaklanjuti secepatnya.</p>
        </div>
        <a href="{{ route('pengaduan.form') }}" class="inline-flex items-center justify-center h-14 px-8 rounded-full border border-primary text-primary font-semibold hover:bg-primary hover:text-white transition-colors whitespace-nowrap">
            Buat Pengaduan
        </a>
    </div>
</section>

<footer class="w-full bg-secondary text-white">
    <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-12 gap-12">

        <!-- Brand -->
        <div class="md:col-span-5 space-y-5">
            <div class="flex items-center gap-3">
                <img src="{{ asset('puskesmas.png') }}" class="w-10 h-10 object-contain bg-white rounded-md p-1" alt="Logo">
                <span class="font-serif text-xl font-medium">Puskesmas Marunggi</span>
            </div>
            <p class="text-white/70 text-sm leading-relaxed max-w-sm">
                Jl. Puti Bungsu, Desa Marunggi, Kec. Pariaman Selatan, Kota Pariaman, Sumatera Barat.
                Sahabat terbaik masyarakat dalam mewujudkan keluarga sehat, masyarakat sehat, dan mandiri.
            </p>
            <div class="flex gap-3 pt-2">
                <a class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-primary hover:border-primary transition-colors" href="https://www.facebook.com/hcmarunggi/" target="_blank" aria-label="Facebook">
                    <i class="bi bi-facebook"></i>
                </a>
                <a class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-primary hover:border-primary transition-colors" href="https://www.instagram.com/puskesmasmarunggi/" target="_blank" aria-label="Instagram">
                    <i class="bi bi-instagram"></i>
                </a>
                <a class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-primary hover:border-primary transition-colors" href="mailto:info@puskesmasmarunggi.pariamankota.go.id" aria-label="Email">
                    <i class="bi bi-envelope"></i>
                </a>
            </div>
        </div>

        <!-- Navigasi -->
        <div class="md:col-span-3 space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-[0.14em] text-white/50">Navigasi</h3>
            <nav class="flex flex-col gap-3 text-sm text-white/80">
                <a class="hover:text-white transition-colors" href="{{ url('landing/berita') }}">Berita</a>
                <a class="hover:text-white transition-colors" href="{{ url('landing/galeri') }}">Galeri Kegiatan</a>
                <a class="hover:text-white transition-colors" href="{{ url('landing/dokumen') }}">Informasi Publik</a>
                <a class="hover:text-white transition-colors" href="{{ url('landing/infografis') }}">Infografis</a>
                <a class="hover:text-white transition-colors" href="{{ route('faq') }}">FAQ</a>
                <a class="hover:text-white transition-colors" href="{{ route('pengaduan.form') }}">Pengaduan</a>
            </nav>
        </div>

        <!-- Jam & Kontak -->
        <div class="md:col-span-4 space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-[0.14em] text-white/50">Jam Pelayanan</h3>
            <div class="text-sm text-white/80 space-y-2">
                <div class="flex justify-between max-w-[220px]"><span>Senin - Kamis</span><span>08:00 - 14:00</span></div>
                <div class="flex justify-between max-w-[220px]"><span>Jumat</span><span>08:00 - 11:00</span></div>
                <div class="flex justify-between max-w-[220px]"><span>Sabtu</span><span>08:00 - 13:00</span></div>
                <div class="flex justify-between max-w-[220px] text-primary font-semibold"><span>UGD</span><span>24 Jam</span></div>
            </div>
            <p class="text-sm text-white/80 flex items-center gap-2 pt-2">
                <span class="material-symbols-outlined text-base">call</span> (0751) 123-456
            </p>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-white/50">
            <p>&copy; {{ date('Y') }} Puskesmas Marunggi &mdash; Dinas Kesehatan Kota Pariaman.</p>
            <p>Dikelola oleh Dinas Komunikasi dan Informatika Kota Pariaman.</p>
        </div>
    </div>
</footer>

</body>
</html>
