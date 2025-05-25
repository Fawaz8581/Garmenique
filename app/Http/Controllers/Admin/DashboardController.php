<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // Get counts for dashboard statistics
        $productCount = Product::count();
        $categoryCount = Category::count();
        $sizeCount = Size::count();
        $lowStockCount = Product::whereHas('sizes', function($query) {
            $query->where('stock', '<', 10);
        })->count();

        // Get the date 24 hours ago
        $last24Hours = Carbon::now()->subHours(24);
        
        // Calculate total sales for the last 24 hours
        $totalSales = Order::where('created_at', '>=', $last24Hours)->sum('total');
        
        // Get total orders count for the last 24 hours
        $totalOrders = Order::where('created_at', '>=', $last24Hours)->count();
        
        // Calculate sales percentage (compared to previous 24 hours)
        $previousPeriod = [
            $last24Hours->copy()->subHours(24),
            $last24Hours
        ];
        
        $previousSales = Order::whereBetween('created_at', $previousPeriod)->sum('total');
        $previousOrders = Order::whereBetween('created_at', $previousPeriod)->count();
        
        // Calculate percentages (avoid division by zero)
        $salesPercentage = $previousSales > 0 
            ? min(100, round(($totalSales / $previousSales) * 100)) 
            : ($totalSales > 0 ? 100 : 0);
        
        $ordersPercentage = $previousOrders > 0 
            ? min(100, round(($totalOrders / $previousOrders) * 100)) 
            : ($totalOrders > 0 ? 100 : 0);
        
        // Get recent orders with product details
        $recentOrders = Order::orderBy('created_at', 'desc')
                            ->take(5)
                            ->get()
                            ->map(function ($order) {
                                // Extract the first product from each order
                                $firstItem = !empty($order->cart_items) ? $order->cart_items[0] : null;
                                
                                // Extract order number for product number
                                $orderNumberParts = explode('-', $order->order_number);
                                $productNumber = isset($orderNumberParts[1]) ? $orderNumberParts[1] : '';
                                
                                return [
                                    'id' => $order->id,
                                    'order_number' => $order->order_number,
                                    'created_at' => $order->created_at,
                                    'status' => $order->status,
                                    'total' => $order->total,
                                    'product_name' => $firstItem ? $firstItem['name'] : 'N/A',
                                    'product_number' => 'ORD-' . $productNumber,
                                ];
                            });

        return view('admin.dashboard', compact(
            'productCount',
            'categoryCount',
            'sizeCount',
            'lowStockCount',
            'totalSales',
            'totalOrders',
            'salesPercentage',
            'ordersPercentage',
            'recentOrders'
        ));
    }
    
    /**
     * Get dashboard data as JSON for AJAX requests.
     */
    public function getDashboardDataJson()
    {
        // Get the date 24 hours ago
        $last24Hours = Carbon::now()->subHours(24);
        
        // Calculate total sales for the last 24 hours
        $totalSales = Order::where('created_at', '>=', $last24Hours)->sum('total');
        
        // Get total orders count for the last 24 hours
        $totalOrders = Order::where('created_at', '>=', $last24Hours)->count();
        
        // Calculate sales percentage (compared to previous 24 hours)
        $previousPeriod = [
            $last24Hours->copy()->subHours(24),
            $last24Hours
        ];
        
        $previousSales = Order::whereBetween('created_at', $previousPeriod)->sum('total');
        $previousOrders = Order::whereBetween('created_at', $previousPeriod)->count();
        
        // Calculate percentages (avoid division by zero)
        $salesPercentage = $previousSales > 0 
            ? min(100, round(($totalSales / $previousSales) * 100)) 
            : ($totalSales > 0 ? 100 : 0);
        
        $ordersPercentage = $previousOrders > 0 
            ? min(100, round(($totalOrders / $previousOrders) * 100)) 
            : ($totalOrders > 0 ? 100 : 0);
        
        // Get recent orders with product details
        $recentOrders = Order::orderBy('created_at', 'desc')
                            ->take(5)
                            ->get()
                            ->map(function ($order) {
                                // Extract the first product from each order
                                $firstItem = !empty($order->cart_items) ? $order->cart_items[0] : null;
                                
                                // Extract order number for product number
                                $orderNumberParts = explode('-', $order->order_number);
                                $productNumber = isset($orderNumberParts[1]) ? $orderNumberParts[1] : '';
                                
                                return [
                                    'id' => $order->id,
                                    'order_number' => $order->order_number,
                                    'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                                    'status' => $order->status,
                                    'total' => $order->total,
                                    'product_name' => $firstItem ? $firstItem['name'] : 'N/A',
                                    'product_number' => 'ORD-' . $productNumber,
                                ];
                            });
        
        return response()->json([
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'sales_percentage' => $salesPercentage,
            'orders_percentage' => $ordersPercentage,
            'recent_orders' => $recentOrders,
            'date' => Carbon::now()->format('m/d/Y')
        ]);
    }
} 