@include('navbar')

<main class="pt-28 md:pt-32 pb-24 bg-surface min-h-screen">
    <div class="max-w-6xl mx-auto px-6">

        <div class="mb-12">
            <span class="text-primary font-bold tracking-[0.14em] text-xs uppercase">Kontak</span>
            <h1 class="font-serif text-3xl md:text-4xl text-secondary mt-2">Pengaduan &amp; Saran</h1>
            <p class="text-muted mt-3 max-w-xl">Sampaikan keluhan, masukan, atau saran Anda terkait pelayanan kami. Setiap pengaduan akan kami tindaklanjuti.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- INFO -->
            <div class="lg:col-span-4 space-y-5">
                <div class="bg-white border border-border rounded-2xl p-6 flex items-start gap-4">
                    <span class="material-symbols-outlined text-primary text-2xl">location_on</span>
                    <div>
                        <h3 class="font-bold text-secondary mb-1">Alamat</h3>
                        <p class="text-sm text-muted">Jl. Puti Bungsu, Desa Marunggi, Kec. Pariaman Selatan, Kota Pariaman.</p>
                    </div>
                </div>
                <div class="bg-white border border-border rounded-2xl p-6 flex items-start gap-4">
                    <span class="material-symbols-outlined text-primary text-2xl">call</span>
                    <div>
                        <h3 class="font-bold text-secondary mb-1">Telepon</h3>
                        <p class="text-sm text-muted">(0751) 123-456</p>
                    </div>
                </div>
                <div class="bg-white border border-border rounded-2xl p-6 flex items-start gap-4">
                    <span class="material-symbols-outlined text-primary text-2xl">mail</span>
                    <div>
                        <h3 class="font-bold text-secondary mb-1">Email</h3>
                        <p class="text-sm text-muted break-all">info@puskesmasmarunggi.pariamankota.go.id</p>
                    </div>
                </div>
                <div class="bg-secondary text-white rounded-2xl p-6">
                    <h3 class="font-bold mb-1">Kanal Lain</h3>
                    <p class="text-sm text-white/70 mb-4">Anda juga bisa menghubungi kami melalui media sosial.</p>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/hcmarunggi/" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-colors">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/puskesmasmarunggi/" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-colors">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- FORM -->
            <div class="lg:col-span-8">
                <div class="bg-white border border-border rounded-2xl p-8">

                    @if(session('success'))
                    <div class="mb-6 p-4 bg-primary/10 text-primary rounded-lg text-sm font-semibold">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('pengaduan.store') }}" class="space-y-5">
                        @csrf
                        <div>
                            <label class="text-sm font-semibold text-secondary block mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" required
                                   class="w-full border border-border rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-secondary block mb-2">Nomor HP</label>
                            <input type="text" name="no_hp" required
                                   class="w-full border border-border rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-secondary block mb-2">Isi Pengaduan</label>
                            <textarea name="isi_pengaduan" rows="5" required
                                      class="w-full border border-border rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-primary outline-none"></textarea>
                        </div>
                        <button type="submit"
                                class="inline-flex items-center justify-center h-13 px-8 py-3.5 rounded-full bg-primary text-white font-semibold hover:bg-secondary transition-colors">
                            Kirim Pengaduan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@include('footer')
