<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'stock'
    ];

    /**
     * Get the product that owns the size.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Available sizes by category
     */
    public static function getAvailableSizes($category)
    {
        $sizeRanges = [
            'pants' => range(29, 35), // 29, 30, 31, 32, 33, 34, 35
            'default' => ['XS', 'S', 'M', 'L', 'XL', 'XXL']
        ];

        return $sizeRanges[$category] ?? $sizeRanges['default'];
    }
} 