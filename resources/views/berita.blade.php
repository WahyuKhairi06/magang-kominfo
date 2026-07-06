@include('navbar')

<style>
.fade-in { opacity: 0; transform: translateY(30px); transition: all .6s ease; }
.fade-in.show { opacity: 1; transform: translateY(0); }
.berita-item img { transition: transform .5s ease; }
.berita-item:hover img { transform: scale(1.06); }
.fb-page, .fb-page span, .fb-page iframe { width: 100% !important; }
</style>

<main class="pt-28 md:pt-32 pb-20 bg-surface min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

        <div class="mb-10 reveal-up">
            <span class="text-primary font-bold tracking-[0.14em] text-xs uppercase">Informasi</span>
            <h1 class="font-serif text-3xl md:text-4xl text-secondary mt-2">Berita &amp; Kegiatan</h1>
            <p class="text-muted mt-2">Informasi terbaru seputar kegiatan dan program Puskesmas Marunggi.</p>
        </div>

        <!-- FILTER -->
        <div class="flex flex-wrap gap-3 mb-10 reveal-up">
            <button onclick="filterKategori('all')" class="btn-filter px-5 py-2 rounded-full bg-primary text-white text-sm font-semibold">
                Semua
            </button>
            @foreach($kategoris as $kat)
            <button onclick="filterKategori('{{ $kat->id }}')" class="btn-filter px-5 py-2 rounded-full bg-white border border-border text-secondary text-sm font-semibold hover:border-primary hover:text-primary transition-colors">
                {{ $kat->nama }}
            </button>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

            <!-- GRID BERITA -->
            <div class="lg:col-span-3">
                <div id="gridBerita" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($beritas as $item)
                    <div class="berita-item fade-in bg-white rounded-xl border border-border hover:shadow-lg transition overflow-hidden" data-kategori="{{ $item->kategori_id }}">
                        <a href="{{ url('landing/berita/'.encrypt($item->id)) }}" class="block h-48 overflow-hidden">
                            <img src="{{ asset('storage/'.$item->gambar) }}" class="w-full h-full object-cover" alt="{{ $item->judul }}">
                        </a>
                        <div class="p-5">
                            <span class="text-xs bg-surface text-secondary font-semibold px-3 py-1 rounded-full">
                                {{ $item->kategori ?? 'Umum' }}
                            </span>
                            <h3 class="mt-3 text-lg font-bold text-secondary leading-snug line-clamp-2">
                                <a href="{{ url('landing/berita/'.encrypt($item->id)) }}" class="hover:text-primary transition-colors">{{ $item->judul }}</a>
                            </h3>
                            <p class="text-xs text-muted mt-2">
                                {{ \Carbon\Carbon::parse($item->tanggal_publish)->format('d M Y') }}
                            </p>
                            <a href="{{ url('landing/berita/'.encrypt($item->id)) }}" class="inline-flex items-center gap-1 mt-4 text-primary font-semibold text-sm">
                                Baca Selengkapnya <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted col-span-full">Belum ada berita yang dipublikasikan.</p>
                    @endforelse
                </div>
            </div>

            <!-- SIDEBAR -->
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-border p-5 sticky top-32">
                    <h3 class="text-base font-bold text-secondary mb-4">Ikuti Media Sosial Kami</h3>
                    <div class="fb-page"
                         data-href="https://www.facebook.com/hcmarunggi/"
                         data-tabs="timeline" data-width="340" data-height="700"
                         data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
                        <blockquote cite="https://www.facebook.com/hcmarunggi/" class="fb-xfbml-parse-ignore">
                            <a href="https://www.facebook.com/hcmarunggi/">Facebook Puskesmas Marunggi</a>
                        </blockquote>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v23.0"></script>

<script>
function filterKategori(kategori) {
    document.querySelectorAll('.berita-item').forEach(item => {
        item.style.display = (kategori === 'all' || item.dataset.kategori == kategori) ? 'block' : 'none';
    });
    document.querySelectorAll('.btn-filter').forEach(b => {
        b.classList.remove('bg-primary', 'text-white');
        b.classList.add('bg-white', 'text-secondary', 'border', 'border-border');
    });
    event.currentTarget.classList.add('bg-primary', 'text-white');
    event.currentTarget.classList.remove('bg-white', 'text-secondary', 'border', 'border-border');
}

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('show'); });
}, { threshold: 0.1 });
document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
</script>

@include('footer')
