<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing_page');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/catalog', function () {
    return view('catalog');
});

// Temporary routes for Men and Women sections
Route::get('/men', function () {
    return redirect('/catalog');
});

Route::get('/women', function () {
    return redirect('/catalog');
});

// Temporary routes for Account and Cart
Route::get('/account', function () {
    return redirect('/');
});

Route::get('/cart', function () {
    return redirect('/');
});

// Product detail route with dynamic product ID parameter
Route::get('/catalog/product/{id}', function ($id) {
    return view('product_detail', ['productId' => $id]);
});

// Redirect old product URLs to the new format
Route::get('/product/{id}', function ($id) {
    return redirect('/catalog/product/' . $id);
});

// Admin Dashboard routes
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/products', function () {
    return view('admin.products');
})->name('admin.products');
