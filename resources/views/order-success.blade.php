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
            padding: 10px 15px;
            background-color: #E8F5E9;
            color: #4CAF50;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 15px;
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
        }
        
        .btn-download-invoice {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-download-invoice:hover {
            background-color: #218838;
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
        
        {{-- Removed success/error messages to improve UX --}}
        
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
                <div class="payment-actions mt-4">
                    <button class="btn btn-primary btn-pay-now">
                        <i class="fas fa-credit-card me-2"></i> Pay Now
                    </button>
                    <button class="btn btn-secondary btn-check-status ms-2">
                        <i class="fas fa-sync-alt me-2"></i> Check Status
                    </button>
                </div>
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
                
                @if(in_array($order->status, ['success', 'confirmed', 'shipped', 'delivered', 'completed']))
                    <a href="{{ route('invoice.download', $order->id) }}" class="btn-download-invoice">
                        <i class="fas fa-file-invoice me-2"></i> Download Invoice
                    </a>
                @endif
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
    
    @if(isset($order))
    <script>
        // Handle case where Midtrans might redirect with order_id parameter that's the order_number
        document.addEventListener('DOMContentLoaded', function() {
            // Get URL params to check if we have the transaction_status
            const urlParams = new URLSearchParams(window.location.search);
            const transactionStatus = urlParams.get('transaction_status');
            
            // If this is a redirect from Midtrans, we need to update the page
            if (transactionStatus) {
                console.log('Detected return from Midtrans with status:', transactionStatus);
                
                // Refresh the page without the Midtrans query parameters to avoid issues on reload
                if (window.history.replaceState) {
                    const cleanUrl = window.location.href.split('?')[0] + '?order_id={{ $order->order_number }}';
                    window.history.replaceState({}, document.title, cleanUrl);
                }
            }
        });
    </script>
    @endif
    
    @if(isset($order) && ($order->status === 'pending' || $order->status === 'payment_pending') && !empty($order->snap_token))
    <!-- Midtrans JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-61XuGAwQ8Bj8LxSS"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set up the button click handler
            const payNowBtn = document.querySelector('.btn-pay-now');
            if (payNowBtn) {
                payNowBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Open Midtrans payment popup when button is clicked
                    window.snap.pay('{{ $order->snap_token }}', {
                        onSuccess: function(result) {
                            // Update the order status directly without page refresh and redirect
                            updateOrderStatus('success', result);
                        },
                        onPending: function(result) {
                            // Redirect to order success page with pending status
                            updateOrderStatus('pending', result);
                        },
                        onError: function(result) {
                            // Redirect to order success page with error status
                            updateOrderStatus('failed', result);
                        },
                        onClose: function() {
                            // When user clicks X, redirect to order success page with pending status
                            window.location.href = '{{ route("order.success", ["order_id" => $order->id, "status" => "pending"]) }}';
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
            
            // Set up the check status button click handler with cooldown
            const checkStatusBtn = document.querySelector('.btn-check-status');
            if (checkStatusBtn) {
                // Track last check time to prevent spam
                let lastCheckTime = 0;
                const COOLDOWN_MS = 15000; // 15 seconds cooldown
                let checkCount = 0;
                const MAX_CHECKS = 3; // Maximum number of checks allowed
                let isCheckingStatus = false; // Flag to prevent multiple simultaneous requests
                
                checkStatusBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Prevent multiple simultaneous requests
                    if (isCheckingStatus) {
                        alert('Status check already in progress. Please wait...');
                        return;
                    }
                    
                    const now = Date.now();
                    
                    // Prevent spam clicks with longer cooldown
                    if (now - lastCheckTime < COOLDOWN_MS) {
                        alert('Please wait before checking again. The payment gateway needs time to process your payment.');
                        return;
                    }
                    
                    // Limit number of checks to prevent abuse
                    checkCount++;
                    if (checkCount > MAX_CHECKS) {
                        alert('You have reached the maximum number of status checks. Please wait a few minutes before trying again.');
                        checkStatusBtn.disabled = true;
                        setTimeout(() => {
                            checkCount = 0;
                            checkStatusBtn.disabled = false;
                        }, 120000); // Reset after 2 minutes
                        return;
                    }
                    
                    lastCheckTime = now;
                    isCheckingStatus = true;
                    
                    // Show loading indicator
                    checkStatusBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Checking...';
                    checkStatusBtn.disabled = true;
                    
                    // Make AJAX request to check status from Midtrans
                    fetch('/api/midtrans/check-status/{{ $order->order_number }}', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        // Add cache control to prevent browser caching
                        cache: 'no-store'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Status check response:', data);
                        isCheckingStatus = false;
                        
                        if (data.success) {
                            // Handle expired payments
                            if (data.order_status === 'expired' || data.transaction_status === 'expire') {
                                alert('This payment has expired. The order will be removed from your orders list.');
                                window.location.reload();
                                return;
                            }
                            
                            // If order status is already updated to success, refresh the page
                            if (data.order_status === 'success' || data.order_status === 'completed') {
                                window.location.reload();
                                return;
                            }
                            
                            // If payment is successful with valid transaction_id, update status
                            if ((data.transaction_status === 'settlement' || 
                                data.transaction_status === 'capture') && 
                                data.transaction_id) {
                                
                                alert('Payment confirmed! The page will refresh to show your updated order status.');
                                window.location.reload();
                            } 
                            // If payment is still pending, show message
                            else if (data.transaction_status === 'pending') {
                                alert('Payment is still pending. Please complete your payment.');
                                checkStatusBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i> Check Status';
                                checkStatusBtn.disabled = false;
                            }
                            // If payment failed, show message
                            else {
                                alert('Payment status: ' + data.transaction_status + '. Please try again or contact support.');
                                checkStatusBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i> Check Status';
                                checkStatusBtn.disabled = false;
                            }
                        } else {
                            // Show error message
                            alert('Error checking payment status: ' + (data.message || 'Unknown error'));
                            checkStatusBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i> Check Status';
                            checkStatusBtn.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error checking status:', error);
                        alert('Error checking payment status. Please try again.');
                        checkStatusBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i> Check Status';
                        checkStatusBtn.disabled = false;
                        isCheckingStatus = false;
                    })
                    .finally(() => {
                        // Re-enable button after COOLDOWN_MS regardless of result
                        setTimeout(() => {
                            if (checkStatusBtn.disabled) {
                                checkStatusBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i> Check Status';
                                checkStatusBtn.disabled = false;
                            }
                            // Make sure the flag is reset
                            isCheckingStatus = false;
                        }, COOLDOWN_MS);
                    });
                });
            }
        });
    </script>
    @endif
</body>
</html> 