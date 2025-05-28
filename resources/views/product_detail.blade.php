<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Garmenique - Product Details</title>
        <meta name="keyword" content="Garmenique">
        <meta name="description" content="Garmenique - Premium Clothing Brand">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="icon" href="images/icons/GarmeniqueLogo.png" type="image/png">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- AngularJS -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
        <link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
        <link rel="stylesheet" href="{{ asset('css/landing.page.search.css') }}">
        <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Navbar Fix CSS -->
        <style>
            /* Override styles for the navbar to match other pages */
            .header .nav-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 40px;
            }
            
            .header .logo-container {
                flex: 1;
                max-width: 200px;
                position: relative;
                z-index: 101;
                text-align: left;
            }
            
            .header .logo {
                font-weight: 600;
                font-size: 1.5rem;
                letter-spacing: 1px;
                text-transform: uppercase;
                color: #000;
            }
            
            .header .main-nav {
                flex: 2;
                display: flex;
                justify-content: center;
            }
            
            .header .main-nav ul {
                display: flex;
                list-style: none;
                margin: 0;
                padding: 0;
                justify-content: center;
            }
            
            .header .main-nav li {
                margin: 0 15px;
                text-align: center;
            }
            
            .header .nav-icons {
                flex: 1;
                max-width: 120px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .header .nav-icon {
                font-size: 1rem;
                color: #333;
                text-decoration: none;
                transition: color 0.3s ease;
            }
            
            /* Mobile responsive fix */
            @media (max-width: 991px) {
                .header .mobile-toggle {
                    display: block;
                }
                
                .header .logo-container, .header .nav-icons {
                    max-width: 120px;
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
                        <li><a href="/catalog" class="nav-item active">CATALOG</a></li>
                        <li><a href="/blog" class="nav-item">BLOG</a></li>
                        <li><a href="/about" class="nav-item">ABOUT</a></li>
                        <li><a href="/contact" class="nav-item">CONTACT</a></li>
                    </ul>
                </nav>
                
                <div class="nav-icons">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="/admin" class="nav-icon admin-icon-link" title="Admin Dashboard">
                                <img src="{{ asset('images/icons/GarmeniqueLogo.png') }}" alt="Admin" class="admin-nav-icon">
                            </a>
                        @endif
                    @endauth
                    <a href="{{ route('user.messages') }}" class="nav-icon"><i class="fas fa-envelope"></i></a>
                    @include('partials.account-dropdown')
                    <a href="javascript:void(0)" class="nav-icon" ng-click="openCartPanel()"><i class="fas fa-shopping-cart"></i></a>
                </div>
                
                <button class="mobile-toggle" ng-click="toggleNav()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
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
        
        <!-- Product Detail Section -->
        <section class="product-detail-section">
            <div class="container">
                <div class="breadcrumb-container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">HOME</a></li>
                            <li class="breadcrumb-item"><a href="/catalog">CATALOG</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>
                
                <div class="row">
                    <!-- Product Image on Left -->
                    <div class="col-md-6">
                        <div class="main-product-image">
                        @if($product->db_image_url)
                            <img src="{{ $product->db_image_url }}" alt="{{ $product->name }}" class="img-fluid">
                        @elseif(!empty($product->images) && count($product->images) > 0)
                            <img src="{{ asset($product->images[0]) }}" alt="{{ $product->name }}" class="img-fluid">
                        @else
                            <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="{{ $product->name }}" class="img-fluid">
                        @endif
                        </div>
                    </div>
                    
                    <!-- Product Info on Right -->
                    <div class="col-md-5">
                        <div class="product-info">
                            <h1 class="product-title">{{ $product->name }}</h1>
                            
                            <!-- Product Reference ID -->
                            <div class="product-ref-id mb-3">
                                <span class="text-muted">REF: {{ $product->id }}</span>
                            </div>
                            
                            <!-- Product Price -->
                            <div class="product-price mb-4">
                                <span class="current-price">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            
                            <!-- Product Sizes -->
                            <div class="product-sizes mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5>Size: <span id="selected-size">Select size</span></h5>
                                    <a href="#" class="size-guide">Size Guide</a>
                                </div>
                                <div class="size-stock-grid">
                                    @if($product->sizes && count($product->sizes) > 0)
                                        @foreach($product->sizes as $size)
                                            @if($size['stock'] > 0)
                                                <div class="size-stock">
                                                    <button onclick="selectSize('{{ $size['name'] }}')" 
                                                            class="size-btn" 
                                                            data-size="{{ $size['name'] }}">
                                                        {{ $size['name'] }}
                                                    </button>
                                                    <span class="size-quantity">Stock: {{ $size['stock'] }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>No sizes available</p>
                                    @endif
                                </div>
                                <!-- Total Stock Display -->
                                <div class="total-stock mt-3">
                                    <p class="text-muted mb-0">Total Stock: {{ $product->total_stock }}</p>
                                </div>
                            </div>
                            
                            <!-- Quantity Selector -->
                            <div class="quantity-selector mb-4">
                                <h5>Quantity:</h5>
                                <div class="quantity-input">
                                    <button class="quantity-btn" onclick="decreaseQuantity()">-</button>
                                    <input type="text" id="quantity" value="1" readonly>
                                    <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                                </div>
                                
                                <!-- User Selection Summary -->
                                <div class="user-selection-summary mt-3 mb-2" id="selection-summary" style="display: none;">
                                    <p class="text-muted mb-1">You selected: 
                                        <span>Size <strong id="summary-size"></strong></span>
                                    </p>
                                </div>
                                
                                <!-- Add to Cart Button -->
                                <div class="mt-3">
                                    <button class="btn btn-dark w-100 d-flex align-items-center justify-content-center" onclick="addToCart()">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Product Meta Info -->
                            <div class="product-meta mb-4">
                                <div class="meta-item">
                                    <i class="fas fa-truck"></i>
                                    <span>Free shipping on orders over IDR 1.500.000</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-undo"></i>
                                    <span>30-day easy returns</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>2-year warranty</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Product Description -->
                <div class="product-description mt-5">
                    <h3>Description</h3>
                    <div class="description-content mt-4">
                        <p>{{ $product->description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Include Sliding Cart Partial -->
        @include('partials.sliding-cart')

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-col">
                        <h4>Company</h4>
                        <ul class="footer-links">
                            <li><a href="/about">About Us</a></li>
                            <li><a href="#">Our Story</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Sustainability</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4>Help</h4>
                        <ul class="footer-links">
                            <li><a href="#">Customer Service</a></li>
                            <li><a href="#">Track Order</a></li>
                            <li><a href="#">Returns & Exchanges</a></li>
                            <li><a href="#">Shipping Info</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4>Quick Links</h4>
                        <ul class="footer-links">
                            <li><a href="/men">Men's Collection</a></li>
                            <li><a href="/women">Women's Collection</a></li>
                            <li><a href="#">Gift Cards</a></li>
                            <li><a href="/blog">Blog</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4>Connect With Us</h4>
                        <div class="social-email-section">
                            <div class="social-icons">
                                <a href="#" class="social-icon-circle"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon-circle"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-icon-circle"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-icon-circle"><i class="fab fa-pinterest"></i></a>
                            </div>
                            <p class="email-title">Sign Up for Updates</p>
                            <form class="email-form">
                                <input type="email" placeholder="Enter your email" class="email-input" required>
                                <button type="submit" class="email-button">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; 2025 Garmenique. All Rights Reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Angular Controllers -->
        <script src="{{ asset('js/catalog.js') }}"></script>
        <script src="{{ asset('js/product_detail.js') }}"></script>
        <script src="{{ asset('js/cart.js') }}"></script>

        <!-- JavaScript for Product Detail Functionality -->
        <script>
            let selectedSize = '';
            let quantity = 1;

            function selectSize(size) {
                selectedSize = size;
                document.getElementById('selected-size').textContent = size;
                document.getElementById('summary-size').textContent = size;
                document.getElementById('selection-summary').style.display = 'block';
                
                // Remove active class from all size buttons
                document.querySelectorAll('.size-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to selected size button
                document.querySelector(`.size-btn[data-size="${size}"]`).classList.add('active');
            }

            function increaseQuantity() {
                quantity++;
                document.getElementById('quantity').value = quantity;
            }

            function decreaseQuantity() {
                if (quantity > 1) {
                    quantity--;
                    document.getElementById('quantity').value = quantity;
                }
            }

            function addToCart() {
                if (!selectedSize) {
                    alert('Please select a size');
                    return;
                }

                // Create product data object
                const productData = {
                    id: {{ $product->id }},
                    name: '{{ $product->name }}',
                    price: {{ $product->price }},
                    image: '{{ $product->db_image_url ?? (!empty($product->images) && count($product->images) > 0 ? asset($product->images[0]) : "https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80") }}',
                    size: selectedSize,
                    color: 'Default', // Adding default color since it's required by cart
                    quantity: quantity
                };

                // Call the Angular controller's addToCart function
                const scope = angular.element(document.querySelector('[ng-controller="CartController"]')).scope();
                scope.$apply(function() {
                    scope.addToCart(productData);
                });
            }
        </script>
    </body>
</html>