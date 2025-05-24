<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\DashboardController;
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

// Password Reset Routes
Route::get('/forgot-password', function() {
    return view('password.request');
})->name('password.request');

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
    // Profile routes
    Route::get('/account/settings', [AccountController::class, 'showSettings'])->name('account.settings');
    Route::post('/account/profile', [AccountController::class, 'updateProfile'])->name('account.update.profile');
    
    // Password routes
    Route::get('/account/password', [AccountController::class, 'showPassword'])->name('account.password');
    Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.update.password');
    
    // Contact routes
    Route::get('/account/contact', [AccountController::class, 'showContact'])->name('account.contact');
    Route::post('/account/contact', [AccountController::class, 'updateContact'])->name('account.update.contact');
    
    // Orders routes
    Route::get('/account/orders', [AccountController::class, 'showOrders'])->name('account.orders');

    // User Messages routes
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'userMessages'])->name('user.messages');
    Route::post('/messages/send', [\App\Http\Controllers\MessageController::class, 'sendMessage'])->name('messages.send');
    Route::get('/messages/data', [\App\Http\Controllers\MessageController::class, 'getMessages'])->name('messages.data');
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

// Admin Routes (All public for now)
Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Products
    Route::get('/products', [ProductController::class, 'show'])->name('admin.products');
    
    // Categories
    Route::get('/categories', [CategoryController::class, 'show'])->name('admin.categories');
    
    // Sizes
    Route::get('/sizes', [SizeController::class, 'show'])->name('admin.sizes');
    
    // Messages
    Route::get('/messages', [App\Http\Controllers\Admin\MessageController::class, 'index'])->name('admin.messages');
    Route::get('/messages/{userId}', [App\Http\Controllers\Admin\MessageController::class, 'getMessages']);
    Route::post('/messages/send', [App\Http\Controllers\Admin\MessageController::class, 'sendMessage']);

    // API Routes
    Route::prefix('api')->group(function () {
        // Products API
        Route::get('/products', [ProductController::class, 'index']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
        
        // Categories API
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        // Sizes API
        Route::get('/sizes', [SizeController::class, 'index']);
        Route::post('/sizes', [SizeController::class, 'store']);
        Route::put('/sizes/{id}', [SizeController::class, 'update']);
        Route::delete('/sizes/{id}', [SizeController::class, 'destroy']);
    });

    // Auth Routes (will be used later)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
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