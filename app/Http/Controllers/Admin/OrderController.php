<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Update the order status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,rejected,confirmed,packing,shipped,delivered,completed',
            'note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input values',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order = Order::findOrFail($id);
            $oldStatus = $order->status;
            $newStatus = $request->status;
            
            // Handle stock management based on status change
            if ($oldStatus === 'rejected' && $newStatus !== 'rejected') {
                // If order was rejected but now is not, decrease stock
                $this->updateProductStock($order, 'decrease');
            } else if ($oldStatus !== 'rejected' && $newStatus === 'rejected') {
                // If order was not rejected but now is, increase stock (return items)
                $this->updateProductStock($order, 'increase');
            }
            
            // Update order status
            $order->status = $newStatus;
            
            // Add admin note if provided
            if ($request->filled('note')) {
                // Each status change gets its own note
                $order->addNote($request->note, $newStatus, true);
            }
            
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'has_notes' => !empty($order->notes)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update product stock based on order items
     * 
     * @param Order $order
     * @param string $action 'increase' or 'decrease'
     */
    private function updateProductStock($order, $action = 'decrease')
    {
        if (empty($order->cart_items)) {
            return;
        }
        
        foreach ($order->cart_items as $item) {
            if (!isset($item['id']) || !isset($item['size']) || !isset($item['quantity'])) {
                continue;
            }
            
            $product = \App\Models\Product::find($item['id']);
            
            if (!$product) {
                continue;
            }
            
            // Find the product size relationship using the exact size string from the cart item
            $productSize = \App\Models\ProductSize::where('product_id', $item['id'])
                ->where('size', $item['size'])
                ->first();
                
            // If not found, try to find it via the Size model for translation
            if (!$productSize) {
                \Log::info('Admin: Trying to find size via alternative method', [
                    'product_id' => $item['id'],
                    'size_name' => $item['size']
                ]);
                
                // Try to find the size in the sizes table
                $size = \App\Models\Size::where('name', $item['size'])->first();
                
                if ($size) {
                    $productSize = \App\Models\ProductSize::where('product_id', $item['id'])
                        ->where('size', $size->name)
                        ->first();
                    
                    \Log::info('Admin: Found via alternative method', [
                        'size_id' => $size->id,
                        'size_name' => $size->name,
                        'product_size_found' => $productSize ? 'yes' : 'no'
                    ]);
                }
            }
            
            if (!$productSize) {
                \Log::warning('Admin: Product size not found', [
                    'product_id' => $item['id'],
                    'size' => $item['size']
                ]);
                continue;
            }
            
            // Update stock based on action
            if ($action === 'decrease') {
                $newStock = max(0, $productSize->stock - $item['quantity']);
            } else {
                $newStock = $productSize->stock + $item['quantity'];
            }
            
            $productSize->stock = $newStock;
            $productSize->save();
            
            // Log the stock update
            \Log::info('Admin: Product stock updated', [
                'product_id' => $item['id'],
                'product_name' => $product->name,
                'size' => $item['size'],
                'action' => $action,
                'new_stock' => $newStock,
                'quantity_change' => $item['quantity']
            ]);
        }
    }

    /**
     * Get order details by ID
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getOrderDetails($id)
    {
        try {
            $order = Order::findOrFail($id);
            
            // Ensure shipping expedition information is properly formatted
            $orderData = $order->toArray();
            
            // Format shipping expedition if it exists
            if (isset($orderData['shipping_info']) && isset($orderData['shipping_info']['expedition'])) {
                $expedition = $orderData['shipping_info']['expedition'];
                $expeditionName = 'Standard Shipping';
                
                switch ($expedition) {
                    case 'jne':
                        $expeditionName = 'JNE - Regular delivery';
                        break;
                    case 'jnt':
                        $expeditionName = 'J&T Express - Regular delivery';
                        break;
                    case 'sicepat':
                        $expeditionName = 'SiCepat - Regular delivery';
                        break;
                }
                
                $orderData['shipping_info']['expedition_name'] = $expeditionName;
            }
            
            return response()->json([
                'success' => true,
                'order' => $orderData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve order details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 