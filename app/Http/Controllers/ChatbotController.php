<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ChatbotController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = $request->input('message');
        
        // Generate knowledge base from database dynamically
        $this->generateDatabaseKnowledge();
        
        // Path to the python script
        $scriptPath = base_path('ai-service/chat_api.py');
        
        $chatbotSetting = DB::table('chatbot_settings')->first();
        $aiName = $chatbotSetting->ai_name ?? 'Asisten Puskesmas';
        $puskesmasName = $chatbotSetting->puskesmas_display_name ?? 'Puskesmas Marunggi';

        // Execute python using Process
        // On Windows, the python command might be 'python' or 'py'. 
        // We will assume 'python' is in PATH since they already ran it before.
        $process = new Process(['python', $scriptPath, $message, $aiName, $puskesmasName]);
        $process->setTimeout(60); // Timeout up to 60 seconds for API call
        $process->run();
        
        if (!$process->isSuccessful()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada AI Service.',
                'error' => $process->getErrorOutput(),
                'output' => $process->getOutput()
            ], 500);
        }
        
        $output = $process->getOutput();
        
        // Try to parse the JSON string outputted by chat_api.py
        $result = json_decode($output, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Fallback if not pure JSON
            return response()->json([
                'status' => 'error',
                'message' => 'Format balasan dari AI Service tidak valid.',
                'raw_output' => $output
            ], 500);
        }
        
        // Convert Markdown formatting (like **bold** or *italic*) from Gemini to basic HTML so it looks good in Blade
        if(isset($result['answer']) && $result['status'] === 'success') {
            // Replace newlines with <br>
            $answerHTML = nl2br(htmlspecialchars($result['answer']));
            
            // Basic markdown to html bold
            $answerHTML = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $answerHTML);
            
            // Basic markdown to html italic
            $answerHTML = preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $answerHTML);

            // Basic markdown to html link
            $answerHTML = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2" class="text-primary hover:underline font-semibold" target="_blank">$1</a>', $answerHTML);

            $result['answer'] = $answerHTML;
        }

        return response()->json($result);
    }

    private function generateDatabaseKnowledge()
    {
        try {
            $chatbotSetting = DB::table('chatbot_settings')->first();
            $sambutan = DB::table('sambutans')->latest()->first();

            $halamen = DB::table('halamen')
                ->leftJoin('kategori_halamen', 'halamen.kategori_halaman_id', '=', 'kategori_halamen.id')
                ->select('halamen.judul', 'halamen.isi', 'halamen.isi_ocr', 'kategori_halamen.nama as kategori', 'halamen.kategori_halaman_id')
                ->get();

            $agendas = Schema::hasTable('agendas') ? DB::table('agendas')->where('status', 'upcoming')->get() : collect();
            $beritas = Schema::hasTable('beritas') ? DB::table('beritas')->where('status', 'publish')->get() : collect();

            $infografis = Schema::hasTable('infografis') ? DB::table('infografis')->get() : collect();
            $galeriInfografis = Schema::hasTable('galeris') ? DB::table('galeris')->where('jenis', 'infografis')->get() : collect();

            $dokumen = Schema::hasTable('dokumen') ? DB::table('dokumen')->where('is_active', 1)->get() : collect();
            $faqs = Schema::hasTable('faqs') ? DB::table('faqs')->get() : collect();

            $inovasi = Schema::hasTable('inovasi1') ? DB::table('inovasi1')->where('is_active', 1)->get() : collect();

            $knowledge = [
                'profile' => [
                    'nama_puskesmas' => $chatbotSetting->puskesmas_display_name ?? 'Puskesmas Marunggi',
                    'sambutan_pejabat' => $sambutan ? [
                        'nama' => $sambutan->nama,
                        'judul' => $sambutan->judul,
                        'motto' => $sambutan->motto,
                        'isi' => strip_tags($sambutan->isi),
                        'url' => url('/')
                    ] : null
                ],
                'halaman_informasi' => $halamen->map(function($h) {
                    return [
                        'kategori' => $h->kategori,
                        'judul' => $h->judul,
                        'isi' => strip_tags($h->isi), // Clean HTML tags since we now use pre-extracted OCR text
                        'isi_ocr' => $h->isi_ocr,
                        'url' => url('/landing/halaman/' . encrypt($h->kategori_halaman_id))
                    ];
                })->toArray(),
                'acara_mendatang' => $agendas->map(function($a) {
                    return [
                        'nama_kegiatan' => $a->judul_agenda,
                        'tanggal' => $a->tanggal,
                        'waktu' => $a->jam_mulai . ' s/d ' . $a->jam_selesai,
                        'lokasi' => $a->lokasi,
                        'deskripsi' => strip_tags($a->deskripsi),
                        'penyelenggara' => $a->penyelenggara,
                        'url' => url('/landing/agenda')
                    ];
                })->toArray(),
                'berita' => $beritas->map(function($b) {
                    return [
                        'judul_berita' => $b->judul,
                        'isi_berita' => $b->isi, // Keep HTML tags to preserve full layout & images for news outline
                        'tanggal_publish' => $b->tanggal_publish,
                        'url' => url('/landing/berita/' . encrypt($b->id))
                    ];
                })->toArray(),
                'infografis' => array_merge(
                    $infografis->map(function($i) {
                        return [
                            'nama' => $i->nama,
                            'keterangan' => strip_tags($i->keterangan),
                            'url' => url('/landing/infografis')
                        ];
                    })->toArray(),
                    $galeriInfografis->map(function($g) {
                        return [
                            'nama' => $g->judul_kegiatan,
                            'keterangan' => strip_tags($g->deskripsi),
                            'lokasi' => $g->lokasi,
                            'url' => url('/landing/infografis')
                        ];
                    })->toArray()
                ),
                'dokumen_publik' => $dokumen->map(function($d) {
                    return [
                        'judul' => $d->judul,
                        'kategori' => $d->kategori,
                        'deskripsi' => strip_tags($d->deskripsi),
                        'url' => url('/landing/dokumen')
                    ];
                })->toArray(),
                'faqs' => $faqs->map(function($f) {
                    return [
                        'pertanyaan' => $f->pertanyaan,
                        'jawaban' => strip_tags($f->jawaban),
                        'url' => url('/faq')
                    ];
                })->toArray(),
                'inovasi_program' => $inovasi->map(function($in) {
                    return [
                        'judul_inovasi' => $in->judul_inovasi,
                        'deskripsi' => strip_tags($in->deskripsi_inovasi),
                        'tahun' => $in->tahun_inovasi,
                        'url' => url('/landing/inovasi1')
                    ];
                })->toArray(),
                'ai_assistant_identity' => [
                    'nama_asisten' => $chatbotSetting->ai_name ?? 'Asisten AI',
                    'greeting_message' => $chatbotSetting->greeting_message ?? 'Halo, ada yang bisa saya bantu?'
                ]
            ];

            $jsonPath = base_path('ai-service/knowledge/database_knowledge.json');
            file_put_contents($jsonPath, json_encode($knowledge, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        } catch (\Exception $e) {
            Log::error('Chatbot knowledge generation error: ' . $e->getMessage());
        }
    }
}
