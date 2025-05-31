<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Garmenique - Order Success</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Premium Clothing Brand">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .success-container {
            max-width: 800px;
            margin: 80px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 600;
            text-decoration: none;
            color: #000;
        }

        .order-status {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
        }
        
        .status-pending {
            background-color: #FFF8E1;
            color: #FF9800;
        }

        .status-success {
            background-color: #E8F5E9;
            color: #4CAF50;
        }
        
        .status-failed {
            background-color: #FFEBEE;
            color: #F44336;
        }
        
        .order-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .order-number {
            color: #6c757d;
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .order-info {
            margin-bottom: 30px;
        }
        
        .info-item {
            display: flex;
            margin-bottom: 10px;
        }
        
        .info-label {
            width: 150px;
            font-weight: 500;
        }
        
        .info-value {
            flex-grow: 1;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 5px;
        }
        
        .cart-item-details {
            flex-grow: 1;
        }
        
        .cart-item-title {
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        .cart-item-meta {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .cart-item-price {
            text-align: right;
            font-weight: 500;
        }
        
        .order-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .summary-total {
            font-size: 18px;
            font-weight: 600;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
        }
        
        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        
        .btn-back {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background-color: #000;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #333;
            color: #fff;
        }

        .btn-outline {
            background-color: transparent;
            color: #000;
            border: 1px solid #dee2e6;
        }
        
        .btn-outline:hover {
            background-color: #f8f9fa;
            color: #000;
        }
        
        .pending-instructions {
            margin-top: 30px;
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 8px;
            background-color: #e3f2fd;
            border-left: 5px solid #007bff;
        }
        
        .pending-instructions h4 {
            color: #0056b3;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .pending-instructions p {
            margin-bottom: 10px;
        }
        
        .refresh-status {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background-color: #E8F5E9;
            color: #4CAF50;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .refresh-status:hover {
            background-color: #4CAF50;
            color: #fff;
        }
        
        .btn-pay-now {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-pay-now:hover {
            background-color: #0069d9;
            color: #fff;
            text-decoration: none;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #C8E6C9;
        }
        
        .alert-info {
            background-color: #E3F2FD;
            color: #1565C0;
            border: 1px solid #BBDEFB;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="header">
            <a href="/" class="logo">GARMENIQUE</a>
            
            @if(isset($order))
                @php
                    $statusClass = '';
                    $statusText = 'Unknown';
                    
                    if ($order->status === 'pending' || $order->status === 'payment_pending') {
                        $statusClass = 'status-pending';
                        $statusText = 'Payment Pending';
                    } elseif ($order->status === 'success' || $order->status === 'completed') {
                        $statusClass = 'status-success';
                        $statusText = 'Payment Success';
                    } elseif ($order->status === 'failed' || $order->status === 'expired') {
                        $statusClass = 'status-failed';
                        $statusText = 'Payment Failed';
                    }
                @endphp
                
                <span class="order-status {{ $statusClass }}">{{ $statusText }}</span>
            @endif
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        @if(isset($order))
            <h1 class="order-title">
                @if($order->status === 'pending' || $order->status === 'payment_pending')
                    Payment Pending
                @elseif($order->status === 'success' || $order->status === 'completed')
                    Thank You for Your Order!
                @else
                    Order Status: {{ ucfirst($order->status) }}
                @endif
            </h1>
            <p class="order-number">Order #{{ $order->order_number }}</p>
            
            @if($order->status === 'pending' || $order->status === 'payment_pending')
                <div class="pending-instructions">
                    <h4><i class="fas fa-credit-card me-2"></i> Payment Required</h4>
                    <p>Your payment is still pending. Please complete your payment to process your order.</p>
                    
                    <a href="{{ route('payment.retry', $order->id) }}" class="btn-pay-now">
                        <i class="fas fa-money-bill-wave me-2"></i> Pay Now
                    </a>
                </div>
            @endif
            
            <div class="order-info">
                <h3 class="section-title">Order Information</h3>
                
                <div class="info-item">
                    <div class="info-label">Order Date:</div>
                    <div class="info-value">{{ $order->created_at->format('F d, Y, h:i A') }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Payment Method:</div>
                    <div class="info-value">
                        @if(isset($order->payment_info['payment_type']))
                            {{ ucfirst($order->payment_info['payment_type']) }}
                        @else
                            Midtrans
                        @endif
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Shipping Address:</div>
                    <div class="info-value">
                        {{ $order->shipping_info['firstName'] }} {{ $order->shipping_info['lastName'] }}<br>
                        {{ $order->shipping_info['address'] }}<br>
                        {{ $order->shipping_info['province'] ?? 'Unknown Province' }}<br>
                        Phone: {{ $order->shipping_info['phoneNumber'] }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Shipping Method:</div>
                    <div class="info-value">
                        @if(isset($order->shipping_info['expedition']))
                            {{ strtoupper($order->shipping_info['expedition']) }}
                            @if(isset($order->shipping_info['service']))
                                - {{ $order->shipping_info['service'] }}
                            @else
                                - Regular
                            @endif
                        @else
                            Standard Shipping
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="order-items">
                <h3 class="section-title">Order Items</h3>
                
                @foreach($order->cart_items as $item)
                    <div class="cart-item">
                        <img src="{{ $item['image'] ?? asset('images/products/product1.jpg') }}" alt="{{ $item['name'] }}" class="cart-item-image">
                        <div class="cart-item-details">
                            <div class="cart-item-title">{{ $item['name'] }}</div>
                            <div class="cart-item-meta">
                                Size: {{ $item['size'] }}
                            </div>
                            <div class="cart-item-meta">
                                Quantity: {{ $item['quantity'] }}
                            </div>
                        </div>
                        <div class="cart-item-price">
                            IDR {{ number_format($item['price'], 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
                
                <div class="order-summary">
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span>IDR {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span>IDR {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item summary-total">
                        <span>Total</span>
                        <span>IDR {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="actions">
                <a href="/catalog" class="btn-back btn-outline">
                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                </a>
                
                <a href="/account/orders" class="btn-back btn-primary">
                    View My Orders <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> No order information found. Please check your order history in your account.
            </div>
            
            <div class="actions">
                <a href="/catalog" class="btn-back btn-outline">
                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                </a>
                
                <a href="/account/orders" class="btn-back btn-primary">
                    View My Orders <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @if(isset($order) && ($order->status === 'pending' || $order->status === 'payment_pending') && !empty($order->snap_token))
    <!-- Midtrans JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-61XuGAwQ8Bj8LxSS"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Only set up the button click handler, don't automatically open payment popup
            const payNowBtn = document.querySelector('.btn-pay-now');
            if (payNowBtn) {
                payNowBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Open Midtrans payment popup only when button is clicked
                    window.snap.pay('{{ $order->snap_token }}', {
                        onSuccess: function(result) {
                            // Update the order status directly without page refresh
                            updateOrderStatus('success', result);
                        },
                        onPending: function(result) {
                            console.log('Payment is still pending');
                        },
                        onError: function(result) {
                            alert('Payment failed. Please try again.');
                        },
                        onClose: function() {
                            console.log('Payment popup closed without completing payment');
                        }
                    });
                });
            }
            
            // Function to update order status via AJAX
            function updateOrderStatus(status, result) {
                // Create a form and submit it to avoid CSRF issues
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("manual.update.status", $order->id) }}';
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add method field to handle PUT request
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PUT';
                form.appendChild(methodField);
                
                // Add status field
                const statusField = document.createElement('input');
                statusField.type = 'hidden';
                statusField.name = 'status';
                statusField.value = status;
                form.appendChild(statusField);
                
                // Append form to body and submit
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
    @endif
</body>
</html> 