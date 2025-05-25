<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'shipping.firstName' => 'required|string|max:255',
            'shipping.lastName' => 'required|string|max:255',
            'shipping.email' => 'required|email|max:255',
            'shipping.address' => 'required|string|max:255',
            'shipping.city' => 'required|string|max:255',
            'shipping.postalCode' => 'required|string|max:20',
            'payment.method' => 'required|in:credit,paypal',
            'cart' => 'required|array|min:1',
            'totals' => 'required|array'
        ]);

        try {
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

            // Decrease product stock for each cart item
            $this->updateProductStock($order->cart_items);
            
            // Process payment (in a real application, you would integrate with a payment gateway here)
            
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order' => $order
            ], 201);
        } catch (\Exception $e) {
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
                continue;
            }
            
            $product = \App\Models\Product::find($item['id']);
            
            if (!$product) {
                continue;
            }
            
            // Find the product size relationship
            $productSize = \App\Models\ProductSize::where('product_id', $item['id'])
                ->where('size', $item['size'])
                ->first();
            
            if (!$productSize) {
                continue;
            }
            
            // Decrease stock
            $newStock = max(0, $productSize->stock - $item['quantity']);
            $productSize->stock = $newStock;
            $productSize->save();
        }
    }
} 