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
            
            // Get shipping expedition information
            $shippingInfo = $order->shipping_info ?? [];
            
            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'created_at' => $order->created_at,
                'status' => $order->status,
                'total' => $order->total,
                'product_name' => $firstItem ? $firstItem['name'] : 'N/A',
                'product_number' => 'ORD-' . $productNumber,
                'shipping_info' => $shippingInfo,
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
     * Get dashboard data for AJAX requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDashboardDataJson(Request $request)
    {
        try {
            // Get date filter
            $showAllDates = $request->has('all_dates');
            $selectedDate = $request->has('date') 
                ? Carbon::parse($request->date)
                : Carbon::today();
            
            // Get page for pagination
            $page = $request->input('page', 1);
            
            // Apply date filter to orders query
            $ordersQuery = Order::where('status', '!=', 'rejected');
            
            if (!$showAllDates) {
                $startDate = $selectedDate->copy()->startOfDay();
                $endDate = $selectedDate->copy()->endOfDay();
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            
            // Get total sales and orders for the selected date or all time
            $totalSales = $ordersQuery->sum('total');
            $totalOrders = $ordersQuery->count();
            
            // Clone the query for pagination to ensure we're using the same filter conditions
            $paginationQuery = clone $ordersQuery;
            
            // Get recent orders with pagination
            $recentOrdersPaginated = $paginationQuery->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'page', $page);
            
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
                    'status' => $order->status, // Ensure we're using the actual status
                    'total' => $order->total,
                    'product_name' => $firstItem ? $firstItem['name'] : 'N/A',
                    'product_number' => 'ORD-' . $productNumber,
                    'shipping_info' => $order->shipping_info ?? [],
                ];
            });
            
            // Calculate sales percentage (compared to previous period)
            if (!$showAllDates) {
                // If filtering by date, compare to previous day
                $previousPeriod = [
                    $selectedDate->copy()->subDay()->startOfDay(),
                    $selectedDate->copy()->subDay()->endOfDay()
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
            
            // Format pagination data for frontend
            $pagination = [
                'current_page' => $recentOrdersPaginated->currentPage(),
                'last_page' => $recentOrdersPaginated->lastPage(),
                'per_page' => $recentOrdersPaginated->perPage(),
                'total' => $recentOrdersPaginated->total(),
            ];
            
            return response()->json([
                'total_sales' => $totalSales,
                'total_orders' => $totalOrders,
                'recent_orders' => $recentOrders,
                'sales_percentage' => $salesPercentage,
                'orders_percentage' => $ordersPercentage,
                'show_all_dates' => $showAllDates,
                'date' => $selectedDate->format('Y-m-d'),
                'pagination' => $pagination,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getDashboardDataJson: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading dashboard data',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
} 