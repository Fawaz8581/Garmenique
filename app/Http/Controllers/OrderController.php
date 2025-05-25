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
} 