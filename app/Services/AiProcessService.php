<?php

namespace App\Services;

use Symfony\Component\Process\Process;

/**
 * Class AiProcessService
 * 
 * Centralized service for resolving Python executables and spawning
 * background processes for AI features (Chatbot, Classification, OCR).
 */
class AiProcessService
{
    /**
     * Resolve the Python executable path.
     * Prioritizes PYTHON_EXECUTABLE in .env, then project virtualenv (.venv), and falls back to system 'python'.
     *
     * @return string
     */
    public static function getPythonExecutable(): string
    {
        $pythonExec = env('PYTHON_EXECUTABLE');

        if ($pythonExec && (file_exists($pythonExec) || $pythonExec === 'python')) {
            return $pythonExec;
        }

        if (file_exists(base_path('.venv/Scripts/python.exe'))) {
            return base_path('.venv/Scripts/python.exe');
        }

        if (file_exists(base_path('.venv/bin/python'))) {
            return base_path('.venv/bin/python');
        }

        return 'python';
    }

    /**
     * Create a Symfony Process configured with ai-service working directory
     * and system environment variables necessary for Windows socket & DLL inheritance.
     *
     * @param array $command Command tokens array
     * @param int $timeout Timeout in seconds
     * @return Process
     */
    public static function createProcess(array $command, int $timeout = 60): Process
    {
        $env = array_merge($_SERVER, $_ENV, [
            'SystemRoot' => getenv('SystemRoot') ?: 'C:\\Windows',
            'WINDIR'     => getenv('WINDIR') ?: 'C:\\Windows',
            'PATH'       => getenv('PATH'),
        ]);

        $process = new Process($command, base_path('ai-service'), $env);
        $process->setTimeout($timeout);

        return $process;
    }
}
