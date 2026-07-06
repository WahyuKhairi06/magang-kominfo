@include('navbar')

<main class="pt-28 md:pt-32 pb-20 max-w-7xl mx-auto px-6">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Main Content -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl border border-border p-6 md:p-10">

                @if($halaman->id==8)
                @php
                    function sizeClass($jabatan){
                        return match(true){
                            str_contains($jabatan,'Ketua TP PKK') => 'w-72 md:w-80 scale-105',
                            (str_contains($jabatan,'Wakil Ketua') || str_contains($jabatan,'Sekretaris') || str_contains($jabatan,'Bendahara')) && !str_contains($jabatan,'Pokja')
                                => 'w-64 md:w-72',
                            str_contains($jabatan,'Ketua Pokja') => 'w-56 md:w-64',
                            str_contains($jabatan,'Wakil Ketua Pokja') || str_contains($jabatan,'Sekretaris Pokja')
                                => 'w-48 md:w-56',
                            str_contains($jabatan,'Anggota') => 'w-44 md:w-52',
                            default => 'w-52 md:w-60'
                        };
                    }
                    $ketua = $data->filter(fn($item) => str_contains($item->jabatan, 'Ketua TP PKK'));
                    $wakil_sekretaris = $data->filter(fn($item) => str_contains($item->jabatan, 'Wakil Ketua') || str_contains($item->jabatan, 'Sekretaris') || str_contains($item->jabatan, 'Bendahara'));
                    $pokja = $data->filter(fn($item) => str_contains($item->jabatan, 'Pokja'));
                @endphp

                <div class="text-center mb-12">
                    <span class="text-primary font-bold tracking-[0.14em] text-xs uppercase">Profil</span>
                    <h1 class="font-serif text-2xl md:text-3xl text-secondary mt-2">Struktur Organisasi</h1>
                    <p class="text-muted mt-1">Puskesmas Marunggi</p>
                </div>

                <!-- LEVEL TOP -->
                <div class="flex justify-center mb-10 flex-wrap gap-6">
                    @foreach($ketua as $item)
                        @php $foto = $item->foto ? asset('storage/organisasi/'.$item->foto) : 'https://ui-avatars.com/api/?name='.urlencode($item->nama).'&background=006BE9&color=fff'; @endphp
                        <div class="bg-white border-2 border-primary shadow-md rounded-xl p-6 text-center {{ sizeClass($item->jabatan) }}">
                            <img src="{{ $foto }}" class="w-24 h-24 mx-auto rounded-full border-4 border-primary/20 object-cover">
                            <h2 class="mt-3 font-bold text-secondary">{{ $item->nama }}</h2>
                            <p class="text-sm text-primary font-semibold">{{ $item->jabatan }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- WAKIL/SEKRETARIS -->
                <div class="flex flex-wrap justify-center gap-5 mb-10">
                    @foreach($wakil_sekretaris as $item)
                        @php $foto = $item->foto ? asset('storage/organisasi/'.$item->foto) : 'https://ui-avatars.com/api/?name='.urlencode($item->nama).'&background=F2F3F4&color=052049'; @endphp
                        <div class="bg-white border border-border shadow-sm rounded-xl p-4 text-center {{ sizeClass($item->jabatan) }} hover:shadow-md transition">
                            <img src="{{ $foto }}" class="w-20 h-20 mx-auto rounded-full border border-border object-cover">
                            <h3 class="mt-2 font-semibold text-secondary text-sm">{{ $item->nama }}</h3>
                            <p class="text-xs text-primary">{{ $item->jabatan }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- POKJA -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
                    @foreach($pokja as $item)
                        @php $foto = $item->foto ? asset('storage/organisasi/'.$item->foto) : 'https://ui-avatars.com/api/?name='.urlencode($item->nama).'&background=F2F3F4&color=052049'; @endphp
                        <div class="bg-white border border-border rounded-xl p-4 text-center hover:-translate-y-1 hover:shadow-md transition">
                            <img src="{{ $foto }}" class="w-16 h-16 mx-auto rounded-full border border-border object-cover">
                            <h4 class="mt-2 font-bold text-secondary text-sm">{{ $item->nama }}</h4>
                            <p class="text-xs text-muted">{{ $item->jabatan }}</p>
                        </div>
                    @endforeach
                </div>

                @else
                <h1 class="font-serif text-2xl md:text-3xl text-secondary mb-6">
                    {{ $halaman->judul }}
                </h1>
                <div class="prose prose-lg max-w-none text-on-surface break-words">
                    {!! $halaman->isi !!}
                </div>
                @endif

            </div>
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-4 space-y-8">
            <div class="bg-surface p-7 rounded-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-bold text-secondary">Berita Terkini</h3>
                    <span class="material-symbols-outlined text-primary">rss_feed</span>
                </div>
                <div class="space-y-6">
                    @forelse ($berita as $ber )
                    <a href="{{ url('landing/berita/'.encrypt($ber->id)) }}" class="flex gap-4 group">
                        <div class="w-20 h-20 shrink-0 rounded-lg overflow-hidden bg-white">
                            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform" src="{{ asset('storage/' . $ber->gambar) }}" alt="{{ $ber->judul }}">
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-[10px] font-medium text-muted">{{ \Carbon\Carbon::parse($ber->tanggal_publish)->format('d M Y') }}</span>
                            <h4 class="text-sm font-bold text-secondary group-hover:text-primary transition-colors line-clamp-2">{{ $ber->judul }}</h4>
                        </div>
                    </a>
                    @empty
                    <p class="text-sm text-muted">Belum ada berita.</p>
                    @endforelse
                </div>
                <a href="{{ url('landing/berita') }}" class="block w-full mt-8 py-3 rounded-full border border-primary text-primary font-bold text-xs uppercase tracking-widest text-center hover:bg-primary hover:text-white transition-all">
                    Lihat Semua Berita
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-border">
                <div class="bg-[#1877F2] p-4 flex items-center gap-3">
                    <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center">
                        <span class="text-[#1877F2] font-black text-lg">f</span>
                    </div>
                    <div>
                        <p class="text-white text-sm font-bold">Puskesmas Marunggi</p>
                        <p class="text-white/80 text-[10px]">Facebook Feed</p>
                    </div>
                </div>
                <div class="p-3">
                    <div class="fb-page" data-href="https://www.facebook.com/hcmarunggi/" data-tabs="timeline"
                         data-width="500" data-height="600" data-small-header="false"
                         data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"></div>
                </div>
            </div>
        </aside>
    </div>
</main>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v19.0"></script>

@include('footer')
