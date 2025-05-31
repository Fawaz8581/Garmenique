<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 14px;
            line-height: 1.4;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            position: relative;
        }
        
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }
        
        .invoice-logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 10px;
        }
        
        .invoice-company {
            font-size: 12px;
            color: #666;
        }
        
        .invoice-title {
            text-align: right;
            font-size: 28px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }
        
        .invoice-details {
            text-align: right;
            font-size: 12px;
            color: #666;
        }
        
        .invoice-id {
            font-weight: bold;
            color: #000;
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .billing-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .billing-section {
            width: 48%;
        }
        
        .billing-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
            color: #000;
        }
        
        .billing-address {
            font-size: 14px;
            line-height: 1.5;
        }
        
        .billing-info {
            margin-top: 10px;
            font-size: 14px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .table th {
            background: #f8f8f8;
            text-align: left;
            padding: 12px;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: top;
        }
        
        .table tr:last-child td {
            border-bottom: none;
        }
        
        .text-right {
            text-align: right;
        }
        
        .summary {
            float: right;
            width: 300px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .summary-item:last-child {
            border-bottom: 2px solid #000;
            font-weight: bold;
            font-size: 16px;
            padding: 12px 0;
        }
        
        .note {
            margin-top: 40px;
            font-size: 12px;
            color: #666;
            text-align: center;
            clear: both;
            padding-top: 20px;
        }
        
        .payment-status {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            color: #fff;
            background-color: #28a745;
        }
        
        .payment-status.pending {
            background-color: #ffc107;
            color: #212529;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #888;
            font-size: 12px;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div>
                <div style="font-size: 24px; font-weight: bold; margin-bottom: 5px;">GARMENIQUE</div>
                <div class="invoice-company">
                    Garmenique Clothing Co.<br>
                    Jl. Cihapit No. 12, Bandung<br>
                    West Java, Indonesia<br>
                    Phone: +62 22 1234567<br>
                    Email: support@garmenique.com
                </div>
            </div>
            <div>
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-details">
                    <div class="invoice-id">Invoice #{{ $order->order_number }}</div>
                    <div>Date: {{ $order->created_at->format('F d, Y') }}</div>
                    <div>Status: {{ ucfirst($order->status) }}</div>
                </div>
            </div>
        </div>
        
        <!-- Billing Details -->
        <div class="billing-details">
            <div class="billing-section">
                <div class="billing-title">Billed To:</div>
                <div class="billing-address">
                    {{ $order->shipping_info['firstName'] }} {{ $order->shipping_info['lastName'] }}<br>
                    {{ $order->shipping_info['address'] }}<br>
                    {{ $order->shipping_info['province'] ?? 'Unknown Province' }}<br>
                    Indonesia
                </div>
                <div class="billing-info">
                    Phone: {{ $order->shipping_info['phoneNumber'] ?? 'N/A' }}<br>
                    Email: {{ $order->shipping_info['email'] ?? 'N/A' }}
                </div>
            </div>
            <div class="billing-section">
                <div class="billing-title">Shipping Details:</div>
                <div class="billing-address">
                    {{ $order->shipping_info['firstName'] }} {{ $order->shipping_info['lastName'] }}<br>
                    {{ $order->shipping_info['address'] }}<br>
                    {{ $order->shipping_info['province'] ?? 'Unknown Province' }}<br>
                    Indonesia
                </div>
                <div class="billing-info">
                    Shipping Method: 
                    @if(isset($order->shipping_info['expedition']))
                        {{ strtoupper($order->shipping_info['expedition']) }}
                        @if(isset($order->shipping_info['service']))
                            - {{ $order->shipping_info['service'] }}
                        @endif
                    @else
                        Standard Shipping
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Payment Status -->
        @php
            $statusClass = '';
            if (in_array($order->status, ['success', 'confirmed', 'packing', 'shipped', 'delivered', 'completed'])) {
                $statusClass = '';
            } else {
                $statusClass = 'pending';
            }
        @endphp
        
        <div class="payment-status {{ $statusClass }}">
            @if(in_array($order->status, ['success', 'confirmed', 'packing', 'shipped', 'delivered', 'completed']))
                PAYMENT COMPLETED
            @else
                PAYMENT PENDING
            @endif
        </div>
        
        <!-- Order Items -->
        <table class="table">
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
                @foreach($order->cart_items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['size'] }}</td>
                    <td>IDR {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td class="text-right">IDR {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Order Summary -->
        <div class="summary">
            <div class="summary-item">
                <div>Subtotal:</div>
                <div>IDR {{ number_format($order->subtotal, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div>Shipping:</div>
                <div>IDR {{ number_format($order->shipping_cost, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div>Total:</div>
                <div>IDR {{ number_format($order->total, 0, ',', '.') }}</div>
            </div>
        </div>
        
        <!-- Note -->
        <div class="note">
            <p>Thank you for your business! If you have any questions about this invoice, please contact our customer support.</p>
            <p>This is a computer-generated document and doesn't require a signature.</p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Garmenique. All rights reserved.
        </div>
    </div>
</body>
</html> 