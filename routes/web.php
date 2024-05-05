<?php

use App\Jobs\GeneratePdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pdf-example-1', function () {

    $pdf = GeneratePdf::dispatchSync();

    return response()->streamDownload(function () use ($pdf) {
        echo $pdf;
    }, 'example.pdf');
})->name('print');
