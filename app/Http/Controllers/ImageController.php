<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    /**
     * Store an image in the database
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|max:5120', // Max 5MB
                'type' => 'required|string',
                'id' => 'required|integer'
            ]);

            if (!$request->hasFile('image')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No image file uploaded'
                ], 400);
            }

            // Get image data and encode as base64 to avoid UTF-8 issues
            $imageData = base64_encode(file_get_contents($request->file('image')->getRealPath()));
            $mimeType = $request->file('image')->getMimeType();
            
            // Log image information
            Log::info('Processing image upload via ImageController', [
                'type' => $request->type,
                'id' => $request->id,
                'mime_type' => $mimeType,
                'size' => strlen($imageData),
                'encoding' => 'base64'
            ]);
            
            // Store image data in the appropriate table based on type
            switch ($request->type) {
                case 'product':
                    DB::table('products')
                        ->where('id', $request->id)
                        ->update([
                            'image_data' => $imageData,
                            'image_mime_type' => $mimeType
                        ]);
                    
                    // Generate URL for the stored image
                    $imageUrl = route('product.image', ['id' => $request->id]);
                    break;
                    
                // Add other types as needed (e.g., user profile, category, etc.)
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid image type'
                    ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'image_url' => $imageUrl
            ]);

        } catch (\Exception $e) {
            Log::error('Error uploading image: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error uploading image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get an image from the database
     *
     * @param Request $request
     * @param string $type
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getImage(Request $request, $type, $id)
    {
        try {
            // Get image data from the appropriate table based on type
            switch ($type) {
                case 'product':
                    $item = DB::table('products')
                        ->where('id', $id)
                        ->select('image_data', 'image_mime_type')
                        ->first();
                    break;
                    
                // Add other types as needed
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid image type'
                    ], 400);
            }

            if (!$item || !$item->image_data) {
                // Return default image
                return response()->file(public_path('images/no-image.jpg'));
            }
            
            // We now consistently store images as base64, so decode it
            try {
                $imageData = base64_decode($item->image_data);
                
                // Validate that decode was successful
                if ($imageData === false) {
                    Log::warning('Failed to decode base64 image data', [
                        'type' => $type,
                        'id' => $id,
                        'data_length' => strlen($item->image_data)
                    ]);
                    return response()->file(public_path('images/no-image.jpg'));
                }
                
                Log::info('Successfully decoded base64 image data', [
                    'type' => $type,
                    'id' => $id,
                    'decoded_size' => strlen($imageData)
                ]);
            } catch (\Exception $e) {
                Log::error('Error decoding image data: ' . $e->getMessage());
                return response()->file(public_path('images/no-image.jpg'));
            }
            
            // Add anti-cache headers to ensure browsers always load the new image
            $timestamp = time();
            $random = mt_rand(1000, 9999);
            $cacheKey = 'img-' . $type . '-' . $id . '-' . $timestamp . '-' . $random;
            
            return response($imageData)
                ->header('Content-Type', $item->image_mime_type)
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0')
                ->header('ETag', md5($cacheKey));

        } catch (\Exception $e) {
            Log::error('Error retrieving image: ' . $e->getMessage());
            return response()->file(public_path('images/no-image.jpg'));
        }
    }
} 