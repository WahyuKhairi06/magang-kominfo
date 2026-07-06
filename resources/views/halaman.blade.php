@include('navbar')
<main class="max-w-7xl mx-auto px-6 lg:px-8 py-12">

<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 ">
<!-- Main Content Area -->
<div class="lg:col-span-8 space-y-16">
<!-- Featured Article (Editorial Style) -->
<section class="relative group cursor-pointer">

<!-- Excerpt / Ghost Section -->
<div class="md:col-span-3 mt-10">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 w-full">

@if($halaman->id==8)
@php


// Fungsi untuk menentukan ukuran card sesuai jabatan
function sizeClass($jabatan){
    return match(true){
        str_contains($jabatan,'Ketua TP PKK') => 'w-80 scale-110',
        (str_contains($jabatan,'Wakil Ketua') || str_contains($jabatan,'Sekretaris') || str_contains($jabatan,'Bendahara')) && !str_contains($jabatan,'Pokja')
            => 'w-72',
        str_contains($jabatan,'Ketua Pokja') => 'w-64',
        str_contains($jabatan,'Wakil Ketua Pokja') || str_contains($jabatan,'Sekretaris Pokja')
            => 'w-56',
        str_contains($jabatan,'Anggota') => 'w-52',
        default => 'w-60'
    };
}

// Filter data fleksibel
$ketua = $data->filter(fn($item) => str_contains($item->jabatan, 'Ketua TP PKK'));
$wakil_sekretaris = $data->filter(fn($item) => str_contains($item->jabatan, 'Wakil Ketua') || str_contains($item->jabatan, 'Sekretaris') || str_contains($item->jabatan, 'Bendahara'));
$pokja = $data->filter(fn($item) => str_contains($item->jabatan, 'Pokja'));
@endphp

<main class="pt-32 pb-24 px-4 md:px-10 max-w-[1440px] mx-auto">

    <!-- HEADER -->
    <div class="text-center mb-16">
        <h1 class="text-3xl md:text-4xl font-bold text-blue-800">
            STRUKTUR ORGANISASI
        </h1>
        <p class="text-gray-500 mt-2">
            Puskesmas Marunggi
        </p>
    </div>

    <!-- LEVEL TOP (KETUA TP PKK) -->
    <div class="flex justify-center mb-12 flex-wrap gap-6">
        @foreach($ketua as $item)
            @php
                $foto = $item->foto
                    ? asset('storage/organisasi/'.$item->foto)
                    : 'https://ui-avatars.com/api/?name='.urlencode($item->nama);
            @endphp
            <div class="bg-white shadow-xl rounded-2xl p-6 text-center border-2 border-blue-500 {{ sizeClass($item->jabatan) }}">
                <img src="{{ $foto }}" class="w-24 h-24 mx-auto rounded-full border-4 border-blue-400 object-cover">
                <h2 class="mt-3 font-bold text-blue-700">{{ $item->nama }}</h2>
                <p class="text-sm text-red-600 font-semibold">{{ $item->jabatan }}</p>
            </div>
        @endforeach
    </div>

    <!-- WAKIL + SEKRETARIS + BENDARA -->
    <div class="flex flex-wrap justify-center gap-6 mb-12">
        @foreach($wakil_sekretaris as $item)
            @php
                $foto = $item->foto
                    ? asset('storage/organisasi/'.$item->foto)
                    : 'https://ui-avatars.com/api/?name='.urlencode($item->nama);
            @endphp
            <div class="bg-white shadow-md rounded-xl p-4 text-center w-60 hover:scale-105 transition">
                <img src="{{ $foto }}" class="w-20 h-20 mx-auto rounded-full border object-cover">
                <h3 class="mt-2 font-semibold text-gray-800">{{ $item->nama }}</h3>
                <p class="text-sm text-blue-600">{{ $item->jabatan }}</p>
            </div>
        @endforeach
    </div>

    <!-- POKJA SECTION -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($pokja as $item)
            @php
                $foto = $item->foto
                    ? asset('storage/organisasi/'.$item->foto)
                    : 'https://ui-avatars.com/api/?name='.urlencode($item->nama);
            @endphp
            <div class="bg-white rounded-xl shadow-lg p-4 text-center hover:-translate-y-2 transition">
                <img src="{{ $foto }}" class="w-16 h-16 mx-auto rounded-full border object-cover">
                <h4 class="mt-2 font-bold text-gray-800 text-sm">{{ $item->nama }}</h4>
                <p class="text-xs text-gray-500">{{ $item->jabatan }}</p>
            </div>
        @endforeach
    </div>

</main>
@else
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            {{ $halaman->judul }}
        </h2>

        <div class="prose max-w-none text-gray-700 break-words">
            {!! $halaman->isi !!}
        </div>
@endif

    </div>
</div>
</section>
</div>
<!-- Sidebar -->
<aside class="lg:col-span-4 space-y-12">
<!-- Berita Terkini List -->
<div class="bg-surface-container-low p-8 rounded-[2rem]">
<div class="flex items-center justify-between mb-8">
<h3 class="text-lg font-bold text-primary">Berita Terkini</h3>
<span class="material-symbols-outlined text-secondary">rss_feed</span>
</div>
<div class="space-y-8">
<!-- Recent Item 1 -->
@foreach ($berita as $ber )
    
<div class="flex gap-4 group cursor-pointer">
<div class="w-20 h-20 shrink-0 rounded-xl overflow-hidden bg-white">
<img class="w-full h-full object-cover group-hover:scale-110 transition-transform" data-alt="Close up of digital tablet showing healthcare app data for children" src="{{ asset('storage/' . $ber->gambar) }}"/>
</div>
<div class="flex flex-col justify-center">
<span class="text-[10px] font-medium text-outline">{{ $ber->tanggal_publish }}</span>
<h4 class="text-sm font-bold text-primary group-hover:text-secondary transition-colors line-clamp-2">{{ $ber->judul }}</h4>
</div>
</div>
@endforeach

</div>
<button class="w-full mt-10 py-3 rounded-xl border border-primary/10 text-primary font-bold text-xs uppercase tracking-widest hover:bg-primary hover:text-white transition-all">Lihat Semua Berita</button>
</div>
<!-- Social Feed Card (Facebook Style) -->
<div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border">

<div class="bg-[#1877F2] p-4 flex items-center gap-3">
    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
        <span class="text-[#1877F2] font-black text-xl">f</span>
    </div>
    <div>
        <p class="text-white text-sm font-bold">PKK Desa Talago Sariak Kota Pariaman</p>
        <p class="text-white/80 text-[10px]">Facebook Feed</p>
    </div>
</div>

<!-- EMBED FACEBOOK -->
<div class="p-3">
    <div class="fb-page"
        data-href="https://www.facebook.com/profile.php?id=100025930223109"
        data-tabs="timeline"
        data-width="500"
        data-height="600"
        data-small-header="false"
        data-adapt-container-width="true"
        data-hide-cover="false"
        data-show-facepile="true">
    </div>
</div>

</div>

</aside>
</div>
</main>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" 
src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v19.0">
</script>
@include('footer')
