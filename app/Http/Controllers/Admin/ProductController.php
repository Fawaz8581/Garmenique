<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.products', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|string',
            'description' => 'nullable|string'
        ]);

        $status = $request->stock > 0 ? ($request->stock <= 20 ? 'Low Stock' : 'In Stock') : 'Out of Stock';
        
        $images = [];
        if ($request->image) {
            $images[] = $request->image;
        }

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'status' => $status,
            'images' => $images,
            'description' => $request->description ?? '',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product->load('category')
        ]);
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|string',
            'description' => 'nullable|string'
        ]);

        $product = Product::findOrFail($id);
        
        $status = $request->stock > 0 ? ($request->stock <= 20 ? 'Low Stock' : 'In Stock') : 'Out of Stock';
        
        $images = $product->images ?? [];
        if ($request->image && !in_array($request->image, $images)) {
            $images[] = $request->image;
        }

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'status' => $status,
            'images' => $images,
            'description' => $request->description ?? $product->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product->load('category')
        ]);
    }

    /**
     * Remove the specified product.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Get all products as JSON.
     */
    public function getProducts()
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }
} 