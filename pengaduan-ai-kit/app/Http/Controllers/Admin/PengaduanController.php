<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ClassifyPengaduanJob;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

/**
 * CATATAN INTEGRASI:
 * File ini adalah REFERENSI method yang perlu ditambahkan ke PengaduanController
 * yang SUDAH ADA di project (baik untuk sisi publik/store, maupun sisi admin).
 * JANGAN timpa seluruh file controller asli — gabungkan method di bawah ini
 * ke controller yang sudah ada, sesuaikan namespace/import sesuai struktur asli.
 */
class PengaduanController extends Controller
{
    /**
     * Tambahkan baris dispatch job ini SETELAH pengaduan berhasil disimpan
     * di method store() yang sudah ada (sisi publik, form pengaduan).
     *
     * Contoh penempatan:
     *
     *   public function store(Request $request)
     *   {
     *       $validated = $request->validate([...]);
     *       $pengaduan = Pengaduan::create($validated); // status_klasifikasi default 'pending'
     *
     *       ClassifyPengaduanJob::dispatch($pengaduan->id); // <-- TAMBAHKAN INI
     *
     *       return redirect()->back()->with('success', 'Pengaduan berhasil dikirim.');
     *   }
     */
    public function exampleStoreIntegration(Request $request)
    {
        $validated = $request->validate([
            'subjek' => 'required|string|max:255',
            'isi' => 'required|string',
            // field lain sesuai form asli (nama, kontak, dll — tidak berubah)
        ]);

        $pengaduan = Pengaduan::create($validated);

        ClassifyPengaduanJob::dispatch($pengaduan->id);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim.');
    }

    /**
     * Endpoint baru: admin override kategori/urgensi lewat klik chip.
     * Daftarkan route PATCH ke method ini (lihat routes/pengaduan-ai.php).
     */
    public function updateKlasifikasi(Request $request, int $id)
    {
        $validated = $request->validate([
            'kategori_final' => 'required|string|in:' . implode(',', $this->kategoriOptions()),
            'urgensi_final' => 'required|string|in:rendah,sedang,tinggi',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        $pengaduan->update([
            'kategori_final' => $validated['kategori_final'],
            'urgensi_final' => $validated['urgensi_final'],
            // is_overridden true kalau nilai final beda dari saran AI awal
            'is_overridden' => $validated['kategori_final'] !== $pengaduan->kategori_ai
                || $validated['urgensi_final'] !== $pengaduan->urgensi_ai,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'pengaduan' => $pengaduan->fresh(),
        ]);
    }

    /**
     * Sumber kebenaran kategori di sisi PHP — WAJIB SAMA PERSIS dengan
     * ai-service/taxonomy.py bagian CATEGORIES. Kalau salah satu diubah,
     * yang lain wajib ikut diubah (lihat AGENTS.md aturan #1).
     */
    private function kategoriOptions(): array
    {
        return [
            'Pendaftaran & Administrasi',
            'Pelayanan Petugas/Medis',
            'Waktu Tunggu & Antrean',
            'Kebersihan & Fasilitas',
            'Ketersediaan Obat',
            'Sarana & Prasarana',
            'Lainnya',
        ];
    }
}
