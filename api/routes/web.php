<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '';
});

Route::get('/test-mail', function () {
    return resolve(\App\Mail\SalesOfTheDay::class);
});
