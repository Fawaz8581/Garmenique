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
                padding: 6px 10px;
                min-width: 40px;
                height: 32px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                font-size: 0.8rem;
                transition: all 0.2s ease;
                border-radius: 4px;
                margin-right: 8px;
                margin-bottom: 8px;
            }
            
            .size-btn:hover {
                border-color: #333;
            }
            
            .size-btn.active {
                background: #333;
                color: #fff;
                border-color: #333;
            }
            
            .clothing-sizes,
            .number-sizes {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
                margin-bottom: 15px;
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

            /* Size filter styles */
            .filter-subheading {
                font-size: 0.8rem;
                font-weight: 500;
                color: #666;
                margin-bottom: 8px;
            }
            
            .product-sizes {
                display: flex;
                flex-wrap: wrap;
                gap: 4px;
                margin-top: 8px;
            }
            
            .size-badge {
                font-size: 0.7rem;
                padding: 2px 6px;
                background: #f5f5f5;
                border-radius: 3px;
                color: #666;
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
                
                @include('partials.nav-icons')
                
                <button class="mobile-toggle" ng-click="toggleNav()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </header>

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
                        @foreach($availableSizes as $type => $sizes)
                            <div class="mb-3">
                                <h4 class="filter-subheading">{{ ucfirst($type) }} Sizes</h4>
                                <div class="{{ strtolower($type) }}-sizes">
                                    @foreach($sizes as $size)
                                        <button type="button" 
                                                class="size-btn" 
                                                data-size-type="{{ $type }}" 
                                                data-size-id="{{ $size->id }}"
                                                data-size-name="{{ $size->name }}"
                                                onclick="toggleSize(this)">
                                            {{ $size->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
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
                            <div class="col-md-6 product-card mb-5" 
                                data-category="{{ $product->category->slug ?? 'uncategorized' }}" 
                                data-price="{{ $product->price }}"
                                data-sizes="{{ json_encode($product->sizes) }}">
                                <div class="product-container">
                                    <div class="product-image">
                                        <a href="/catalog/product/{{ $product->id }}">
                                            @if($product->db_image_url)
                                                <img src="{{ $product->db_image_url }}?v={{ time() }}-{{ rand(1000, 9999) }}" alt="{{ $product->name }}">
                                            @elseif(!empty($product->images) && is_array($product->images))
                                                <img src="{{ asset($product->images[0]) }}?v={{ time() }}-{{ rand(1000, 9999) }}" alt="{{ $product->name }}">
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
                                        <div class="product-sizes">
                                            @foreach($product->sizes as $size)
                                                @if(isset($size['pivot']['stock']) && $size['pivot']['stock'] > 0)
                                                    <span class="size-badge" 
                                                          data-size-id="{{ $size['id'] }}" 
                                                          data-size-type="{{ $size['type'] }}">
                                                        {{ $size['name'] }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                        <!-- Stock Information -->
                                        <div class="product-stock mt-2">
                                            <small class="text-muted">Stock: {{ $product->total_stock }}</small>
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
            document.addEventListener('DOMContentLoaded', function() {
                // Get categories from PHP
                const categories = @json($categories->pluck('slug'));
                
                // Initialize filter state
                const filterState = {
                    categories: [],
                    sizes: [],
                    minPrice: 0,
                    maxPrice: Infinity
                };
                
                // Count products per category
                categories.forEach(category => {
                    const productsInCategory = document.querySelectorAll(`.product-card[data-category="${category}"]`).length;
                    const categoryCountEl = document.querySelector(`.category-count[data-category="${category}"]`);
                    if (categoryCountEl) {
                        categoryCountEl.textContent = productsInCategory;
                    }
                });
                
                // Toggle size buttons with visual feedback
                const sizeButtons = document.querySelectorAll('.size-btn');
                sizeButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const sizeType = btn.dataset.sizeType;
                        const sizeId = parseInt(btn.dataset.sizeId);
                        const sizeName = btn.dataset.sizeName;
                        
                        // Toggle active state
                        btn.classList.toggle('active');
                        
                        // Update filter state
                        updateFilterState();
                        
                        // Apply filters
                        filterProducts();
                        
                        // Log for debugging
                        console.log('Size button clicked:', { sizeType, sizeId, sizeName });
                        console.log('Current filter state:', filterState);
                    });
                });
                
                // Category filter checkboxes
                const categoryCheckboxes = document.querySelectorAll('.category-filter');
                categoryCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateFilterState();
                        filterProducts();
                    });
                });

                // Price input handling
                const priceInputs = document.querySelectorAll('.price-input');
                priceInputs.forEach(input => {
                    input.addEventListener('input', function(e) {
                        let value = this.value.replace(/\D/g, '');
                        if (value.length > 0) {
                            this.value = new Intl.NumberFormat('id-ID').format(value);
                        }
                        updateFilterState();
                        filterProducts();
                    });
                });

                // Update filter state
                function updateFilterState() {
                    // Update categories
                    filterState.categories = Array.from(document.querySelectorAll('.category-filter:checked'))
                        .map(cb => cb.dataset.category);

                    // Update sizes
                    filterState.sizes = Array.from(document.querySelectorAll('.size-btn.active'))
                        .map(btn => ({
                            id: parseInt(btn.dataset.sizeId),
                            type: btn.dataset.sizeType,
                            name: btn.dataset.sizeName
                        }));

                    // Update price range
                    filterState.minPrice = parseInt(document.getElementById('minPrice').value.replace(/\D/g, '')) || 0;
                    filterState.maxPrice = parseInt(document.getElementById('maxPrice').value.replace(/\D/g, '')) || Infinity;
                    
                    // Log for debugging
                    console.log('Filter state updated:', filterState);
                }
                
                // Product filtering function
                function filterProducts() {
                    const products = document.querySelectorAll('.product-card');
                    let visibleCount = 0;
                    
                    products.forEach(product => {
                        const productCategory = product.dataset.category;
                        const productPrice = parseInt(product.dataset.price);
                        const productSizesData = product.dataset.sizes;
                        const productSizes = JSON.parse(productSizesData || '{}');
                        
                        // Apply filters
                        let showProduct = true;
                        
                        // Category filter
                        if (filterState.categories.length > 0 && !filterState.categories.includes(productCategory)) {
                            showProduct = false;
                        }
                        
                        // Size filter
                        if (filterState.sizes.length > 0) {
                            const sizeMatch = filterState.sizes.some(selectedSize => {
                                return Object.values(productSizes).some(productSize => {
                                    const match = productSize.id === selectedSize.id && 
                                           productSize.type === selectedSize.type &&
                                           productSize.stock > 0;
                                    
                                    // Log for debugging
                                    console.log('Size comparison:', {
                                        selected: selectedSize,
                                        product: productSize,
                                        matches: match
                                    });
                                    
                                    return match;
                                });
                            });
                            
                            if (!sizeMatch) {
                                showProduct = false;
                            }
                        }
                        
                        // Price filter
                        if (productPrice < filterState.minPrice || 
                            (filterState.maxPrice !== Infinity && productPrice > filterState.maxPrice)) {
                            showProduct = false;
                        }
                        
                        // Show/hide based on filters
                        product.style.display = showProduct ? '' : 'none';
                        if (showProduct) {
                            visibleCount++;
                        }
                        
                        // Log for debugging
                        console.log('Product visibility:', {
                            product: product.querySelector('.product-title')?.textContent,
                            visible: showProduct,
                            sizes: productSizes
                        });
                    });
                    
                    // Update count display
                    const visibleProductCountEl = document.getElementById('visibleProductCount');
                    if (visibleProductCountEl) {
                        visibleProductCountEl.textContent = visibleCount;
                    }

                    // Update total count
                    const totalProductCountEl = document.getElementById('totalProductCount');
                    if (totalProductCountEl) {
                        totalProductCountEl.textContent = products.length;
                    }
                }
                
                // Reset filters
                const resetButton = document.getElementById('resetFilters');
                function resetFilters() {
                    // Reset category checkboxes
                    document.querySelectorAll('.category-filter').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    
                    // Reset size buttons
                    document.querySelectorAll('.size-btn').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    
                    // Reset price inputs
                    document.querySelectorAll('.price-input').forEach(input => {
                        input.value = '';
                    });
                    
                    // Reset filter state
                    filterState.categories = [];
                    filterState.sizes = [];
                    filterState.minPrice = 0;
                    filterState.maxPrice = Infinity;
                    
                    // Reset sort select
                    const sortSelect = document.getElementById('sortSelect');
                    if (sortSelect) {
                        sortSelect.value = 'featured';
                    }
                    
                    // Show all products explicitly
                    document.querySelectorAll('.product-card').forEach(product => {
                        product.style.display = '';
                    });
                    
                    // Update product count
                    updateProductCount();
                }
                
                if (resetButton) {
                    resetButton.addEventListener('click', resetFilters);
                }
                
                // Initialize with all products showing
                resetFilters();
            });

            function toggleSize(button) {
                // Toggle active class
                button.classList.toggle('active');
                
                // Get all active size buttons
                const activeSizes = document.querySelectorAll('.size-btn.active');
                
                // Get all products
                const products = document.querySelectorAll('.product-card');
                
                // If no sizes selected, show all products
                if (activeSizes.length === 0) {
                    products.forEach(product => {
                        product.style.display = '';
                    });
                    updateProductCount();
                    return;
                }
                
                // Filter products based on selected sizes
                products.forEach(product => {
                    const productSizesData = product.dataset.sizes;
                    const productSizes = JSON.parse(productSizesData || '{}');
                    console.log('Product Sizes data:', productSizesData); // Debug log
                    console.log('Product Sizes parsed:', productSizes); // Debug log
                    
                    // Check if product has any of the selected sizes with stock > 0
                    const hasSelectedSize = Array.from(activeSizes).some(sizeBtn => {
                        const selectedSizeId = parseInt(sizeBtn.dataset.sizeId);
                        const selectedSizeType = sizeBtn.dataset.sizeType;
                        const selectedSizeName = sizeBtn.textContent.trim();
                        
                        console.log('Checking size:', { // Debug log
                            selectedSizeId,
                            selectedSizeType,
                            selectedSizeName
                        });
                        
                        // Check in all size values
                        return Object.values(productSizes).some(productSize => {
                            // Check if this size matches the selected one
                            const sizeMatch = productSize.id === selectedSizeId && 
                                           productSize.type === selectedSizeType &&
                                           productSize.stock > 0;
                            
                            console.log('Size comparison:', { // Debug log
                                productSize,
                                selectedSizeId,
                                selectedSizeType,
                                sizeMatch
                            });
                            
                            return sizeMatch;
                        });
                    });
                    
                    console.log('Product visibility:', { // Debug log
                        product: product.querySelector('.product-title')?.textContent,
                        hasSelectedSize
                    });
                    
                    // Show/hide product based on size match
                    product.style.display = hasSelectedSize ? '' : 'none';
                });
                
                // Update product count
                updateProductCount();
                
                // Debug log of current filter state
                console.log('Current filter state:', {
                    activeSizes: Array.from(activeSizes).map(btn => ({
                        id: parseInt(btn.dataset.sizeId),
                        type: btn.dataset.sizeType,
                        name: btn.textContent.trim()
                    })),
                    visibleProducts: document.querySelectorAll('.product-card:not([style*="display: none"])').length,
                    totalProducts: products.length
                });
            }
            
            function updateProductCount() {
                const visibleProducts = document.querySelectorAll('.product-card:not([style*="display: none"])').length;
                const totalProducts = document.querySelectorAll('.product-card').length;
                
                const visibleProductCountEl = document.getElementById('visibleProductCount');
                const totalProductCountEl = document.getElementById('totalProductCount');
                
                if (visibleProductCountEl) {
                    visibleProductCountEl.textContent = visibleProducts;
                }
                if (totalProductCountEl) {
                    totalProductCountEl.textContent = totalProducts;
                }
            }
            
            // Initialize product count
            document.addEventListener('DOMContentLoaded', function() {
                updateProductCount();
                
                // Debug log of initial product sizes
                const products = document.querySelectorAll('.product-card');
                products.forEach(product => {
                    const productSizes = JSON.parse(product.dataset.sizes || '[]');
                    console.log('Initial product sizes:', {
                        product: product.querySelector('.product-title')?.textContent,
                        sizes: productSizes
                    });
                });
            });
        </script>
    </body>
</html>