<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'status',
        'featured',
        'images',
        'image_data',
        'image_mime_type'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images' => 'array',
        'featured' => 'boolean',
        'price' => 'integer'
    ];

    /**
     * The attributes that should be hidden from serialization.
     *
     * @var array
     */
    protected $hidden = [
        'image_data'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_url', 'category_name', 'total_stock', 'sizes', 'available_sizes', 'db_image_url'];
    
    /**
     * Get the image URL for display.
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        if (!empty($this->images) && is_array($this->images)) {
            return asset($this->images[0]);
        }
        return null;
    }

    /**
     * Get the database image URL for display.
     *
     * @return string|null
     */
    public function getDbImageUrlAttribute()
    {
        if ($this->image_data) {
            return route('public.product.image', ['id' => $this->id]);
        }
        return null;
    }

    /**
     * Get the price for array/JSON serialization.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function getPriceAttribute($value)
    {
        // Return the raw value without decimal places
        return (int) $value;
    }

    /**
     * Set the price attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setPriceAttribute($value)
    {
        // If the value is a string with dots (formatted), convert it
        if (is_string($value) && str_contains($value, '.')) {
            $value = (int) str_replace('.', '', $value);
        }
        
        // Store as integer without decimal places
        $this->attributes['price'] = $value;
    }
    
    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Get the category name with proper capitalization
     * 
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'Uncategorized';
    }

    /**
     * Get the total stock across all sizes
     */
    public function getTotalStockAttribute()
    {
        return $this->sizes()->sum('stock');
    }

    /**
     * Get the sizes relationship
     */
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes', 'product_id', 'size', 'id', 'name')
                    ->withPivot('stock')
                    ->withTimestamps();
    }

    /**
     * Get available sizes for the current category
     */
    public function getAvailableSizesAttribute()
    {
        return ProductSize::getAvailableSizes($this->category_id);
    }

    /**
     * Get sizes with stock information
     */
    public function getSizesAttribute()
    {
        // Get all sizes for this product with their pivot data
        $productSizes = $this->sizes()->withPivot('stock')->get();
        
        \Log::info("Getting sizes for product {$this->id}:", [
            'raw_sizes' => $productSizes->toArray()
        ]);
        
        $sizeData = [];
        
        // Map each size to its stock value
        foreach ($productSizes as $size) {
            $sizeData[$size->name] = [
                'id' => $size->id,
                'name' => $size->name,
                'type' => $size->type,
                'stock' => (int)$size->pivot->stock
            ];
        }
        
        \Log::info("Final size data for product {$this->id}:", [
            'size_data' => $sizeData
        ]);
        
        return $sizeData;
    }

    /**
     * Get image data attribute - handle binary data properly
     * 
     * @param mixed $value
     * @return mixed
     */
    public function getImageDataAttribute($value)
    {
        // Return the base64-encoded data
        return $value;
    }
    
    /**
     * Set image data attribute - handle binary data properly
     * 
     * @param mixed $value
     * @return void
     */
    public function setImageDataAttribute($value)
    {
        // Don't attempt to set binary data through the model
        // Use direct DB queries instead
    }
} 