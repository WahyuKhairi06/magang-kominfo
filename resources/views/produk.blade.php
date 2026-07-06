@include('navbar')

<main class="pt-28 pb-20 max-w-7xl mx-auto px-8">

<!-- HERO -->
<div class="mb-12">
    <h1 class="text-5xl font-extrabold text-primary tracking-tight mb-4">
        Inovasi II
    </h1>
    <p class="text-on-surface-variant text-lg max-w-2xl leading-relaxed">
        Isian Inovasi 2.
    </p>
</div>

<div class="flex flex-col md:flex-row gap-10">

<!-- ========================= -->
<!-- SIDEBAR FILTER -->
<!-- ========================= -->
<aside class="md:w-72 shrink-0">
    <div class="bg-slate-50 rounded-2xl p-6 sticky top-28 flex flex-col gap-6">

        <div>
            <h2 class="text-lg font-bold text-emerald-900 mb-1">Filter Inovasi</h2>
            <p class="text-slate-500 text-sm">Temukan inovasi unggulan</p>
        </div>

        <!-- KATEGORI -->
        <div class="flex flex-col gap-2">
            <label class="text-xs font-bold text-primary uppercase tracking-widest mb-2">
                Kategori Inovasi
            </label>

            <!-- Semua -->
            <a href="{{ route('produk.frontend') }}"
               class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg transition
               {{ request('kategori') ? 'text-slate-500 hover:bg-slate-200' : 'bg-amber-100 text-amber-900 font-bold' }}">
                <span class="material-symbols-outlined">category</span>
                Semua
            </a>

            <!-- Loop kategori unik -->
            @foreach($kategoris as $k)
            <a href="{{ route('produk.frontend', ['kategori' => $k->kategori]) }}"
               class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg transition
               {{ request('kategori') == $k->kategori ? 'bg-amber-100 text-amber-900 font-bold' : 'text-slate-500 hover:bg-slate-200' }}">
                
                <span class="material-symbols-outlined">category</span>
                {{ $k->kategori }}
            </a>
            @endforeach
        </div>

    </div>
</aside>

<!-- ========================= -->
<!-- PRODUK GRID -->
<!-- ========================= -->
<section class="flex-1">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
        <div class="text-on-surface-variant font-medium">
            Menampilkan 
            <span class="text-primary font-bold">
                {{ $produks->total() }} Produk
            </span>
        </div>
    </div>

    <!-- GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        @forelse($produks as $p)
        <div class="group bg-surface-container-lowest rounded-3xl overflow-hidden hover:shadow-xl transition">

            <!-- GAMBAR -->
            <div class="aspect-square overflow-hidden relative">

                <img 
                    src="{{ $p->foto ? asset('storage/'.$p->foto) : 'https://via.placeholder.com/300' }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition"
                >

                @if($p->harga_diskon)
                <div class="absolute top-4 right-4 bg-red-500 text-white text-xs px-3 py-1 rounded-full">
                    Diskon
                </div>
                @endif

            </div>

            <!-- CONTENT -->
            <div class="p-6">

                <h3 class="text-lg font-bold text-primary mb-1 leading-tight">
                    {{ $p->nama_produk }}
                </h3>

                <p class="text-sm text-slate-500 mb-3">
                    {{ $p->kategori }}
                </p>

                <div class="flex items-center justify-between mt-auto">

                    <div>
                        @if($p->harga_diskon)
                            <span class="text-red-500 line-through text-sm">
                                Rp {{ number_format($p->harga) }}
                            </span><br>

                            <span class="text-xl font-black text-secondary">
                                Rp {{ number_format($p->harga_diskon) }}
                            </span>
                        @else
                            <span class="text-xl font-black text-secondary">
                                Rp {{ number_format($p->harga) }}
                            </span>
                        @endif
                    </div>

                    <a href="#" class="p-2 bg-primary-container text-on-primary-container rounded-full hover:bg-primary hover:text-white transition">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>

                </div>

            </div>

        </div>
        @empty
            <div class="col-span-3 text-center text-slate-500 py-10">
                Tidak ada produk ditemukan
            </div>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-12 flex justify-center">
        {{ $produks->links() }}
    </div>

</section>
</div>

</main>

@include('footer')