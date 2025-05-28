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
            // 1. Validate all input first
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'sizes' => 'required|string'
            ]);

            // 2. Parse and validate sizes data
            $sizes = json_decode($request->sizes, true);
            if (!is_array($sizes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid sizes format'
                ], 400);
            }
            
            // 3. Validate all sizes exist
            $sizesToInsert = [];
            $totalStock = 0;
            
            foreach ($sizes as $sizeData) {
                if (isset($sizeData['id'])) {
                    // Validate that the size exists
                    $size = Size::find($sizeData['id']);
                    if (!$size) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Size with ID ' . $sizeData['id'] . ' not found'
                        ], 400);
                    }
                    
                    // Get stock value, default to 0 if not provided
                    $stock = isset($sizeData['stock']) ? (int)$sizeData['stock'] : 0;
                    $totalStock += $stock;
                }
            }
            
            // 4. Prepare image data if present
            $imageData = null;
            $mimeType = null;
            $path = null;
            
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                try {
                    // Store image path for compatibility
                    $path = $request->file('image')->store('products', 'public');
                    
                    // Get image data and encode as base64 to avoid UTF-8 issues
                    $imageData = base64_encode(file_get_contents($request->file('image')->getRealPath()));
                    $mimeType = $request->file('image')->getMimeType();
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error processing image: ' . $e->getMessage()
                    ], 400);
                }
            }
            
            // 5. Now start transaction with all validations complete
            DB::beginTransaction();
            
            try {
                // 6. Create product
                $product = Product::create([
                    'name' => $request->name,
                    'category_id' => $request->category_id,
                    'price' => $request->price,
                    'description' => $request->description,
                    'status' => $totalStock > 0 ? 'In Stock' : 'Out of Stock'
                ]);
                
                // 7. Update image if provided
                if ($path) {
                    // Update product with image path
                    $product->update([
                        'images' => ['storage/' . $path]
                    ]);
                    
                    // Handle binary data separately
                    if ($imageData && $mimeType) {
                        DB::table('products')
                            ->where('id', $product->id)
                            ->update([
                                'image_data' => $imageData,
                                'image_mime_type' => $mimeType
                            ]);
                    }
                }
                
                // 8. Insert sizes
                foreach ($sizes as $sizeData) {
                    if (isset($sizeData['id'])) {
                        $size = Size::find($sizeData['id']);
                        if ($size) {
                            $stock = isset($sizeData['stock']) ? (int)$sizeData['stock'] : 0;
                            
                            $sizesToInsert[] = [
                                'product_id' => $product->id,
                                'size' => $size->name,
                                'stock' => $stock,
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                        }
                    }
                }
                
                // Insert all sizes at once
                if (!empty($sizesToInsert)) {
                    DB::table('product_sizes')->insert($sizesToInsert);
                }
                
                // 9. Commit transaction
                DB::commit();
                
                // 10. Refresh product data
                $product = Product::with(['category', 'sizes'])->find($product->id);
                $product->category_name = $product->category ? $product->category->name : 'Uncategorized';
                $product->total_stock = $totalStock;
                
                return response()->json([
                    'success' => true,
                    'product' => $product
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                
                Log::error('Database error creating product: ' . $e->getMessage(), [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage(), [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
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
            // 1. Validate all input first
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'sizes' => 'required|string'
            ]);

            // 2. Parse and validate sizes data
            $sizes = json_decode($request->sizes, true);
            if (!is_array($sizes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid sizes format'
                ], 400);
            }

            // 3. Fetch the product outside of transaction
            $product = Product::findOrFail($id);
            
            // 4. Prepare sizes data
            $sizesToInsert = [];
            $totalStock = 0;
            
            foreach ($sizes as $sizeData) {
                if (isset($sizeData['id'])) {
                    // Validate that the size exists
                    $size = Size::find($sizeData['id']);
                    if (!$size) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Size with ID ' . $sizeData['id'] . ' not found'
                        ], 400);
                    }
                    
                    // Get stock value, default to 0 if not provided
                    $stock = isset($sizeData['stock']) ? (int)$sizeData['stock'] : 0;
                    
                    // Prepare data for bulk insert
                    $sizesToInsert[] = [
                        'product_id' => $product->id,
                        'size' => $size->name,
                        'stock' => $stock,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                    
                    $totalStock += $stock;
                }
            }
            
            // 5. Prepare image data if present
            $imageData = null;
            $mimeType = null;
            $path = null;
            
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                try {
                    // Store image path for compatibility
                    $path = $request->file('image')->store('products', 'public');
                    
                    // Get image data and encode as base64 to avoid UTF-8 issues
                    $imageData = base64_encode(file_get_contents($request->file('image')->getRealPath()));
                    $mimeType = $request->file('image')->getMimeType();
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error processing image: ' . $e->getMessage()
                    ], 400);
                }
            }
            
            // 6. Now start transaction with all validations complete
            DB::beginTransaction();
            
            try {
                // 7. Update basic product info
                $product->update([
                    'name' => $request->name,
                    'category_id' => $request->category_id,
                    'price' => $request->price,
                    'description' => $request->description,
                    'status' => $totalStock > 0 ? 'In Stock' : 'Out of Stock'
                ]);
                
                // 8. Update image if provided
                if ($path) {
                    // Delete old image if exists
                    if ($product->image_url) {
                        $oldPath = str_replace('/storage/', '', $product->image_url);
                        if (Storage::disk('public')->exists($oldPath)) {
                            Storage::disk('public')->delete($oldPath);
                        }
                    }
                    
                    // Update product with image path
                    $product->update([
                        'images' => ['storage/' . $path]
                    ]);
                    
                    // Handle binary data separately
                    if ($imageData && $mimeType) {
                        DB::table('products')
                            ->where('id', $product->id)
                            ->update([
                                'image_data' => $imageData,
                                'image_mime_type' => $mimeType
                            ]);
                    }
                }
                
                // 9. Update sizes - delete and insert in separate steps
                // First delete all existing sizes
                DB::table('product_sizes')
                    ->where('product_id', $product->id)
                    ->delete();
                
                // Then insert new sizes if any
                if (!empty($sizesToInsert)) {
                    DB::table('product_sizes')->insert($sizesToInsert);
                }
                
                // 10. Commit transaction
                DB::commit();
                
                // 11. Refresh product data
                $product = Product::with(['category', 'sizes'])->find($product->id);
                $product->category_name = $product->category ? $product->category->name : 'Uncategorized';
                $product->total_stock = $totalStock;
                
                return response()->json([
                    'success' => true,
                    'product' => $product
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                
                Log::error('Database error updating product: ' . $e->getMessage(), [
                    'product_id' => $id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage(), [
                'product_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
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
     * Serve the product image directly from the database.
     * 
     * @param int $id Product ID
     * @return \Illuminate\Http\Response
     */
    public function getImage($id)
    {
        try {
            // Get the product directly from the database to avoid model casting issues
            $product = DB::table('products')->where('id', $id)->first();
            
            if (!$product) {
                Log::warning('Product not found', ['product_id' => $id]);
                return $this->returnDefaultImage();
            }
            
            if ($product->image_data && $product->image_mime_type) {
                Log::info('Serving image from database', [
                    'product_id' => $id,
                    'mime_type' => $product->image_mime_type
                ]);
                
                // Decode the base64 image data
                $imageData = base64_decode($product->image_data);
                
                return response($imageData)
                    ->header('Content-Type', $product->image_mime_type)
                    ->header('Cache-Control', 'public, max-age=86400'); // Cache for 1 day
            }
            
            Log::warning('No image data found for product', [
                'product_id' => $id
            ]);
            
            // Check if there's a file-based image
            $images = json_decode($product->images ?? '[]');
            if (!empty($images) && is_array($images)) {
                $path = str_replace('storage/', '', $images[0]);
                if (Storage::disk('public')->exists($path)) {
                    Log::info('Serving image from storage', [
                        'product_id' => $id,
                        'path' => $path
                    ]);
                    return response()->file(storage_path('app/public/' . $path));
                }
            }
            
            return $this->returnDefaultImage();
        } catch (\Exception $e) {
            Log::error('Error retrieving product image: ' . $e->getMessage(), [
                'product_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return $this->returnDefaultImage();
        }
    }
    
    /**
     * Return a default image when no product image is available
     * 
     * @return \Illuminate\Http\Response
     */
    private function returnDefaultImage()
    {
        // Return a default image if no image is found
        if (file_exists(public_path('images/no-image.jpg'))) {
            return response()->file(public_path('images/no-image.jpg'));
        }
        
        // If no default image exists, return a 404
        return response()->json(['error' => 'Image not found'], 404);
    }

    /**
     * Get all products as JSON.
     */
    public function getProducts()
    {
        try {
            // Get products with their sizes and category
            $products = Product::with(['category', 'sizes'])->get();
            
            // Transform the data to include formatted sizes
            $products->transform(function ($product) {
                // Add the category name to the product
                $product->category_name = $product->category ? $product->category->name : 'Uncategorized';
                
                // Calculate total stock
                $totalStock = 0;
                if ($product->sizes) {
                    foreach ($product->sizes as $size) {
                        $totalStock += $size->pivot->stock;
                    }
                }
                $product->total_stock = $totalStock;
                
                // Log for debugging
                Log::info('Product ID: ' . $product->id . ' sizes:', [
                    'sizes' => $product->sizes
                ]);
                
                return $product;
            });
            
            return response()->json($products);
        } catch (\Exception $e) {
            Log::error('Error getting products: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching products'], 500);
        }
    }

    public function show()
    {
        $sizes = Size::all();
        return view('admin.products', compact('sizes'));
    }
} 