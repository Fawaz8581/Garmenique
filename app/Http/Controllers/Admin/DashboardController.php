<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Order;
use App\Models\User;
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

        // Get total users with the 'user' role
        $totalUsers = User::where('role', 'user')->count();

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
        $totalSales = (clone $ordersQuery)->sum('total');
        
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
        
        // Calculate percentages (avoid division by zero)
        $salesPercentage = $previousSales > 0 
            ? min(100, round(($totalSales / $previousSales) * 100)) 
            : ($totalSales > 0 ? 100 : 0);
        
        // Get recent orders with product details and pagination
        $recentOrdersQuery = (clone $ordersQuery)->orderBy('created_at', 'desc');
        
        // Apply search filter if provided
        $search = $request->input('search');
        if ($search) {
            $recentOrdersQuery->where(function($query) use ($search) {
                $query->where('order_number', 'like', "%{$search}%")
                      ->orWhere('cart_items', 'like', "%{$search}%");
            });
        }
        
        // Apply status filter if provided
        $status = $request->input('status');
        if ($status) {
            $recentOrdersQuery->where('status', $status);
        }
        
        // Preserve the all_dates parameter when paginating
        $recentOrdersPaginated = $recentOrdersQuery->paginate(5)->appends($request->except('page'));
        
        $recentOrders = $recentOrdersPaginated->map(function ($order) {
            $firstItem = !empty($order->cart_items) ? $order->cart_items[0] : null;
            $orderNumberParts = explode('-', $order->order_number);
            $productNumber = isset($orderNumberParts[1]) ? $orderNumberParts[1] : '';
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

        // --- Most Sold Products Logic ---
        $allOrdersForProducts = (clone $ordersQuery)->get();

        $productSales = [];
        foreach ($allOrdersForProducts as $order) {
            if (is_array($order->cart_items)) {
                foreach ($order->cart_items as $item) {
                    if (isset($item['id']) && isset($item['quantity'])) {
                        $productId = $item['id'];
                        $productSales[$productId] = ($productSales[$productId] ?? 0) + $item['quantity'];
                    }
                }
            }
        }

        arsort($productSales);
        $topProductIds = array_slice(array_keys($productSales), 0, 5);
        $topProducts = Product::with('sizes')->whereIn('id', $topProductIds)->get()->keyBy('id');

        $mostSoldProducts = [];
        foreach ($topProductIds as $productId) {
            if (isset($topProducts[$productId])) {
                $product = $topProducts[$productId];
                $mostSoldProducts[] = [
                    'product' => $product,
                    'quantity_sold' => $productSales[$productId]
                ];
            }
        }
        // --- End Most Sold Products Logic ---

        return view('admin.dashboard', compact(
            'productCount',
            'categoryCount',
            'sizeCount',
            'lowStockCount',
            'totalUsers',
            'totalSales',
            'salesPercentage',
            'recentOrders',
            'recentOrdersPaginated',
            'selectedDate',
            'showAllDates',
            'mostSoldProducts'
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
            
            // Get status filter
            $statusFilter = $request->input('status');
            
            // Get selected date
            $selectedDate = $request->has('date') 
                ? Carbon::parse($request->date)
                : Carbon::today();
            
            // Get page for pagination
            $page = $request->input('page', 1);
            
            // Apply date filter to orders query
            $ordersQuery = Order::where('status', '!=', 'rejected');
            
            // Apply status filter if provided
            if ($statusFilter) {
                $ordersQuery->where('status', $statusFilter);
            }
            
            if (!$showAllDates) {
                $startDate = $selectedDate->copy()->startOfDay();
                $endDate = $selectedDate->copy()->endOfDay();
                $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            
            // Get total sales and orders
            $totalSales = $ordersQuery->sum('total');
            $totalOrders = $ordersQuery->count();
            
            // Clone the query for pagination
            $paginationQuery = clone $ordersQuery;
            
            // Get recent orders with pagination
            $recentOrdersPaginated = $paginationQuery
                ->orderBy('created_at', 'desc')
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
                'pagination' => $pagination,
                'show_all_dates' => $showAllDates,
                'date' => $selectedDate->format('Y-m-d'),
                'selected_status' => $statusFilter, // Add this line
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error fetching dashboard data: ' . $e->getMessage()
            ], 500);
        }
    }
}