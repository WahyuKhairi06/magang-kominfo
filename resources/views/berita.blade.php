@include('navbar')

<style>
/* 🌟 ANIMASI MASUK DARI TEPI */
.fade-in {
  opacity: 0;
  transform: translateY(40px);
  transition: all 0.6s ease;
}

.fade-in.show {
  opacity: 1;
  transform: translateY(0);
}

/* 🌄 PARALLAX BACKGROUND (optional section) */
.parallax {
  background-attachment: fixed;
  background-size: cover;
  background-position: center;
}

/* 🖼️ IMAGE SMOOTH ZOOM */
.berita-item img {
  transition: transform 0.5s ease;
}

.berita-item:hover img {
  transform: scale(1.1);
}
.fb-page {
    width: 100% !important;
}

.fb-page span,
.fb-page iframe {
    width: 100% !important;
}

.sticky {
    position: sticky;
    top: 20px;
}
</style>

<div class="bg-slate-50 min-h-screen py-10">

  <div class="max-w-7xl mx-auto px-6">

    <!-- TITLE (PARALLAX OPTIONAL) -->
    <div class="mb-10">
      <h1 class="text-3xl font-bold text-slate-800">Berita PKK</h1>
      <p class="text-slate-500 mt-2">Informasi terbaru kegiatan dan program</p>
    </div>

    <!-- FILTER -->
    <div class="flex flex-wrap gap-3 mb-8">
      <button onclick="filterKategori('all')"
        class="btn-filter px-4 py-2 rounded-xl bg-primary text-white text-sm font-semibold">
        Semua
      </button>

      @foreach($kategoris as $kat)
      <button onclick="filterKategori('{{ $kat->id }}')"
        class="btn-filter px-4 py-2 rounded-xl bg-white border text-slate-600 text-sm font-semibold hover:bg-primary hover:text-white transition">
        {{ $kat->nama }}
      </button>
      @endforeach
    </div>

    <!-- GRID BERITA -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

    <!-- BERITA -->
    <div class="lg:col-span-3">

        <div id="gridBerita" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach($beritas as $item)

            <div class="berita-item fade-in bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden"
                 data-kategori="{{ $item->kategori_id }}">

                <div class="h-48 overflow-hidden">
                    <img src="{{ asset('storage/'.$item->gambar) }}"
                         class="w-full h-full object-cover">
                </div>

                <div class="p-5">

                    <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                        {{ $item->kategori ?? 'Umum' }}
                    </span>

                    <h3 class="mt-3 text-lg font-bold line-clamp-2">
                        {{ $item->judul }}
                    </h3>

                    <p class="text-xs text-slate-400 mt-2">
                        {{ \Carbon\Carbon::parse($item->tanggal_publish)->format('d M Y') }}
                    </p>

                    <a href="{{ url('landing/berita/'.encrypt($item->id)) }}"
                       class="inline-block mt-4 text-primary font-semibold">
                        Baca Selengkapnya →
                    </a>

                </div>

            </div>

            @endforeach

        </div>

    </div>

    <!-- SIDEBAR -->
    <div class="lg:col-span-1">

        <div class="bg-white rounded-2xl shadow p-4 sticky top-5">

            <h3 class="text-lg font-bold mb-4">
                Berita Sosial Media
            </h3>

            <div class="fb-page"
                 data-href="https://www.facebook.com/hcmarunggi/"
                 data-tabs="timeline"
                 data-width="340"
                 data-height="700"
                 data-adapt-container-width="true"
                 data-hide-cover="false"
                 data-show-facepile="false">
                <blockquote
                    cite="https://www.facebook.com/hcmarunggi/"
                    class="fb-xfbml-parse-ignore">
                    <a href="https://www.facebook.com/hcmarunggi/">
                        Facebook
                    </a>
                </blockquote>
            </div>

        </div>

    </div>

</div>

    </aside>

</div>

  </div>

</div>
<div id="fb-root"></div>

<script async defer crossorigin="anonymous"
src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v23.0">
</script>
<!-- SCRIPT -->
<script>
  
function filterKategori(kategori) {
    let items = document.querySelectorAll('.berita-item');

    items.forEach(item => {
        if (kategori === 'all') {
            item.style.display = 'block';
        } else {
            item.style.display = item.dataset.kategori == kategori ? 'block' : 'none';
        }
    });
}

/* 🌟 SCROLL ANIMATION (FADE + SLIDE) */
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
        }
    });
}, {
    threshold: 0.1
});

document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
});
</script>

@include('footer')