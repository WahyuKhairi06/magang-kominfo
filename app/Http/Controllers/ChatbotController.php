<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ChatbotController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = $request->input('message');
        
        // Path to the python script
        $scriptPath = base_path('ai-service/chat_api.py');
        
        // Execute python using Process
        // On Windows, the python command might be 'python' or 'py'. 
        // We will assume 'python' is in PATH since they already ran it before.
        $process = new Process(['python', $scriptPath, $message]);
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

            $result['answer'] = $answerHTML;
        }

        return response()->json($result);
    }
}
