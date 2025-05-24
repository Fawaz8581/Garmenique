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
                    <a href="javascript:void(0)" class="nav-icon" ng-click="toggleSearch()"><i class="fas fa-search"></i></a>
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
        <section class="product-detail-section" ng-controller="ProductDetailController">
            <div class="container">
                <div class="breadcrumb-container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">HOME</a></li>
                            <li class="breadcrumb-item"><a href="/catalog">CATALOG</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@{{ product.name }}</li>
                        </ol>
                    </nav>
                </div>
                
                <div class="row" ng-if="product">
                    <!-- Product Image on Left -->
                    <div class="col-md-7">
                        <div class="main-product-image">
                            <img ng-src="@{{ product.primaryImage }}" alt="@{{ product.name }} - Full View" class="img-fluid">
                        </div>
                    </div>
                    
                    <!-- Product Info on Right -->
                    <div class="col-md-5">
                        <div class="product-info">
                            <h1 class="product-title">@{{ product.name }}</h1>
                            
                            <!-- Product Reference ID -->
                            <div class="product-ref-id mb-3">
                                <span class="text-muted">REF: @{{ product.id }}</span>
                            </div>
                            
                            <!-- Product Price -->
                            <div class="product-price mb-4">
                                <span class="current-price" ng-class="{'has-discount': product.discount}">IDR @{{ (product.price * 15500).toLocaleString('id-ID') }}</span>
                                <span class="old-price" ng-if="product.oldPrice">IDR @{{ (product.oldPrice * 15500).toLocaleString('id-ID') }}</span>
                                <span class="discount-badge" ng-if="product.discount">-@{{ product.discount }}%</span>
                            </div>
                            
                            <!-- Product Sizes -->
                            <div class="product-sizes mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5>Size: <span>@{{ selectedSize || 'Select size' }}</span></h5>
                                    <a href="#" class="size-guide">Size Guide</a>
                                </div>
                                <div class="size-options">
                                    <button ng-repeat="size in product.sizes" 
                                            ng-click="selectSize(size)" 
                                            ng-class="{'active': selectedSize === size}" 
                                            class="size-btn">
                                        @{{ size }}
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Quantity Selector -->
                            <div class="quantity-selector mb-4">
                                <h5>Quantity:</h5>
                                <div class="quantity-input">
                                    <button class="quantity-btn" ng-click="decreaseQuantity()">-</button>
                                    <input type="text" ng-model="quantity" readonly>
                                    <button class="quantity-btn" ng-click="increaseQuantity()">+</button>
                                </div>
                                
                                <!-- User Selection Summary -->
                                <div class="user-selection-summary mt-3 mb-2" ng-if="selectedSize">
                                    <p class="text-muted mb-1">You selected: 
                                        <span ng-if="selectedSize">Size <strong>@{{ selectedSize }}</strong></span>
                                    </p>
                                </div>
                                
                                <!-- Shopping Cart Icon aligned left with text -->
                                <div class="mt-3 text-left">
                                    <a href="javascript:void(0)" class="nav-icon d-inline-flex align-items-center" ng-click="addToCart()">
                                        <i class="fas fa-shopping-cart" style="font-size: 24px;"></i>
                                        <span class="ml-2" style="margin-left: 10px; font-size: 16px;">Add to Cart</span>
                                    </a>
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
                        <p>@{{ product.description }}</p>
                        <ul>
                            <li>Made from premium materials</li>
                            <li>Designed for comfort and style</li>
                            <li>Perfect for everyday wear</li>
                            <li>Machine washable</li>
                        </ul>
                    </div>
                </div>

                <!-- You May Also Like -->
                <div class="related-products mt-5">
                    <h3>You May Also Like</h3>
                    <div class="row row-cols-2 row-cols-md-4 g-4">
                        <div class="col" ng-repeat="relatedProduct in relatedProducts">
                            <div class="product-card" ng-mouseenter="hover(relatedProduct)" ng-mouseleave="unhover(relatedProduct)">
                                <div class="product-card-img">
                                    <a href="/catalog/product/@{{ relatedProduct.id }}">
                                        <img ng-src="@{{ relatedProduct.isHovered ? relatedProduct.hoverImage : relatedProduct.primaryImage }}" alt="@{{ relatedProduct.name }}" class="img-fluid">
                                    </a>
                                    <div class="product-actions" ng-if="relatedProduct.isHovered">
                                        <button class="action-btn" ng-click="quickView(relatedProduct)" title="Quick View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn" ng-click="addToWishlist(relatedProduct)" title="Add to Wishlist">
                                            <i class="far fa-heart"></i>
                                        </button>
                                        <button class="action-btn" ng-click="addToCompare(relatedProduct)" title="Compare">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                    </div>
                                    <span class="product-badge new" ng-if="relatedProduct.isNew">New</span>
                                    <span class="product-badge discount" ng-if="relatedProduct.discount">-@{{ relatedProduct.discount }}%</span>
                                </div>
                                <div class="product-card-info">
                                    <h3 class="product-title">
                                        <a href="/catalog/product/@{{ relatedProduct.id }}">@{{ relatedProduct.name }}</a>
                                    </h3>
                                    <div class="product-price">
                                        <span class="current-price" ng-class="{'has-discount': relatedProduct.discount}">IDR @{{ (relatedProduct.price * 15500).toLocaleString('id-ID') }}</span>
                                        <span class="old-price" ng-if="relatedProduct.oldPrice">IDR @{{ (relatedProduct.oldPrice * 15500).toLocaleString('id-ID') }}</span>
                                    </div>
                                    <div class="product-rating">
                                        <div class="stars">
                                            <i class="fas fa-star" ng-repeat="i in getStars(relatedProduct.rating) track by $index"></i>
                                            <i class="far fa-star" ng-repeat="i in getEmptyStars(relatedProduct.rating) track by $index"></i>
                                        </div>
                                        <span class="review-count">(@{{ relatedProduct.reviewCount }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    </body>
</html>