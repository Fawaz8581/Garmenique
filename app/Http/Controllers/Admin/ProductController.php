<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        // No need to load categories anymore since we're using static categories
        return view('admin.products');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|numeric|exists:categories,id',
                'price' => 'required',
                'sizes' => 'required|json',
                'image' => 'nullable|image|max:2048',
                'description' => 'nullable|string'
            ]);

            DB::beginTransaction();

            // Convert price to integer
            $price = (int) str_replace('.', '', $request->price);
            
            // Decode sizes
            $sizes = json_decode($request->sizes, true);
            
            // Create product
            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $price,
                'description' => $request->description,
                'status' => array_sum($sizes) > 0 ? 'In Stock' : 'Out of Stock'
            ]);

            // Handle image if uploaded
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $product->update(['images' => ['storage/' . $path]]);
            }

            // Create size records - now saving all sizes including 0
            foreach ($sizes as $size => $stock) {
                $product->sizes()->create([
                    'size' => $size,
                    'stock' => (int)$stock
                ]);
            }

            DB::commit();
            
            // Load the product with sizes and return
            $product = $product->fresh(['sizes']);
            return response()->json(['success' => true, 'product' => $product]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating product: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|numeric|exists:categories,id',
                'price' => 'required',
                'sizes' => 'required|json',
                'image' => 'nullable|image|max:2048',
                'description' => 'nullable|string'
            ]);

            DB::beginTransaction();

            $product = Product::findOrFail($id);
            
            // Log incoming data
            \Log::info('Updating product ' . $id . ' with data:', [
                'request_data' => $request->all(),
                'sizes_json' => $request->sizes
            ]);
            
            // Convert price to integer
            $price = (int) str_replace('.', '', $request->price);
            
            // Decode sizes
            $sizes = json_decode($request->sizes, true);
            \Log::info('Decoded sizes:', ['sizes' => $sizes]);
            
            // Update product
            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $price,
                'description' => $request->description,
                'status' => array_sum($sizes) > 0 ? 'In Stock' : 'Out of Stock'
            ]);

            // Handle image if uploaded
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $product->update(['images' => ['storage/' . $path]]);
            }

            // Update sizes - now saving all sizes including 0
            $product->sizes()->delete(); // Delete existing sizes
            foreach ($sizes as $size => $stock) {
                \Log::info("Creating size record for product {$id}:", [
                    'size' => $size,
                    'stock' => (int)$stock
                ]);
                
                $product->sizes()->create([
                    'size' => $size,
                    'stock' => (int)$stock
                ]);
            }

            DB::commit();
            
            // Load the product with sizes and verify data
            $product = $product->fresh(['sizes']);
            \Log::info('Updated product data:', [
                'product_id' => $product->id,
                'sizes_relationship' => $product->sizes()->get()->toArray(),
                'sizes_attribute' => $product->sizes
            ]);
            
            return response()->json(['success' => true, 'product' => $product]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating product: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified product.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            // This will also delete related sizes due to cascade
            $product->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all products as JSON.
     */
    public function getProducts()
    {
        try {
            // Get products with their sizes
            $products = Product::with('sizes')->get();
            
            // Transform the data to include formatted sizes
            $products->transform(function ($product) {
                // Force reload sizes to ensure we have fresh data
                $product->load('sizes');
                
                // Log for debugging
                \Log::info('Product ID: ' . $product->id . ' sizes:', [
                    'sizes' => $product->sizes,
                    'formatted_sizes' => $product->getSizesAttribute()
                ]);
                
                return $product;
            });
            
            return response()->json($products);
        } catch (\Exception $e) {
            \Log::error('Error getting products: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching products'], 500);
        }
    }
} 