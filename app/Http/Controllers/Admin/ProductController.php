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
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'stock' => 'nullable|integer|min:0',
                'image' => 'nullable|image|max:2048', // Validate uploaded image
                'description' => 'nullable|string'
            ]);

            $status = $request->stock > 0 ? ($request->stock <= 20 ? 'Low Stock' : 'In Stock') : 'Out of Stock';
            
            // Initialize variables
            $imagePath = null;
            $imageMimeType = null;
            
            // Handle image upload safely
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');
                // Generate a safer filename
                $extension = $file->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;
                // Use storeAs which is more reliable
                $imagePath = $file->storeAs('products', $imageName, 'public');
                $imageMimeType = $file->getMimeType();
                $imagePath = 'storage/' . $imagePath; // Adjust path for public URL
            }

            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock ?? 0,
                'status' => $status,
                'description' => $request->description ?? '',
                'images' => $imagePath ? [$imagePath] : [],
                'image_mime_type' => $imageMimeType
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'product' => $product->load('category')
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error adding product: ' . $e->getMessage()
            ], 500);
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
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'stock' => 'nullable|integer|min:0',
                'image' => 'nullable|image|max:2048', // Validate uploaded image
                'description' => 'nullable|string'
            ]);

            $product = Product::findOrFail($id);
            
            $status = $request->stock > 0 ? ($request->stock <= 20 ? 'Low Stock' : 'In Stock') : 'Out of Stock';
            
            $updateData = [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock ?? 0,
                'status' => $status,
                'description' => $request->description ?? $product->description,
            ];
            
            // Handle image upload safely
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');
                // Generate a safer filename
                $extension = $file->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;
                // Use storeAs which is more reliable
                $imagePath = $file->storeAs('products', $imageName, 'public');
                $imageMimeType = $file->getMimeType();
                $imagePath = 'storage/' . $imagePath; // Adjust path for public URL
                
                $updateData['image_mime_type'] = $imageMimeType;
                $updateData['images'] = [$imagePath];
            }

            $product->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'product' => $product->load('category')
            ]);
        } catch (\Exception $e) {
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