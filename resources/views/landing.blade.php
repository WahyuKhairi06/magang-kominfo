@include('navbar')

@php
use Carbon\Carbon;

// mapping agenda berdasarkan tanggal
$agendaMap = [];
foreach ($agendas as $a) {
    $agendaMap[$a->tanggal][] = $a;
}
$month = Carbon::now()->month;
$year = Carbon::now()->year;
$totalDays = Carbon::create($year, $month)->daysInMonth;
@endphp

<!-- ================= HERO ================= -->
<section class="relative min-h-[92vh] md:min-h-screen flex items-end overflow-hidden pt-24 md:pt-32">
    <div class="absolute inset-0 z-0">
        <div class="swiper heroBgSwiper w-full h-full">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                <div class="swiper-slide">
                    <img src="{{ asset('storage/' . $slider->gambar) }}" class="w-full h-full object-cover" alt="{{ $slider->judul ?? 'Puskesmas Marunggi' }}">
                </div>
                @endforeach
            </div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-secondary/90 via-secondary/30 to-secondary/10"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 pb-20">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-white/80 mb-6">
                <span class="w-6 h-px bg-primary"></span> Fasilitas Kesehatan Tingkat Pertama
            </span>
            <h1 class="font-serif text-white text-4xl md:text-6xl leading-[1.05] tracking-tight mb-6">
                Melayani dengan Hati,<br>Mengabdi untuk Kesehatan Kota Pariaman
            </h1>
            <p class="text-white/85 text-lg max-w-xl mb-10 leading-relaxed">
                Puskesmas Marunggi &mdash; sahabat terbaik masyarakat dalam mewujudkan keluarga sehat,
                masyarakat sehat, dan mandiri menuju Kota Pariaman Sehat.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#layanan-unggulan" class="inline-flex items-center justify-center h-14 px-8 rounded-full bg-white text-secondary font-semibold hover:bg-primary hover:text-white transition-colors">
                    Layanan Kami
                </a>
                <a
                    href="{{ route('pengaduan.form') }}"
                    class="inline-flex items-center justify-center h-14 px-8 rounded-full
                    bg-primary text-white font-semibold
                    shadow-lg shadow-primary/20
                    border border-
                    transition-all duration-300
                    hover:bg-secondary
                    hover:border-secondary
                    hover:shadow-xl hover:shadow-secondary/30
                    hover:-translate-y-0.5
                    active:scale-95">
                    Sampaikan Pengaduan
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ================= QUICK INFO PANEL (hero-panel, putih, mengambang) ================= -->
<section class="relative z-20 -mt-10 md:-mt-12">
    <div class="max-w-6xl mx-auto px-6">
        <div class="bg-white rounded-2xl shadow-xl border border-border grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 divide-x-0 md:divide-x divide-border overflow-hidden">
            <div class="p-6 flex flex-col items-center text-center gap-1">
                <span class="material-symbols-outlined text-primary text-2xl">schedule</span>
                <span class="text-xs text-muted uppercase tracking-wide font-semibold mt-1">Jam Layanan</span>
                <span class="text-sm font-bold text-secondary">08.00 &ndash; 14.00 WIB</span>
            </div>
            <div class="p-6 flex flex-col items-center text-center gap-1">
                <span class="material-symbols-outlined text-primary text-2xl">emergency</span>
                <span class="text-xs text-muted uppercase tracking-wide font-semibold mt-1">Gawat Darurat</span>
                <span class="text-sm font-bold text-secondary">24 Jam Siaga</span>
            </div>
            <div class="p-6 flex flex-col items-center text-center gap-1">
                <span class="material-symbols-outlined text-primary text-2xl">location_on</span>
                <span class="text-xs text-muted uppercase tracking-wide font-semibold mt-1">Lokasi</span>
                <span class="text-sm font-bold text-secondary">Marunggi, Pariaman Selatan</span>
            </div>
            <div class="p-6 flex flex-col items-center text-center gap-1">
                <span class="material-symbols-outlined text-primary text-2xl">call</span>
                <span class="text-xs text-muted uppercase tracking-wide font-semibold mt-1">Hubungi Kami</span>
                <span class="text-sm font-bold text-secondary">(0751) 123-456</span>
            </div>
        </div>
    </div>
</section>

<!-- ================= SAMBUTAN ================= -->
<section class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-12 gap-16 items-center">
            <div class="md:col-span-5 relative reveal-up">
                <div class="aspect-[3/4] rounded-2xl overflow-hidden shadow-lg">
                    <img alt="Kepala Puskesmas Marunggi" class="w-full h-full object-cover"
                         src="{{ $sambutan && $sambutan->foto ? asset('storage/'.$sambutan->foto) : asset('no-image.png') }}">
                </div>
                <div class="mt-4 sm:mt-0 sm:absolute sm:-bottom-6 sm:-right-6 bg-secondary p-6 sm:p-7 rounded-xl shadow-lg sm:max-w-[220px]">
                    <p class="text-white font-serif text-lg leading-snug">&ldquo;{{ $sambutan->motto ?? 'Profesional dalam tugas, melayani dengan hati.' }}&rdquo;</p>
                </div>
            </div>
            <div class="md:col-span-7 space-y-6 reveal-up">
                <div class="space-y-3">
                    <span class="text-primary font-bold tracking-[0.14em] text-xs uppercase">Kata Sambutan</span>
                    <h2 class="font-serif text-3xl md:text-4xl text-secondary">Kepala Puskesmas</h2>
                </div>
                <div class="prose prose-lg text-muted leading-relaxed max-w-none">
                    {!! $sambutan->isi ?? '<p>Selamat datang di website resmi Puskesmas Marunggi. Kami berkomitmen memberikan pelayanan kesehatan yang profesional, ramah, dan mudah diakses oleh seluruh masyarakat Kota Pariaman.</p>' !!}
                </div>
                <div class="pt-6 border-t border-border flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-surface flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined">signature</span>
                    </div>
                    <div>
                        <p class="font-bold text-secondary">{{ $sambutan->nama ?? 'dr. Kepala Puskesmas' }}</p>
                        <p class="text-sm text-muted">Kepala Puskesmas Marunggi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= LAYANAN UNGGULAN (tabs) ================= -->
<div id="layanan-unggulan"></div>
@include('pokja_tab')

<!-- ================= AGENDA KEGIATAN ================= -->
<section class="py-24 bg-surface">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center gap-4 mb-12 reveal-up">
            <div>
                <span class="text-primary font-bold tracking-[0.14em] text-xs uppercase">Kalender</span>
                <h2 class="font-serif text-3xl md:text-4xl text-secondary mt-2">Agenda Kegiatan</h2>
            </div>
            <div class="h-px flex-1 bg-border ml-4"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- CALENDAR -->
            <div class="lg:col-span-7 bg-white p-6 md:p-8 rounded-2xl border border-border reveal-up">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-secondary">
                        {{ Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}
                    </h3>
                </div>
                <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-muted mb-3">
                    <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                </div>
                <div class="grid grid-cols-7 gap-2">
                    @for($i = 1; $i <= $totalDays; $i++)
                        @php
                            $date = sprintf('%04d-%02d-%02d', $year, $month, $i);
                            $hasAgenda = isset($agendaMap[$date]);
                        @endphp
                        <div onclick="openAgenda('{{ $date }}')"
                             class="h-16 md:h-20 border rounded-lg p-2 cursor-pointer transition text-left
                             {{ $hasAgenda ? 'bg-primary/5 border-primary' : 'bg-white border-border hover:bg-surface' }}">
                            <div class="font-bold text-sm text-secondary">{{ $i }}</div>
                            @if($hasAgenda)
                                <div class="text-[10px] text-primary font-semibold mt-0.5">{{ count($agendaMap[$date]) }} agenda</div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            <!-- LIST -->
            <div class="lg:col-span-5 bg-white p-6 md:p-8 rounded-2xl border border-border reveal-up">
                <h3 class="text-lg font-bold text-secondary mb-4">Semua Agenda Bulan Ini</h3>
                <div class="space-y-3 max-h-[420px] overflow-y-auto pr-1">
                    @forelse($agendas as $a)
                    <div class="border border-border rounded-lg p-4 hover:border-primary cursor-pointer transition" onclick="openAgenda('{{ $a->tanggal }}')">
                        <div class="flex justify-between gap-3">
                            <div class="font-bold text-sm text-secondary">{{ $a->judul_agenda }}</div>
                            <div class="text-xs text-muted whitespace-nowrap">{{ \Carbon\Carbon::parse($a->tanggal)->format('d M') }}</div>
                        </div>
                        <div class="text-sm text-muted mt-1">{{ $a->lokasi }}</div>
                        <div class="text-xs text-primary font-semibold mt-1">{{ $a->jam_mulai }} - {{ $a->jam_selesai }}</div>
                    </div>
                    @empty
                    <p class="text-sm text-muted">Belum ada agenda terjadwal.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODAL AGENDA -->
<div id="agendaModal" class="fixed inset-0 bg-secondary/60 hidden items-center justify-center z-[70] px-6">
    <div class="bg-white w-full max-w-lg rounded-2xl p-6 relative">
        <button onclick="closeModal()" class="absolute right-4 top-4 text-muted hover:text-secondary text-xl">&times;</button>
        <h3 class="text-lg font-bold text-secondary mb-4">Detail Agenda</h3>
        <div id="agendaContent" class="space-y-3"></div>
    </div>
</div>

<!-- ================= KEGIATAN TERBARU (bento) ================= -->
@if(count($galeris_double))
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-end mb-12 reveal-up">
            <div class="space-y-2">
                <span class="text-primary font-bold tracking-[0.14em] text-xs uppercase">Dokumentasi</span>
                <h2 class="font-serif text-3xl md:text-4xl text-secondary">Kegiatan Terbaru</h2>
            </div>
            <a href="{{ url('landing/galeri') }}" class="hidden md:inline-flex text-primary font-semibold items-center gap-2 hover:gap-3 transition-all">
                Lihat Galeri <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($galeris_double as $galer)
            <div class="relative group rounded-2xl overflow-hidden h-[260px] reveal-up">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="{{ asset('storage/'. $galer->foto) }}" alt="{{ $galer->judul_kegiatan }}">
                <div class="absolute inset-0 bg-gradient-to-t from-secondary/90 via-secondary/10 to-transparent"></div>
                <div class="absolute bottom-0 p-6 text-white">
                    <h3 class="font-serif text-xl">{{ $galer->judul_kegiatan }}</h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ================= BERITA ================= -->
<section class="py-24 bg-surface">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center gap-4 mb-12 reveal-up">
            <h2 class="font-serif text-3xl md:text-4xl text-secondary">Berita &amp; Informasi</h2>
            <div class="h-px flex-1 bg-border"></div>
            <a href="{{ url('landing/berita') }}" class="text-primary font-semibold text-sm whitespace-nowrap hover:underline">Semua Berita</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach ($beritas as $berita )
            <article class="flex flex-col group reveal-up">
                <a href="{{ url('landing/berita/'.encrypt($berita->id)) }}" class="aspect-[16/9] rounded-xl overflow-hidden mb-5 block">
                    <img alt="{{ $berita->judul }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('storage/' . $berita->gambar) }}">
                </a>
                <div class="flex items-center gap-3 text-xs text-muted mb-3">
                    <span class="px-2.5 py-1 rounded-full bg-white border border-border font-semibold text-secondary">{{ $berita->nama }}</span>
                    <span>{{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}</span>
                </div>
                <h3 class="text-lg font-bold text-secondary mb-2 leading-snug group-hover:text-primary transition-colors">
                    <a href="{{ url('landing/berita/'.encrypt($berita->id)) }}">{{ $berita->judul }}</a>
                </h3>
                <p class="text-muted text-sm mb-4 line-clamp-2">{!! Str::limit(strip_tags($berita->isi), 90) !!}</p>
                <a class="mt-auto inline-flex items-center gap-2 font-bold text-primary text-sm" href="{{ url('landing/berita/'.encrypt($berita->id)) }}">
                    Baca Selengkapnya <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>

@include('footer')

<script>
const agendaData = @json($agendaMap);

function openAgenda(date){
    const modal = document.getElementById('agendaModal');
    const content = document.getElementById('agendaContent');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    const data = agendaData[date];
    if(!data){
        content.innerHTML = `<p class="text-muted text-sm">Tidak ada agenda pada tanggal ini.</p>`;
        return;
    }
    let html = '';
    data.forEach(a => {
        html += `
        <div class="p-4 border border-border rounded-lg">
            <div class="font-bold text-secondary">${a.judul_agenda}</div>
            <div class="text-sm text-muted">${a.lokasi}</div>
            <div class="text-xs mt-1 text-muted">${a.deskripsi ?? ''}</div>
            <div class="text-xs text-primary font-semibold mt-2">${a.jam_mulai} - ${a.jam_selesai}</div>
        </div>`;
    });
    content.innerHTML = html;
}
function closeModal(){
    document.getElementById('agendaModal').classList.add('hidden');
    document.getElementById('agendaModal').classList.remove('flex');
}
window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

/* Hero background slider - crossfade tenang, tanpa efek zoom dramatis */
const heroBgSwiper = new Swiper('.heroBgSwiper', {
    effect: 'fade',
    fadeEffect: { crossFade: true },
    speed: 1200,
    loop: true,
    autoplay: { delay: 5000, disableOnInteraction: false },
});
</script>
