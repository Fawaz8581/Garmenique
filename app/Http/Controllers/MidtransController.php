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
                'city' => 'nullable|string|max:255',
                'postalCode' => 'nullable|string|max:20',
                'phoneNumber' => 'nullable|string|max:20',
                'total' => 'required|numeric',
            ]);

            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to process payment'
                ], 401);
            }

            // Create shipping info array
            $shippingInfo = [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postalCode' => $request->postalCode,
                'phoneNumber' => $request->phoneNumber,
            ];

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
            foreach ($cartItems as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            $shippingCost = 18000; // Default shipping cost from the form
            $total = $subtotal + $shippingCost;
            
            // Generate unique order number
            $orderNumber = 'ORD-' . strtoupper(uniqid());
            
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
            \Midtrans\Config::$appendNotifUrl = "https://webhook.site/c7e81171-dbde-43aa-bd9a-c7e6e6f3d506"; // Tambahkan URL webhook untuk testing
            \Midtrans\Config::$overrideNotifUrl = "https://webhook.site/c7e81171-dbde-43aa-bd9a-c7e6e6f3d506"; // Override notifikasi URL

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
                'item_details' => [],
                'callbacks' => [
                    'finish' => route('order.success', ['order_id' => $order->id]),
                    'error' => route('order.success', ['order_id' => $order->id, 'status' => 'failed']),
                    'pending' => route('order.success', ['order_id' => $order->id, 'status' => 'pending'])
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
                    'order_id' => $order->id
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
            
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->status = 'challenge';
                    } else {
                        $order->status = 'success';
                    }
                } else {
                    $order->status = 'success';
                }
            } else if ($transaction == 'settlement') {
                $order->status = 'success';
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
                'new_status' => $order->status
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
    
    // Menambahkan endpoint untuk mengupdate status pesanan secara manual
    public function manualUpdateStatus(Request $request, $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            
            // Update status pesanan ke success
            $order->status = 'success';
            $order->save();
            
            Log::info('Order status manually updated to success', [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);
            
            return redirect()->route('order.success', ['order_id' => $order->id])
                ->with('success', 'Order status has been updated to success');
                
        } catch (\Exception $e) {
            Log::error('Manual status update error', [
                'error' => $e->getMessage(),
                'order_id' => $orderId
            ]);
            
            return redirect()->back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }
} 