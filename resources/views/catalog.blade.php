<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="garmeniqueApp">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Garmenique - Catalog</title>
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
        <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
        <link rel="stylesheet" href="{{ asset('css/landing.page.search.css') }}">
        <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <style>
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

            /* Page title styling */
            .page-title {
                margin: 30px 0 20px;
                font-size: 1.5rem;
                font-weight: 600;
            }
            
            .filters-section {
                padding-right: 30px;
            }
            
            .filter-heading {
                font-size: 0.9rem;
                font-weight: 600;
                margin-bottom: 10px;
            }
            
            .filter-group {
                margin-bottom: 25px;
            }
            
            .checkbox-label {
                display: flex;
                align-items: center;
                font-size: 0.85rem;
                margin-bottom: 8px;
                cursor: pointer;
            }
            
            .checkbox-label input {
                margin-right: 8px;
            }
            
            .color-swatch {
                width: 24px;
                height: 24px;
                border-radius: 50%;
                display: inline-block;
                margin-right: 8px;
                cursor: pointer;
                border: 1px solid #ddd;
            }
            
            .color-swatch.active {
                box-shadow: 0 0 0 2px #fff, 0 0 0 3px #333;
            }
            
            .size-btn {
                background: #fff;
                border: 1px solid #ddd;
                width: 40px;
                height: 40px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-right: 8px;
                margin-bottom: 8px;
                cursor: pointer;
                font-size: 0.8rem;
            }
            
            .size-btn.active {
                background: #333;
                color: #fff;
                border-color: #333;
            }
            
            .products-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }
            
            .products-count {
                font-size: 0.85rem;
                color: #666;
            }
            
            .view-options {
                display: flex;
                align-items: center;
            }
            
            .sort-select {
                padding: 5px 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                margin-left: 10px;
                font-size: 0.85rem;
            }
            
            /* Styling for product cards */
            .product-card {
                margin-bottom: 30px;
                position: relative;
                padding: 0 20px; /* Add horizontal spacing */
            }
            
            /* Product container with shadow and hover effect */
            .product-container {
                border-radius: 10px;
                overflow: hidden;
                transition: all 0.3s ease;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
                height: 100%;
                background-color: white;
            }
            
            .product-container:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }
            
            .product-image {
                position: relative;
                margin-bottom: 15px;
                overflow: hidden;
                height: 400px; /* Fixed height for consistent sizing */
                background-color: #f8f8f8;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px 8px 0 0; /* Rounded top corners */
            }
            
            .product-image img {
                width: 100%;
                height: 100%;
                object-fit: cover; /* Maintain aspect ratio while filling container */
                transition: all 0.4s ease;
            }
            
            .product-image:hover img {
                transform: scale(1.05);
            }
            
            .product-info {
                padding: 15px 20px 20px;
            }
            
            .product-title {
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 10px;
                line-height: 1.4;
            }
            
            .product-brand {
                font-size: 0.9rem;
                color: #666;
                margin-bottom: 12px;
            }
            
            .product-price {
                font-size: 1.1rem;
                font-weight: 600;
                color: #333;
                margin-bottom: 12px;
            }
            
            .discount-badge {
                position: absolute;
                top: 10px;
                right: 10px;
                background: #f54;
                color: white;
                padding: 3px 8px;
                font-size: 0.75rem;
                font-weight: 500;
            }
            
            .color-dots {
                margin-top: 8px;
            }
            
            .color-dot {
                width: 14px;
                height: 14px;
                border-radius: 50%;
                display: inline-block;
                margin-right: 4px;
                border: 1px solid #ddd;
            }
            
            .pagination {
                margin-top: 40px;
                margin-bottom: 60px;
                display: flex;
                justify-content: center;
            }
            
            .page-link {
                border: none;
                color: #333;
                padding: 8px 14px;
                margin: 0 5px;
            }
            
            .page-item.active .page-link {
                background: #333;
                color: #fff;
            }
            
            /* Custom 5-column grid */
            .col-md-20p {
                width: 20%;
                padding-right: 15px;
                padding-left: 15px;
            }
            
            @media (max-width: 767px) {
                .col-md-20p {
                    width: 50%;
                }
            }
            
            /* Mobile styles */
            @media (max-width: 991px) {
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
                
                .mobile-toggle {
                    display: block;
                }
                
                .logo-container, .nav-icons {
                    width: auto;
                }
            }

            /* Pagination styling */
            .pagination-container {
                margin-bottom: 50px;
            }
            
            .pagination .page-link {
                color: #333;
                border: 1px solid #ddd;
                padding: 8px 16px;
                font-size: 0.9rem;
                margin: 0 3px;
                border-radius: 4px;
                background-color: white;
            }
            
            .pagination .page-item.active .page-link {
                background-color: #333;
                border-color: #333;
                color: white;
            }
            
            .pagination .page-link:hover {
                background-color: #f8f8f8;
                border-color: #ccc;
                color: #333;
            }
            
            .pagination .page-link:focus {
                box-shadow: none;
                outline: none;
            }
            
            .pagination .page-item.disabled .page-link {
                color: #999;
                background-color: #f8f8f8;
            }

            .price-inputs {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .price-inputs .input-group {
                width: 100%;
            }

            .price-inputs input {
                text-align: right;
            }
        </style>
    </head>
    <body>
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
                            <li><a href="/catalog?category=t-shirt">T-SHIRT</a></li>
                            <li><a href="/catalog?category=shirt">SHIRT</a></li>
                            <li><a href="/catalog?category=jackets">JACKETS</a></li>
                            <li><a href="/catalog?category=pants">PANTS</a></li>
                            <li><a href="/catalog?category=hoodie">HOODIE</a></li>
                        </ul>
                    </div>

                    <!-- Popular Categories -->
                    <section class="popular-categories">
                        <h2>Popular Categories</h2>
                        <div class="row">
                            <div class="col-md-20p col-6">
                                <div class="category-card">
                                    <img src="{{ asset('images/catalog/category-tops.jpg') }}" alt="T-shirts" class="card-img-top">
                                    <h5 class="category-card-title">T-shirts</h5>
                                </div>
                            </div>
                            <div class="col-md-20p col-6">
                                <div class="category-card">
                                    <img src="{{ asset('images/catalog/category-tops.jpg') }}" alt="Shirts" class="card-img-top">
                                    <h5 class="category-card-title">Shirts</h5>
                                </div>
                            </div>
                            <div class="col-md-20p col-6">
                                <div class="category-card">
                                    <img src="{{ asset('images/catalog/category-outerwear.jpg') }}" alt="Jackets" class="card-img-top">
                                    <h5 class="category-card-title">Jackets</h5>
                                </div>
                            </div>
                            <div class="col-md-20p col-6">
                                <div class="category-card">
                                    <img src="{{ asset('images/catalog/category-bottoms.jpg') }}" alt="Pants" class="card-img-top">
                                    <h5 class="category-card-title">Pants</h5>
                                </div>
                            </div>
                            <div class="col-md-20p col-6">
                                <div class="category-card">
                                    <img src="{{ asset('images/catalog/category-tops.jpg') }}" alt="Hoodie" class="card-img-top">
                                    <h5 class="category-card-title">Hoodie</h5>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
            <div class="container mt-5 pt-5">
                <!-- Spacer -->
                <div class="spacer py-4"></div>

                <div class="row mt-5">
                <!-- Filters -->
                <div class="col-md-3 filters-section">
                    <div class="filter-group">
                        <h3 class="filter-heading">Categories</h3>
                        @foreach($categories as $category)
                        <label class="checkbox-label">
                            <input type="checkbox" class="category-filter" data-category="{{ $category->slug }}"> 
                            {{ $category->name }} (<span class="category-count" data-category="{{ $category->slug }}">{{ $category->products_count }}</span>)
                        </label>
                        @endforeach
                    </div>

                    <div class="filter-group">
                        <h3 class="filter-heading">Size</h3>
                        <div>
                            <button class="size-btn">XS</button>
                            <button class="size-btn">S</button>
                            <button class="size-btn">M</button>
                            <button class="size-btn">L</button>
                            <button class="size-btn">XL</button>
                            <button class="size-btn">XXL</button>
                            </div>
                        </div>

                    <div class="filter-group">
                        <h3 class="filter-heading">Price Range</h3>
                        <div class="mb-3">
                            <div class="price-inputs">
                                <div class="input-group mb-2">
                                    <span class="input-group-text">IDR</span>
                                    <input type="text" class="form-control price-input" id="minPrice" placeholder="Min">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">IDR</span>
                                    <input type="text" class="form-control price-input" id="maxPrice" placeholder="Max">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Reset Filters Button -->
                        <div class="mb-4 mt-4 text-center">
                            <button id="resetFilters" class="btn btn-outline-secondary btn-sm">Reset All Filters</button>
                        </div>
                    </div>
                            </div>

                <!-- Products -->
                <div class="col-md-9">
                    <div class="products-header">
                        <div class="products-count">
                            Showing <span id="visibleProductCount">{{ count($products) }}</span> of <span id="totalProductCount">{{ count($products) }}</span> products
                        </div>

                        <div class="view-options">
                            <select class="sort-select" id="sortSelect">
                                        <option value="featured">Featured</option>
                                <option value="newest">New Arrivals</option>
                                        <option value="price_low">Price: Low to High</option>
                                        <option value="price_high">Price: High to Low</option>
                                    </select>
                        </div>
                                        </div>
                                        
                    <div class="row mt-5 pt-3" id="productsContainer">
                        @if(count($products) > 0)
                            @foreach($products as $product)
                            <div class="col-md-6 product-card mb-5" data-category="{{ $product->category->slug ?? 'uncategorized' }}" data-price="{{ $product->price }}">
                                <div class="product-container">
                                <div class="product-image">
                                    <a href="/catalog/product/{{ $product->id }}">
                                        @if(!empty($product->images) && count($product->images) > 0)
                                            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                </div>
                                        <div class="product-info">
                                    <h3 class="product-title">
                                        <a href="/catalog/product/{{ $product->id }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
                                            </h3>
                                    <p class="product-brand">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                            <div class="product-price">
                                            <span>IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <p class="text-center">No products found. Please check back later.</p>
                            </div>
                        @endif
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-container mt-5">
                            <div class="row">
                                <!-- Page numbers in center with Previous/Next -->
                                <div class="col-12 mb-4">
                                    <nav aria-label="Product pagination">
                                        <ul class="pagination justify-content-center">
                                            <!-- Previous page link -->
                                            @if ($products->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">« Previous</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">« Previous</a>
                                                </li>
                                            @endif

                                            <!-- Pagination Elements -->
                                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                                @if ($page == $products->currentPage())
                                                    <li class="page-item active">
                                                        <span class="page-link">{{ $page }}</span>
                                                    </li>
                                                @else
                            <li class="page-item">
                                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                                @endif
                                            @endforeach

                                            <!-- Next Page Link -->
                                            @if ($products->hasMorePages())
                            <li class="page-item">
                                                    <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">Next »</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">Next »</span>
                                    </li>
                                            @endif
                                </ul>
                            </nav>
                                </div>
                                
                                <!-- Showing text centered with proper spacing -->
                                <div class="col-12">
                                    <p class="text-muted text-center">
                                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                                    </p>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
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
        <script src="{{ asset('js/catalog.js') }}"></script>
        
        <script>
            // Legacy non-angular code for filters
            document.addEventListener('DOMContentLoaded', function() {
                // Get categories from PHP
                const categories = @json($categories->pluck('slug'));
                
                // Count products per category
                categories.forEach(category => {
                    const productsInCategory = document.querySelectorAll(`.product-card[data-category="${category}"]`).length;
                    const categoryCountEl = document.querySelector(`.category-count[data-category="${category}"]`);
                    if (categoryCountEl) {
                        categoryCountEl.textContent = productsInCategory;
                    }
                });
                
                // Toggle size buttons
                const sizeButtons = document.querySelectorAll('.size-btn');
                sizeButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        btn.classList.toggle('active');
                        filterProducts();
                    });
                });
                
                // Category filter checkboxes
                const categoryCheckboxes = document.querySelectorAll('.category-filter');
                categoryCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', filterProducts);
                });
                
                // Sort functionality
                const sortSelect = document.getElementById('sortSelect');
                if (sortSelect) {
                    sortSelect.addEventListener('change', function() {
                        sortProducts(this.value);
                    });
                }
                
                // Price input formatting
                const priceInputs = document.querySelectorAll('.price-input');
                priceInputs.forEach(input => {
                    input.addEventListener('input', function(e) {
                        // Remove non-numeric characters
                        let value = this.value.replace(/\D/g, '');
                        
                        // Format with thousand separators
                        if (value.length > 0) {
                            value = parseInt(value).toLocaleString('id-ID');
                        }
                        
                        this.value = value;
                        filterProducts();
                    });
                });
                
                // Product filtering function
                function filterProducts() {
                    const products = document.querySelectorAll('.product-card');
                    const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.dataset.category);
                    const selectedSizes = Array.from(document.querySelectorAll('.size-btn.active')).map(btn => btn.textContent.trim());
                    const minPrice = parseInt(document.getElementById('minPrice').value.replace(/\D/g, '')) || 0;
                    const maxPrice = parseInt(document.getElementById('maxPrice').value.replace(/\D/g, '')) || Infinity;
                    
                    let visibleCount = 0;
                    
                    products.forEach(product => {
                        const productCategory = product.dataset.category;
                        const productPrice = parseInt(product.dataset.price);
                        
                        // Apply filters
                        let showProduct = true;
                        
                        // Category filter - only apply if categories are selected
                        if (selectedCategories.length > 0 && !selectedCategories.includes(productCategory)) {
                            showProduct = false;
                        }
                        
                        // Price filter - only apply if price is outside range
                        if (productPrice < minPrice || (maxPrice !== Infinity && productPrice > maxPrice)) {
                            showProduct = false;
                        }
                        
                        // Show/hide based on filters
                        product.style.display = showProduct ? '' : 'none';
                        if (showProduct) {
                            visibleCount++;
                        }
                    });
                    
                    // Update count display
                    const visibleProductCountEl = document.getElementById('visibleProductCount');
                    if (visibleProductCountEl) {
                        visibleProductCountEl.textContent = visibleCount;
                    }
                }
                
                // Product sorting function
                function sortProducts(sortBy) {
                    const productsContainer = document.getElementById('productsContainer');
                    const products = Array.from(productsContainer.querySelectorAll('.product-card'));
                    
                    products.sort((a, b) => {
                        const priceA = parseInt(a.dataset.price);
                        const priceB = parseInt(b.dataset.price);
                        
                        switch(sortBy) {
                            case 'price_low':
                                return priceA - priceB;
                            case 'price_high':
                                return priceB - priceA;
                            case 'newest':
                                // Would need a date attribute on products
                                return 0;
                            case 'featured':
                            default:
                                // Default ordering
                                return 0;
                        }
                    });
                    
                    // Re-append products in sorted order
                    products.forEach(product => {
                        productsContainer.appendChild(product);
                    });
                }
                
                // Reset filters button functionality
                const resetButton = document.getElementById('resetFilters');
                if (resetButton) {
                    resetButton.addEventListener('click', function() {
                        // Reset category checkboxes
                        const categoryCheckboxes = document.querySelectorAll('.category-filter');
                        categoryCheckboxes.forEach(checkbox => {
                            checkbox.checked = false;
                        });
                        
                        // Reset size buttons
                        sizeButtons.forEach(btn => {
                            btn.classList.remove('active');
                        });
                        
                        // Reset price inputs
                        priceInputs.forEach(input => {
                            input.value = '';
                        });
                        
                        // Reset sort select
                        if (sortSelect) {
                            sortSelect.value = 'featured';
                        }
                        
                        // Show all products
                        document.querySelectorAll('.product-card').forEach(card => {
                            card.style.display = '';
                        });
                        
                        // Update product count
                        const visibleProductCountEl = document.getElementById('visibleProductCount');
                        const totalProductCount = document.querySelectorAll('.product-card').length;
                        if (visibleProductCountEl) {
                            visibleProductCountEl.textContent = totalProductCount;
                        }
                    });
                }
                
                // Initialize filters
                filterProducts();
            });
        </script>
    </body>
</html>