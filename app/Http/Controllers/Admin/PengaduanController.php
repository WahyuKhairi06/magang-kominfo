<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    // LIST ADMIN
    public function index(Request $request)
    {
        $perPage = in_array((int)$request->input('per_page'), [10, 25, 50, 100])
            ? (int)$request->input('per_page')
            : 10;

        $query = Pengaduan::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('kategori')) {
            $query->where(function($q) use ($request) {
                $q->where('kategori_final', $request->kategori)
                  ->orWhere('kategori_ai', $request->kategori);
            });
        }

        $data = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('admin.pengaduan.index', compact('data', 'perPage'));
    }

    // CETAK PDF WITH DATE RANGE
    public function cetakPdf(Request $request)
    {
        $query = Pengaduan::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('kategori')) {
            $query->where(function($q) use ($request) {
                $q->where('kategori_final', $request->kategori)
                  ->orWhere('kategori_ai', $request->kategori);
            });
        }

        $data = $query->orderBy('created_at', 'desc')->get();
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.pengaduan.pdf', compact('data', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-pengaduan-' . date('Y-m-d') . '.pdf');
    }

    // DETAIL/EDIT ADMIN
    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Jika aduan masih pending saat admin melihat detailnya (misal karena queue listener lokal belum jalan),
        // paksa proses klasifikasi berjalan secara sinkron agar admin langsung mendapatkan hasilnya tanpa menunggu.
        if ($pengaduan->status_klasifikasi === 'pending') {
            try {
                \App\Jobs\ClassifyPengaduanJob::dispatchSync($pengaduan->id);
                $pengaduan = $pengaduan->fresh();
            } catch (\Throwable $e) {
                // abaikan kegagalan klasifikasi agar halaman detail tetap bisa dibuka
            }
        }

        return view('admin.pengaduan.edit', compact('pengaduan'));
    }

    // DELETE ADMIN
    public function destroy($id)
    {
        DB::table('pengaduans')->where('id', $id)->delete();

        return back()->with('success', 'Pengaduan berhasil dihapus');
    }

    // UPDATE KLASIFIKASI (PATCH override)
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
     * ai-service/taxonomy.py bagian CATEGORIES.
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