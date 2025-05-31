<?php

namespace App\Http\Controllers;

require_once dirname(__DIR__, 3) . '/vendor/midtrans/midtrans-php/Midtrans.php';

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Order submission started', ['user_id' => Auth::id()]);
        
        try {
            // Validate the request
            $request->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'address' => 'required|string|max:255',
                'phoneNumber' => 'nullable|string|max:20',
                'province_id' => 'required|string',
                'expedition' => 'required|string',
                'shipping_cost' => 'required|numeric',
                'total' => 'required|numeric'
            ]);
            
            Log::info('Order validation passed', [
                'shipping' => $request->only('firstName', 'lastName', 'email', 'address', 'phoneNumber', 'province_id'),
                'expedition' => $request->expedition,
                'shipping_cost' => $request->shipping_cost,
                'total' => $request->total
            ]);

            // Check if user is authenticated
            if (!Auth::check()) {
                Log::warning('Order attempt without authentication');
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to place an order'
                ], 401);
            }

            // Get cart items from session
            $userId = Auth::id();
            $cartItems = session("user_cart_{$userId}", []);
            
            if (empty($cartItems)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty'
                ], 400);
            }
            
            // Calculate totals
            $subtotal = 0;
            $totalQuantity = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item['price'] * $item['quantity'];
                $totalQuantity += $item['quantity'];
            }
            
            // Calculate weight - 250g per item
            $weight = $totalQuantity * 250;
            
            // Get shipping cost from the form
            $shippingCost = (int)$request->shipping_cost;
            $total = $subtotal + $shippingCost;

            // Get province name based on ID
            $provinces = [
                '1' => 'Bali',
                '2' => 'Bangka Belitung',
                '3' => 'Banten',
                '4' => 'Bengkulu',
                '5' => 'DI Yogyakarta',
                '6' => 'DKI Jakarta',
                '7' => 'Gorontalo',
                '8' => 'Jambi',
                '9' => 'Jawa Barat',
                '10' => 'Jawa Tengah',
                '11' => 'Jawa Timur',
                '12' => 'Kalimantan Barat',
                '13' => 'Kalimantan Selatan',
                '14' => 'Kalimantan Tengah',
                '15' => 'Kalimantan Timur',
                '16' => 'Kalimantan Utara',
                '17' => 'Kepulauan Riau',
                '18' => 'Lampung',
                '19' => 'Maluku',
                '20' => 'Maluku Utara',
                '21' => 'Nanggroe Aceh Darussalam',
                '22' => 'Nusa Tenggara Barat',
                '23' => 'Nusa Tenggara Timur',
                '24' => 'Papua',
                '25' => 'Papua Barat',
                '26' => 'Riau',
                '27' => 'Sulawesi Barat',
                '28' => 'Sulawesi Selatan',
                '29' => 'Sulawesi Tengah',
                '30' => 'Sulawesi Tenggara',
                '31' => 'Sulawesi Utara',
                '32' => 'Sumatera Barat',
                '33' => 'Sumatera Selatan',
                '34' => 'Sumatera Utara',
            ];
            
            $provinceName = $provinces[$request->province_id] ?? 'Unknown Province';

            // Create shipping info array
            $shippingInfo = [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'address' => $request->address,
                'phoneNumber' => $request->phoneNumber,
                'province' => $provinceName,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id ?? '',
                'expedition' => $request->expedition,
                'service' => $request->service ?? '',
                'weight' => $weight // Add weight to shipping info
            ];
            
            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'shipping_info' => $shippingInfo,
                'payment_info' => ['method' => 'midtrans'],
                'cart_items' => $cartItems,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'status' => 'pending'
            ]);
            
            // Set up Midtrans configuration
            \Midtrans\Config::$serverKey = 'SB-Mid-server-GwUP_WGbJPXsDzsNEBRs8IYA';
            \Midtrans\Config::$clientKey = 'SB-Mid-client-61XuGAwQ8Bj8LxSS';
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;
            // Gunakan URL aplikasi Anda sendiri untuk callback
            \Midtrans\Config::$appendNotifUrl = url('/api/midtrans/notification');
            \Midtrans\Config::$overrideNotifUrl = url('/api/midtrans/notification');

            // Set up transaction parameters
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int)$total,
                ],
                'customer_details' => [
                    'first_name' => $request->firstName,
                    'last_name' => $request->lastName,
                    'email' => $request->email,
                    'phone' => $request->phoneNumber,
                    'billing_address' => [
                        'first_name' => $request->firstName,
                        'last_name' => $request->lastName,
                        'email' => $request->email,
                        'phone' => $request->phoneNumber,
                        'address' => $request->address,
                        'country_code' => 'IDN'
                    ],
                ],
                'item_details' => []
            ];

            // Add items to transaction params
            foreach ($cartItems as $item) {
                $params['item_details'][] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity']
                ];
            }

            // Add shipping cost to item details
            $params['item_details'][] = [
                'id' => 'SHIPPING',
                'name' => 'Shipping Cost',
                'price' => $shippingCost,
                'quantity' => 1
            ];

            // Generate snap token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $order->snap_token = $snapToken;
            $order->save();
            
            // Note: We've removed the premature stock reduction here
            // Stock will be reduced only after successful payment confirmation
            
            Log::info('Order created successfully with snap token', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'snap_token' => $snapToken
            ]);
            
            return redirect()->route('checkout', $order->id);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Order validation failed', [
                'errors' => $e->errors(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error placing order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display order success page
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function success(Request $request)
    {
        $orderId = $request->input('order_id');
        $status = $request->input('status', 'success');
        
        Log::info('Order success page accessed', [
            'order_id' => $orderId,
            'status' => $status,
            'user_id' => Auth::id()
        ]);
        
        if (!$orderId) {
            return redirect('/')->with('error', 'No order specified');
        }
        
        // First try to find the order by order_number (when it starts with "ORD-")
        if (is_string($orderId) && strpos($orderId, 'ORD-') === 0) {
            $order = Order::where('order_number', $orderId)->first();
            
            Log::info('Order looked up by order_number', [
                'order_number' => $orderId,
                'found' => $order ? 'yes' : 'no'
            ]);
        } 
        // Otherwise try to find by ID if it's numeric
        else if (is_numeric($orderId)) {
            $order = Order::find($orderId);
            
            Log::info('Order looked up by ID', [
                'id' => $orderId,
                'found' => $order ? 'yes' : 'no'
            ]);
        } 
        // If not a valid format, try both
        else {
            $order = Order::where('order_number', $orderId)->first();
            if (!$order) {
                try {
                    $order = Order::find($orderId);
                } catch (\Exception $e) {
                    Log::warning('Failed to find order', [
                        'order_id' => $orderId,
                        'error' => $e->getMessage()
                    ]);
                    // Continue with order as null
                }
            }
        }
        
        // Check if order exists and belongs to current user
        if (!$order || (!Auth::check() || $order->user_id !== Auth::id())) {
            return redirect('/')->with('error', 'Order not found or unauthorized');
        }
        
        // If status is pending, update order status
        if ($status === 'pending') {
            $order->status = 'payment_pending';
            $order->save();
            
            Log::info('Order status updated to payment_pending', [
                'order_id' => $orderId,
                'user_id' => Auth::id()
            ]);
        } else {
            // Success status - mark order as completed
            $order->status = 'completed';
            $order->save();
            
            // Update product stock here - hanya jika belum pernah diupdate
            if ($order->cart_items) {
                // Cek apakah stok sudah pernah dikurangi untuk order ini
                $stockAlreadyUpdated = isset($order->payment_info['stock_updated']) && $order->payment_info['stock_updated'] === true;
                
                if (!$stockAlreadyUpdated) {
                    // Tandai bahwa stok sudah diupdate
                    $paymentInfo = $order->payment_info ?: [];
                    $paymentInfo['stock_updated'] = true;
                    $order->payment_info = $paymentInfo;
                    $order->save();
                    
                    // Update stok produk
                    $this->updateProductStock($order->cart_items);
                    
                    Log::info('Stock updated for order items after successful payment', [
                        'order_id' => $orderId,
                        'cart_items_count' => count($order->cart_items)
                    ]);
                } else {
                    Log::info('Stock already updated for this order, skipping', ['order_id' => $order->id]);
                }
            } else {
                Log::warning('No cart items found in order for stock update', [
                    'order_id' => $orderId
                ]);
            }
            
            Log::info('Order status updated to completed', [
                'order_id' => $orderId,
                'user_id' => Auth::id()
            ]);
        }
        
        // Clear cart after successful order
        $userId = Auth::id();
        session()->forget("user_cart_{$userId}");
        
        return view('order-success', [
            'order' => $order,
            'status' => $status
        ]);
    }
    
    /**
     * Update product stock based on cart items
     * 
     * @param array $cartItems
     */
    private function updateProductStock($cartItems)
    {
        if (empty($cartItems)) {
            Log::warning('No cart items to update stock for');
            return;
        }
        
        // Log the cart items for debugging
        Log::info('OrderController: Processing cart items for stock update', ['cartItems' => $cartItems]);
        
        $successCount = 0;
        $failedCount = 0;
        
        foreach ($cartItems as $item) {
            if (!isset($item['id']) || !isset($item['size']) || !isset($item['quantity'])) {
                Log::warning('Skipping stock update for incomplete cart item', ['item' => $item]);
                $failedCount++;
                continue;
            }
            
            $product = \App\Models\Product::find($item['id']);
            
            if (!$product) {
                Log::warning('Product not found for stock update', ['product_id' => $item['id']]);
                $failedCount++;
                continue;
            }
            
            // Log product details for debugging
            Log::info('OrderController: Found product for stock update', [
                'product_id' => $item['id'],
                'product_name' => $product->name,
                'product_size' => $item['size']
            ]);
            
            // Find the product size relationship using the exact size string from the cart item
            $productSize = \App\Models\ProductSize::where('product_id', $item['id'])
                ->where('size', $item['size'])
                ->first();
                
            // If not found, try to find it via the Size model for translation
            if (!$productSize) {
                Log::info('OrderController: Trying to find size via alternative method', [
                    'product_id' => $item['id'],
                    'size_name' => $item['size']
                ]);
                
                // Try to find the size in the sizes table
                $size = \App\Models\Size::where('name', $item['size'])->first();
                
                if ($size) {
                    $productSize = \App\Models\ProductSize::where('product_id', $item['id'])
                        ->where('size', $size->name)
                        ->first();
                    
                    Log::info('OrderController: Found via alternative method', [
                        'size_id' => $size->id,
                        'size_name' => $size->name,
                        'product_size_found' => $productSize ? 'yes' : 'no'
                    ]);
                }
            }
            
            if (!$productSize) {
                Log::warning('Product size not found', [
                    'product_id' => $item['id'],
                    'size' => $item['size']
                ]);
                $failedCount++;
                continue;
            }
            
            // Log current stock before update
            Log::info('OrderController: Product size found with current stock', [
                'product_id' => $item['id'],
                'size' => $item['size'],
                'current_stock' => $productSize->stock,
                'quantity_to_reduce' => $item['quantity']
            ]);
            
            // Decrease stock
            $oldStock = $productSize->stock;
            $newStock = max(0, $oldStock - $item['quantity']);
            $productSize->stock = $newStock;
            $result = $productSize->save();
            
            // Log save result
            Log::info('OrderController: Product stock save result', [
                'success' => $result ? 'true' : 'false',
                'stock_before' => $oldStock,
                'stock_after' => $newStock
            ]);
            
            if ($result) {
                $successCount++;
            } else {
                $failedCount++;
            }
            
            // Update the product's cache if needed
            $product->refresh();
            
            Log::info('Product stock updated successfully', [
                'product_id' => $item['id'],
                'product_name' => $product->name,
                'size' => $item['size'],
                'old_stock' => $oldStock,
                'new_stock' => $newStock,
                'quantity_purchased' => $item['quantity'],
                'total_stock_remaining' => $product->total_stock
            ]);
        }
        
        Log::info('Stock update operation completed', [
            'successful_updates' => $successCount,
            'failed_updates' => $failedCount,
            'total_items' => count($cartItems)
        ]);
    }
}
