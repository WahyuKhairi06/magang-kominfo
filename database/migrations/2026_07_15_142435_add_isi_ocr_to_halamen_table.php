<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('halamen', function (Blueprint $table) {
            $table->longText('isi_ocr')->nullable()->after('isi');
        });

        // Backfill existing halamen with OCR data
        try {
            $halamen = DB::table('halamen')->get();
            foreach ($halamen as $h) {
                if (empty($h->isi)) {
                    continue;
                }

                preg_match_all('/<img[^>]+src="([^">]+)"/i', $h->isi, $matches);
                if (empty($matches[1])) {
                    continue;
                }

                $ocrTexts = [];
                foreach ($matches[1] as $url) {
                    $filename = basename(urldecode($url));
                    $imagePath = public_path('uploads/' . $filename);

                    if (file_exists($imagePath)) {
                        try {
                            $process = new Process(['python', base_path('ai-service/extract_ocr.py'), $imagePath]);
                            $process->setTimeout(60);
                            $process->run();

                            if ($process->isSuccessful()) {
                                $res = json_decode($process->getOutput(), true);
                                if (isset($res['status']) && $res['status'] === 'success') {
                                    $ocrTexts[] = $res['ocr_text'];
                                }
                            }
                        } catch (\Exception $e) {
                            // Suppress process errors so migration doesn't crash
                        }
                    }
                }

                if (!empty($ocrTexts)) {
                    $combinedOcr = implode("\n\n---\n\n", $ocrTexts);
                    DB::table('halamen')->where('id', $h->id)->update(['isi_ocr' => $combinedOcr]);
                }
            }
        } catch (\Exception $e) {
            // Log or ignore backfill errors to keep migration running
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('halamen', function (Blueprint $table) {
            $table->dropColumn('isi_ocr');
        });
    }
};
