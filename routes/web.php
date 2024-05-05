<?php

use App\Jobs\GeneratePdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pdf-example-1', function () {
    GeneratePdf::dispatch();

})->name('print');
