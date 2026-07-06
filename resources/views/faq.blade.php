@include('navbar')

<section class="max-w-3xl mx-auto px-6 py-20">

    <div class="bg-white shadow-lg rounded-2xl p-8">

        <h1 class="text-2xl font-bold text-emerald-700 mb-6">
            FAQ
        </h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-emerald-100 text-emerald-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('faq.store') }}" class="space-y-4">
            @csrf

           @foreach ($faqs as $faq)

<div class="mb-4">
    <label class="text-sm font-semibold">Pertanyaan</label>

    <div class="w-full border rounded-lg px-4 py-2 bg-gray-50">
        {{ $faq->pertanyaan }}
    </div>

    <label class="text-sm font-semibold mt-2 block">Jawaban</label>

    <div class="w-full border rounded-lg px-4 py-2 bg-gray-50">
        {{ $faq->jawaban }}
    </div>
</div>

@endforeach
    

        </form>

    </div>

</section>

@include('footer')