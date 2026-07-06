<div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md modal-overlay"
     id="modal-delete{{ $halaman->id }}">

    <div class="bg-white w-full max-w-md rounded-[24px] shadow-2xl overflow-hidden modal-content p-6">

        <!-- ICON -->
        <div class="w-16 h-16 mx-auto bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-3xl">delete</span>
        </div>

        <!-- TEXT -->
        <h2 class="text-xl font-bold text-center text-slate-800 mb-2">
            Hapus Kategori Halaman?
        </h2>

        <p class="text-sm text-slate-500 text-center mb-6">
            Data <b>{{ $halaman->judul }}</b> akan dihapus permanen dan tidak bisa dikembalikan.
        </p>

        <!-- ACTION -->
        <div class="flex gap-3">

            <button type="button"
                class="flex-1 py-3 rounded-xl bg-slate-100 text-slate-600 font-semibold hover:bg-slate-200 transition"
                onclick="closeModal('modal-delete{{ $halaman->id }}')">
                Batal
            </button>

            <form action="{{ url('halaman/delete', $halaman->id) }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="w-full py-3 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 transition">
                    Hapus
                </button>
            </form>

        </div>

    </div>
</div>