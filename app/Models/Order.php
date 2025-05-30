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
        'status',
        'snap_token',
        'notes'
    ];

    protected $casts = [
        'shipping_info' => 'array',
        'payment_info' => 'array',
        'cart_items' => 'array',
        'notes' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Add a note to the order
     *
     * @param string $message The note message
     * @param string $status Current order status
     * @param bool $isAdmin Whether the note is from admin
     * @return $this
     */
    public function addNote($message, $status = null, $isAdmin = false)
    {
        $notes = $this->notes ?? [];
        
        // If notes is null or not an array, initialize it
        if (!is_array($notes)) {
            $notes = [];
        }
        
        $notes[] = [
            'date' => now()->toDateTimeString(),
            'status' => $status ?? $this->status,
            'message' => $message,
            'admin' => $isAdmin
        ];
        
        $this->notes = $notes;
        return $this;
    }
} 