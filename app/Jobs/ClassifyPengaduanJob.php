<?php

namespace App\Jobs;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClassifyPengaduanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;
    public int $timeout = 30;

    public function __construct(protected int $pengaduanId)
    {
    }

    public function handle(): void
    {
        $pengaduan = Pengaduan::find($this->pengaduanId);

        if (!$pengaduan) {
            Log::warning("ClassifyPengaduanJob: pengaduan #{$this->pengaduanId} tidak ditemukan, dilewati.");
            return;
        }

        try {
            // Karena tidak ada kolom subjek, potong 50 karakter pertama dari isi_pengaduan sebagai subjek
            $subjek = Str::limit($pengaduan->isi_pengaduan, 50);
            $isi = $pengaduan->isi_pengaduan ?? '';

            $response = Http::timeout(25)
                ->withHeaders(['X-API-KEY' => config('services.ai.internal_key')])
                ->post(config('services.ai.base_url') . '/api/v1/admin/classify-complaint', [
                    'pengaduan_id' => $pengaduan->id,
                    'subjek' => $subjek,
                    'isi' => $isi,
                ]);

            if ($response->failed()) {
                throw new \RuntimeException("AI service merespons error: " . $response->status() . ' - ' . $response->body());
            }

            $data = $response->json();

            $pengaduan->update([
                'kategori_ai' => $data['kategori'],
                'urgensi_ai' => $data['urgensi'],
                'alasan_ai' => $data['alasan'],
                // AI suggestion langsung jadi nilai aktif sampai admin override manual
                'kategori_final' => $data['kategori'],
                'urgensi_final' => $data['urgensi'],
                'status_klasifikasi' => 'selesai',
            ]);
        } catch (\Throwable $e) {
            Log::error("ClassifyPengaduanJob gagal untuk pengaduan #{$this->pengaduanId}: " . $e->getMessage());

            // Sistem cadangan lokal jika Python API atau Gemini API mengalami kendala total
            $fallback = $this->localKeywordClassify($pengaduan->isi_pengaduan ?? '');

            $pengaduan->update([
                'kategori_ai' => $fallback['kategori'],
                'urgensi_ai' => $fallback['urgensi'],
                'alasan_ai' => $fallback['alasan'],
                'kategori_final' => $fallback['kategori'],
                'urgensi_final' => $fallback['urgensi'],
                'status_klasifikasi' => 'selesai',
            ]);
        }
    }

    /**
     * Klasifikasi cadangan berbasis kata kunci (Rule-based Local Matching)
     */
    private function localKeywordClassify(string $text): array
    {
        $text = strtolower($text);

        $keywords = [
            'Pendaftaran & Administrasi' => ['daftar', 'registrasi', 'online', 'ktp', 'kk', 'bpjs', 'kartu', 'administrasi', 'loket', 'berkas', 'rujukan', 'kis', 'kartu bpjs'],
            'Pelayanan Petugas/Medis' => ['dokter', 'perawat', 'bidan', 'petugas', 'suster', 'pelayanan', 'ramah', 'kasar', 'lambat', 'cuek', 'marah', 'sopan', 'medis', 'layan'],
            'Waktu Tunggu & Antrean' => ['lama', 'tunggu', 'antre', 'antrean', 'jam', 'menunggu', 'antrian'],
            'Kebersihan & Fasilitas' => ['kotor', 'bersih', 'bau', 'toilet', 'wc', 'sampah', 'ac', 'panas', 'kursi', 'ruang', 'bocor', 'nyamuk'],
            'Ketersediaan Obat' => ['obat', 'resep', 'apotek', 'habis', 'kosong', 'puyer', 'sirup', 'vitamin', 'salep', 'alkes', 'farmasi'],
            'Sarana & Prasarana' => ['parkir', 'jalan', 'gedung', 'ambulan', 'ambulance', 'ruangan', 'kursi roda', 'timbangan', 'alat', 'tensi', 'fasilitas'],
        ];

        $scores = [];
        foreach ($keywords as $category => $words) {
            $scores[$category] = 0;
            foreach ($words as $word) {
                if (str_contains($text, $word)) {
                    $scores[$category]++;
                }
            }
        }

        arsort($scores);
        $kategori = key($scores);
        $maxScore = current($scores);

        if ($maxScore === 0) {
            $kategori = 'Lainnya';
        }

        $urgensi = 'rendah';
        $emergencyKeywords = ['darurat', 'gawat', 'sekarat', 'pingsan', 'kecelakaan', 'pendarahan', 'sesak', 'jantung', 'kejang', 'meninggal', 'mati', 'kritis', 'parah'];
        foreach ($emergencyKeywords as $word) {
            if (str_contains($text, $word)) {
                $urgensi = 'tinggi';
                break;
            }
        }

        if ($urgensi === 'rendah') {
            $moderateKeywords = ['sakit', 'demam', 'luka', 'nyeri', 'muntah', 'diare', 'obat habis', 'antrean panjang', 'antrian panjang', 'kasar', 'lambat'];
            foreach ($moderateKeywords as $word) {
                if (str_contains($text, $word)) {
                    $urgensi = 'sedang';
                    break;
                }
            }
        }

        return [
            'kategori' => $kategori,
            'urgensi' => $urgensi,
            'alasan' => 'Klasifikasi lokal otomatis (sistem cadangan berbasis kata kunci karena kegagalan API Laravel).'
        ];
    }
}
