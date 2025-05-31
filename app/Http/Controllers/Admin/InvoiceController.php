<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Download invoice as PDF
     *
     * @param int $order_id
     * @return \Illuminate\Http\Response
     */
    public function download($order_id)
    {
        // Get order data
        $order = Order::findOrFail($order_id);
        
        // Get page settings for invoice
        $invoiceSettings = \App\Models\PageSetting::where('page_name', 'invoice')
            ->where('section_name', 'invoice')
            ->first();
        
        // Set default settings if not found
        $settings = [];
        if ($invoiceSettings && $invoiceSettings->settings) {
            // settings sudah otomatis di-cast menjadi array oleh Laravel
            $settings = $invoiceSettings->settings;
        }
        
        // Pastikan shipping_info adalah array
        if (!is_array($order->shipping_info)) {
            $order->shipping_info = [];
        }
        
        // Generate PDF
        $pdf = PDF::loadView('invoices.template', [
            'order' => $order,
            'settings' => $settings
        ]);
        
        // Set paper size to A4
        $pdf->setPaper('a4');
        
        // Return PDF for download
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }
}
