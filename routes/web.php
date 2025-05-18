<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing_page');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/about', function () {
    return view('about');
});
