<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        // Fetch products with pagination and eager load categories
        $products = Product::with('category')->paginate(6);
        
        // Fetch categories with their product counts
        $categories = Category::withCount('products')->get();
        
        return view('catalog', compact('products', 'categories'));
    }
} 