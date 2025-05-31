<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
            background-color: white;
        }
        
        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }
        
        .header {
            margin-bottom: 30px;
        }
        
        .header-left {
            float: left;
            width: 50%;
        }
        
        .header-right {
            float: right;
            width: 50%;
            text-align: right;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        
        .company-details {
            font-size: 14px;
            color: #555;
            line-height: 1.4;
        }
        
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .invoice-details {
            font-size: 14px;
            line-height: 1.4;
        }
        
        .billing-section {
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .billing-left {
            float: left;
            width: 50%;
        }
        
        .billing-right {
            float: right;
            width: 50%;
        }
        
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .payment-status {
            background-color: #28a745;
            color: white;
            text-align: center;
            padding: 10px;
            margin: 20px 0;
            font-weight: bold;
            font-size: 16px;
        }
        
        .payment-status.pending {
            background-color: #ffc107;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            color: #333;
        }
        
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .text-right {
            text-align: right;
        }
        
        .summary {
            width: 100%;
            margin-top: 20px;
        }
        
        .summary-row {
            overflow: hidden;
            padding: 5px 0;
        }
        
        .summary-label {
            float: right;
            width: 70%;
            text-align: right;
            padding-right: 10px;
        }
        
        .summary-value {
            float: right;
            width: 30%;
            text-align: right;
        }
        
        .total-row {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        
        .footer-note {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            line-height: 1.4;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header Section -->
        <div class="header clearfix">
            @php
                // Gunakan settings yang dikirim dari controller
                $companyName = isset($settings['companyName']) ? $settings['companyName'] : 'Garmenique Clothing Co.';
                $companyAddress = isset($settings['companyAddress']) ? $settings['companyAddress'] : 'Jl. Cihapit No. 12, Bandung';
                $companyRegion = isset($settings['companyRegion']) ? $settings['companyRegion'] : 'West Java, Indonesia';
                $companyPhone = isset($settings['companyPhone']) ? $settings['companyPhone'] : '+62 22 1234567';
                $companyEmail = isset($settings['companyEmail']) ? $settings['companyEmail'] : 'support@garmenique.com';
            @endphp
            
            <div class="header-left">
                <div class="company-name">GARMENIQUE</div>
                <div class="company-details">
                    {{ $companyName }}<br>
                    {{ $companyAddress }}<br>
                    {{ $companyRegion }}<br>
                    Phone: {{ $companyPhone }}<br>
                    Email: {{ $companyEmail }}
                </div>
            </div>
            
            <div class="header-right">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-details">
                    <div><strong>Invoice #{{ $order->order_number }}</strong></div>
                    <div>Date: {{ $order->created_at->format('F d, Y') }}</div>
                    <div>Status: {{ ucfirst($order->status) }}</div>
                </div>
            </div>
        </div>
        
        <!-- Billing Details Section -->
        <div class="billing-section clearfix">
            <div class="billing-left">
                <div class="section-title">Billed To:</div>
                <div>
                    {{ $order->shipping_info['firstName'] ?? '' }} {{ $order->shipping_info['lastName'] ?? '' }}<br>
                    {{ $order->shipping_info['address'] ?? '' }}<br>
                    {{ $order->shipping_info['city'] ?? '' }}<br>
                    {{ $order->shipping_info['country'] ?? '' }}
                </div>
                <div style="margin-top: 10px;">
                    Phone: {{ $order->shipping_info['phoneNumber'] ?? '' }}<br>
                    Email: {{ $order->shipping_info['email'] ?? '' }}
                </div>
            </div>
            
            <div class="billing-right">
                <div class="section-title">Shipping Details:</div>
                <div>
                    {{ $order->shipping_info['firstName'] ?? '' }} {{ $order->shipping_info['lastName'] ?? '' }}<br>
                    {{ $order->shipping_info['address'] ?? '' }}<br>
                    {{ $order->shipping_info['city'] ?? '' }}<br>
                    {{ $order->shipping_info['country'] ?? '' }}
                </div>
                <div style="margin-top: 10px;">
                    @php
                        $expedition = $order->shipping_info['expedition'] ?? '';
                        $expeditionName = 'N/A';
                        
                        if ($expedition === 'jne') {
                            $expeditionName = 'JNE';
                        } elseif ($expedition === 'jnt') {
                            $expeditionName = 'J&T Express';
                        } elseif ($expedition === 'sicepat') {
                            $expeditionName = 'SiCepat';
                        } elseif ($expedition === 'pos') {
                            $expeditionName = 'POS Indonesia';
                        } elseif ($expedition === 'tiki') {
                            $expeditionName = 'TIKI';
                        }
                        
                        // Add service if available
                        if (isset($order->shipping_info['service'])) {
                            $expeditionName .= ' - ' . $order->shipping_info['service'];
                        }
                    @endphp
                    Shipping Method: {{ $expeditionName }}
                </div>
            </div>
        </div>
        
        <!-- Payment Status -->
        @php
            $paymentStatusClass = '';
            if (in_array($order->status, ['success', 'confirmed', 'packing', 'shipped', 'delivered', 'completed'])) {
                $paymentStatus = 'PAYMENT COMPLETED';
            } else {
                $paymentStatusClass = 'pending';
                $paymentStatus = 'PAYMENT PENDING';
            }
        @endphp
        <div class="payment-status {{ $paymentStatusClass }}">
            {{ $paymentStatus }}
        </div>
        
        <!-- Order Items -->
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($order->items) && is_array($order->items))
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? $item['name'] ?? 'Product' }}</td>
                        <td>{{ $item->size ?? $item['size'] ?? '-' }}</td>
                        <td>IDR {{ number_format($item->price ?? $item['price'] ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity ?? $item['quantity'] ?? 1 }}</td>
                        <td class="text-right">IDR {{ number_format(($item->price ?? $item['price'] ?? 0) * ($item->quantity ?? $item['quantity'] ?? 1), 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                @elseif(isset($order->cart_items) && is_array($order->cart_items))
                    @foreach($order->cart_items as $item)
                    <tr>
                        <td>{{ $item['name'] ?? 'Product' }}</td>
                        <td>{{ $item['size'] ?? '-' }}</td>
                        <td>IDR {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $item['quantity'] ?? 1 }}</td>
                        <td class="text-right">IDR {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">No items found</td>
                    </tr>
                @endif
            </tbody>
        </table>
        
        <!-- Order Summary -->
        <div class="summary">
            <div class="summary-row">
                <div class="summary-label">Subtotal:</div>
                <div class="summary-value">IDR {{ number_format($order->subtotal ?? ($order->cart_subtotal ?? 0), 0, ',', '.') }}</div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Shipping:</div>
                <div class="summary-value">IDR {{ number_format($order->shipping_cost ?? (isset($order->shipping_info) && isset($order->shipping_info['cost']) ? $order->shipping_info['cost'] : 0), 0, ',', '.') }}</div>
            </div>
            <div class="summary-row total-row">
                <div class="summary-label">Total:</div>
                <div class="summary-value">IDR {{ number_format($order->total ?? ($order->cart_total ?? 0), 0, ',', '.') }}</div>
            </div>
        </div>
        
        <!-- Footer Notes -->
        @php
            // Gunakan settings yang dikirim dari controller
            $footerNote = isset($settings['footerNote']) ? $settings['footerNote'] : 'Thank you for your business! If you have any questions about this invoice, please contact our customer support.';
            $footerDisclaimer = isset($settings['footerDisclaimer']) ? $settings['footerDisclaimer'] : 'This is a computer-generated document and doesn\'t require a signature.';
            $footerCopyright = isset($settings['footerCopyright']) ? $settings['footerCopyright'] : '&copy; ' . date('Y') . ' Garmenique. All rights reserved.';
        @endphp
        
        <div class="footer-note">
            <p>{{ $footerNote }}</p>
            <p>{{ $footerDisclaimer }}</p>
        </div>
        
        <div class="footer">
            {!! $footerCopyright !!}
        </div>
    </div>
</body>
</html> 