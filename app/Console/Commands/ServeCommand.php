<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Carbon;

/**
 * Overrides Laravel's built-in `serve` command to avoid an Undefined array key error
 * on Windows when the PHP built-in server outputs a line that doesn't match the
 * expected date pattern.
 */
class ServeCommand extends BaseServeCommand
{
    /**
     * The name and signature of the console command.
     * We keep the same signature so it completely replaces the default one.
     */
    protected $signature = 'serve
                {--host=127.0.0.1 : The host address to serve the application on}
                {--port=8000 : The port to serve the application on}
                {--tries= : The max number of times to attempt to bind to a port}
                {--no-reload : Disable automatic reloading of the server}';

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    /**
     * Parse a line from the PHP development server output and extract the date.
     * If the line doesn't contain a date in the expected format we just return
     * the current time instead of crashing.
     */
    protected function getDateFromLine($line)
    {
        // Example line: [Wed Aug 23 19:15:34 2025] PHP 8.2.9 Development Server (http://127.0.0.1:8000) started
        if (preg_match('/\[(.*?)\]/', str_replace('  ', ' ', $line), $matches) && isset($matches[1])) {
            try {
                return Carbon::createFromFormat('D M d H:i:s Y', $matches[1]);
            } catch (\Exception $e) {
                // Ignore parse error and fall through to now()
            }
        }

        // Fallback: avoid exception that crashes the command
        return Carbon::now();
    }
}
