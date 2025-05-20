<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('landing_page');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

// Account routes
Route::middleware(['auth'])->group(function () {
    Route::get('/account/settings', function () {
        return view('account.settings');
    })->name('account.settings');
    
    Route::get('/account/orders', function () {
        return view('account.orders');
    })->name('account.orders');
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
Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/products', function () {
        return view('admin.products');
    })->name('admin.products');
});
