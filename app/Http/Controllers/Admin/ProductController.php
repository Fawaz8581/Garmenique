<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::with(['category', 'sizes'])->get();
        return response()->json($products);
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'sizes' => 'required|string'
            ]);

            // Create product
            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'description' => $request->description,
                'status' => 'In Stock'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $product->update([
                    'images' => ['storage/' . $path]
                ]);
            }

            // Handle sizes
            $sizes = json_decode($request->sizes, true);
            if (is_array($sizes)) {
                foreach ($sizes as $sizeData) {
                    if (isset($sizeData['id']) && isset($sizeData['stock']) && $sizeData['stock'] > 0) {
                        $product->sizes()->attach($sizeData['id'], [
                            'stock' => $sizeData['stock']
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'product' => $product->load(['category', 'sizes'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'sizes' => 'required|string'
            ]);

            // Update basic product info
            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'description' => $request->description
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image_url) {
                    $oldPath = str_replace('/storage/', '', $product->image_url);
                    Storage::disk('public')->delete($oldPath);
                }

                $path = $request->file('image')->store('products', 'public');
                $product->update([
                    'images' => ['storage/' . $path]
                ]);
            }

            // Update sizes
            $product->sizes()->detach(); // Remove all existing size relationships
            $sizes = json_decode($request->sizes, true);
            
            if (is_array($sizes)) {
                foreach ($sizes as $sizeData) {
                    if (isset($sizeData['id']) && isset($sizeData['stock']) && $sizeData['stock'] > 0) {
                        $product->sizes()->attach($sizeData['id'], [
                            'stock' => $sizeData['stock']
                        ]);
                    }
                }
            }

            // Update product status based on total stock
            $totalStock = $product->sizes()->sum('stock');
            $product->update([
                'status' => $totalStock > 0 ? 'In Stock' : 'Out of Stock'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'product' => $product->load(['category', 'sizes'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified product.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);

            // Delete image if exists
            if ($product->image_url) {
                $path = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($path);
            }

            // Delete product (sizes will be detached automatically due to cascade)
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

    public function show()
    {
        $sizes = Size::all();
        return view('admin.products', compact('sizes'));
    }
} 