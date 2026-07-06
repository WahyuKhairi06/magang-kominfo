@include('navbar')

<main class="pt-28 md:pt-32 pb-24 bg-surface min-h-screen">
    <div class="max-w-3xl mx-auto px-6">

        <div class="text-center mb-12">
            <span class="text-primary font-bold tracking-[0.14em] text-xs uppercase">Bantuan</span>
            <h1 class="font-serif text-3xl md:text-4xl text-secondary mt-2">Pertanyaan yang Sering Diajukan</h1>
            <p class="text-muted mt-3">Temukan jawaban atas pertanyaan umum seputar layanan Puskesmas Marunggi.</p>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-primary/10 text-primary rounded-lg text-sm font-semibold">
            {{ session('success') }}
        </div>
        @endif

        <div class="space-y-3">
            @forelse ($faqs as $i => $faq)
            <div class="bg-white border border-border rounded-xl overflow-hidden">
                <button type="button" onclick="toggleFaq({{ $i }})"
                        class="faq-btn w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
                    <span class="font-semibold text-secondary">{{ $faq->pertanyaan }}</span>
                    <span id="faq-icon-{{ $i }}" class="material-symbols-outlined text-primary shrink-0 transition-transform">add</span>
                </button>
                <div id="faq-answer-{{ $i }}" class="hidden px-6 pb-5 text-muted leading-relaxed">
                    {{ $faq->jawaban }}
                </div>
            </div>
            @empty
            <p class="text-center text-muted">Belum ada pertanyaan yang tersedia.</p>
            @endforelse
        </div>

        <div class="mt-14 bg-white border border-border rounded-2xl p-8 text-center">
            <h3 class="font-serif text-xl text-secondary mb-2">Masih punya pertanyaan lain?</h3>
            <p class="text-muted mb-6">Sampaikan langsung kepada kami melalui halaman pengaduan.</p>
            <a href="{{ route('pengaduan.form') }}" class="inline-flex items-center justify-center h-12 px-7 rounded-full bg-primary text-white font-semibold hover:bg-secondary transition-colors">
                Hubungi Kami
            </a>
        </div>
    </div>
</main>

@include('footer')

<script>
function toggleFaq(i) {
    const answer = document.getElementById('faq-answer-' + i);
    const icon = document.getElementById('faq-icon-' + i);
    const isOpen = !answer.classList.contains('hidden');
    if (isOpen) {
        answer.classList.add('hidden');
        icon.textContent = 'add';
    } else {
        answer.classList.remove('hidden');
        icon.textContent = 'remove';
    }
}
</script>
