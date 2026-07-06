@include('navbar')

<!-- HERO -->
<header class="relative overflow-hidden pt-28 md:pt-32 pb-16 bg-secondary">
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="text-white/60 font-bold tracking-[0.14em] text-xs uppercase">Program Unggulan</span>
        <h1 class="font-serif text-3xl md:text-5xl text-white mt-3">
            Inovasi Puskesmas Marunggi
        </h1>
        <p class="text-white/70 mt-4 max-w-xl mx-auto">Kumpulan inovasi terbaru dalam pelayanan kesehatan masyarakat.</p>
    </div>
</header>

<!-- TABLE -->
<section class="max-w-5xl mx-auto px-6 -mt-8 relative z-10 pb-24">

    <div class="bg-white rounded-2xl shadow-lg border border-border overflow-hidden">

        <!-- TABLE -->
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="bg-surface text-secondary text-left text-sm">
                        <th class="px-4 py-4 text-center w-16 font-bold">No</th>
                        <th class="px-4 py-4 font-bold">Judul Inovasi</th>
                        <th class="px-4 py-4 text-center font-bold">Tahun</th>
                        <th class="px-4 py-4 text-center font-bold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-border">

                    @foreach ($inovasi1 as $item)
                        <tr class="hover:bg-surface transition-colors">

                            <td class="px-4 py-4 text-center text-muted">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-4 font-semibold text-secondary">
                                {{ $item->judul_inovasi }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="inline-block bg-primary/10 text-primary text-xs px-3 py-1 rounded-full font-semibold">
                                    {{ $item->tahun_inovasi }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-center">
                                <a href="{{ route('inovasiview.frontend', $item->id_inovasi) }}"
                                   class="inline-flex items-center gap-1.5 bg-primary hover:bg-secondary text-white px-4 py-2 rounded-full text-xs font-semibold transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span> Lihat
                                </a>
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</section>
@include('footer')