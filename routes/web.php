<?php

use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pdf-example-1', function () {
    $pdf = app(Browsershot::class)
        ->setUrl(route('home'))
        ->format('A4')
        ->usePipe()
        ->setBinPath(base_path('/browser.cjs'))
        ->noSandbox()
        ->waitForSelector('.pdf-demo')
        ->pdf();

    return response()->streamDownload(function () use ($pdf) {
        echo $pdf;
    }, 'example-1.pdf');
})->name('print');
