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
                <form id="checkoutForm" method="POST" action="{{ route('checkout.process') }}" autocomplete="off">
                    @csrf
                    <!-- Shipping Information -->
                    <div class="form-section" id="shipping-section">
                        <h2 class="form-section-title">Shipping Information</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="firstName" name="firstName" required autocomplete="new-name">
                                    <label for="firstName">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="lastName" name="lastName" required autocomplete="new-lastName">
                                    <label for="lastName">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email" required autocomplete="new-email">
                            <label for="email">Email Address</label>
                        </div>

                        <!-- Phone Number -->
                        <div class="mt-3">
                            <h5 class="mb-2">Phone Number</h5>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="phone_option" id="new_phone" value="new" checked>
                                    <label class="form-check-label" for="new_phone">
                                        Use a new phone number
                                    </label>
                                </div>
                                @if(Auth::check() && Auth::user()->phone_number)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="phone_option" id="saved_phone" value="saved">
                                    <label class="form-check-label" for="saved_phone">
                                        Use saved phone number ({{ Auth::user()->country_code }} {{ Auth::user()->phone_number }})
                                    </label>
                                </div>
                                @endif
                            </div>
                            <div class="form-floating" id="phone_input_container">
                                <div class="row">
                                    <div class="col-4 col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="countryCode" name="countryCode" value="+62" autocomplete="new-country-code">
                                            <label for="countryCode">Code</label>
                                        </div>
                                    </div>
                                    <div class="col-8 col-md-9">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" autocomplete="new-phone">
                                            <label for="phoneNumber">Phone Number</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mt-3">
                            <h5 class="mb-2">Address</h5>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="address_option" id="new_address" value="new" checked>
                                    <label class="form-check-label" for="new_address">
                                        Use a new address
                                    </label>
                                </div>
                                @if(Auth::check() && Auth::user()->address)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="address_option" id="saved_address" value="saved">
                                    <label class="form-check-label" for="saved_address">
                                        Use saved address
                                    </label>
                                </div>
                                @endif
                            </div>
                            <div class="form-floating" id="address_input_container">
                                <input type="text" class="form-control" id="address" name="address" autocomplete="new-address">
                                <label for="address">Address</label>
                            </div>
                        </div>
                        
                        <!-- Shipping Expedition Selection -->
                        <div class="shipping-options mt-4">
                            <h5 class="mb-3">Shipping Options</h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="province" name="province_id">
                                            <option value="">Select Province</option>
                                            <option value="1">Bali</option>
                                            <option value="2">Bangka Belitung</option>
                                            <option value="3">Banten</option>
                                            <option value="4">Bengkulu</option>
                                            <option value="5">DI Yogyakarta</option>
                                            <option value="6">DKI Jakarta</option>
                                            <option value="7">Gorontalo</option>
                                            <option value="8">Jambi</option>
                                            <option value="9">Jawa Barat</option>
                                            <option value="10">Jawa Tengah</option>
                                            <option value="11">Jawa Timur</option>
                                            <option value="12">Kalimantan Barat</option>
                                            <option value="13">Kalimantan Selatan</option>
                                            <option value="14">Kalimantan Tengah</option>
                                            <option value="15">Kalimantan Timur</option>
                                            <option value="16">Kalimantan Utara</option>
                                            <option value="17">Kepulauan Riau</option>
                                            <option value="18">Lampung</option>
                                            <option value="19">Maluku</option>
                                            <option value="20">Maluku Utara</option>
                                            <option value="21">Nanggroe Aceh Darussalam</option>
                                            <option value="22">Nusa Tenggara Barat</option>
                                            <option value="23">Nusa Tenggara Timur</option>
                                            <option value="24">Papua</option>
                                            <option value="25">Papua Barat</option>
                                            <option value="26">Riau</option>
                                            <option value="27">Sulawesi Barat</option>
                                            <option value="28">Sulawesi Selatan</option>
                                            <option value="29">Sulawesi Tengah</option>
                                            <option value="30">Sulawesi Tenggara</option>
                                            <option value="31">Sulawesi Utara</option>
                                            <option value="32">Sumatera Barat</option>
                                            <option value="33">Sumatera Selatan</option>
                                            <option value="34">Sumatera Utara</option>
                                        </select>
                                        <label for="province">Province</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="city" name="city_id">
                                            <option value="">Select City</option>
                                        </select>
                                        <label for="city">City/District</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="courier" name="courier">
                                            <option value="">Select Courier</option>
                                            <option value="jne">JNE</option>
                                            <option value="pos">POS Indonesia</option>
                                            <option value="tiki">TIKI</option>
                                            <option value="sicepat">SiCepat</option>
                                            <option value="jnt">J&T Express</option>
                                        </select>
                                        <label for="courier">Courier</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="weight" name="weight" value="250" min="1" readonly style="background-color: #f8f9fa;">
                                        <label for="weight">Weight (grams)</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" id="origin-city" value="78"> <!-- Bogor, Jawa Barat as origin city -->
                                    <button type="button" class="btn btn-primary w-100 h-100" id="calculate-shipping">Calculate Shipping</button>
                                </div>
                            </div>
                            
                            <!-- Shipping Results will be displayed here -->
                            <div id="shipping-results" class="mt-3"></div>
                            
                            <!-- Hidden input for shipping cost - will be updated by JS -->
                            <input type="hidden" name="expedition" value="jne">
                            <input type="hidden" name="shipping_cost" id="shipping-cost" value="0">
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
                    <input type="hidden" name="total" id="total-input" value="{{ isset($order) ? $order->total : '400000' }}">
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
                    @elseif(isset($cartItems) && count($cartItems) > 0)
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
                        <div class="alert alert-info">
                            <i class="fas fa-shopping-cart me-2"></i> Your cart is empty
                        </div>
                    @endif
                </div>

                <!-- Summary Calculations -->
                <div class="summary-calculations mt-4">
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span id="subtotal-amount">
                            @if(isset($order))
                                IDR {{ number_format($order->subtotal, 0, ',', '.') }}
                            @elseif(isset($cartItems) && count($cartItems) > 0)
                                IDR {{ number_format(array_reduce($cartItems, function($carry, $item) {
                                    return $carry + ($item['price'] * $item['quantity']);
                                }, 0), 0, ',', '.') }}
                            @else
                                IDR 0
                            @endif
                        </span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span id="shipping-amount">IDR 0</span>
                    </div>
                    <div class="summary-item summary-total">
                        <span>Total</span>
                        <span id="total-amount">
                            @if(isset($order))
                                IDR {{ number_format($order->total, 0, ',', '.') }}
                            @elseif(isset($cartItems) && count($cartItems) > 0)
                                IDR {{ number_format(array_reduce($cartItems, function($carry, $item) {
                                    return $carry + ($item['price'] * $item['quantity']);
                                }, 0), 0, ',', '.') }}
                            @else
                                IDR 0
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/checkout.js') }}"></script>
    <script src="{{ asset('js/shipping.js') }}"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Disable autofill for the entire form
        const form = document.getElementById('checkoutForm');
        if (form) {
            form.setAttribute('autocomplete', 'off');
            
            // Also add random attributes to important fields to further prevent autofill
            const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"]');
            inputs.forEach(input => {
                input.setAttribute('autocomplete', 'new-' + Math.random().toString(36).substring(2, 8));
            });
        }
        
        // Get the subtotal from cart items
        function calculateSubtotal() {
            let total = 0;
            
            // Look for cart items in the page
            const cartItems = document.querySelectorAll('.cart-item');
            if (cartItems.length > 0) {
                cartItems.forEach(item => {
                    const quantityText = item.querySelector('.quantity')?.textContent;
                    const priceText = item.querySelector('.price')?.textContent;
                    
                    if (quantityText && priceText) {
                        const quantity = parseInt(quantityText.replace('x', '').trim());
                        // Extract price value from "IDR 200.000" format
                        const price = parseInt(priceText.replace(/[^\d]/g, ''));
                        
                        if (!isNaN(quantity) && !isNaN(price)) {
                            total += quantity * price;
                        }
                    }
                });
            }
            
            return total;
        }
        
        // Calculate and update total based on subtotal and shipping
        function updateTotal() {
            const subtotal = calculateSubtotal();
            const shippingText = document.getElementById('shipping-amount')?.textContent || 'IDR 0';
            const shipping = parseInt(shippingText.replace(/[^\d]/g, ''));
            
            const total = subtotal + shipping;
            
            console.log('Checkout total calculation: subtotal=' + subtotal + ', shipping=' + shipping + ', total=' + total);
            
            // Update total display
            const totalElement = document.getElementById('total-amount');
            if (totalElement) {
                totalElement.textContent = 'IDR ' + new Intl.NumberFormat('id-ID').format(total);
            }
            
            // Update hidden input
            const totalInput = document.getElementById('total-input');
            if (totalInput) {
                totalInput.value = total;
            }
        }
        
        // Check if cart is empty
        const isCartEmpty = document.querySelector('.alert.alert-info') !== null && 
                           document.querySelector('.alert.alert-info').textContent.includes('Your cart is empty');
        
        // Calculate and update subtotal/total on page load
        const subtotal = calculateSubtotal();
        const subtotalElement = document.getElementById('subtotal-amount');
        const totalElement = document.getElementById('total-amount');
        const totalInput = document.getElementById('total-input');
        
        if (isCartEmpty) {
            // Set values to zero if cart is empty
            if (subtotalElement) subtotalElement.textContent = 'IDR 0';
            if (totalElement) totalElement.textContent = 'IDR 0';
            if (totalInput) totalInput.value = 0;
            
            // Disable the continue button
            const continueBtn = document.getElementById('continue-btn');
            if (continueBtn) {
                continueBtn.disabled = true;
                continueBtn.classList.add('disabled');
                continueBtn.title = 'Your cart is empty';
            }
        } else if (subtotalElement && subtotal > 0) {
            // Format the number with thousands separator
            subtotalElement.textContent = 'IDR ' + new Intl.NumberFormat('id-ID').format(subtotal);
            
            // Update total as well (initially equals subtotal before shipping is added)
            if (totalElement) {
                totalElement.textContent = 'IDR ' + new Intl.NumberFormat('id-ID').format(subtotal);
            }
            
            // Update hidden input
            if (totalInput) {
                totalInput.value = subtotal;
            }
            
            // Make sure the total is updated whenever shipping changes
            const shippingAmount = document.getElementById('shipping-amount');
            if (shippingAmount) {
                // Create a mutation observer to watch for changes to the shipping amount
                const observer = new MutationObserver(function(mutations) {
                    updateTotal();
                });
                
                observer.observe(shippingAmount, { childList: true, characterData: true, subtree: true });
            }
        }
        
        // Handle address and phone number options
        // Phone number options
        const newPhoneRadio = document.getElementById('new_phone');
        const savedPhoneRadio = document.getElementById('saved_phone');
        const phoneInput = document.getElementById('phone_input_container');
        
        if (newPhoneRadio && savedPhoneRadio) {
            newPhoneRadio.addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('phoneNumber').value = '';
                    document.getElementById('countryCode').value = '+62';
                }
            });
            
            savedPhoneRadio.addEventListener('change', function() {
                if (this.checked) {
                    @if(Auth::check() && Auth::user()->phone_number)
                    document.getElementById('phoneNumber').value = '{{ Auth::user()->phone_number }}';
                    document.getElementById('countryCode').value = '{{ Auth::user()->country_code ?? "+62" }}';
                    @endif
                }
            });
        }
        
        // Address options
        const newAddressRadio = document.getElementById('new_address');
        const savedAddressRadio = document.getElementById('saved_address');
        const addressInput = document.getElementById('address_input_container');
        
        if (newAddressRadio && savedAddressRadio) {
            newAddressRadio.addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('address').value = '';
                }
            });
            
            savedAddressRadio.addEventListener('change', function() {
                if (this.checked) {
                    @if(Auth::check() && Auth::user()->address)
                    document.getElementById('address').value = '{{ Auth::user()->address }}';
                    @endif
                }
            });
        }
    });
    </script>
</body>
</html>
