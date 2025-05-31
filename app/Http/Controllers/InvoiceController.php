<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use PDF;

class InvoiceController extends Controller
{
    /**
     * Download a PDF invoice for an order
     *
     * @param int $orderId
     * @return \Illuminate\Http\Response
     */
    public function download($orderId)
    {
        // Find the order
        $order = Order::findOrFail($orderId);
        
        // Verify that the order belongs to the authenticated user
        if (Auth::id() !== $order->user_id) {
            return redirect()->route('account.orders')
                ->with('error', 'You are not authorized to access this invoice');
        }
        
        // Verify that the order is in a status that should have an invoice
        if (!in_array($order->status, ['success', 'confirmed', 'packing', 'shipped', 'delivered', 'completed'])) {
            return redirect()->route('account.orders')
                ->with('error', 'Invoice is only available for completed orders');
        }
        
        // Generate PDF invoice
        $pdf = PDF::loadView('invoices.template', [
            'order' => $order,
        ]);
        
        // Set PDF options
        $pdf->setPaper('a4', 'portrait');
        
        // Generate filename
        $filename = 'Invoice-' . $order->order_number . '.pdf';
        
        // Return the PDF as a download
        return $pdf->download($filename);
    }
} 