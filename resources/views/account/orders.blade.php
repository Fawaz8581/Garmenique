<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Garmenique - Order History</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Premium Clothing Brand">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
    <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Admin icon styling */
        .admin-icon-link {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .admin-nav-icon {
            width: 20px;
            height: 20px;
            object-fit: contain;
            border-radius: 50%;
            border: 2px solid #14387F;
            padding: 2px;
            background-color: white;
        }
        
        /* Hover effect for admin icon */
        .admin-icon-link:hover {
            transform: scale(1.1);
        }

        /* Track Your Order button style */
        .btn-track-order {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background-color: #f8f9fa;
            color: #212529;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        
        .btn-track-order:hover {
            background-color: #e9ecef;
            color: #000;
            text-decoration: none;
        }
    </style>
</head>
<body ng-app="garmeniqueApp">
    <!-- Header Section -->
    <header class="header" ng-controller="HeaderController">
        <div class="container nav-container">
            <div class="logo-container">
                <a href="/" class="logo">GARMENIQUE</a>
            </div>
            
            <nav class="main-nav" ng-class="{'active': isNavActive}">
                <ul>
                    <li><a href="/" class="nav-item">HOME</a></li>
                    <li><a href="/catalog" class="nav-item">CATALOG</a></li>
                    <li><a href="/blog" class="nav-item">BLOG</a></li>
                    <li><a href="/about" class="nav-item">ABOUT</a></li>
                    <li><a href="/contact" class="nav-item">CONTACT</a></li>
                </ul>
            </nav>
            
            @include('partials.nav-icons')
            
            <button class="mobile-toggle" ng-click="toggleNav()">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <!-- Account Settings Section -->
    <section class="account-section" style="margin-top: 80px;">
        <div class="account-container">
            <div class="account-header">
                <h1 style="font-size: 40px; font-weight: 500;">Account Settings</h1>
                <p style="font-size: 16px; color: #6c757d;">Manage your account information and preferences</p>
            </div>
            
            <div class="account-content">
                <div class="account-sidebar">
                    <ul class="account-nav">
                        <li><a href="{{ route('account.settings') }}">Profile Settings</a></li>
                        <li><a href="{{ route('account.password') }}">Password</a></li>
                        <li><a href="{{ route('account.contact') }}">Contact Information</a></li>
                        <li><a href="{{ route('account.orders') }}" class="active">Your Orders</a></li>
                        <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">Logout</a></li>
                    </ul>
                    <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                
                <div class="account-main">
                    <h2>Order History</h2>
                    
                    @if($orders->isEmpty())
                        <div class="text-center py-5">
                            <img src="{{ asset('images/icons/empty-orders.svg') }}" alt="No Orders" class="mb-4" style="width: 120px;">
                            <h5>No orders yet</h5>
                            <p class="text-muted">When you place an order, it will appear here.</p>
                            <a href="{{ url('/catalog') }}" class="btn btn-dark px-4">Start Shopping</a>
                        </div>
                    @else
                        <div class="orders-list">
                            @foreach($orders as $order)
                                <div class="order-item">
                                    <div class="order-header">
                                        <div class="order-info-group">
                                            <div class="order-number">Order #{{ $order->order_number }}</div>
                                            <div class="order-date">Placed on {{ $order->created_at->format('F j, Y') }}</div>
                                        </div>
                                        <div class="status-badge status-{{ strtolower($order->status) }}">
                                            {{ ucfirst($order->status) }}
                                        </div>
                                    </div>

                                    <div class="order-content">
                                        <div class="product-info-section">
                                            @foreach($order->cart_items as $item)
                                            <div class="product-row">
                                                <div class="product-image">
                                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                                </div>
                                                <div class="product-details">
                                                    <div class="product-name">{{ $item['name'] }}</div>
                                                    <div class="product-meta">
                                                        <span>Size: {{ $item['size'] }}</span>
                                                        <span class="separator">|</span>
                                                        <span>Quantity: {{ $item['quantity'] }}</span>
                                                    </div>
                                                    <div class="price">
                                                        <span>IDR {{ number_format($item['price'], 0, ',', '.') }}</span>
                                                        <span class="per-item">per item</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="order-summary-section">
                                            <div class="shipping-info">
                                                <span class="info-title">Shipping Address</span>
                                                <div class="address">
                                                    {{ $order->shipping_info['firstName'] }} {{ $order->shipping_info['lastName'] }}<br>
                                                    {{ $order->shipping_info['address'] }}<br>
                                                    {{ $order->shipping_info['province'] ?? 'Unknown Province' }}
                                                </div>
                                            </div>
                                            
                                            <div class="shipping-info">
                                                <span class="info-title">Shipping Method</span>
                                                <div class="shipping-method">
                                                    @php
                                                        $expeditionName = 'Standard Shipping';
                                                        $expeditionIcon = 'fa-truck';
                                                        $expeditionColor = 'text-secondary';
                                                        
                                                        if(isset($order->shipping_info['expedition'])) {
                                                            switch($order->shipping_info['expedition']) {
                                                                case 'jne':
                                                                    $expeditionName = 'JNE';
                                                                    $expeditionIcon = 'fa-truck';
                                                                    $expeditionColor = 'text-primary';
                                                                    break;
                                                                case 'pos':
                                                                    $expeditionName = 'POS Indonesia';
                                                                    $expeditionIcon = 'fa-envelope';
                                                                    $expeditionColor = 'text-danger';
                                                                    break;
                                                                case 'tiki':
                                                                    $expeditionName = 'TIKI';
                                                                    $expeditionIcon = 'fa-truck-fast';
                                                                    $expeditionColor = 'text-warning';
                                                                    break;
                                                                case 'jnt':
                                                                    $expeditionName = 'J&T Express';
                                                                    $expeditionIcon = 'fa-truck-moving';
                                                                    $expeditionColor = 'text-danger';
                                                                    break;
                                                                case 'sicepat':
                                                                    $expeditionName = 'SiCepat';
                                                                    $expeditionIcon = 'fa-truck-arrow-right';
                                                                    $expeditionColor = 'text-success';
                                                                    break;
                                                            }
                                                        }
                                                        
                                                        // Get service if available
                                                        $service = isset($order->shipping_info['service']) ? $order->shipping_info['service'] : '';
                                                    @endphp
                                                    
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas {{ $expeditionIcon }} {{ $expeditionColor }} me-2"></i>
                                                        <span>{{ $expeditionName }} {{ $service ? "- {$service}" : '' }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="price-summary">
                                                <div class="summary-line">
                                                    <span>Subtotal:</span>
                                                    <span>IDR {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="summary-line">
                                                    <span>Shipping:</span>
                                                    <span>IDR {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="summary-line total">
                                                    <span>Total:</span>
                                                    <span>IDR {{ number_format($order->total, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="order-status">
                                                <span class="info-title">Status</span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="status-badge status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
                                                    
                                                    @if($order->status == 'pending' || $order->status == 'payment_pending')
                                                        <a href="{{ route('payment.retry', $order->id) }}" class="btn-pay-now" data-order-id="{{ $order->id }}">
                                                            <i class="fas fa-money-bill-wave me-2"></i> Pay Now
                                                        </a>
                                                    @elseif($order->status == 'shipped' || $order->status == 'delivered')
                                                        @php
                                                            $trackingUrl = '#';
                                                            $waybill = $order->shipping_info['waybill'] ?? '';
                                                            
                                                            if(isset($order->shipping_info['expedition'])) {
                                                                switch($order->shipping_info['expedition']) {
                                                                    case 'jne':
                                                                        $trackingUrl = 'https://jne.co.id/tracking-package';
                                                                        break;
                                                                    case 'pos':
                                                                        $trackingUrl = 'https://www.posindonesia.co.id/id/tracking';
                                                                        break;
                                                                    case 'tiki':
                                                                        $trackingUrl = 'https://www.tiki.id/id/track';
                                                                        break;
                                                                    case 'sicepat':
                                                                        $trackingUrl = 'https://www.sicepat.com/';
                                                                        break;
                                                                    case 'jnt':
                                                                        $trackingUrl = 'https://jet.co.id/track';
                                                                        break;
                                                                }
                                                            }
                                                        @endphp
                                                        
                                                        <div class="d-flex flex-column gap-2">
                                                            <a href="{{ $trackingUrl }}" target="_blank" class="btn-track-order">
                                                                <i class="fas fa-map-marker-alt me-2"></i> Track Order
                                                            </a>
                                                            
                                                            <a href="{{ route('invoice.download', $order->id) }}" class="btn-download-invoice">
                                                                <i class="fas fa-file-invoice me-2"></i> Invoice
                                                            </a>

                                                            @if ($order->status == 'shipped')
                                                                <form action="{{ route('account.orders.complete', $order->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn-track-order" style="background-color: #007bff; color: white; border-color: #007bff;">Complete Order</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    @elseif(in_array($order->status, ['success', 'confirmed', 'completed']))
                                                        <a href="{{ route('invoice.download', $order->id) }}" class="btn-download-invoice">
                                                            <i class="fas fa-file-invoice me-2"></i> Download Invoice
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @if(!empty($order->notes))
                                            <div class="order-notes">
                                                <span class="info-title">Notes from Seller</span>
                                                <div class="notes-container">
                                                    @php
                                                        // Get only the latest note for the current status
                                                        $currentStatusNotes = collect($order->notes)
                                                            ->filter(function($note) use ($order) {
                                                                return isset($note['admin']) && 
                                                                       $note['admin'] === true && 
                                                                       $note['status'] === $order->status;
                                                            })
                                                            ->sortByDesc('date');
                                                        
                                                        $latestNote = $currentStatusNotes->first();
                                                    @endphp
                                                    
                                                    @if($latestNote)
                                                        <div class="note-item">
                                                            <div class="note-header">
                                                                <span class="note-date">{{ \Carbon\Carbon::parse($latestNote['date'])->format('M d, Y - H:i') }}</span>
                                                                <span class="note-status status-badge status-{{ strtolower($latestNote['status']) }}">{{ ucfirst($latestNote['status']) }}</span>
                                                            </div>
                                                            <div class="note-message">{{ $latestNote['message'] }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="pagination-container">
                            <div class="custom-pagination">
                                @if ($orders->hasPages())
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($orders->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                            @if ($page == $orders->currentPage())
                                                <li class="page-item active" aria-current="page">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($orders->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                            </li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- End account dashboard content -->

    <!-- Include Sliding Cart Partial -->
    @include('partials.sliding-cart')

    <!-- Footer -->
    @include('partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/landingpage.js') }}"></script>

    <!-- Cart Functionality Script -->
    <script>
        // Create the CartController in case it wasn't properly registered
        (function() {
            try {
                var app = angular.module('garmeniqueApp');
                
                // Define CartController only if it doesn't already exist
                if (!app._invokeQueue || !app._invokeQueue.some(function(q) { 
                    return q[1] === 'controller' && q[2][0] === 'CartController'; 
                })) {
                    app.controller('CartController', ['$scope', '$rootScope', '$http', '$window', function($scope, $rootScope, $http, $window) {
                        // Basic cart properties
                        $scope.isCartActive = false;
                        $scope.cartItems = [];
                        $scope.isAuthenticated = true;
                        $scope.isLoading = true;  // Set to true while loading
                        
                        // Load cart from server
                        function loadCartFromSession() {
                            console.log("Loading cart from session");
                            $scope.isLoading = true;
                            
                            $http.get('/get-cart?_=' + new Date().getTime(), {
                                headers: {'Cache-Control': 'no-cache'}
                            })
                            .then(function(response) {
                                console.log('Get cart response:', response.data);
                                if (response.data.cart && Array.isArray(response.data.cart)) {
                                    $scope.cartItems = response.data.cart;
                                }
                                $scope.isLoading = false;
                            })
                            .catch(function(error) {
                                console.error('Error loading cart from session:', error);
                                $scope.isLoading = false;
                            });
                        }
                        
                        // Check auth status and load cart
                        function checkAuth() {
                            $http.get('/check-auth?_=' + new Date().getTime(), {
                                headers: {'Cache-Control': 'no-cache'}
                            })
                            .then(function(response) {
                                console.log('Auth check response:', response.data);
                                $scope.isAuthenticated = response.data.authenticated;
                                
                                if ($scope.isAuthenticated) {
                                    loadCartFromSession();
                                } else {
                                    $scope.isLoading = false;
                                }
                            })
                            .catch(function(error) {
                                console.error('Auth check error:', error);
                                $scope.isLoading = false;
                            });
                        }
                        
                        // Save cart to session
                        $scope.saveCartToSession = function() {
                            console.log("Saving cart to session");
                            
                            if (!$scope.isAuthenticated) {
                                console.log("Not authenticated, can't save cart");
                                return Promise.reject("Not authenticated");
                            }
                            
                            return $http.post('/save-cart', {
                                cart: $scope.cartItems
                            })
                            .then(function(response) {
                                console.log('Cart saved to session:', response.data);
                                return response;
                            })
                            .catch(function(error) {
                                console.error('Error saving cart to session:', error);
                                throw error;
                            });
                        };
                        
                        // Required cart functions
                        $scope.openCart = function() {
                            console.log("Opening cart");
                            $scope.isCartActive = true;
                            document.body.style.overflow = 'hidden';
                        };
                        
                        $scope.closeCart = function() {
                            console.log("Closing cart");
                            $scope.isCartActive = false;
                            document.body.style.overflow = '';
                        };
                        
                        $scope.increaseQuantity = function(item) {
                            item.quantity = (item.quantity || 1) + 1;
                            $scope.saveCartToSession();
                        };
                        
                        $scope.decreaseQuantity = function(item) {
                            if (item.quantity > 1) {
                                item.quantity--;
                            } else {
                                var index = $scope.cartItems.indexOf(item);
                                if (index !== -1) {
                                    $scope.cartItems.splice(index, 1);
                                }
                            }
                            $scope.saveCartToSession();
                        };
                        
                        $scope.calculateSubtotal = function() {
                            var total = 0;
                            $scope.cartItems.forEach(function(item) {
                                var price = item.price;
                                if (item.discount) {
                                    price = price * (1 - item.discount/100);
                                }
                                total += price * item.quantity;
                            });
                            return total;
                        };
                        
                        $scope.getTotalItems = function() {
                            var count = 0;
                            $scope.cartItems.forEach(function(item) {
                                count += item.quantity;
                            });
                            return count;
                        };
                        
                        // Proceed to checkout function
                        $scope.proceedToCheckout = function() {
                            if (!$scope.isAuthenticated) {
                                alert('Please login to checkout');
                                $window.location.href = '/login';
                                return;
                            }
                            
                            $window.location.href = '/checkout';
                        };
                        
                        // Listen for both openCart and openCartPanel events
                        $rootScope.$on('openCart', function() {
                            console.log("Received openCart event");
                            $scope.openCart();
                        });
                        
                        $rootScope.$on('openCartPanel', function() {
                            console.log("Received openCartPanel event");
                            $scope.openCart();
                        });
                        
                        // Initialize by checking auth and loading cart
                        checkAuth();
                    }]);
                }
                
                // Define HeaderController if it doesn't already exist
                if (!app._invokeQueue || !app._invokeQueue.some(function(q) { 
                    return q[1] === 'controller' && q[2][0] === 'HeaderController'; 
                })) {
                    app.controller('HeaderController', ['$scope', '$rootScope', function($scope, $rootScope) {
                        $scope.isNavActive = false;
                        
                        $scope.toggleNav = function() {
                            $scope.isNavActive = !$scope.isNavActive;
                        };
                        
                        // Send both openCart and openCartPanel events for compatibility
                        $scope.openCartPanel = function() {
                            console.log("Broadcasting openCart and openCartPanel events");
                            $rootScope.$broadcast('openCart');
                            $rootScope.$broadcast('openCartPanel');
                        };
                    }]);
                }
            } catch(e) {
                console.error("Error setting up controllers:", e);
            }
        })();
        
        // Add function to manually load cart data if Angular fails
        function loadCartDataManually() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/get-cart?_=' + new Date().getTime(), true);
            xhr.setRequestHeader('Cache-Control', 'no-cache');
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        
                        if (response.cart && Array.isArray(response.cart) && response.cart.length > 0) {
                            var cartItemsContainer = document.querySelector('.cart-items');
                            var emptyCartMessage = document.querySelector('.empty-cart');
                            var cartFooter = document.querySelector('.sliding-cart-footer');
                            
                            if (cartItemsContainer && emptyCartMessage && cartFooter) {
                                // Hide empty cart message and show footer
                                emptyCartMessage.style.display = 'none';
                                cartFooter.style.display = 'block';
                                
                                // Clear existing items
                                cartItemsContainer.innerHTML = '';
                                
                                // Add each item
                                var totalItems = 0;
                                var subtotal = 0;
                                
                                response.cart.forEach(function(item) {
                                    var itemHtml = `
                                        <div class="cart-item">
                <div class="cart-item-image">
                                                <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="cart-item-details">
                                                <h4 class="cart-item-title">${item.name}</h4>
                                                <p class="cart-item-variants">${item.size} · ${item.color}</p>
                                                <div class="cart-item-price">`;
                                    
                                    if (item.discount) {
                                        var discountedPrice = item.price * (1 - item.discount/100);
                                        itemHtml += `
                                            <span class="current-price">IDR ${Math.round(discountedPrice).toLocaleString('id-ID')}</span>
                                            <span class="old-price">IDR ${Math.round(item.price).toLocaleString('id-ID')}</span>
                                            <span class="discount-badge">${item.discount}% Off</span>`;
                                        subtotal += discountedPrice * item.quantity;
                                    } else {
                                        itemHtml += `<span class="current-price">IDR ${Math.round(item.price).toLocaleString('id-ID')}</span>`;
                                        subtotal += item.price * item.quantity;
                                    }
                                    
                                    itemHtml += `
            </div>
        </div>
                                            <div class="cart-item-quantity">
                                                <button class="quantity-btn minus" onclick="handleQuantityAction('decrease', this)">−</button>
                                                <input type="text" value="${item.quantity}" readonly>
                                                <button class="quantity-btn plus" onclick="handleQuantityAction('increase', this)">+</button>
    </div>
                                        </div>`;
                                    
                                    cartItemsContainer.innerHTML += itemHtml;
                                    totalItems += item.quantity;
                                });
                                
                                // Update subtotal
                                var subtotalEl = document.querySelector('.subtotal-price');
                                var itemsCountEl = document.querySelector('.cart-subtotal span:first-child');
                                
                                if (subtotalEl) {
                                    subtotalEl.textContent = 'IDR ' + Math.round(subtotal).toLocaleString('id-ID');
                                }
                                
                                if (itemsCountEl) {
                                    itemsCountEl.textContent = 'Subtotal (' + totalItems + ' items)';
                                }
                                
                                // Set up quantity buttons
                                setupQuantityButtons();
                                setupCheckoutButton();
                            }
                        }
                    } catch (e) {
                        console.error('Error parsing cart data:', e);
                    }
                }
            };
            
            xhr.onerror = function() {
                console.error('Error loading cart data');
            };
            
            xhr.send();
        }
        
        // Ensure cart functionality works even without Angular
        document.addEventListener('DOMContentLoaded', function() {
            // Load cart data manually as a fallback
            loadCartDataManually();
            
            // Open cart panel when clicking the cart icon
            var cartButtons = document.querySelectorAll('[ng-click="openCartPanel()"]');
            cartButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    console.log("Cart button clicked");
                    var cartPanel = document.querySelector('.sliding-cart-panel');
                    var cartOverlay = document.querySelector('.sliding-cart-overlay');
                    
                    if (cartPanel && cartOverlay) {
                        cartPanel.classList.add('active');
                        cartOverlay.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                });
            });
            
            // Close cart panel when clicking the close button or overlay
            var closeBtn = document.querySelector('.sliding-cart-panel .close-btn');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    var cartPanel = document.querySelector('.sliding-cart-panel');
                    var cartOverlay = document.querySelector('.sliding-cart-overlay');
                    
                    if (cartPanel && cartOverlay) {
                        cartPanel.classList.remove('active');
                        cartOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            }
            
            var cartOverlay = document.querySelector('.sliding-cart-overlay');
            if (cartOverlay) {
                cartOverlay.addEventListener('click', function() {
                    var cartPanel = document.querySelector('.sliding-cart-panel');
                    
                    if (cartPanel) {
                        cartPanel.classList.remove('active');
                        this.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            }
            
            // Add DOM-based quantity buttons functionality
            function setupQuantityButtons() {
                var minusButtons = document.querySelectorAll('.quantity-btn.minus');
                var plusButtons = document.querySelectorAll('.quantity-btn.plus');
                
                minusButtons.forEach(function(btn) {
                    // Remove any existing click listeners first
                    btn.removeEventListener('click', decreaseQuantity);
                    // Add a new one
                    btn.addEventListener('click', decreaseQuantity);
                });
                
                plusButtons.forEach(function(btn) {
                    // Remove any existing click listeners first
                    btn.removeEventListener('click', increaseQuantity);
                    // Add a new one
                    btn.addEventListener('click', increaseQuantity);
                });
            }
            
            // Separate functions for event handlers
            function decreaseQuantity() {
                var inputEl = this.parentNode.querySelector('input');
                if (!inputEl) return;
                
                var currentVal = parseInt(inputEl.value) || 1;
                if (currentVal > 1) {
                    inputEl.value = currentVal - 1;
                } else {
                    // Remove item if quantity goes to 0
                    var itemContainer = this.closest('.cart-item');
                    if (itemContainer) {
                        itemContainer.style.opacity = '0.5';
                        setTimeout(function() {
                            itemContainer.remove();
                            
                            // Check if cart is empty
                            var remainingItems = document.querySelectorAll('.cart-item');
                            if (remainingItems.length === 0) {
                                var emptyCart = document.querySelector('.empty-cart');
                                var cartFooter = document.querySelector('.sliding-cart-footer');
                                
                                if (emptyCart) emptyCart.style.display = 'block';
                                if (cartFooter) cartFooter.style.display = 'none';
                            }
                        }, 300);
                    }
                }
                
                // Update subtotal
                updateSubtotal();
                
                // Save changes to server
                saveCartChanges();
            }
            
            function increaseQuantity() {
                var inputEl = this.parentNode.querySelector('input');
                if (!inputEl) return;
                
                var currentVal = parseInt(inputEl.value) || 1;
                inputEl.value = currentVal + 1;
                
                // Update subtotal
                updateSubtotal();
                
                // Save changes to server
                saveCartChanges();
            }
            
            // Function to update subtotal
            function updateSubtotal() {
                var subtotal = 0;
                var totalItems = 0;
                
                document.querySelectorAll('.cart-item').forEach(function(item) {
                    var priceEl = item.querySelector('.current-price');
                    var qtyEl = item.querySelector('input');
                    
                    if (priceEl && qtyEl) {
                        // Extract only the numeric part and handle thousands separator properly
                        var priceText = priceEl.textContent.replace('IDR ', '').trim();
                        var price = parseFloat(priceText.replace(/\./g, '').replace(/,/g, '.'));
                        var qty = parseInt(qtyEl.value) || 1;
                        
                        subtotal += price * qty;
                        totalItems += qty;
                    }
                });
                
                // Update displayed subtotal
                var subtotalEl = document.querySelector('.subtotal-price');
                var itemsCountEl = document.querySelector('.cart-subtotal span:first-child');
                
                if (subtotalEl) {
                    subtotalEl.textContent = 'IDR ' + Math.round(subtotal).toLocaleString('id-ID');
                }
                
                if (itemsCountEl) {
                    itemsCountEl.textContent = 'Subtotal (' + totalItems + ' items)';
                }
            }
            
            // Add checkout button click handler
            function setupCheckoutButton() {
                var checkoutBtn = document.querySelector('.checkout-btn');
                if (checkoutBtn && !checkoutBtn.hasAttribute('data-handler-added')) {
                    checkoutBtn.setAttribute('data-handler-added', 'true');
                    checkoutBtn.addEventListener('click', function() {
                        // Check if user is authenticated
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', '/check-auth?_=' + new Date().getTime(), true);
                        xhr.setRequestHeader('Cache-Control', 'no-cache');
                        
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                try {
                                    var response = JSON.parse(xhr.responseText);
                                    if (response.authenticated) {
                                        window.location.href = '/checkout';
                                    } else {
                                        alert('Please login to checkout');
                                        window.location.href = '/login';
                                    }
                                } catch (e) {
                                    console.error('Error parsing auth response:', e);
                                    // Default to login screen if can't verify
                                    alert('Please login to checkout');
                                    window.location.href = '/login';
                                }
                            } else {
                                // Default to login screen if can't verify
                                alert('Please login to checkout');
                                window.location.href = '/login';
                            }
                        };
                        
                        xhr.onerror = function() {
                            console.error('Error checking auth status');
                            // Default to login screen if error
                            alert('Please login to checkout');
                            window.location.href = '/login';
                        };
                        
                        xhr.send();
                    });
                }
            }
            
            // Function to save cart changes to server
            function saveCartChanges() {
                var cartItems = [];
                
                document.querySelectorAll('.cart-item').forEach(function(item) {
                    var titleEl = item.querySelector('.cart-item-title');
                    var variantsEl = item.querySelector('.cart-item-variants');
                    var priceEl = item.querySelector('.current-price');
                    var discountEl = item.querySelector('.discount-badge');
                    var qtyEl = item.querySelector('input');
                    var imgEl = item.querySelector('img');
                    
                    if (titleEl && variantsEl && priceEl && qtyEl) {
                        var variantsParts = variantsEl.textContent.split('·');
                        // Extract only the numeric part and handle thousands separator properly
                        var priceText = priceEl.textContent.replace('IDR ', '').trim();
                        var price = parseFloat(priceText.replace(/\./g, '').replace(/,/g, '.'));
                        
                        var cartItem = {
                            name: titleEl.textContent.trim(),
                            size: variantsParts[0].trim(),
                            color: variantsParts[1].trim(),
                            price: price,
                            quantity: parseInt(qtyEl.value) || 1
                        };
                        
                        if (imgEl && imgEl.src) {
                            cartItem.image = imgEl.src;
                        }
                        
                        if (discountEl) {
                            cartItem.discount = parseInt(discountEl.textContent) || 0;
                        }
                        
                        cartItems.push(cartItem);
                    }
                });
                
                // Send to server
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/save-cart', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log('Cart saved successfully');
                    } else {
                        console.error('Error saving cart:', xhr.statusText);
                    }
                };
                
                xhr.onerror = function() {
                    console.error('Network error when saving cart');
                };
                
                xhr.send(JSON.stringify({ cart: cartItems }));
            }
            
            // Handle quantity action function (for onclick handlers)
            window.handleQuantityAction = function(action, button) {
                if (action === 'increase') {
                    // Instead of using click(), directly call the appropriate function
                    increaseQuantity.call(button);
                } else if (action === 'decrease') {
                    // Instead of using click(), directly call the appropriate function
                    decreaseQuantity.call(button);
                }
            };
            
            // Monitor DOM changes to handle dynamically added cart items
            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length > 0) {
                        setupQuantityButtons();
                        setupCheckoutButton();
                    }
                });
            });
            
            var cartItems = document.querySelector('.cart-items');
            if (cartItems) {
                observer.observe(cartItems, { childList: true, subtree: true });
            }
            
            // Also observe the entire sliding cart panel for changes
            var slidingCartPanel = document.querySelector('.sliding-cart-panel');
            if (slidingCartPanel) {
                observer.observe(slidingCartPanel, { childList: true, subtree: true });
            } else {
                // If the sliding cart panel doesn't exist yet, observe the body
                // to catch when it gets added to the DOM
                observer.observe(document.body, { childList: true, subtree: false });
                
                // Set up a timeout to check for the sliding cart panel every 500ms
                var checkInterval = setInterval(function() {
                    var panel = document.querySelector('.sliding-cart-panel');
                    if (panel) {
                        clearInterval(checkInterval);
                        observer.observe(panel, { childList: true, subtree: true });
                        setupCheckoutButton();
                    }
                }, 500);
            }
        });
    </script>

    <!-- Status Badge Styles -->
    <style>
        /* Status Badge Base Style */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        
        /* Pay Now Button */
        .btn-pay-now {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        
        .btn-pay-now:hover {
            background-color: #0069d9;
            color: white;
            text-decoration: none;
        }
        
        /* Download Invoice Button */
        .btn-download-invoice {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        
        .btn-download-invoice:hover {
            background-color: #218838;
            color: white;
            text-decoration: none;
        }
        
        /* Status Badge Colors */
        .status-badge.status-pending {
            background-color: #ffc107;
            color: #212529;
        }
        
        .status-badge.status-confirmed {
            background-color: #17a2b8;
            color: white;
        }
        
        .status-badge.status-packing {
            background-color: #6610f2;
            color: white;
        }
        
        .status-badge.status-shipped {
            background-color: #007bff;
            color: white;
        }
        
        .status-badge.status-delivered {
            background-color: #28a745;
            color: white;
        }
        
        .status-badge.status-completed {
            background-color: #20c997;
            color: white;
        }
        
        .status-badge.status-rejected {
            background-color: #dc3545;
            color: white;
        }
        
        /* Note Status Badge - smaller version */
        .note-status {
            font-size: 11px !important;
            padding: 3px 8px !important;
        }
    </style>

    <!-- Midtrans JS for Payment Retry -->
    @foreach($orders as $order)
        @if($order->status === 'pending' || $order->status === 'payment_pending')
            @if(!empty($order->snap_token))
                <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-61XuGAwQ8Bj8LxSS"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Set up click handlers for all Pay Now buttons
                        const payNowBtn{{ $order->id }} = document.querySelector('[data-order-id="{{ $order->id }}"]');
                        
                        if (payNowBtn{{ $order->id }}) {
                            payNowBtn{{ $order->id }}.addEventListener('click', function(e) {
                                e.preventDefault();
                                
                                // Open Midtrans payment popup when button is clicked
                                window.snap.pay('{{ $order->snap_token }}', {
                                    onSuccess: function(result) {
                                        // Update the order status directly without page refresh
                                        updateOrderStatus{{ $order->id }}('success', result);
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
                        function updateOrderStatus{{ $order->id }}(status, result) {
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
                            
                            // Add the form to the document and submit
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                </script>
            @endif
        @endif
    @endforeach
</body>
</html>

<style>
.account-section {
    padding: 20px 0;
}

.account-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.account-header {
    margin-bottom: 30px;
    text-align: center;
}

.account-header h1 {
    margin-bottom: 8px;
}

.account-content {
    display: flex;
    gap: 30px;
    margin-top: 2rem;
}

.account-sidebar {
    width: 250px;
    flex-shrink: 0;
}

.account-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.account-nav li a {
    display: block;
    padding: 15px 20px;
    color: #333;
    text-decoration: none;
    border-left: 3px solid transparent;
    transition: all 0.3s ease;
}

.account-nav li a:hover {
    color: #0d6efd;
}

.account-nav li a.active {
    color: #0d6efd;
    border-left-color: #0d6efd;
    background-color: #f8f9fa;
}

.account-main {
    flex: 1;
    background: #fff;
    border-radius: 10px;
    padding: 30px;
}

.account-main h2 {
    margin-bottom: 25px;
    font-size: 24px;
}

.order-item-image {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.order-item-row {
    transition: all 0.3s ease;
}

.order-item-row:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.btn-dark {
    padding: 0.75rem 2rem;
    font-weight: 500;
    border-radius: 5px;
}

.btn-dark:hover {
    background-color: #343a40;
}

@media (max-width: 768px) {
    .account-content {
        flex-direction: column;
    }
    
    .account-sidebar {
        width: 100%;
        margin-bottom: 2rem;
    }
}

.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}

.status-pending {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
}

.status-rejected {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.status-confirmed {
    background-color: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

.status-packing {
    background-color: #d6d8db;
    color: #383d41;
    border: 1px solid #c6c8ca;
}

.status-shipped {
    background-color: #cce5ff;
    color: #004085;
    border: 1px solid #b8daff;
}

.status-delivered {
    background-color: #e2efda;
    color: #285b2a;
    border: 1px solid #c6e7c6;
}

.status-completed {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-processing {
    background-color: #cce5ff;
    color: #004085;
    border: 1px solid #b8daff;
}

.order-item {
    transition: all 0.3s ease;
}

.order-item:hover {
    transform: translateY(-2px);
}

.order-item-row {
    border: 1px solid #eee;
    transition: all 0.2s ease;
}

.order-item-row:hover {
    border-color: #dee2e6;
    background-color: #f8f9fa;
}

.order-summary h6 {
    color: #495057;
}

.rounded-3 {
    border-radius: 8px !important;
}

.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
}

.g-4 {
    gap: 1.5rem !important;
}

.fw-semibold {
    font-weight: 600 !important;
}

.card-header {
    border-bottom: 1px solid #dee2e6;
}

.text-muted {
    color: #6c757d !important;
}

.order-item {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    max-width: 100%;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.order-number {
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 4px;
}

.order-date {
    color: #666;
    font-size: 14px;
}

.order-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
}

.product-row {
    display: flex;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 15px;
}

.product-image {
    width: 80px;
    height: 80px;
    flex-shrink: 0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
}

.product-details {
    flex: 1;
    min-width: 0;
}

.product-name {
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 6px;
    color: #333;
}

.product-meta {
    font-size: 14px;
    color: #666;
    margin-bottom: 6px;
}

.product-meta .separator {
    margin: 0 6px;
    color: #ccc;
}

.price {
    font-size: 14px;
    color: #333;
    font-weight: 500;
}

.per-item {
    font-size: 13px;
    color: #666;
    margin-left: 4px;
}

.order-summary-section {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.shipping-info {
    margin-bottom: 15px;
}

.shipping-method {
    font-size: 14px;
    color: #666;
    line-height: 1.5;
    display: flex;
    align-items: center;
}

.shipping-method i {
    margin-right: 8px;
    font-size: 16px;
}

.info-title {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #333;
    margin-bottom: 8px;
}

.address {
    font-size: 14px;
    color: #666;
    line-height: 1.5;
}

.price-summary {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.summary-line {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #666;
}

.summary-line.total {
    padding-top: 8px;
    margin-top: 4px;
    border-top: 1px solid #eee;
    font-weight: 500;
    color: #333;
}

@media (max-width: 768px) {
    .order-content {
        grid-template-columns: 1fr;
    }
}

/* Cart Sidebar Styles */
.cart-sidebar {
    position: fixed;
    top: 0;
    right: -400px;
    width: 400px;
    height: 100vh;
    background: #fff;
    box-shadow: -2px 0 5px rgba(0,0,0,0.1);
    z-index: 1000;
    transition: right 0.3s ease;
    display: flex;
    flex-direction: column;
}

.cart-sidebar.active {
    right: 0;
}

.cart-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 999;
    display: none;
}

.cart-overlay.active {
    display: block;
}

.cart-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.cart-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 500;
}

.close-cart {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #666;
}

.cart-items {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
}

.cart-item {
    display: flex;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
    position: relative;
}

.cart-item-image {
    width: 80px;
    height: 80px;
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
}

.cart-item-details {
    flex: 1;
}

.cart-item-details h4 {
    margin: 0 0 5px;
    font-size: 16px;
    font-weight: 500;
}

.cart-item-details p {
    margin: 0;
    color: #666;
    font-size: 14px;
}

.cart-item-price {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-controls button {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    width: 24px;
    height: 24px;
    border-radius: 4px;
    cursor: pointer;
}

.remove-item {
    position: absolute;
    top: 15px;
    right: 0;
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
}

.empty-cart {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    text-align: center;
}

.empty-cart i {
    font-size: 48px;
    color: #dee2e6;
    margin-bottom: 20px;
}

.cart-footer {
    padding: 20px;
    border-top: 1px solid #eee;
    background: #fff;
}

.cart-total {
    display: flex;
    justify-content: space-between;
    font-weight: 500;
    margin-bottom: 15px;
}

.checkout-btn {
    width: 100%;
    padding: 12px;
    text-align: center;
    background: #0d6efd;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: block;
}

.checkout-btn:hover {
    background: #0b5ed7;
}

@media (max-width: 480px) {
    .cart-sidebar {
        width: 100%;
        right: -100%;
    }
}
</style> 