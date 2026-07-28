<?php

namespace App\Jobs;

use App\Models\Pengaduan;
use App\Services\AiProcessService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

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

            $apiKey = config('services.ai.gemini_key');
            if (!$apiKey) {
                throw new \RuntimeException("GEMINI_API_KEY tidak dikonfigurasi di Laravel .env");
            }

            $categories = [
                'Pendaftaran & Administrasi',
                'Pelayanan Petugas/Medis',
                'Waktu Tunggu & Antrean',
                'Kebersihan & Fasilitas',
                'Ketersediaan Obat',
                'Sarana & Prasarana',
                'Lainnya',
            ];
            $urgencyRubric = [
                'tinggi' => 'Berpotensi membahayakan keselamatan/kesehatan, butuh tindakan < 24 jam.',
                'sedang' => 'Mengganggu kualitas layanan, perlu tindak lanjut dalam beberapa hari.',
                'rendah' => 'Masukan atau kritik ringan, tidak mendesak.',
            ];

            $kategoriList = implode("\n", array_map(fn($k) => "- $k", $categories));
            $urgencyList = implode("\n", array_map(fn($k, $v) => "- $k: $v", array_keys($urgencyRubric), $urgencyRubric));

            $prompt = "Kamu adalah sistem klasifikasi internal untuk pengaduan masyarakat di sebuah Puskesmas. " .
                "Ini BUKAN chatbot publik — hasil klasifikasi ini HANYA dilihat oleh admin/staff internal, tidak pernah ditampilkan atau dikirim balik ke pelapor.\n\n" .
                "TUGAS: Klasifikasikan pengaduan berikut ke TEPAT SATU kategori dari daftar ini (gunakan nama kategori PERSIS seperti tertulis, jangan diubah/disingkat):\n" .
                $kategoriList . "\n\n" .
                "Tentukan tingkat urgensi berdasarkan rubrik berikut:\n" .
                $urgencyList . "\n\n" .
                "Berikan alasan singkat (maksimal 1 kalimat, bahasa Indonesia natural, jelaskan kenapa kategori dan urgensi ini yang paling tepat).\n\n" .
                "ATURAN PENTING:\n" .
                "- Jangan berikan saran tindakan medis, diagnosa, atau rekomendasi obat dalam bentuk apapun, walau isi pengaduan menyebut soal kesehatan/obat — tugasmu HANYA mengklasifikasi teks, bukan menjawab atau memberi saran medis.\n" .
                "- Kalau isi pengaduan tidak jelas, kosong, atau tidak bisa dipahami, pilih kategori \"Lainnya\" dan urgensi \"rendah\", dengan alasan \"Konten tidak jelas, perlu ditinjau manual\".\n\n" .
                "PENGADUAN:\n" .
                "Subjek: $subjek\n" .
                "Isi: $isi";

            // Jalankan classification via Python CLI process agar menggunakan kredensial Google otomatis yang sama dengan chatbot
            $pythonExec = AiProcessService::getPythonExecutable();
            $scriptPath = base_path('ai-service/classify_cli.py');
            
            $process = AiProcessService::createProcess([$pythonExec, $scriptPath, $subjek, $isi], 30);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new \RuntimeException("Python Service gagal: " . $process->getErrorOutput());
            }

            $output = $process->getOutput();
            $result = json_decode($output, true);

            if (json_last_error() !== JSON_ERROR_NONE || !isset($result['status'])) {
                throw new \RuntimeException("Format output dari Python Service tidak valid: " . $output);
            }

            if ($result['status'] === 'fallback' || $result['status'] === 'error') {
                $err = $result['error'] ?? 'API Error';
                throw new \RuntimeException("Python Service mengembalikan status gagal: " . $err);
            }

            $data = $result['data'] ?? [];
            if (!isset($data['kategori']) || !isset($data['urgensi']) || !isset($data['alasan'])) {
                throw new \RuntimeException("Skema data dari Python Service tidak lengkap.");
            }

            $pengaduan->update([
                'kategori_ai' => $data['kategori'],
                'urgensi_ai' => $data['urgensi'],
                'alasan_ai' => $data['alasan'],
                'kategori_final' => $data['kategori'],
                'urgensi_final' => $data['urgensi'],
                'status_klasifikasi' => 'selesai',
            ]);
        } catch (\Throwable $e) {
            Log::error("ClassifyPengaduanJob gagal untuk pengaduan #{$this->pengaduanId}: " . $e->getMessage());

            // Sistem cadangan lokal jika Gemini API mengalami kendala
            $fallback = $this->localKeywordClassify($pengaduan->isi_pengaduan ?? '', $e->getMessage());

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
    private function localKeywordClassify(string $text, string $errorMsg = ''): array
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

        // Tentukan pesan alasan fallback berdasarkan detail error
        $reason = 'Klasifikasi lokal otomatis (sistem cadangan berbasis kata kunci karena kegagalan REST API/koneksi).';
        if ($errorMsg) {
            $errLower = strtolower($errorMsg);
            if (str_contains($errLower, 'quota') || str_contains($errLower, '429') || str_contains($errLower, 'limit') || str_contains($errLower, 'api key') || str_contains($errLower, 'key') || str_contains($errLower, 'unauthorized')) {
                $reason = 'Klasifikasi lokal otomatis (sistem cadangan berbasis kata kunci karena kuota/key API Gemini habis atau tidak valid).';
            }
        }

        return [
            'kategori' => $kategori,
            'urgensi' => $urgensi,
            'alasan' => $reason
        ];
    }
}
