<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Show the account settings page.
     */
    public function showSettings()
    {
        return view('account.settings');
    }
    
    /**
     * Show the password page.
     */
    public function showPassword()
    {
        return view('account.password');
    }
    
    /**
     * Show the contact information page.
     */
    public function showContact()
    {
        return view('account.contact');
    }
    
    /**
     * Show the orders page.
     */
    public function showOrders()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->paginate(3);

        return view('account.orders', ['orders' => $orders]);
    }
    
    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country_code' => ['nullable', 'string', 'max:10'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);
        
        // Update user information
        $user->name = $validated['name'];
        $user->country_code = $validated['country_code'];
        $user->phone_number = $validated['phone_number'];
        $user->address = $validated['address'];
        
        // Handle password change if requested
        if ($request->filled('current_password')) {
            $request->validate([
                'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('The current password is incorrect.');
                    }
                }],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('account.settings')->with('status', 'Profile updated successfully!');
    }
    
    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        // Update password
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('account.password')->with('status', 'Password updated successfully!');
    }
    
    /**
     * Update the user's contact information (phone and address).
     */
    public function updateContact(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $validated = $request->validate([
            'country_code' => ['nullable', 'string', 'max:10'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
        ]);
        
        // Update user information
        $user->country_code = $validated['country_code'];
        $user->phone_number = $validated['phone_number'];
        $user->address = $validated['address'];
        $user->city = $validated['city'] ?? null;
        $user->postal_code = $validated['postal_code'] ?? null;
        $user->save();
        
        return redirect()->route('account.contact')->with('status', 'Contact information updated successfully!');
    }

    /**
     * Get dashboard data including total sales, total orders, and recent orders.
     */
    public function getDashboardData()
    {
        // Get current user ID
        $userId = Auth::id();
        
        // Get the date 24 hours ago
        $last24Hours = Carbon::now()->subHours(24);
        
        // Calculate total sales and total orders for the last 24 hours
        $totalSales = Order::where('user_id', $userId)
                          ->where('created_at', '>=', $last24Hours)
                          ->sum('total');
        
        $totalOrders = Order::where('user_id', $userId)
                           ->where('created_at', '>=', $last24Hours)
                           ->count();
        
        // Get recent orders with product details
        $recentOrders = Order::where('user_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get()
                            ->map(function ($order) {
                                // Extract the first product from each order
                                $firstItem = !empty($order->cart_items) ? $order->cart_items[0] : null;
                                
                                return [
                                    'id' => $order->id,
                                    'order_number' => $order->order_number,
                                    'created_at' => $order->created_at,
                                    'status' => $order->status,
                                    'total' => $order->total,
                                    'product_name' => $firstItem ? $firstItem['name'] : 'N/A',
                                    'product_number' => 'GA-' . str_pad(($order->id % 1000), 4, '0', STR_PAD_LEFT),
                                    'product_image' => $firstItem ? $firstItem['image'] : null,
                                ];
                            });
        
        // Calculate sales percentage (compared to previous 24 hours)
        $previousPeriod = [
            $last24Hours->copy()->subHours(24),
            $last24Hours
        ];
        
        $previousSales = Order::where('user_id', $userId)
                             ->whereBetween('created_at', $previousPeriod)
                             ->sum('total');
        
        $previousOrders = Order::where('user_id', $userId)
                              ->whereBetween('created_at', $previousPeriod)
                              ->count();
        
        // Calculate percentages (avoid division by zero)
        $salesPercentage = $previousSales > 0 
            ? min(100, round(($totalSales / $previousSales) * 100)) 
            : ($totalSales > 0 ? 100 : 0);
        
        $ordersPercentage = $previousOrders > 0 
            ? min(100, round(($totalOrders / $previousOrders) * 100)) 
            : ($totalOrders > 0 ? 100 : 0);
        
        return [
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'recent_orders' => $recentOrders,
            'sales_percentage' => $salesPercentage,
            'orders_percentage' => $ordersPercentage,
            'date' => Carbon::now()->format('m/d/Y')
        ];
    }
    
    /**
     * Show the dashboard page with analytics.
     */
    public function showDashboard()
    {
        $dashboardData = $this->getDashboardData();
        return view('account.dashboard', $dashboardData);
    }
    
    /**
     * Get dashboard data as JSON for AJAX requests.
     */
    public function getDashboardDataJson()
    {
        return response()->json($this->getDashboardData());
    }
    
    /**
     * Get user's address information for checkout.
     */
    public function getUserAddress()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        
        return response()->json([
            'name' => $user->name,
            'address' => $user->address,
            'city' => $user->city,
            'postal_code' => $user->postal_code,
            'country_code' => $user->country_code,
            'phone_number' => $user->phone_number,
        ]);
    }
}