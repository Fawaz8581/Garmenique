<?php

namespace App\Http\Controllers;

require_once dirname(__DIR__, 3) . '/vendor/midtrans/midtrans-php/Midtrans.php';

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function getSnapToken(Request $request)
    {
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
                'total' => 'required|numeric',
            ]);

            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to process payment'
                ], 401);
            }

            // Get cart items from session
            $userId = Auth::id();
            $cartItems = session("user_cart_{$userId}", []);
            
            // If no cart items, return error
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
            
            // Generate unique order number
            $orderNumber = 'ORD-' . strtoupper(uniqid());
            
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

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'shipping_info' => $shippingInfo,
                'payment_info' => ['method' => 'midtrans'],
                'cart_items' => $cartItems,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'status' => 'pending'
            ]);
            
            // Pastikan order sudah dibuat
            if (!$order) {
                Log::error('Failed to create order', [
                    'user_id' => Auth::id(),
                    'cart_items' => $cartItems
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create order'
                ], 500);
            }
            
            Log::info('Order created successfully', [
                'order_id' => $order->id,
                'order_number' => $orderNumber,
                'user_id' => Auth::id()
            ]);
            
            // IMPORTANT: Gunakan server key dan client key yang benar
            // Pastikan Anda menggantinya dengan server key dan client key dari akun Midtrans Anda
            \Midtrans\Config::$serverKey = 'SB-Mid-server-GwUP_WGbJPXsDzsNEBRs8IYA';
            \Midtrans\Config::$clientKey = 'SB-Mid-client-61XuGAwQ8Bj8LxSS'; 
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;
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
                'item_details' => [],
                'callbacks' => [
                    'finish' => route('order.success', ['order_id' => $order->order_number]),
                    'error' => route('order.success', ['order_id' => $order->order_number, 'status' => 'failed']),
                    'pending' => route('order.success', ['order_id' => $order->order_number, 'status' => 'pending'])
                ]
            ];

            // Add items to transaction params
            foreach ($cartItems as $item) {
                $params['item_details'][] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'price' => (int)$item['price'],
                    'quantity' => (int)$item['quantity']
                ];
            }

            // Add shipping cost to item details
            $params['item_details'][] = [
                'id' => 'SHIPPING',
                'name' => 'Shipping Cost',
                'price' => (int)$shippingCost,
                'quantity' => 1
            ];

            Log::info('Trying to generate snap token with params', ['params' => $params]);
            
            try {
                // Generate snap token
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                
                Log::info('Successfully generated snap token', ['token' => $snapToken]);
    
                // Update order with snap token
                $order->snap_token = $snapToken;
                $order->save();
    
                return response()->json([
                    'success' => true,
                    'snap_token' => $snapToken,
                    'order_id' => $order->id,
                    'order_number' => $order->order_number
                ]);
            } catch (\Exception $snapError) {
                Log::error('Midtrans snap token generation error', [
                    'error' => $snapError->getMessage(),
                    'trace' => $snapError->getTraceAsString(),
                    'params' => $params
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Error generating payment token: ' . $snapError->getMessage()
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error in getSnapToken', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function notificationHandler(Request $request)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-GwUP_WGbJPXsDzsNEBRs8IYA';
        \Midtrans\Config::$isProduction = false;
        
        Log::info('Midtrans notification received', [
            'payload' => $request->all()
        ]);
        
        try {
            $notification = new \Midtrans\Notification();
            
            Log::info('Notification object created', [
                'order_id' => $notification->order_id ?? 'N/A',
                'transaction_status' => $notification->transaction_status ?? 'N/A',
                'payment_type' => $notification->payment_type ?? 'N/A'
            ]);

            $order = Order::where('order_number', $notification->order_id)->first();
            
            if (!$order) {
                Log::error('Order not found for notification', [
                    'order_id' => $notification->order_id ?? 'N/A'
                ]);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }
            
            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $fraud = $notification->fraud_status ?? null;
            $order_id = $notification->order_id;
            
            Log::info('Processing Midtrans notification', [
                'order_id' => $order_id,
                'order_number' => $order->order_number,
                'status' => $transaction,
                'payment_type' => $type,
                'fraud_status' => $fraud
            ]);
            
            // Simpan status pembayaran sebelumnya untuk log
            $previousStatus = $order->status;
            $stockUpdated = false;
            
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->status = 'challenge';
                    } else {
                        $order->status = 'success';
                        // Update product stock on successful payment
                        $this->updateProductStock($order);
                        $stockUpdated = true;
                    }
                } else {
                    $order->status = 'success';
                    // Update product stock on successful payment
                    $this->updateProductStock($order);
                    $stockUpdated = true;
                }
            } else if ($transaction == 'settlement') {
                $order->status = 'success';
                // Update product stock on successful payment
                $this->updateProductStock($order);
                $stockUpdated = true;
            } else if ($transaction == 'pending') {
                $order->status = 'pending';
            } else if ($transaction == 'deny') {
                $order->status = 'failed';
            } else if ($transaction == 'expire') {
                $order->status = 'expired';
            } else if ($transaction == 'cancel') {
                $order->status = 'failed';
            }
            
            // Tambahkan semua detail dari notifikasi ke payment_info
            $paymentDetails = $request->all();
            
            // Save the updated payment status
            $order->payment_info = array_merge(
                $order->payment_info ?: [], 
                [
                    'transaction_status' => $transaction,
                    'payment_type' => $type,
                    'transaction_id' => $notification->transaction_id ?? null,
                    'fraud_status' => $fraud ?? null,
                    'updated_at' => now()->toDateTimeString(),
                    'full_notification' => $paymentDetails
                ]
            );
            
            $order->save();
            
            Log::info('Order status updated from notification', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'previous_status' => $previousStatus,
                'new_status' => $order->status,
                'stock_updated' => $stockUpdated
            ]);
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Midtrans notification error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update order status manually - supports both GET and POST requests
     * 
     * @param Request $request
     * @param int $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function manualUpdateStatus(Request $request, $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            
            // Verify that the order belongs to the authenticated user
            if (Auth::id() !== $order->user_id && !Auth::user()->is_admin) {
                return redirect()->back()
                    ->with('error', 'You are not authorized to update this order');
            }
            
            // Get status from request or default to success
            $status = $request->input('status', 'success');
            
            // Only allow valid statuses
            $validStatuses = ['success', 'completed', 'confirmed'];
            if (!in_array($status, $validStatuses)) {
                $status = 'success';
            }
            
            // Only update stock if changing to success/completed status
            $previousStatus = $order->status;
            $order->status = $status;
            $order->save();
            
            if (($status === 'success' || $status === 'completed') && 
                ($previousStatus === 'pending' || $previousStatus === 'payment_pending')) {
                // Update product stock on successful payment
                $this->updateProductStock($order);
                
                Log::info('Order status manually updated and stock reduced', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'previous_status' => $previousStatus,
                    'new_status' => $status
                ]);
            } else {
                Log::info('Order status manually updated without stock change', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'previous_status' => $previousStatus,
                    'new_status' => $status
                ]);
            }
            
            // If this was an AJAX request, return JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order status has been updated to ' . $status,
                    'order_id' => $order->id,
                    'status' => $status
                ]);
            }
            
            // Otherwise redirect to order success page
            return redirect()->route('order.success', ['order_id' => $order->id])
                ->with('success', 'Order status has been updated to ' . $status);
                
        } catch (\Exception $e) {
            Log::error('Manual status update error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'order_id' => $orderId
            ]);
            
            // If this was an AJAX request, return JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update order status: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }
    
    /**
     * Retry payment for an order with pending status
     * 
     * @param Request $request
     * @param int $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function retryPayment(Request $request, $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            
            // Verify that the order belongs to the authenticated user
            if (Auth::id() !== $order->user_id) {
                return redirect()->route('account.orders')
                    ->with('error', 'You are not authorized to access this order');
            }
            
            // Verify that the order is in pending status
            if ($order->status !== 'pending' && $order->status !== 'payment_pending') {
                return redirect()->route('account.orders')
                    ->with('error', 'This order is not in a pending payment status');
            }
            
            // Set Midtrans configuration
            \Midtrans\Config::$serverKey = 'SB-Mid-server-GwUP_WGbJPXsDzsNEBRs8IYA';
            \Midtrans\Config::$clientKey = 'SB-Mid-client-61XuGAwQ8Bj8LxSS'; 
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;
            
            // Set up transaction parameters
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int)$order->total,
                ],
                'customer_details' => [
                    'first_name' => $order->shipping_info['firstName'] ?? '',
                    'last_name' => $order->shipping_info['lastName'] ?? '',
                    'email' => $order->shipping_info['email'] ?? '',
                    'phone' => $order->shipping_info['phoneNumber'] ?? '',
                    'billing_address' => [
                        'first_name' => $order->shipping_info['firstName'] ?? '',
                        'last_name' => $order->shipping_info['lastName'] ?? '',
                        'email' => $order->shipping_info['email'] ?? '',
                        'phone' => $order->shipping_info['phoneNumber'] ?? '',
                        'address' => $order->shipping_info['address'] ?? '',
                        'country_code' => 'IDN'
                    ],
                ],
                'item_details' => [],
                'callbacks' => [
                    'finish' => route('order.success', ['order_id' => $order->order_number]),
                    'error' => route('order.success', ['order_id' => $order->order_number, 'status' => 'failed']),
                    'pending' => route('order.success', ['order_id' => $order->order_number, 'status' => 'pending'])
                ]
            ];
            
            // Add cart items to transaction params
            foreach ($order->cart_items as $item) {
                $params['item_details'][] = [
                    'id' => $item['id'] ?? 'UNKNOWN',
                    'name' => $item['name'] ?? 'Unknown Product',
                    'price' => (int)($item['price'] ?? 0),
                    'quantity' => (int)($item['quantity'] ?? 1)
                ];
            }
            
            // Add shipping cost to item details
            $params['item_details'][] = [
                'id' => 'SHIPPING',
                'name' => 'Shipping Cost',
                'price' => (int)$order->shipping_cost,
                'quantity' => 1
            ];
            
            Log::info('Retrying payment with params', ['params' => $params]);
            
            try {
                // Generate new snap token
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                
                Log::info('Successfully generated new snap token for retry payment', ['token' => $snapToken]);
                
                // Update order with new snap token
                $order->snap_token = $snapToken;
                $order->save();
                
                // Redirect to order success page with the new token
                return redirect()->route('order.success', ['order_id' => $order->id])
                    ->with('success', 'Payment retry initiated. Please complete your payment.');
                    
            } catch (\Exception $snapError) {
                Log::error('Midtrans retry payment token generation error', [
                    'error' => $snapError->getMessage(),
                    'trace' => $snapError->getTraceAsString(),
                    'params' => $params
                ]);
                
                return redirect()->route('account.orders')
                    ->with('error', 'Error generating payment token: ' . $snapError->getMessage());
            }
            
        } catch (\Exception $e) {
            Log::error('Error in retryPayment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'order_id' => $orderId
            ]);
            
            return redirect()->route('account.orders')
                ->with('error', 'Error processing payment retry: ' . $e->getMessage());
        }
    }
    
    /**
     * Update product stock based on cart items in the order
     * 
     * @param Order $order
     */
    private function updateProductStock($order)
    {
        if (!$order || empty($order->cart_items)) {
            Log::warning('Cannot update stock: Order has no cart items', ['order_id' => $order->id ?? 'null']);
            return;
        }
        
        // Log cart items for debugging
        Log::info('MidtransController: Processing cart items for stock update', [
            'order_id' => $order->id,
            'cart_items' => $order->cart_items
        ]);
        
        $successCount = 0;
        $failedCount = 0;
        
        foreach ($order->cart_items as $item) {
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
            
            // Log product found
            Log::info('MidtransController: Found product for stock update', [
                'product_id' => $item['id'],
                'product_name' => $product->name,
                'size_to_update' => $item['size']
            ]);
            
            // Find the product size relationship using the exact size string from the cart item
            $productSize = \App\Models\ProductSize::where('product_id', $item['id'])
                ->where('size', $item['size'])
                ->first();
                
            // If not found, try to find it via the Size model for translation
            if (!$productSize) {
                Log::info('MidtransController: Trying to find size via alternative method', [
                    'product_id' => $item['id'],
                    'size_name' => $item['size']
                ]);
                
                // Try to find the size in the sizes table
                $size = \App\Models\Size::where('name', $item['size'])->first();
                
                if ($size) {
                    $productSize = \App\Models\ProductSize::where('product_id', $item['id'])
                        ->where('size', $size->name)
                        ->first();
                    
                    Log::info('MidtransController: Found via alternative method', [
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
            
            // Log current stock
            Log::info('MidtransController: Current product stock', [
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
            Log::info('MidtransController: Stock update result', [
                'success' => $result ? 'true' : 'false',
                'old_stock' => $oldStock,
                'new_stock' => $newStock
            ]);
            
            if ($result) {
                $successCount++;
            } else {
                $failedCount++;
            }
            
            // Update the product's cache if needed
            $product->refresh();
            
            Log::info('Product stock updated successfully from payment confirmation', [
                'order_id' => $order->id,
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
            'order_id' => $order->id,
            'successful_updates' => $successCount,
            'failed_updates' => $failedCount,
            'total_items' => count($order->cart_items)
        ]);
    }
} 