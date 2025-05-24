<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;

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

        return view('admin.dashboard', compact(
            'productCount',
            'categoryCount',
            'sizeCount',
            'lowStockCount'
        ));
    }
} 