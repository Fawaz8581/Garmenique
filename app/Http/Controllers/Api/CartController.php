<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Clear the cart in the session.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearCart()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            session()->forget('user_cart_' . $userId);
        }
        
        // Also clear the generic cart key for backward compatibility
        session()->forget('cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }
    
    /**
     * Update an item in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'productId' => 'required',
            'size' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = session()->get('cart', []);
        
        // Find and update the item
        foreach ($cart as &$item) {
            if ($item['id'] == $request->productId && $item['size'] == $request->size) {
                $item['quantity'] = $request->quantity;
                break;
            }
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart' => $cart
        ]);
    }
    
    /**
     * Remove an item from the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'productId' => 'required',
            'size' => 'required'
        ]);
        
        $cart = session()->get('cart', []);
        
        // Filter out the item to remove
        $cart = array_filter($cart, function($item) use ($request) {
            return !($item['id'] == $request->productId && $item['size'] == $request->size);
        });
        
        // Re-index the array
        $cart = array_values($cart);
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart successfully',
            'cart' => $cart
        ]);
    }
}
