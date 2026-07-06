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
    Inovasi <br><span class="text-secondary-fixed">Puskesmas Marunggi</span>
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


    <!-- TITLE -->
  
<section class="max-w-7xl mx-auto px-6 py-10">

    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">

        <!-- HEADER -->
        <div class="px-6 py-5 bg-gradient-to-r from-emerald-600 to-teal-500 text-white">
            <h2 class="text-lg font-bold">
                Daftar Inovasi
            </h2>
            <p class="text-sm text-white/80">
                Kumpulan Inovasi Terbaru Puskesmas Marunggi
            </p>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-center w-16">No</th>
                        <th class="px-4 py-3 text-left">Judul Inovasi</th>                      
                        <th class="px-4 py-3 text-center">Tahun</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @foreach ($inovasi1 as $item)
                        <tr class="hover:bg-emerald-50 transition">

                            <td class="px-4 py-3 text-center text-gray-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-semibold text-gray-800">
                                {{ $item->judul_inovasi }}
                            </td>                            

                            <td class="px-4 py-3 text-center">
                                <span class="inline-block bg-emerald-100 text-emerald-700 text-xs px-3 py-1 rounded-full font-semibold">
                                    {{ $item->tahun_inovasi }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('inovasiview.frontend', $item->id_inovasi) }}"
                                   class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-xs font-semibold transition">
                                    Lihat
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