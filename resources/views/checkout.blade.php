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

        .checkout-header {
            text-align: center;
            margin-bottom: 40px;
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
    </style>
</head>
<body ng-app="garmeniqueApp" ng-controller="CheckoutController">
    <div class="checkout-container">
        <!-- Checkout Header -->
        <div class="checkout-header">
            <a href="/" class="logo">GARMENIQUE</a>
        </div>

        <!-- Checkout Steps -->
        <div class="checkout-steps">
            <div class="step active">
                <div class="step-number">1</div>
                <span>Shipping</span>
            </div>
            <div class="step" ng-class="{'active': currentStep >= 2}">
                <div class="step-number">2</div>
                <span>Payment</span>
            </div>
            <div class="step" ng-class="{'active': currentStep >= 3}">
                <div class="step-number">3</div>
                <span>Review</span>
            </div>
        </div>

        <!-- Checkout Content -->
        <div class="checkout-content">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form name="checkoutForm" ng-submit="submitOrder()" novalidate>
                    <!-- Shipping Information -->
                    <div class="form-section" ng-show="currentStep === 1">
                        <h2 class="form-section-title">Shipping Information</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="firstName" name="firstName" 
                                           ng-model="shippingInfo.firstName" required>
                                    <label for="firstName">First Name</label>
                                    <div class="invalid-feedback" ng-show="checkoutForm.firstName.$dirty && checkoutForm.firstName.$invalid">
                                        First name is required
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="lastName" name="lastName" 
                                           ng-model="shippingInfo.lastName" required>
                                    <label for="lastName">Last Name</label>
                                    <div class="invalid-feedback" ng-show="checkoutForm.lastName.$dirty && checkoutForm.lastName.$invalid">
                                        Last name is required
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email" 
                                   ng-model="shippingInfo.email" required>
                            <label for="email">Email Address</label>
                            <div class="invalid-feedback" ng-show="checkoutForm.email.$dirty && checkoutForm.email.$invalid">
                                Please enter a valid email address
                            </div>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="address" name="address" 
                                   ng-model="shippingInfo.address" required>
                            <label for="address">Street Address</label>
                            <div class="invalid-feedback" ng-show="checkoutForm.address.$dirty && checkoutForm.address.$invalid">
                                Address is required
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="city" name="city" 
                                           ng-model="shippingInfo.city" required>
                                    <label for="city">City</label>
                                    <div class="invalid-feedback" ng-show="checkoutForm.city.$dirty && checkoutForm.city.$invalid">
                                        City is required
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="postalCode" name="postalCode" 
                                           ng-model="shippingInfo.postalCode" required>
                                    <label for="postalCode">Postal Code</label>
                                    <div class="invalid-feedback" ng-show="checkoutForm.postalCode.$dirty && checkoutForm.postalCode.$invalid">
                                        Postal code is required
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="form-section" ng-show="currentStep === 2">
                        <h2 class="form-section-title">Payment Method</h2>
                        <div class="payment-methods">
                            <div class="payment-method" ng-class="{'selected': paymentMethod === 'credit'}" 
                                 ng-click="selectPaymentMethod('credit')">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-credit-card me-2"></i>
                                    <div>
                                        <h6 class="mb-0">Credit Card</h6>
                                        <small class="text-muted">Pay with Visa, Mastercard, or American Express</small>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-method" ng-class="{'selected': paymentMethod === 'paypal'}" 
                                 ng-click="selectPaymentMethod('paypal')">
                                <div class="d-flex align-items-center">
                                    <i class="fab fa-paypal me-2"></i>
                                    <div>
                                        <h6 class="mb-0">PayPal</h6>
                                        <small class="text-muted">Pay with your PayPal account</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Credit Card Form (shown when credit card is selected) -->
                        <div ng-show="paymentMethod === 'credit'" class="mt-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="cardNumber" name="cardNumber" 
                                       ng-model="paymentInfo.cardNumber" required>
                                <label for="cardNumber">Card Number</label>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="expiryDate" name="expiryDate" 
                                               ng-model="paymentInfo.expiryDate" required>
                                        <label for="expiryDate">Expiry Date (MM/YY)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="cvv" name="cvv" 
                                               ng-model="paymentInfo.cvv" required>
                                        <label for="cvv">CVV</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Review -->
                    <div class="form-section" ng-show="currentStep === 3">
                        <h2 class="form-section-title">Review Your Order</h2>
                        <div class="review-section">
                            <h5>Shipping Information</h5>
                            <p>@{{ shippingInfo.firstName }} @{{ shippingInfo.lastName }}</p>
                            <p>@{{ shippingInfo.address }}</p>
                            <p>@{{ shippingInfo.city }}, @{{ shippingInfo.postalCode }}</p>
                            <p>@{{ shippingInfo.email }}</p>
                        </div>
                        <div class="review-section mt-4">
                            <h5>Payment Method</h5>
                            <p ng-if="paymentMethod === 'credit'">
                                Credit Card ending in @{{ paymentInfo.cardNumber.slice(-4) }}
                            </p>
                            <p ng-if="paymentMethod === 'paypal'">PayPal</p>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-dark" 
                                ng-show="currentStep > 1" 
                                ng-click="previousStep()">Previous</button>
                        <button type="button" class="btn btn-dark" 
                                ng-show="currentStep < 3" 
                                ng-click="nextStep()">Continue</button>
                        <button type="submit" class="btn btn-dark" 
                                ng-show="currentStep === 3">Place Order</button>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3 class="form-section-title">Order Summary</h3>
                
                <!-- Cart Items -->
                <div class="cart-items mb-4">
                    <div ng-if="cart.length === 0" class="text-center py-4">
                        <p class="text-muted">Your cart is empty</p>
                        <a href="/catalog" class="btn btn-outline-dark mt-2">Continue Shopping</a>
                    </div>
                    <div class="cart-item" ng-repeat="item in cart">
                        <img ng-src="@{{ item.image }}" alt="@{{ item.name }}" class="cart-item-image">
                        <div class="cart-item-details">
                            <div class="cart-item-title">@{{ item.name }}</div>
                            <div class="cart-item-meta text-muted small mb-1">
                                Size: @{{ item.size }}
                            </div>
                            <div class="cart-item-price">
                                <span class="quantity">@{{ item.quantity }}x</span>
                                <span class="price">IDR @{{ formatIDR(item.price) }}</span>
                                <span class="total ms-2">= IDR @{{ formatIDR(item.price * item.quantity) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Calculations -->
                <div class="summary-calculations mt-4">
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span>IDR @{{ formatIDR(subtotal) }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span>IDR @{{ formatIDR(shipping) }}</span>
                    </div>
                    <div class="summary-item summary-total">
                        <span>Total</span>
                        <span>IDR @{{ formatIDR(total) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/checkout.js') }}"></script>
</body>
</html> 