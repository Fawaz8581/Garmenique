<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

// Update to use the controller
Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index']);

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

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (Request $request, $token) {
    return view('password.reset', ['token' => $token, 'email' => $request->email]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact/submit', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

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
    Route::post('/account/orders/{id}/complete', [AccountController::class, 'completeOrder'])->name('account.orders.complete');
    
    // Dashboard routes
    Route::get('/account/dashboard', [AccountController::class, 'showDashboard'])->name('account.dashboard');
    Route::get('/api/account/dashboard-data', [AccountController::class, 'getDashboardDataJson'])->name('api.account.dashboard-data');

    // User address for checkout
    Route::get('/api/user-address', [AccountController::class, 'getUserAddress']);

    // User Messages routes
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'userMessages'])->name('user.messages');
    Route::post('/messages/send', [\App\Http\Controllers\MessageController::class, 'sendMessage'])->name('messages.send');
    Route::get('/messages/admin', [\App\Http\Controllers\MessageController::class, 'getMessages'])->name('messages.data');

    // Checkout routes
    Route::get('/checkout/{id?}', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order-success', [App\Http\Controllers\OrderController::class, 'success'])->name('order.success');
    
    // Invoice routes
    Route::get('/invoice/{orderId}', [App\Http\Controllers\InvoiceController::class, 'download'])->name('invoice.download');
    
    Route::post('/api/orders', [\App\Http\Controllers\OrderController::class, 'store']);
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

// Public product image route - accessible to all users
Route::get('/api/products/{id}/image', [ProductController::class, 'getImage'])->name('public.product.image');

// Admin Routes
Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::prefix('admin')->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/api/dashboard-data', [DashboardController::class, 'getDashboardDataJson'])->name('admin.dashboard.data');
        
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
        
        // Settings
        Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'show'])->name('admin.settings');
        Route::post('/users/create', [App\Http\Controllers\Admin\SettingsController::class, 'createAdminUser'])->name('admin.users.create');
        Route::delete('/users/{id}', [App\Http\Controllers\Admin\SettingsController::class, 'deleteAdminUser'])->name('admin.users.delete');
        
        // Customizes
        Route::get('/customizes/{page?}', [App\Http\Controllers\Admin\PageSettingController::class, 'index'])->name('admin.customizes');
        Route::post('/api/page-settings', [App\Http\Controllers\Admin\PageSettingController::class, 'save'])->name('admin.page-settings.save');
        Route::get('/api/page-settings', [App\Http\Controllers\Admin\PageSettingController::class, 'getSettings'])->name('admin.page-settings.get');

        // Test Image Upload
        Route::get('/test-image-upload', function() {
            return view('admin.image_upload_test');
        })->name('admin.test-image-upload');
        
        // Test direct database image upload
        Route::get('/test-db-image', function() {
            return view('admin.db_image_test');
        })->name('admin.test-db-image');

        // API Routes
        Route::prefix('api')->group(function () {
            // Products API
            Route::get('/products', [ProductController::class, 'index']);
            Route::post('/products', [ProductController::class, 'store']);
            Route::put('/products/{id}', [ProductController::class, 'update']);
            Route::delete('/products/{id}', [ProductController::class, 'destroy']);
            Route::get('/products/{id}/image', [ProductController::class, 'getImage'])->name('product.image');
            
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
            
            // Orders API
            Route::put('/orders/{id}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus']);
            Route::get('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'getOrderDetails']);
            
            // Invoice API
            Route::get('/invoice/download/{order_id}', [App\Http\Controllers\Admin\InvoiceController::class, 'download'])->name('admin.invoice.download');
        });
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

// Create Admin Route
Route::get('/create-admin', [App\Http\Controllers\AdminCreatorController::class, 'createAdmin']);

// Debug route to check route definitions
Route::get('/debug-routes', function() {
    return [
        'product_image_route' => route('product.image', ['id' => 1]),
        'upload_image_route' => route('upload.image'),
        'get_image_route' => route('get.image', ['type' => 'product', 'id' => 1]),
        'public_product_image_route' => route('public.product.image', ['id' => 1])
    ];
});

// Cart API routes
Route::post('/api/clear-cart', [\App\Http\Controllers\Api\CartController::class, 'clearCart']);
Route::post('/api/update-cart', [\App\Http\Controllers\Api\CartController::class, 'updateCart']);
Route::post('/api/remove-from-cart', [\App\Http\Controllers\Api\CartController::class, 'removeFromCart']);

// General API routes
Route::post('/api/upload-image', [App\Http\Controllers\ImageController::class, 'storeImage'])->name('upload.image');
Route::get('/api/images/{type}/{id}', [App\Http\Controllers\ImageController::class, 'getImage'])->name('get.image');

// Midtrans Routes
Route::post('/get-snap-token', [App\Http\Controllers\MidtransController::class, 'getSnapToken'])->name('get.snap.token');
Route::post('/midtrans/notification', [App\Http\Controllers\MidtransController::class, 'notificationHandler'])->name('midtrans.notification');
Route::match(['get', 'post', 'put'], '/manual-update-status/{orderId}', [App\Http\Controllers\MidtransController::class, 'manualUpdateStatus'])->name('manual.update.status');
Route::get('/payment/retry/{orderId}', [App\Http\Controllers\MidtransController::class, 'retryPayment'])->name('payment.retry');

// Test route to verify stock reduction (for testing purposes only)
Route::get('/test-stock-reduction/{orderId}', function($orderId) {
    if (!Auth::check() || !Auth::user()->is_admin) {
        return redirect('/')->with('error', 'Unauthorized');
    }
    
    $order = \App\Models\Order::find($orderId);
    if (!$order) {
        return redirect('/')->with('error', 'Order not found');
    }
    
    $controller = new \App\Http\Controllers\MidtransController();
    $stockBeforeUpdate = [];
    
    // Record stock before update
    foreach ($order->cart_items as $item) {
        if (isset($item['id']) && isset($item['size'])) {
            $productSize = \App\Models\ProductSize::where('product_id', $item['id'])
                ->where('size', $item['size'])
                ->first();
            
            if ($productSize) {
                $stockBeforeUpdate[] = [
                    'product_id' => $item['id'],
                    'size' => $item['size'],
                    'stock_before' => $productSize->stock,
                    'qty_to_reduce' => $item['quantity']
                ];
            }
        }
    }
    
    // Call the method using reflection to access the private method
    $reflectionMethod = new \ReflectionMethod('\App\Http\Controllers\MidtransController', 'updateProductStock');
    $reflectionMethod->setAccessible(true);
    $reflectionMethod->invoke($controller, $order);
    
    // Get stock after update
    $stockAfterUpdate = [];
    foreach ($stockBeforeUpdate as $item) {
        $productSize = \App\Models\ProductSize::where('product_id', $item['product_id'])
            ->where('size', $item['size'])
            ->first();
        
        if ($productSize) {
            $stockAfterUpdate[] = [
                'product_id' => $item['product_id'],
                'size' => $item['size'],
                'stock_before' => $item['stock_before'],
                'stock_after' => $productSize->stock,
                'qty_reduced' => $item['stock_before'] - $productSize->stock,
                'qty_requested' => $item['qty_to_reduce']
            ];
        }
    }
    
    return [
        'order_id' => $orderId,
        'order_number' => $order->order_number,
        'stock_changes' => $stockAfterUpdate
    ];
});