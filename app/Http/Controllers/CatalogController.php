<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        // Fetch products with pagination and eager load categories and sizes with pivot
        $products = Product::with([
            'category',
            'sizes' => function($query) {
                $query->select(['sizes.id', 'sizes.name', 'sizes.type'])
                      ->withPivot('stock');
            }
        ])->paginate(12);
        
        // Convert the sizes relationship to array format and ensure proper structure
        $products->getCollection()->transform(function ($product) {
            if (is_object($product->sizes) && method_exists($product->sizes, 'toArray')) {
                $sizesArray = $product->sizes->map(function ($size) {
                    return [
                        'id' => $size->id,
                        'name' => $size->name,
                        'type' => $size->type,
                        'pivot' => [
                            'stock' => $size->pivot->stock
                        ]
                    ];
                })->toArray();
                $product->sizes = $sizesArray;
            } else {
                $product->sizes = [];
            }
            return $product;
        });
        
        // Fetch categories with their product counts
        $categories = Category::withCount('products')->get();
        
        // Get all available sizes grouped by type
        $availableSizes = Size::orderBy('name')->get()->groupBy('type');
        
        // Add debug logging
        \Log::info('Products with sizes:', [
            'products' => $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sizes' => $product->sizes
                ];
            })
        ]);
        
        \Log::info('Available sizes:', [
            'sizes' => $availableSizes
        ]);
        
        return view('catalog', compact('products', 'categories', 'availableSizes'));
    }
} 