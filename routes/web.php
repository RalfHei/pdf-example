<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pdf-example-1', function () {
    $key = Str::random(40);

    Artisan::call('app:generate-pdf', ['key' => $key]);

    return response()->streamDownload(function () use ($key) {
        echo Cache::pull($key);
    }, 'example.pdf');
})->name('print');
