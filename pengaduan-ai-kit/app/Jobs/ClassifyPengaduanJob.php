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
        // Ganti App\Models\Pengaduan kalau nama model asli di project beda
        $pengaduan = Pengaduan::find($this->pengaduanId);

        if (!$pengaduan) {
            Log::warning("ClassifyPengaduanJob: pengaduan #{$this->pengaduanId} tidak ditemukan, dilewati.");
            return;
        }

        try {
            $response = Http::timeout(25)
                ->withHeaders(['X-API-KEY' => config('services.ai.internal_key')])
                ->post(config('services.ai.base_url') . '/api/v1/admin/classify-complaint', [
                    'pengaduan_id' => $pengaduan->id,
                    // HANYA kirim subjek & isi — jangan pernah kirim nama/kontak pelapor
                    'subjek' => $pengaduan->subjek,
                    'isi' => $pengaduan->isi,
                ]);

            if ($response->failed()) {
                throw new \RuntimeException("AI service merespons error: " . $response->status());
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

            $pengaduan->update([
                'status_klasifikasi' => 'gagal',
            ]);

            // Tidak perlu $this->fail($e) — kegagalan klasifikasi tidak fatal,
            // admin tetap bisa klasifikasi manual. Cukup ditandai 'gagal'.
        }
    }
}
