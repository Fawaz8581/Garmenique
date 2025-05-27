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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status value',
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
            
            $order->status = $newStatus;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status',
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
            
            // Find the product size relationship
            $productSize = \App\Models\ProductSize::where('product_id', $item['id'])
                ->where('size', $item['size'])
                ->first();
            
            if (!$productSize) {
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