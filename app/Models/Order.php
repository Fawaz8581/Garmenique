<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'shipping_info',
        'payment_info',
        'cart_items',
        'subtotal',
        'shipping_cost',
        'total',
        'status'
    ];

    protected $casts = [
        'shipping_info' => 'array',
        'payment_info' => 'array',
        'cart_items' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 