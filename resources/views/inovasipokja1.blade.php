@include('navbar')

<main class="pt-28 pb-20 px-4 sm:px-6 lg:px-10 max-w-7xl mx-auto">

    {{-- HEADER --}}
    <section class="mb-12">

        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-blue-600 to-cyan-500 p-8 md:p-12 shadow-2xl">

            {{-- background blur --}}
            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-60 h-60 bg-cyan-300/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                <div class="max-w-3xl">

                    <!-- <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-md px-4 py-2 rounded-full text-white text-sm mb-5 border border-white/20">

                        <span class="material-symbols-outlined text-[18px]">
                            folder_managed
                        </span>

                        Arsip Digital Pokja I

                    </div> -->

                    <h1 class="text-3xl md:text-5xl font-black text-white leading-tight mb-4">

                        Inovasi 
                        <span class="block text-cyan-100">
                            Tentang Inovasi
                        </span>

                    </h1>

                    <p class="text-white/90 text-base md:text-lg leading-relaxed max-w-2xl">

                        Kumpulan dokumen, laporan, dan file inovasi I
                        yang tersimpan secara digital dan dapat diakses kapan saja
                        dengan tampilan modern, aman, dan responsif.

                    </p>

                </div>

                {{-- ICON --}}
                <div class="hidden lg:flex items-center justify-center">

                    <div class="w-40 h-40 rounded-full bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center shadow-2xl">

                        <span class="material-symbols-outlined text-white text-[90px]">
                            folder_open
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- GRID --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        @forelse($pokja1 as $d)

        @php
            $file = $d->file;
            $url = asset('storage/'.$file);
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        @endphp

        <div class="group relative overflow-hidden rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 flex flex-col">

            {{-- TOP --}}
            <div class="p-6 flex-grow">

                {{-- IMAGE PREVIEW --}}
                @if(in_array($ext,['jpg','jpeg','png','webp']))

                <div class="mb-6 overflow-hidden rounded-2xl">

                    <img src="{{ $url }}"
                         class="w-full h-52 object-cover rounded-2xl group-hover:scale-105 transition duration-500">

                </div>

                @else

                {{-- ICON --}}
                <div class="mb-6">

                    @if($ext == 'pdf')

                    <div class="w-20 h-20 rounded-2xl bg-red-100 flex items-center justify-center shadow-inner">

                        <span class="material-symbols-outlined text-[48px] text-red-600">
                            picture_as_pdf
                        </span>

                    </div>

                    @elseif(in_array($ext,['xls','xlsx']))

                    <div class="w-20 h-20 rounded-2xl bg-green-100 flex items-center justify-center shadow-inner">

                        <span class="material-symbols-outlined text-[48px] text-green-600">
                            table_chart
                        </span>

                    </div>

                    @elseif(in_array($ext,['doc','docx']))

                    <div class="w-20 h-20 rounded-2xl bg-blue-100 flex items-center justify-center shadow-inner">

                        <span class="material-symbols-outlined text-[48px] text-blue-600">
                            description
                        </span>

                    </div>

                    @else

                    <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center shadow-inner">

                        <span class="material-symbols-outlined text-[48px] text-slate-500">
                            folder
                        </span>

                    </div>

                    @endif

                </div>

                @endif

                {{-- FILE NAME --}}
                <h2 class="text-lg font-bold text-slate-800 line-clamp-2 mb-3 group-hover:text-blue-600 transition">

                    <!-- {{ $file }} -->

                </h2>

                {{-- DESC --}}
                <details class="group/details">

                    <summary class="cursor-pointer list-none text-sm text-slate-500 leading-relaxed">

                        <span class="line-clamp-3 group-open/details:line-clamp-none">

                            {{ $d->keterangan ?? 'Dokumen inovasi I tersimpan secara digital.' }}

                        </span>

                        <span class="text-blue-600 font-semibold mt-2 inline-block">

                            Lihat Selengkapnya

                        </span>

                    </summary>

                </details>

            </div>

            {{-- FOOTER --}}
            <div class="px-6 py-5 border-t border-slate-100 bg-slate-50/70 backdrop-blur-sm">

                <div class="flex items-center justify-between">

                    {{-- EXTENSION --}}
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-slate-200 text-xs font-semibold text-slate-700 shadow-sm">

                        <span class="w-2 h-2 rounded-full bg-green-500"></span>

                        {{ strtoupper($ext) }}

                    </div>

                    {{-- BUTTON --}}
                    @if($file)

                    <a href="{{ $url }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-300">

                        <span class="material-symbols-outlined text-[18px]">
                            open_in_new
                        </span>

                        Buka

                    </a>

                    @else

                    <span class="text-sm text-slate-400">
                        Tidak ada file
                    </span>

                    @endif

                </div>

            </div>

            {{-- HOVER EFFECT --}}
            <div class="absolute inset-0 border-2 border-transparent group-hover:border-blue-500/20 rounded-3xl pointer-events-none transition-all duration-500"></div>

        </div>

        @empty

        <div class="col-span-full">

            <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 py-20 text-center">

                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-slate-200 flex items-center justify-center">

                    <span class="material-symbols-outlined text-slate-500 text-[50px]">
                        folder_off
                    </span>

                </div>

                <h3 class="text-2xl font-bold text-slate-700 mb-3">

                    Belum Ada Dokumen

                </h3>

                <p class="text-slate-500 max-w-md mx-auto">

                    Data dokumen Inovasi I belum tersedia
                    atau belum diunggah ke sistem.

                </p>

            </div>

        </div>

        @endforelse

    </section>

</main>

@include('footer')