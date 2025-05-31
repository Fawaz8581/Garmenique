<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index($id = null)
    {
        // If ID provided, load specific order
        if ($id) {
            $order = Order::find($id);
            
            // Check if order exists and belongs to current user
            if (!$order || $order->user_id !== Auth::id()) {
                return redirect('/')->with('error', 'Order not found');
            }
            
            return view('checkout', ['order' => $order]);
        }
        
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to checkout');
        }
        
        // Ambil cart dari session dengan format yang benar (user_cart_{user_id})
        $userId = Auth::id();
        $cartItems = session("user_cart_{$userId}", []);
        
        // Check if cart is empty
        if (empty($cartItems) || count($cartItems) === 0) {
            return redirect('/catalog')->with('error', 'Your cart is empty. Please add items before checkout.');
        }
        
        return view('checkout', ['cartItems' => $cartItems]);
    }
    
    public function process(Request $request)
    {
        // This method will be called when the form is submitted directly (non-AJAX)
        // We'll redirect to the OrderController's store method
        return app(OrderController::class)->store($request);
    }
} 