<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pdf-example-1', function () {

    $key = Str::random(40);
    $php_bin = config('app.php_binary');

    $process = Process::path(base_path())->start("$php_bin artisan app:generate-pdf $key");

    while ($process->running()) {
        Log::info($process->latestOutput());
        Log::info($process->latestErrorOutput());
    }

    $result = $process->wait();

    if ($result->successful()) {
        Artisan::call('app:generate-pdf', ['key' => $key]);

        return response()->streamDownload(function () use ($key) {
            echo Cache::pull($key);
        }, 'example.pdf');
    }

    if ($result->failed()) {
        abort(500);
    }

})->name('print');
