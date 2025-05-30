<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="garmeniqueApp" ng-cloak>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Garmenique - About Us</title>
        <meta name="keyword" content="Garmenique">
        <meta name="description" content="Garmenique - Premium Clothing Brand">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
        <link rel="stylesheet" href="{{ asset('css/about.search.css') }}">
        <link rel="stylesheet" href="{{ asset('css/about.css') }}">
        <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <style>
            /* Angular JS cloak - hide angular bindings until loaded */
            [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
                display: none !important;
            }
            
            body {
                font-family: 'Inter', sans-serif;
                color: #333;
                background-color: #fff;
                margin: 0;
                padding: 0;
            }
            
            /* Header styles to match image */
            .header {
                background-color: white;
                border-bottom: 1px solid #e5e5e5;
                padding: 15px 0;
                position: relative;
            }
            
            .nav-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 40px;
            }
            
            .logo-container {
                flex: 1;
                max-width: 200px;
                position: relative;
                z-index: 101;
                text-align: left;
            }
            
            .logo {
                font-weight: 600;
                font-size: 1.5rem;
                letter-spacing: 1px;
                text-transform: uppercase;
                color: #000;
                text-decoration: none;
            }
            
            .main-nav {
                display: flex;
                justify-content: center;
                flex: 2;
            }
            
            .main-nav ul {
                display: flex;
                list-style: none;
                margin: 0;
                padding: 0;
                justify-content: center;
            }
            
            .main-nav li {
                margin: 0 15px;
                text-align: center;
            }
            
            .nav-item {
                font-size: 0.9rem;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                font-weight: 500;
                color: #333;
                text-decoration: none;
                position: relative;
                padding: 0 5px;
            }
            
            .nav-item:hover, .nav-item.active {
                color: #000;
            }
            
            .nav-item::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 0;
                width: 0;
                height: 2px;
                background-color: #000;
                transition: width 0.2s ease;
            }
            
            .nav-item:hover::after,
            .nav-item.active::after {
                width: 100%;
            }
            
            .nav-icons {
                flex: 1;
                max-width: 120px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .nav-icon {
                font-size: 1rem;
                color: #333;
                text-decoration: none;
                transition: color 0.3s ease;
            }
            
            .nav-icon:hover {
                color: #000;
            }
            
            /* Cart icon specific styling */
            .cart-icon {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* Mobile toggle button styling */
            .mobile-menu-btn {
                display: none;
            }
            
            @media (max-width: 991px) {
                .mobile-menu-btn {
                    display: block;
                }
            }
            
            .mobile-toggle {
                display: block;
                background: transparent;
                border: none;
                cursor: pointer;
                padding: 0;
                z-index: 102;
                position: relative;
                width: 30px;
                height: 24px;
            }
            
            .toggle-bar {
                display: block;
                width: 100%;
                height: 2px;
                background-color: #333;
                margin: 5px 0;
                transition: all 0.3s ease;
            }
            
            @media (max-width: 991px) {
                .mobile-toggle {
                    display: block;
                }
                
                .main-nav {
                    position: fixed;
                    top: 60px;
                    left: -100%;
                    width: 100%;
                    height: calc(100vh - 60px);
                    background-color: white;
                    flex-direction: column;
                    padding: 20px;
                    transition: left 0.3s;
                    z-index: 100;
                }
                
                .main-nav.active {
                    left: 0;
                }
                
                .main-nav ul {
                    flex-direction: column;
                    width: 100%;
                }
                
                .main-nav li {
                    margin: 10px 0;
                    text-align: center;
                }
            }
            
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

            /* Blog-specific styles */
            /* Values Section Styling */
            .blog-values {
                background-color: #f8f9fa;
                padding: 60px 0;
                margin: 40px 0;
            }

            .values-container {
                display: flex;
                justify-content: space-around;
                align-items: center;
                max-width: 900px;
                margin: 0 auto;
            }

            .value-item {
                text-align: center;
                padding: 0 20px;
                transition: transform 0.3s ease;
            }

            .value-item:hover {
                transform: translateY(-5px);
            }

            .value-icon {
                width: 80px;
                height: 80px;
                margin: 0 auto 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #fff;
                border-radius: 50%;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            }

            .value-icon i {
                color: #14387F !important;
            }

            .value-item h3 {
                font-size: 1.1rem;
                font-weight: 600;
                margin-top: 15px;
            }

            @media (max-width: 768px) {
                .values-container {
                    flex-direction: column;
                    gap: 30px;
                }
            }
        </style>
    </head>
    <body ng-controller="AboutController">
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
                        <li><a href="/about" class="nav-item active">ABOUT</a></li>
                        <li><a href="/contact" class="nav-item">CONTACT</a></li>
                    </ul>
                </nav>
                
                <div class="nav-icons">
                    <a href="{{ route('user.messages') }}" class="nav-icon"><i class="fas fa-envelope"></i></a>
                    @include('partials.account-dropdown')
                    <a href="javascript:void(0)" class="nav-icon" ng-click="openCartPanel()">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
                
                <div class="mobile-menu-btn">
                    <button type="button" class="mobile-toggle" ng-click="toggleNav()">
                        <span class="toggle-bar"></span>
                        <span class="toggle-bar"></span>
                        <span class="toggle-bar"></span>
                </button>
                </div>
            </div>
        </header>
        
        <!-- Search Overlay -->
        <div class="search-overlay" ng-class="{'active': isSearchActive}"></div>

        <!-- Search Panel (Hidden by default) -->
        <div class="search-panel" ng-controller="SearchController" ng-class="{'active': isSearchActive}">
            <div class="container">
                <!-- Search Bar -->
                <div class="search-container">
                    <div class="d-flex align-items-center">
                        <input type="text" class="search-input" placeholder="Search" ng-model="searchQuery" autofocus>
                        <a href="javascript:void(0)" class="cancel-btn" ng-click="closeSearch()">Cancel</a>
                    </div>
                </div>

                <div class="search-content">
                    <!-- Categories Navigation as Bullets -->
                    <div class="categories-list">
                        <ul>
                            <li><a href="/catalog">BEST SELLERS</a></li>
                            <li><a href="/catalog">CLOTHING</a></li>
                            <li><a href="/catalog">TOPS & SWEATERS</a></li>
                            <li><a href="/catalog">PANTS & JEANS</a></li>
                            <li><a href="/catalog">OUTERWEAR</a></li>
                            <li><a href="/catalog">SHOES & BAGS</a></li>
                            <li><a href="/catalog">SALE</a></li>
                        </ul>
                    </div>

                    <!-- Popular Categories -->
                    <section class="popular-categories">
                        <h2>Popular Categories</h2>
                        <div class="row">
                            <div class="col-6 col-md-3" ng-repeat="category in popularCategories">
                                <div class="category-card" ng-mouseenter="hover(category)" ng-mouseleave="unhover(category)" ng-class="{'hovered': category.isHovered}">
                                    <img ng-src="@{{ category.image }}" alt="@{{ category.name }}" class="card-img-top">
                                    <h5 class="category-card-title">@{{ category.name }}</h5>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        
        <!-- About Page Content -->
        <!-- Server-rendered content -->
        @if($pageSettings['about']['hero']['enabled'])
            <section class="hero-about" style="background-image: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('{{ $pageSettings['about']['hero']['backgroundImage'] }}')">
                <div class="container">
                    <div class="hero-content">
                        <h1 class="hero-title">{{ $pageSettings['about']['hero']['title'] }}</h1>
                        <div class="hero-description">
                            <p>{{ $pageSettings['about']['hero']['subtitle'] }}</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if($pageSettings['about']['ethicalApproach']['enabled'])
            <section class="ethical-approach">
                <div class="container">
                    <div class="approach-grid">
                        <div class="approach-content">
                            <h2>{{ $pageSettings['about']['ethicalApproach']['title'] }}</h2>
                            <p>{{ $pageSettings['about']['ethicalApproach']['description'] }}</p>
                        </div>
                        <div class="approach-image" style="padding-left: 30px; display: flex; justify-content: flex-end;">
                            <img src="{{ $pageSettings['about']['ethicalApproach']['image'] }}" alt="Ethical Approach" style="max-width: 100%; height: auto;">
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if($pageSettings['about']['factoryImages']['enabled'])
            <section class="factory-images">
                <div class="factory-grid">
                    @foreach($pageSettings['about']['factoryImages']['images'] as $image)
                        <div class="factory-image">
                            <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}">
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($pageSettings['about']['designedToLast']['enabled'])
            <section class="designed-section">
                <div class="container">
                    <div class="designed-grid">
                        <div class="designed-content">
                            <h2>{{ $pageSettings['about']['designedToLast']['title'] }}</h2>
                            <p>{{ $pageSettings['about']['designedToLast']['description'] }}</p>
                        </div>
                        <div class="designed-images">
                            @foreach($pageSettings['about']['designedToLast']['images'] as $image)
                                <div>
                                    <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" style="width: 100%; height: 100%;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if($pageSettings['about']['transparent']['enabled'])
            <section class="transparency-section">
                <div class="container">
                    <h2>{{ $pageSettings['about']['transparent']['title'] }}</h2>
                    <p>{{ $pageSettings['about']['transparent']['description'] }}</p>
                    <div class="color-palette">
                        @foreach($pageSettings['about']['transparent']['colors'] as $color)
                            <div class="color-swatch" style="background-color: {{ $color['hex'] }}"></div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if($pageSettings['about']['explore']['enabled'])
            <section class="meet-explore">
                <div class="container">
                    <h2>{{ $pageSettings['about']['explore']['title'] }}</h2>
                    <div class="explore-grid">
                        @foreach($pageSettings['about']['explore']['categories'] as $category)
                            <div class="explore-item">
                                <img src="{{ $category['image'] }}" alt="{{ $category['title'] }}">
                                <p>{{ $category['title'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Angular-controlled content (hidden until loaded) -->
        <div ng-controller="AboutController" class="ng-cloak" style="display: none;">
            <!-- Content will be loaded by Angular but not visible -->
        </div>

        <!-- Include Sliding Cart Partial -->
        @include('partials.sliding-cart')

        <!-- Footer -->
        @include('partials.footer')

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        <script src="{{ asset('js/landingpage.js') }}"></script>
        <script src="{{ asset('js/cart.js') }}"></script>
        <script src="{{ asset('js/about.js') }}"></script>
        
        <script>
            // Initialize Angular module if it doesn't exist yet
            if (typeof angular !== 'undefined') {
                // Make sure the app is initialized
                try {
                    angular.module('garmeniqueApp');
                } catch(e) {
                    angular.module('garmeniqueApp', []);
                }
                
                // Make sure CartController exists
                var app = angular.module('garmeniqueApp');
                
                // Register CartController if not already registered
                if (!app.hasOwnProperty('_invokeQueue') || !app._invokeQueue.some(function(q) { 
                    return q[1] === 'controller' && q[2][0] === 'CartController'; 
                })) {
                    app.controller('CartController', ['$scope', '$rootScope', '$http', '$window', function($scope, $rootScope, $http, $window) {
                        // Basic cart properties
                        $scope.isCartActive = false;
                        $scope.cartItems = [];
                        $scope.isAuthenticated = true; // Default to true to prevent login message
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
                } else {
                    // Patch the existing CartController if it exists but doesn't load cart items
                    angular.element(document).ready(function() {
                        try {
                            var cartScope = angular.element('[ng-controller="CartController"]').scope();
                            if (cartScope) {
                                // Force cart reload if it has no items
                                if (!cartScope.cartItems || cartScope.cartItems.length === 0) {
                                    console.log("Patching CartController: Loading cart items");
                                    $http.get('/get-cart?_=' + new Date().getTime(), {
                                        headers: {'Cache-Control': 'no-cache'}
                                    })
                                    .then(function(response) {
                                        if (response.data.cart && Array.isArray(response.data.cart)) {
                                            cartScope.$apply(function() {
                                                cartScope.cartItems = response.data.cart;
                                            });
                                        }
                                    });
                                }
                            }
                        } catch(e) {
                            console.error("Error patching CartController:", e);
                        }
                    });
                }
                
                // Ensure cart functionality through direct DOM if needed
                var cartButtons = document.querySelectorAll('[ng-click="openCartPanel()"]');
                cartButtons.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var cartPanel = document.querySelector('.sliding-cart-panel');
                        var cartOverlay = document.querySelector('.sliding-cart-overlay');
                        if (cartPanel && cartOverlay) {
                            try {
                                // Try Angular first
                                var cartScope = angular.element(cartPanel).scope();
                                if (cartScope && typeof cartScope.openCart === 'function') {
                                    cartScope.$apply(function() {
                                        cartScope.openCart();
                                    });
                                    return;
                                }
                            } catch(e) {
                                console.log("Falling back to direct DOM manipulation", e);
                            }
                            
                            // Fallback to direct DOM manipulation
                            cartPanel.classList.add('active');
                            cartOverlay.classList.add('active');
                            document.body.style.overflow = 'hidden';
                            
                            // Add close functionality to overlay
                            cartOverlay.addEventListener('click', function() {
                                cartPanel.classList.remove('active');
                                cartOverlay.classList.remove('active');
                                document.body.style.overflow = '';
                            });
                            
                            // Add close functionality to close button
                            var closeBtn = cartPanel.querySelector('.close-btn');
                            if (closeBtn) {
                                closeBtn.addEventListener('click', function() {
                                    cartPanel.classList.remove('active');
                                    cartOverlay.classList.remove('active');
                                    document.body.style.overflow = '';
                                });
                            }
                        }
                    });
                });
                
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
                
                // Load cart data manually as a fallback
                loadCartDataManually();
                
                // Set up quantity buttons
                setupQuantityButtons();
                
                // Set up the checkout button
                setupCheckoutButton();
                
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
            }
            
            // Additional script to ensure mobile toggle works correctly
            document.addEventListener('DOMContentLoaded', function() {
                // Fix any potential issues with the mobile toggle button
                const mobileToggleBtn = document.querySelector('.mobile-toggle');
                if (mobileToggleBtn) {
                    mobileToggleBtn.innerHTML = `
                        <span class="toggle-bar"></span>
                        <span class="toggle-bar"></span>
                        <span class="toggle-bar"></span>
                    `;
                }
            });
        </script>
    </body>
</html>