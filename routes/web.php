<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

Route::get('/catalog', [\App\Http\Controllers\CatalogController::class, 'index']);

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
    $product = \App\Models\Product::findOrFail($id);
    return view('product_detail', ['product' => $product]);
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

    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
    
    // Product Management API Routes
    Route::get('/admin/api/products', [ProductController::class, 'getProducts']);
    Route::post('/admin/api/products', [ProductController::class, 'store']);
    Route::put('/admin/api/products/{id}', [ProductController::class, 'update']);
    Route::delete('/admin/api/products/{id}', [ProductController::class, 'destroy']);
    
    // Category API Routes
    Route::get('/admin/api/categories', [CategoryController::class, 'index']);

    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login']);

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });
});

// Cart data management routes
Route::get('/check-auth', function () {
    // Add headers to prevent caching
    return response()->json([
        'authenticated' => Auth::check(),
        'user_id' => Auth::check() ? Auth::id() : null,
        'timestamp' => now()->timestamp
    ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
      ->header('Pragma', 'no-cache')
      ->header('Expires', '0');
});

Route::get('/get-cart', function (Request $request) {
    if (!Auth::check()) {
        return response()->json([
            'error' => 'Unauthenticated',
            'authenticated' => false
        ], 401);
    }
    
    try {
        $userId = Auth::id();
        $cart = $request->session()->get('user_cart_'.$userId, []);
        
        return response()->json([
            'cart' => $cart,
            'authenticated' => true,
            'user_id' => $userId
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
          ->header('Pragma', 'no-cache')
          ->header('Expires', '0');
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to retrieve cart',
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::post('/save-cart', function (Request $request) {
    if (!Auth::check()) {
        return response()->json([
            'error' => 'Unauthenticated',
            'authenticated' => false
        ], 401);
    }
    
    try {
        $userId = Auth::id();
        $cart = $request->input('cart', []);
        
        // Make sure cart is an array
        if (!is_array($cart)) {
            return response()->json([
                'error' => 'Invalid cart format',
                'message' => 'Cart must be an array'
            ], 400);
        }
        
        $request->session()->put('user_cart_'.$userId, $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Cart saved successfully',
            'authenticated' => true,
            'cart_size' => count($cart)
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to save cart',
            'message' => $e->getMessage()
        ], 500);
    }
});