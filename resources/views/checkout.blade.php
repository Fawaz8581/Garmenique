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
<body ng-app="garmeniqueApp" ng-controller="CheckoutController">
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
                <div class="mobile-back-to-catalog mb-3 d-md-none">
                    <a href="/catalog" class="btn-back w-100 text-center">
                        <i class="fas fa-arrow-left me-2"></i> Back to Catalog
                    </a>
                </div>
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

                        <!-- Address Selection Options -->
                        <div class="address-options mt-4">
                            <h5 class="mb-3">Select Address Option</h5>
                            
                            <!-- Option 1: Use Saved Address -->
                            <div class="address-option" ng-class="{'selected': addressOption === 'saved'}" 
                                 ng-click="selectAddressOption('saved')">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle me-2"></i>
                                    <div>
                                        <h6 class="mb-0">Use Saved Address</h6>
                                        <small class="text-muted">Use the address from your account settings</small>
                                        
                                        @auth
                                        <div class="saved-address mt-2" ng-show="addressOption === 'saved'">
                                            <p class="mb-1"><strong>{{ Auth::user()->name }}</strong></p>
                                            <p class="mb-0">{{ Auth::user()->address ?? 'No address saved' }}</p>
                                        </div>
                                        @endauth
                                        
                                        @guest
                                        <p class="text-danger mt-2" ng-show="addressOption === 'saved'">
                                            Please <a href="{{ route('login') }}">login</a> to use your saved address
                                        </p>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Option 2: Use Google Maps -->
                            <div class="address-option mt-3" ng-class="{'selected': addressOption === 'google'}" 
                                 ng-click="selectAddressOption('google')">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <div>
                                        <h6 class="mb-0">Use Google Maps</h6>
                                        <small class="text-muted">Search and select your address using Google Maps</small>
                                    </div>
                                </div>
                                
                                <div ng-show="addressOption === 'google'" class="mt-3">
                                    <input id="pac-input" class="form-control" type="text" 
                                           placeholder="Search for your address" ng-model="googleAddress">
                                    <button type="button" class="btn btn-dark mt-2 w-100" id="get-location-btn">
                                        <i class="fas fa-location-arrow me-2"></i> Get Your Address
                                    </button>
                                    <div id="map" class="mt-3"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating">
                            <input type="text" class="form-control" id="address" name="address" 
                                   ng-model="shippingInfo.address" required>
                            <label for="address">Address</label>
                            <div class="invalid-feedback" ng-show="checkoutForm.address.$dirty && checkoutForm.address.$invalid">
                                Address is required
                            </div>
                        </div>
                        <!-- Hidden fields for city and postal code -->
                        <input type="hidden" id="city" name="city" ng-model="shippingInfo.city" value="">
                        <input type="hidden" id="postalCode" name="postalCode" ng-model="shippingInfo.postalCode" value="">
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
    
    <!-- Google Maps JavaScript API -->
    <script>
        // Initialize Google Maps
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -6.2088, lng: 106.8456 }, // Default to Jakarta, Indonesia
                zoom: 13,
                mapTypeControl: false,
            });
            
            // Create the search box and link it to the UI element
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            
            // Bias the SearchBox results towards current map's viewport
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });
            
            let markers = [];
            
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();
                
                if (places.length == 0) {
                    return;
                }
                
                // Clear out the old markers
                markers.forEach((marker) => {
                    marker.setMap(null);
                });
                markers = [];
                
                // For each place, get the icon, name and location
                const bounds = new google.maps.LatLngBounds();
                
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    
                    // Create a marker for each place
                    markers.push(
                        new google.maps.Marker({
                            map,
                            title: place.name,
                            position: place.geometry.location,
                        })
                    );
                    
                    // Get address components and fill form fields
                    let fullAddress = place.formatted_address || '';
                    
                    // Update Angular model
                    const scope = angular.element(document.getElementById('address')).scope();
                    scope.$apply(function() {
                        scope.shippingInfo.address = fullAddress;
                        // Still set city and postal code in hidden fields for backend processing
                        scope.shippingInfo.city = '';
                        scope.shippingInfo.postalCode = '';
                    });
                    
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                
                map.fitBounds(bounds);
            });
            
            // Get location button functionality
            document.getElementById('get-location-btn').addEventListener('click', function() {
                if (navigator.geolocation) {
                    // Show loading state
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Getting your location...';
                    this.disabled = true;
                    
                    // Set a timeout in case geolocation takes too long
                    const timeoutId = setTimeout(() => {
                        document.getElementById('get-location-btn').innerHTML = 
                            '<i class="fas fa-location-arrow me-2"></i> Get Your Address';
                        document.getElementById('get-location-btn').disabled = false;
                        alert("Location request timed out. Please try again or enter your address manually.");
                    }, 15000); // 15 seconds timeout
                    
                    // Request high accuracy location
                    const options = {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    };
                    
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            // Clear the timeout since we got a response
                            clearTimeout(timeoutId);
                            
                            const lat = position.coords.latitude;
                            const lon = position.coords.longitude;
                            
                            // Center map on user's location
                            map.setCenter({ lat, lng: lon });
                            map.setZoom(17);
                            
                            // Clear existing markers
                            markers.forEach(marker => {
                                marker.setMap(null);
                            });
                            markers = [];
                            
                            // Add marker at user's location
                            const marker = new google.maps.Marker({
                                position: { lat, lng: lon },
                                map: map,
                                title: 'Your location'
                            });
                            markers.push(marker);
                            
                            // Show notification
                            const notification = document.createElement('div');
                            notification.style.position = 'fixed';
                            notification.style.bottom = '20px';
                            notification.style.left = '50%';
                            notification.style.transform = 'translateX(-50%)';
                            notification.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                            notification.style.color = 'white';
                            notification.style.padding = '10px 20px';
                            notification.style.borderRadius = '5px';
                            notification.style.zIndex = '9999';
                            notification.textContent = 'Getting your address...';
                            document.body.appendChild(notification);
                            
                            // Use OpenStreetMap Nominatim for reverse geocoding (more accurate than Google Maps API)
                            // Add a timestamp to prevent caching
                            const timestamp = new Date().getTime();
                            const nominatimUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1&_=${timestamp}`;
                            
                            // Add required headers for Nominatim API
                            const headers = new Headers({
                                'Accept': 'application/json',
                                'User-Agent': 'Garmenique Checkout App (https://garmenique.com)'
                            });
                            
                            fetch(nominatimUrl, { headers })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    // Remove notification
                                    if (document.body.contains(notification)) {
                                        document.body.removeChild(notification);
                                    }
                                    
                                    // Reset button state
                                    document.getElementById('get-location-btn').innerHTML = 
                                        '<i class="fas fa-location-arrow me-2"></i> Get Your Address';
                                    document.getElementById('get-location-btn').disabled = false;
                                    
                                    if (data && data.display_name) {
                                        const address = data.display_name;
                                        
                                        // Format address components for better readability if available
                                        let formattedAddress = address;
                                        if (data.address) {
                                            const addr = data.address;
                                            const components = [];
                                            
                                            // Build address from components in a logical order
                                            if (addr.road || addr.street) components.push(addr.road || addr.street);
                                            if (addr.house_number) components.push(addr.house_number);
                                            if (addr.suburb) components.push(addr.suburb);
                                            if (addr.city || addr.town || addr.village) 
                                                components.push(addr.city || addr.town || addr.village);
                                            if (addr.state || addr.province) components.push(addr.state || addr.province);
                                            if (addr.postcode) components.push(addr.postcode);
                                            if (addr.country) components.push(addr.country);
                                            
                                            if (components.length > 0) {
                                                formattedAddress = components.join(', ');
                                            }
                                        }
                                        
                                        // Update search input
                                        document.getElementById('pac-input').value = formattedAddress;
                                        
                                        // Update Angular model
                                        const scope = angular.element(document.getElementById('address')).scope();
                                        scope.$apply(function() {
                                            scope.googleAddress = formattedAddress;
                                            scope.shippingInfo.address = formattedAddress;
                                            // Still set city and postal code in hidden fields for backend processing
                                            scope.shippingInfo.city = data.address?.city || 
                                                                     data.address?.town || 
                                                                     data.address?.village || '';
                                            scope.shippingInfo.postalCode = data.address?.postcode || '';
                                        });
                                        
                                        // Show success notification
                                        const successNotification = document.createElement('div');
                                        successNotification.style.position = 'fixed';
                                        successNotification.style.bottom = '20px';
                                        successNotification.style.left = '50%';
                                        successNotification.style.transform = 'translateX(-50%)';
                                        successNotification.style.backgroundColor = 'rgba(0, 100, 0, 0.8)';
                                        successNotification.style.color = 'white';
                                        successNotification.style.padding = '10px 20px';
                                        successNotification.style.borderRadius = '5px';
                                        successNotification.style.zIndex = '9999';
                                        successNotification.textContent = 'Address found successfully!';
                                        document.body.appendChild(successNotification);
                                        
                                        // Remove success notification after 2 seconds
                                        setTimeout(() => {
                                            if (document.body.contains(successNotification)) {
                                                document.body.removeChild(successNotification);
                                            }
                                        }, 2000);
                                    } else {
                                        // Fallback to Google Maps API if Nominatim fails
                                        fallbackToGoogleGeocoding(lat, lon);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error with Nominatim API:', error);
                                    // Fallback to Google Maps API
                                    fallbackToGoogleGeocoding(lat, lon);
                                });
                        },
                        function(error) {
                            // Clear the timeout since we got a response
                            clearTimeout(timeoutId);
                            
                            // Reset button state
                            document.getElementById('get-location-btn').innerHTML = 
                                '<i class="fas fa-location-arrow me-2"></i> Get Your Address';
                            document.getElementById('get-location-btn').disabled = false;
                            
                            // Handle errors
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    alert("Location access was denied. Please allow access to your location or enter your address manually.");
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    alert("Location information is unavailable. Please enter your address manually.");
                                    break;
                                case error.TIMEOUT:
                                    alert("The request to get your location timed out. Please try again or enter your address manually.");
                                    break;
                                case error.UNKNOWN_ERROR:
                                default:
                                    alert("An error occurred while getting your location. Please try again or enter your address manually.");
                                    break;
                            }
                        },
                        options
                    );
                } else {
                    alert("Geolocation is not supported by this browser. Please enter your address manually.");
                }
            });
            
            // Fallback to Google Maps API if Nominatim fails
            function fallbackToGoogleGeocoding(lat, lon) {
                // Show notification
                const notification = document.createElement('div');
                notification.style.position = 'fixed';
                notification.style.bottom = '20px';
                notification.style.left = '50%';
                notification.style.transform = 'translateX(-50%)';
                notification.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                notification.style.color = 'white';
                notification.style.padding = '10px 20px';
                notification.style.borderRadius = '5px';
                notification.style.zIndex = '9999';
                notification.textContent = 'Trying alternative method to get your address...';
                document.body.appendChild(notification);
                
                const geocodingUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lon}&key=AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao`;
                
                fetch(geocodingUrl)
                    .then(response => response.json())
                    .then(data => {
                        // Remove notification
                        if (document.body.contains(notification)) {
                            document.body.removeChild(notification);
                        }
                        
                        if (data.status === 'OK' && data.results && data.results.length > 0) {
                            const address = data.results[0].formatted_address;
                            
                            // Update search input
                            document.getElementById('pac-input').value = address;
                            
                            // Update Angular model
                            const scope = angular.element(document.getElementById('address')).scope();
                            scope.$apply(function() {
                                scope.googleAddress = address;
                                scope.shippingInfo.address = address;
                                scope.shippingInfo.city = '';
                                scope.shippingInfo.postalCode = '';
                            });
                        } else {
                            handleGeocodeError(new Error('No results from Google API'), { lat, lng: lon });
                        }
                    })
                    .catch(error => {
                        handleGeocodeError(error, { lat, lng: lon });
                    });
            }
            
            // Helper function to handle geocode errors
            function handleGeocodeError(error, latLng) {
                console.error('Error with geocoding API call:', error);
                
                // Remove any existing notifications
                document.querySelectorAll('div[style*="position: fixed"]').forEach(el => {
                    if (document.body.contains(el)) {
                        document.body.removeChild(el);
                    }
                });
                
                // Reset button state
                document.getElementById('get-location-btn').innerHTML = 
                    '<i class="fas fa-location-arrow me-2"></i> Get Your Address';
                document.getElementById('get-location-btn').disabled = false;
                
                // Use coordinates as fallback
                const fallbackAddress = `Latitude: ${latLng.lat.toFixed(6)}, Longitude: ${latLng.lng.toFixed(6)}`;
                
                // Update search input
                document.getElementById('pac-input').value = fallbackAddress;
                
                // Update Angular model
                const scope = angular.element(document.getElementById('address')).scope();
                scope.$apply(function() {
                    scope.googleAddress = fallbackAddress;
                    scope.shippingInfo.address = fallbackAddress;
                    scope.shippingInfo.city = '';
                    scope.shippingInfo.postalCode = '';
                });
                
                // Show fallback message
                const fallbackMessage = document.createElement('div');
                fallbackMessage.style.position = 'fixed';
                fallbackMessage.style.bottom = '20px';
                fallbackMessage.style.left = '50%';
                fallbackMessage.style.transform = 'translateX(-50%)';
                fallbackMessage.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                fallbackMessage.style.color = 'white';
                fallbackMessage.style.padding = '10px 20px';
                fallbackMessage.style.borderRadius = '5px';
                fallbackMessage.style.zIndex = '9999';
                fallbackMessage.style.maxWidth = '80%';
                fallbackMessage.style.textAlign = 'center';
                fallbackMessage.textContent = "We couldn't find your exact address. We've filled in your coordinates instead. You can edit the address field manually.";
                document.body.appendChild(fallbackMessage);
                
                // Remove message after 5 seconds
                setTimeout(() => {
                    if (document.body.contains(fallbackMessage)) {
                        document.body.removeChild(fallbackMessage);
                    }
                }, 5000);
            }
            
            // Show map when Google option is selected
            const scope = angular.element(document.body).scope();
            scope.$watch('addressOption', function(newValue) {
                if (newValue === 'google') {
                    document.getElementById('map').style.display = 'block';
                    // Trigger resize to make sure map renders correctly
                    setTimeout(() => {
                        google.maps.event.trigger(map, 'resize');
                    }, 100);
                } else {
                    document.getElementById('map').style.display = 'none';
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao&libraries=places&callback=initMap" async defer></script>
</body>
</html> 