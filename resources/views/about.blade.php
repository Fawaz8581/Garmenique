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
                    <a href="javascript:void(0)" class="nav-icon cart-icon" ng-click="openCartPanel()">
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
                    app.controller('CartController', ['$scope', '$rootScope', '$http', function($scope, $rootScope, $http) {
                        // Basic cart functionality
                        $scope.isCartActive = false;
                        $scope.cartItems = [];
                        $scope.isAuthenticated = true; // Default to true to prevent login message
                        $scope.isLoading = false; // Default to false to avoid prolonged loading
                        
                        // Check authentication status immediately
                        $http.get('/check-auth?_=' + new Date().getTime(), {
                            headers: {'Cache-Control': 'no-cache'}
                        })
                        .then(function(response) {
                            console.log('Auth check response:', response.data);
                            $scope.isAuthenticated = response.data.authenticated;
                            
                            if ($scope.isAuthenticated) {
                                $scope.userId = response.data.user_id;
                                loadCartFromSession();
                            }
                        })
                        .catch(function(error) {
                            console.error('Auth check error:', error);
                            // Keep isAuthenticated as true on error to avoid login message
                        });
                        
                        // Load cart from session
                        function loadCartFromSession() {
                            $http.get('/get-cart?_=' + new Date().getTime(), {
                                headers: {'Cache-Control': 'no-cache'}
                            })
                            .then(function(response) {
                                console.log('Get cart response:', response.data);
                                if (response.data.cart && Array.isArray(response.data.cart)) {
                                    $scope.cartItems = response.data.cart;
                                }
                            })
                            .catch(function(error) {
                                console.error('Error loading cart from session:', error);
                            });
                        }
                        
                        // Open cart panel
                        $scope.openCart = function() {
                            $scope.isCartActive = true;
                            document.body.style.overflow = 'hidden';
                        };
                        
                        // Close cart panel
                        $scope.closeCart = function() {
                            $scope.isCartActive = false;
                            document.body.style.overflow = '';
                        };
                        
                        // Calculate subtotal
                        $scope.calculateSubtotal = function() {
                            return $scope.cartItems.reduce(function(total, item) {
                                var price = item.price;
                                if (item.discount) {
                                    price = price * (1 - item.discount/100);
                                }
                                return total + (price * item.quantity);
                            }, 0);
                        };
                        
                        // Get total items
                        $scope.getTotalItems = function() {
                            return $scope.cartItems.reduce(function(count, item) {
                                return count + item.quantity;
                            }, 0);
                        };
                        
                        // Listen for openCart event
                        $rootScope.$on('openCartPanel', function() {
                            $scope.openCart();
                        });
                    }]);
                }
                
                // Make sure HeaderController exists and has openCartPanel function
                if (!app.hasOwnProperty('_invokeQueue') || !app._invokeQueue.some(function(q) { 
                    return q[1] === 'controller' && q[2][0] === 'HeaderController'; 
                })) {
                    app.controller('HeaderController', ['$scope', '$rootScope', function($scope, $rootScope) {
                        // Mobile Navigation Toggle
                        $scope.isNavActive = false;
                        
                        $scope.toggleNav = function() {
                            $scope.isNavActive = !$scope.isNavActive;
                        };
                        
                        // Open cart panel
                        $scope.openCartPanel = function() {
                            $rootScope.$broadcast('openCartPanel');
                        };
                    }]);
                } else {
                    // If HeaderController exists, make sure it has openCartPanel function
                    try {
                        angular.element(document).ready(function() {
                            var headerScope = angular.element(document.querySelector('[ng-controller="HeaderController"]')).scope();
                            if (headerScope && !headerScope.openCartPanel) {
                                headerScope.openCartPanel = function() {
                                    var rootScope = angular.element(document.body).scope().$root;
                                    rootScope.$broadcast('openCartPanel');
                                };
                            }
                        });
                    } catch(e) {
                        console.error("Error setting up HeaderController:", e);
                    }
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
            });
        </script>
    </body>
</html>