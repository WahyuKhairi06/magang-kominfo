<div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-md modal-overlay" id="modal-edit{{ $halaman->id }}">
  <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden modal-content">

    <!-- HEADER -->
    <div class="p-8 pb-4 flex justify-between items-start border-b">
      <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
          Edit Kategori Halaman {{ $halaman->nama }}
        </h2>
      </div>

      <button 
        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 transition-colors text-slate-400"
        onclick="closeModal('modal-edit{{ $halaman->id }}')">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>

    <!-- FORM -->
    <form class="p-8 space-y-6" action="{{ url('kategori-halaman').'/'. $halaman->id }}" method="POST">
      @csrf
      @method('PUT')

      <!-- INPUT GRID -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- NAMA ROLE -->
        <div class="space-y-2">
          <label class="text-xs font-bold uppercase tracking-wider text-slate-600">
            Nama 
          </label>
          <input 
            type="text"
            name="nama"
            value="{{ $halaman->nama}}"
            placeholder="Contoh: Visi/Profile"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none"
          />
        </div>

        <!-- KETERANGAN -->
        <div class="space-y-2">
          <label class="text-xs font-bold uppercase tracking-wider text-slate-600">
            Keterangan
          </label>
          <input 
            type="text"
            name="keterangan"
            value="{{ $halaman->keterangan }}"
            placeholder="Keterangan role"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none"
          />
        </div>

      </div>

      <!-- ACTION BUTTON -->
      <div class="flex justify-end gap-3 pt-6 border-t">
        <button 
          type="button"
          onclick="closeModal('modal-edit{{ $halaman->id }}')"
          class="px-6 py-3 rounded-xl text-sm font-semibold text-slate-500 hover:bg-slate-100 transition">
          Batal
        </button>

        <button 
          type="submit"
          class="px-8 py-3 rounded-xl text-sm font-bold bg-primary text-white shadow-lg hover:scale-[1.02] active:scale-[0.98] transition">
          Update 
        </button>
      </div>

    </form>
  </div>
</div>