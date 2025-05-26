<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(Request $request)
    {
        // Get counts for dashboard statistics
        $productCount = Product::count();
        $categoryCount = Category::count();
        $sizeCount = Size::count();
        $lowStockCount = Product::whereHas('sizes', function($query) {
            $query->where('stock', '<', 10);
        })->count();

        // Get the selected date or default to today
        $showAllDates = $request->has('all_dates');
        
        // Always set a valid selectedDate even when in all_dates mode
        $selectedDate = $request->input('date') 
            ? Carbon::parse($request->input('date')) 
            : Carbon::today();
        
        // Set time range for the selected date (entire day)
        $startDate = $selectedDate->copy()->startOfDay();
        $endDate = $selectedDate->copy()->endOfDay();
        
        // Base query for orders
        $ordersQuery = Order::where('status', '!=', 'rejected');
        
        // Apply date filter if not showing all dates
        if (!$showAllDates) {
            $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        // Calculate total sales
        $totalSales = $ordersQuery->sum('total');
        
        // Get total orders count
        $totalOrders = $ordersQuery->count();
        
        // Calculate sales percentage (compared to previous period)
        if (!$showAllDates) {
            // If filtering by date, compare to previous day
            $previousPeriod = [
                $startDate->copy()->subDay()->startOfDay(),
                $endDate->copy()->subDay()->endOfDay()
            ];
        } else {
            // If showing all dates, compare to previous month
            $previousPeriod = [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ];
        }
        
        // Base query for previous period
        $previousOrdersQuery = Order::whereBetween('created_at', $previousPeriod)
                                  ->where('status', '!=', 'rejected');
        
        $previousSales = $previousOrdersQuery->sum('total');
        $previousOrders = $previousOrdersQuery->count();
        
        // Calculate percentages (avoid division by zero)
        $salesPercentage = $previousSales > 0 
            ? min(100, round(($totalSales / $previousSales) * 100)) 
            : ($totalSales > 0 ? 100 : 0);
        
        $ordersPercentage = $previousOrders > 0 
            ? min(100, round(($totalOrders / $previousOrders) * 100)) 
            : ($totalOrders > 0 ? 100 : 0);
        
        // Get recent orders with product details and pagination
        $recentOrdersQuery = Order::orderBy('created_at', 'desc')
                                 ->where('status', '!=', 'rejected');
        
        // Apply date filter if not showing all dates
        if (!$showAllDates) {
            $recentOrdersQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        // Preserve the all_dates parameter when paginating
        $recentOrdersPaginated = $recentOrdersQuery->paginate(5)->appends($request->except('page'));
        
        $recentOrders = $recentOrdersPaginated->map(function ($order) {
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
            'recentOrders',
            'recentOrdersPaginated',
            'selectedDate',
            'showAllDates'
        ));
    }
    
    /**
     * Get dashboard data as JSON for AJAX requests.
     */
    public function getDashboardDataJson(Request $request)
    {
        // Get the selected date or default to today
        $showAllDates = $request->has('all_dates');
        
        // Always set a valid selectedDate even when in all_dates mode
        $selectedDate = $request->input('date') 
            ? Carbon::parse($request->input('date')) 
            : Carbon::today();
        
        // Set time range for the selected date (entire day)
        $startDate = $selectedDate->copy()->startOfDay();
        $endDate = $selectedDate->copy()->endOfDay();
        
        // Base query for orders
        $ordersQuery = Order::where('status', '!=', 'rejected');
        
        // Apply date filter if not showing all dates
        if (!$showAllDates) {
            $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        // Calculate total sales
        $totalSales = $ordersQuery->sum('total');
        
        // Get total orders count
        $totalOrders = $ordersQuery->count();
        
        // Calculate sales percentage (compared to previous period)
        if (!$showAllDates) {
            // If filtering by date, compare to previous day
            $previousPeriod = [
                $startDate->copy()->subDay()->startOfDay(),
                $endDate->copy()->subDay()->endOfDay()
            ];
        } else {
            // If showing all dates, compare to previous month
            $previousPeriod = [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ];
        }
        
        // Base query for previous period
        $previousOrdersQuery = Order::whereBetween('created_at', $previousPeriod)
                                  ->where('status', '!=', 'rejected');
        
        $previousSales = $previousOrdersQuery->sum('total');
        $previousOrders = $previousOrdersQuery->count();
        
        // Calculate percentages (avoid division by zero)
        $salesPercentage = $previousSales > 0 
            ? min(100, round(($totalSales / $previousSales) * 100)) 
            : ($totalSales > 0 ? 100 : 0);
        
        $ordersPercentage = $previousOrders > 0 
            ? min(100, round(($totalOrders / $previousOrders) * 100)) 
            : ($totalOrders > 0 ? 100 : 0);
        
        // Get recent orders with product details and pagination
        $recentOrdersQuery = Order::orderBy('created_at', 'desc')
                                 ->where('status', '!=', 'rejected');
        
        // Apply date filter if not showing all dates
        if (!$showAllDates) {
            $recentOrdersQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        $page = $request->input('page', 1);
        $perPage = 5;
        
        // Preserve the all_dates parameter when paginating
        $recentOrdersPaginated = $recentOrdersQuery->paginate($perPage)->appends($request->except('page'));
        
        $recentOrders = $recentOrdersPaginated->map(function ($order) {
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
            'pagination' => [
                'current_page' => $recentOrdersPaginated->currentPage(),
                'last_page' => $recentOrdersPaginated->lastPage(),
                'per_page' => $recentOrdersPaginated->perPage(),
                'total' => $recentOrdersPaginated->total()
            ],
            'date' => $showAllDates ? 'all' : $selectedDate->format('Y-m-d'),
            'has_orders' => $totalOrders > 0,
            'show_all_dates' => $showAllDates
        ]);
    }
} 