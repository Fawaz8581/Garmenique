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
                'city' => 'nullable|string|max:255',
                'postalCode' => 'nullable|string|max:20',
                'phoneNumber' => 'nullable|string|max:20',
                'expedition' => 'required|string',
                'total' => 'required|numeric'
            ]);
            
            Log::info('Order validation passed', [
                'shipping' => $request->only('firstName', 'lastName', 'email', 'address', 'city', 'postalCode', 'phoneNumber'),
                'expedition' => $request->expedition,
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
            foreach ($cartItems as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            $shippingCost = 18000; // Default shipping cost
            $total = $subtotal + $shippingCost;

            // Create shipping info array
            $shippingInfo = [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postalCode' => $request->postalCode,
                'phoneNumber' => $request->phoneNumber,
                'expedition' => $request->expedition
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
            \Midtrans\Config::$appendNotifUrl = "https://webhook.site/c7e81171-dbde-43aa-bd9a-c7e6e6f3d506";
            \Midtrans\Config::$overrideNotifUrl = "https://webhook.site/c7e81171-dbde-43aa-bd9a-c7e6e6f3d506";

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
                        'city' => $request->city,
                        'postal_code' => $request->postalCode,
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
            
            // Decrease product stock for each cart item
            $this->updateProductStock($order->cart_items);
            
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
        
        $order = Order::find($orderId);
        
        // Check if order exists and belongs to current user
        if (!$order || $order->user_id !== Auth::id()) {
            return redirect('/')->with('error', 'Order not found');
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
            return;
        }
        
        foreach ($cartItems as $item) {
            if (!isset($item['id']) || !isset($item['size']) || !isset($item['quantity'])) {
                Log::warning('Skipping stock update for incomplete cart item', ['item' => $item]);
                continue;
            }
            
            $product = \App\Models\Product::find($item['id']);
            
            if (!$product) {
                Log::warning('Product not found for stock update', ['product_id' => $item['id']]);
                continue;
            }
            
            // Find the product size relationship
            $productSize = \App\Models\ProductSize::where('product_id', $item['id'])
                ->where('size', $item['size'])
                ->first();
            
            if (!$productSize) {
                Log::warning('Product size not found', [
                    'product_id' => $item['id'],
                    'size' => $item['size']
                ]);
                continue;
            }
            
            // Decrease stock
            $oldStock = $productSize->stock;
            $newStock = max(0, $productSize->stock - $item['quantity']);
            $productSize->stock = $newStock;
            $productSize->save();
            
            Log::info('Product stock updated', [
                'product_id' => $item['id'],
                'size' => $item['size'],
                'old_stock' => $oldStock,
                'new_stock' => $newStock,
                'quantity_purchased' => $item['quantity']
            ]);
        }
    }
}
