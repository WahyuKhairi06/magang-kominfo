@include('navbar')
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #00502e 0%, #006b3f 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
<!-- HERO -->
<header class="relative overflow-hidden py-10 md:py-12 hero-gradient">
<div class="max-w-7xl mx-auto px-8 relative z-10 text-center">
<h1 class="mt-20 text-5xl md:text-7xl font-extrabold text-white tracking-tighter mb-6 leading-tight">
    Pusat Unduh <br><span class="text-secondary-fixed">Dokumen</span>
</h1>
<!-- </div> -->
</header>

<!-- SEARCH & FILTER -->
<!-- <section class="max-w-7xl mx-auto px-8 -mt-10 relative z-20">

<div class="bg-white/80 backdrop-blur p-6 rounded-2xl shadow mb-8"> -->

    <!-- SEARCH -->
    <!-- <input id="searchDoc"
           type="text"
           placeholder="Cari dokumen..."
           class="w-full px-4 py-3 rounded-xl border mb-4"> -->

    <!-- FILTER -->
    <!-- <div class="flex flex-wrap gap-3">

        <button onclick="filterDok('all')" class="px-4 py-2 rounded-xl bg-primary text-white">Semua</button>
        <button onclick="filterDok('PDF')" class="px-4 py-2 rounded-xl bg-gray-100">PDF</button>
        <button onclick="filterDok('DOCX')" class="px-4 py-2 rounded-xl bg-gray-100">DOCX</button>
        <button onclick="filterDok('XLSX')" class="px-4 py-2 rounded-xl bg-gray-100">XLSX</button>

    </div> -->

<!-- </div> -->
<!-- 
</section> -->

<!-- GRID -->
<!-- <section class="max-w-7xl mx-auto px-8 py-10">

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"> -->

@foreach($dokumen as $item)

@if($item->is_active == 1)

<div class="doc-card group bg-surface-container-lowest p-6 rounded-[1.5rem] transition-all hover:translate-y-[-8px] hover:shadow-2xl hover:shadow-primary/10"
     data-kategori="{{ $item->kategori }}">

    <!-- ICON -->
    <div class="flex items-start justify-between mb-6">

        <div class="w-14 h-14 rounded-2xl flex items-center justify-center
            @if($item->kategori == 'PDF') bg-red-100 text-red-600
            @elseif($item->kategori == 'DOCX') bg-blue-100 text-blue-600
            @elseif($item->kategori == 'XLSX') bg-green-100 text-green-600
            @else bg-gray-100 text-gray-600
            @endif">

            <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">
                @if($item->kategori == 'PDF') picture_as_pdf
                @elseif($item->kategori == 'DOCX') description
                @elseif($item->kategori == 'XLSX') table_chart
                @else description
                @endif
            </span>

        </div>      

    </div>

    <!-- TITLE -->
    
  <table class="table-fixed w-full border border-gray-200">
        <thead class="bg-primary text-white">
            <tr>
                 <th class="w-12 px-3 py-2 text-center">No</th>
                 <th class="w-64 px-3 py-2 text-left">Judul Dokumen</th>
                 <th class="px-3 py-2 text-left">Deskripsi</th>
                 <th class="w-32 px-3 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($dokumen as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-4 py-3 font-semibold text-gray-800">
                        {{ $item->judul }}
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        {{ $item->deskripsi }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        <a href="{{ url('/download/'.$item->id) }}"
                           class="inline-flex items-center gap-2 bg-secondary text-white px-4 py-2 rounded-lg hover:bg-primary transition">
                            <span class="material-symbols-outlined text-[18px]">
                                download
                            </span>
                            Unduh
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



@endif

@endforeach

</div>

</section>

@include('footer')

<!-- SCRIPT -->
<script>

/* 🔍 SEARCH */
document.getElementById('searchDoc').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    let cards = document.querySelectorAll('.doc-card');

    cards.forEach(card => {
        card.style.display = card.innerText.toLowerCase().includes(value) ? 'block' : 'none';
    });
});

/* 📂 FILTER */
function filterDok(type) {
    let cards = document.querySelectorAll('.doc-card');

    cards.forEach(card => {
        let kat = card.getAttribute('data-kategori');

        if (type === 'all') {
            card.style.display = 'block';
        } else {
            card.style.display = (kat === type) ? 'block' : 'none';
        }
    });
}

</script>