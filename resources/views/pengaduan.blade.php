@include('navbar')

<section class="max-w-3xl mx-auto px-6 py-20">

    <div class="bg-white shadow-lg rounded-2xl p-8">

        <h1 class="text-2xl font-bold text-emerald-700 mb-6">
            Form Pengaduan
        </h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-emerald-100 text-emerald-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pengaduan.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm font-semibold">Nama</label>
                <input type="text" name="nama"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="text-sm font-semibold">No HP</label>
                <input type="text" name="no_hp"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="text-sm font-semibold">Isi Pengaduan</label>
                <textarea name="isi_pengaduan" rows="5"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>

            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg">
                Kirim Pengaduan
            </button>

        </form>

    </div>

</section>

@include('footer')