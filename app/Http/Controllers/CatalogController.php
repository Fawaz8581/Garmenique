<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        // Fetch products with pagination (6 products per page - 2 columns x 3 rows)
        $products = Product::with('category')->paginate(6);
        
        return view('catalog', compact('products'));
    }
} 