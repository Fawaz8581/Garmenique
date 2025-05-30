<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Garmenique - Checkout</title>
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
    
    <!-- Midtrans JS -->
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-61XuGAwQ8Bj8LxSS"></script>
        
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .checkout-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .shipping-method {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 10px;
        }

        .shipping-method:hover {
            border-color: #adb5bd;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .shipping-method.selected {
            border-color: #000;
            background-color: #f8f9fa;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .shipping-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }

        .checkout-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .checkout-header .logo {
            font-size: 24px;
            font-weight: 600;
            text-decoration: none;
            color: #000;
        }

        .checkout-steps {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .step {
            display: flex;
            align-items: center;
            margin: 0 15px;
            color: #6c757d;
        }

        .step.active {
            color: #000;
            font-weight: 500;
        }

        .step-number {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-size: 14px;
        }

        .step.active .step-number {
            background-color: #000;
            color: #fff;
        }

        .checkout-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .checkout-form {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .form-floating {
            margin-bottom: 15px;
        }

        .payment-methods {
            display: grid;
            gap: 15px;
        }

        .payment-method {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method:hover {
            border-color: #000;
        }

        .payment-method.selected {
            border-color: #000;
            background-color: #f8f9fa;
        }

        .order-summary {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 20px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .summary-total {
            font-size: 18px;
            font-weight: 600;
            border-top: 2px solid #dee2e6;
            padding-top: 15px;
            margin-top: 15px;
        }

        .btn-checkout {
            width: 100%;
            padding: 15px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn-checkout:hover {
            background-color: #333;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 4px;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item-title {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .cart-item-price {
            color: #6c757d;
            font-size: 14px;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .address-options {
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
        }

        .address-option {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .address-option:hover {
            border-color: #adb5bd;
        }

        .address-option.selected {
            border-color: #000;
            background-color: #f8f9fa;
        }

        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            margin-top: 15px;
            display: none;
        }

        .pac-container {
            z-index: 1051 !important;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background-color: #e9ecef;
            color: #000;
            text-decoration: none;
        }

        .btn-back.w-100 {
            justify-content: center;
        }

        .mobile-back-to-catalog {
            display: none;
        }

        .payment-loading {
            display: none;
            text-align: center;
            padding: 40px 0;
        }

        @media (max-width: 576px) {
            .checkout-header {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .mobile-back-to-catalog {
                display: block;
            }

            .back-to-catalog {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <!-- Checkout Header -->
        <div class="checkout-header">
            <a href="/" class="logo">GARMENIQUE</a>
            <div class="back-to-catalog">
                <a href="/catalog" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Back to Catalog
                </a>
            </div>
        </div>

        <!-- Checkout Steps -->
        <div class="checkout-steps">
            <div class="step active" id="step-1">
                <div class="step-number">1</div>
                <span>Shipping</span>
            </div>
            <div class="step" id="step-2">
                <div class="step-number">2</div>
                <span>Payment</span>
            </div>
            <div class="step" id="step-3">
                <div class="step-number">3</div>
                <span>Review</span>
            </div>
        </div>

        <!-- Checkout Content -->
        <div class="checkout-content">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <div class="mobile-back-to-catalog mb-3 d-md-none">
                    <a href="/catalog" class="btn-back w-100 text-center">
                        <i class="fas fa-arrow-left me-2"></i> Back to Catalog
                    </a>
                </div>
                <form id="checkoutForm" method="POST" action="{{ route('checkout.process') }}">
                    @csrf
                    <!-- Shipping Information -->
                    <div class="form-section" id="shipping-section">
                        <h2 class="form-section-title">Shipping Information</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="firstName" name="firstName" value="{{ Auth::user()->name ?? '' }}" required>
                                    <label for="firstName">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                                    <label for="lastName">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email ?? '' }}" required>
                            <label for="email">Email Address</label>
                        </div>

                        <!-- Phone Number -->
                        <div class="form-floating mt-3">
                            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required>
                            <label for="phoneNumber">Phone Number</label>
                        </div>

                        <div class="form-floating mt-3">
                            <input type="text" class="form-control" id="address" name="address" required>
                            <label for="address">Address</label>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="city" name="city" required>
                                    <label for="city">City</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="postalCode" name="postalCode" required>
                                    <label for="postalCode">Postal Code</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Shipping Expedition Selection -->
                        <div class="shipping-options mt-4">
                            <h5 class="mb-3">Select Shipping Expedition</h5>
                            
                            <div class="form-group">
                                <div class="shipping-method selected">
                                    <div class="d-flex align-items-center">
                                        <div class="shipping-logo me-3">
                                            <i class="fas fa-truck text-primary" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">JNE</h6>
                                            <small class="text-muted">Regular delivery</small>
                                        </div>
                                        <div class="ms-auto">
                                            <span class="shipping-price">IDR 18.000</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="expedition" value="jne">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-dark" onclick="window.location.href='/catalog'">Cancel</button>
                            <button type="button" class="btn btn-dark" id="continue-btn">Continue to Payment</button>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="form-section" id="payment-section" style="display: none;">
                        <h2 class="form-section-title">Payment Method</h2>
                        
                        <div class="payment-loading" id="payment-loading">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3">Preparing your payment...</p>
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle me-2"></i>
                            You will be redirected to Midtrans secure payment page in a moment.
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-dark" id="back-to-shipping-btn">Back to Shipping</button>
                        </div>
                    </div>
                    
                    <!-- Hidden fields for Midtrans -->
                    <input type="hidden" name="total" id="total-input" value="{{ isset($order) ? $order->total : '618000' }}">
                    <input type="hidden" name="snap_token" id="snap-token" value="{{ isset($order) ? $order->snap_token : '' }}">
                    <input type="hidden" name="order_id" id="order-id" value="{{ isset($order) ? $order->id : '' }}">
                </form>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3 class="form-section-title">Order Summary</h3>
                
                <!-- Cart Items -->
                <div class="cart-items mb-4">
                    @if(isset($order))
                        @foreach($order->cart_items as $item)
                        <div class="cart-item">
                            <img src="{{ $item['image'] ?? asset('images/products/product1.jpg') }}" alt="{{ $item['name'] }}" class="cart-item-image">
                            <div class="cart-item-details">
                                <div class="cart-item-title">{{ $item['name'] }}</div>
                                <div class="cart-item-meta text-muted small mb-1">
                                    Size: {{ $item['size'] }}
                                </div>
                                <div class="cart-item-price">
                                    <span class="quantity">{{ $item['quantity'] }}x</span>
                                    <span class="price">IDR {{ number_format($item['price'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @elseif(isset($cartItems))
                        @foreach($cartItems as $item)
                        <div class="cart-item">
                            <img src="{{ $item['image'] ?? asset('images/products/product1.jpg') }}" alt="{{ $item['name'] }}" class="cart-item-image">
                            <div class="cart-item-details">
                                <div class="cart-item-title">{{ $item['name'] }}</div>
                                <div class="cart-item-meta text-muted small mb-1">
                                    Size: {{ $item['size'] }}
                                </div>
                                <div class="cart-item-price">
                                    <span class="quantity">{{ $item['quantity'] }}x</span>
                                    <span class="price">IDR {{ number_format($item['price'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="cart-item">
                            <img src="{{ asset('images/products/product1.jpg') }}" alt="Product" class="cart-item-image">
                            <div class="cart-item-details">
                                <div class="cart-item-title">Kaos Hitam</div>
                                <div class="cart-item-meta text-muted small mb-1">
                                    Size: XL
                                </div>
                                <div class="cart-item-price">
                                    <span class="quantity">3x</span>
                                    <span class="price">IDR 200.000</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Summary Calculations -->
                <div class="summary-calculations mt-4">
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span>IDR {{ isset($order) ? number_format($order->subtotal, 0, ',', '.') : number_format(600000, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span>IDR {{ isset($order) ? number_format($order->shipping_cost, 0, ',', '.') : number_format(18000, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item summary-total">
                        <span>Total</span>
                        <span>IDR {{ isset($order) ? number_format($order->total, 0, ',', '.') : number_format(618000, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/checkout.js') }}"></script>
</body>
</html>
