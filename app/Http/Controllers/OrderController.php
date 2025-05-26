<?php

namespace App\Http\Controllers;

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
                'shipping.firstName' => 'required|string|max:255',
                'shipping.lastName' => 'required|string|max:255',
                'shipping.email' => 'required|email|max:255',
                'shipping.address' => 'required|string|max:255',
                'shipping.city' => 'nullable|string|max:255',
                'shipping.postalCode' => 'nullable|string|max:20',
                'payment.method' => 'required|in:credit,paypal',
                'cart' => 'required|array|min:1',
                'totals' => 'required|array'
            ]);
            
            Log::info('Order validation passed', [
                'shipping' => $request->shipping,
                'payment_method' => $request->payment['method'],
                'cart_count' => count($request->cart),
                'total' => $request->totals['total']
            ]);

            // Check if user is authenticated
            if (!Auth::check()) {
                Log::warning('Order attempt without authentication');
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to place an order'
                ], 401);
            }

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'shipping_info' => $request->shipping,
                'payment_info' => $request->payment,
                'cart_items' => $request->cart,
                'subtotal' => $request->totals['subtotal'],
                'shipping_cost' => $request->totals['shipping'],
                'total' => $request->totals['total'],
                'status' => 'pending'
            ]);
            
            Log::info('Order created successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

            // Decrease product stock for each cart item
            $this->updateProductStock($order->cart_items);
            
            // Process payment (in a real application, you would integrate with a payment gateway here)
            
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order' => $order
            ], 201);
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