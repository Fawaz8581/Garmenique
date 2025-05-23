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
        'stock',
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
        'featured' => 'boolean'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_url', 'category_name'];
    
    /**
     * Get the image URL for display.
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        // Use images array - for file path approach
        if (!empty($this->images) && is_array($this->images)) {
            return asset($this->images[0]);
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
     * Get the category name with proper capitalization
     * 
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        if (!$this->category_id) {
            return 'Uncategorized';
        }
        
        $categoryMap = [
            "tshirt" => "T-shirt",
            "shirt" => "Shirt",
            "jackets" => "Jackets",
            "pants" => "Pants",
            "hoodie" => "Hoodie"
        ];
        
        return $categoryMap[$this->category_id] ?? ucfirst($this->category_id);
    }
} 