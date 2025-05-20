<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Garmenique - Catalog</title>
        <meta name="keyword" content="Garmenique">
        <meta name="description" content="Garmenique - Premium Clothing Brand">

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
        <link rel="stylesheet" href="{{ asset('css/landing.page.search.css') }}">
        <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        <li><a href="/men" class="nav-item">MEN</a></li>
                        <li><a href="/women" class="nav-item">WOMEN</a></li>
                        <li><a href="/blog" class="nav-item">BLOG</a></li>
                        <li><a href="/about" class="nav-item">ABOUT</a></li>
                        <li><a href="/contact" class="nav-item">CONTACT</a></li>
                    </ul>
                </nav>
                
                <div class="nav-icons">
                    <a href="javascript:void(0)" class="nav-icon" ng-click="toggleSearch()"><i class="fas fa-search"></i></a>
                    @include('partials.account-dropdown')
                    <a href="/cart" class="nav-icon"><i class="fas fa-shopping-cart"></i></a>
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
        
        <!-- Page Title Banner -->
        <section class="page-title-banner" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80');">
            <div class="container">
                <h1>Our Catalog</h1>
            </div>
        </section>

        <!-- Catalog Section -->
        <section class="catalog-section" ng-controller="CatalogController">
            <div class="container">
                <div class="row">
                    <!-- Sidebar / Filters -->
                    <div class="col-lg-3 filter-sidebar">
                        <div class="filter-block">
                            <h3>Categories</h3>
                            <ul class="category-filter">
                                <li ng-repeat="category in categories">
                                    <label>
                                        <input type="checkbox" ng-model="category.selected" ng-change="filterProducts()">
                                        @{{ category.name }} <span>(@{{ category.count }})</span>
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <div class="filter-block">
                            <h3>Price Range (IDR)</h3>
                            <div class="price-range">
                                <div class="price-inputs">
                                    <input type="number" ng-model="priceRange.min" placeholder="Min" ng-change="filterProducts()" step="10000">
                                    <span>-</span>
                                    <input type="number" ng-model="priceRange.max" placeholder="Max" ng-change="filterProducts()" step="10000">
                                </div>
                            </div>
                        </div>

                        <div class="filter-block">
                            <h3>Size</h3>
                            <div class="size-filter">
                                <button ng-repeat="size in sizes" 
                                        ng-class="{'active': size.selected}" 
                                        ng-click="toggleSize(size)" 
                                        class="size-btn">
                                    @{{ size.label }}
                                </button>
                            </div>
                        </div>

                        <div class="filter-block">
                            <h3>Color</h3>
                            <div class="color-filter">
                                <button ng-repeat="color in colors" 
                                        ng-class="{'active': color.selected}" 
                                        ng-click="toggleColor(color)" 
                                        class="color-btn" 
                                        style="background-color: @{{ color.code }};" 
                                        title="@{{ color.name }}">
                                </button>
                            </div>
                        </div>

                        <button class="btn btn-secondary w-100 mt-3" ng-click="resetFilters()">Reset Filters</button>
                    </div>

                    <!-- Product List -->
                    <div class="col-lg-9">
                        <!-- Sorting and View Options -->
                        <div class="catalog-header">
                            <div class="results-count">
                                <p>Showing <strong>@{{ filteredProducts.length }}</strong> of @{{ products.length }} products</p>
                            </div>

                            <div class="sorting-options">
                                <div class="view-toggle">
                                    <button class="grid-view" ng-class="{'active': viewMode === 'grid'}" ng-click="setViewMode('grid')">
                                        <i class="fas fa-th"></i>
                                    </button>
                                    <button class="list-view" ng-class="{'active': viewMode === 'list'}" ng-click="setViewMode('list')">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </div>

                                <div class="sort-dropdown">
                                    <select ng-model="sortOption" ng-change="sortProducts()">
                                        <option value="featured">Featured</option>
                                        <option value="newest">Newest</option>
                                        <option value="price_low">Price: Low to High</option>
                                        <option value="price_high">Price: High to Low</option>
                                        <option value="name_asc">Name: A to Z</option>
                                        <option value="name_desc">Name: Z to A</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Products Grid View -->
                        <div class="products-container" ng-class="{'grid-view': viewMode === 'grid', 'list-view': viewMode === 'list'}">
                            <!-- Grid View -->
                            <div class="row" ng-if="viewMode === 'grid'">
                                <div class="col-md-6 col-6" ng-repeat="product in filteredProducts | limitTo: itemsPerPage : (currentPage - 1) * itemsPerPage">
                                    <div class="product-card" ng-mouseenter="hover(product)" ng-mouseleave="unhover(product)">
                                        <div class="product-img-container">
                                            <a href="/catalog/product/@{{ product.id }}">
                                                <img ng-src="@{{ product.primaryImage }}" alt="@{{ product.name }}" class="primary-img">
                                                <img ng-src="@{{ product.hoverImage }}" alt="@{{ product.name }}" class="hover-img">
                                            </a>
                                            <div class="product-actions" ng-if="product.isHovered">
                                                <button class="action-btn" ng-click="quickView(product)" title="Quick View">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="action-btn" ng-click="addToCart(product)" title="Add to Cart">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>
                                                <button class="action-btn" ng-click="addToWishlist(product)" title="Add to Wishlist">
                                                    <i class="far fa-heart"></i>
                                                </button>
                                                <button class="action-btn" ng-click="addToCompare(product)" title="Compare">
                                                    <i class="fas fa-exchange-alt"></i>
                                                </button>
                                            </div>
                                            <span class="product-tag new" ng-if="product.isNew">New</span>
                                            <span class="product-tag sale" ng-if="product.discount">-@{{ product.discount }}%</span>
                                        </div>
                                        
                                        <div class="product-info">
                                            <h3 class="product-name">
                                                <a href="/catalog/product/@{{ product.id }}">@{{ product.name }}</a>
                                            </h3>
                                            <div class="product-price">
                                                <span class="price-current" ng-class="{'has-discount': product.discount}">IDR @{{ (product.price * 15500).toLocaleString('id-ID') }}</span>
                                                <span class="price-old" ng-if="product.oldPrice">IDR @{{ (product.oldPrice * 15500).toLocaleString('id-ID') }}</span>
                                            </div>
                                            
                                            <div class="product-colors">
                                                <span class="color-dot" ng-repeat="color in product.colors | limitTo:4" style="background-color: @{{ color.code }}" title="@{{ color.name }}"></span>
                                            </div>
                                            
                                            <div class="product-rating" ng-if="product.rating">
                                                <i class="fas fa-star" ng-repeat="n in [].constructor(product.rating) track by $index"></i>
                                                <i class="far fa-star" ng-repeat="n in [].constructor(5 - product.rating) track by $index"></i>
                                                <span class="rating-count">(@{{ product.reviewCount }})</span>
                                            </div>
                                            
                                            <button class="add-to-cart-btn" ng-click="addToCart(product)">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- List View -->
                            <div class="products-list" ng-if="viewMode === 'list'">
                                <div class="product-list-item" ng-repeat="product in filteredProducts">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="product-img-container">
                                                <a href="/catalog/product/@{{ product.id }}">
                                                    <img ng-src="@{{ product.primaryImage }}" alt="@{{ product.name }}" class="list-img">
                                                </a>
                                                <span class="product-tag new" ng-if="product.isNew">New</span>
                                                <span class="product-tag sale" ng-if="product.discount">-@{{ product.discount }}%</span>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="list-product-info">
                                                <h3 class="product-name">
                                                    <a href="/catalog/product/@{{ product.id }}">@{{ product.name }}</a>
                                                </h3>
                                                
                                                <div class="product-rating">
                                                    <i class="fas fa-star" ng-repeat="i in getStars(product.rating) track by $index"></i>
                                                    <i class="far fa-star" ng-repeat="i in getEmptyStars(product.rating) track by $index"></i>
                                                    <span class="rating-count">(@{{ product.reviewCount }} Reviews)</span>
                                                </div>
                                                
                                                <div class="product-price">
                                                    <span class="price-current" ng-class="{'has-discount': product.discount}">IDR @{{ (product.price * 15500).toLocaleString('id-ID') }}</span>
                                                    <span class="price-old" ng-if="product.oldPrice">IDR @{{ (product.oldPrice * 15500).toLocaleString('id-ID') }}</span>
                                                </div>
                                                
                                                <div class="product-description">
                                                    <p>@{{ product.description | limitTo:200 }}@{{ product.description.length > 200 ? '...' : '' }}</p>
                                                </div>
                                                
                                                <div class="product-sizes">
                                                    <span>Available Sizes:</span>
                                                    <span class="size-tag" ng-repeat="size in product.sizes">@{{ size }}</span>
                                                </div>
                                                
                                                <div class="list-product-actions">
                                                    <button class="btn btn-primary" ng-click="addToCart(product)">
                                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                                    </button>
                                                    <button class="btn btn-outline-secondary" ng-click="quickView(product)">
                                                        <i class="fas fa-eye"></i> Quick View
                                                    </button>
                                                    <button class="btn btn-outline-secondary" ng-click="addToWishlist(product)">
                                                        <i class="far fa-heart"></i> Wishlist
                                                    </button>
                                                    <a href="/catalog/product/@{{ product.id }}" class="btn btn-outline-secondary">
                                                        <i class="fas fa-info-circle"></i> View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-container">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item" ng-class="{'disabled': currentPage === 1}">
                                        <a class="page-link" href="javascript:void(0)" aria-label="Previous" ng-click="goToPage(currentPage - 1)">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item" ng-repeat="page in getPages()" ng-class="{'active': page === currentPage}">
                                        <a class="page-link" href="javascript:void(0)" ng-click="goToPage(page)">@{{ page }}</a>
                                    </li>
                                    <li class="page-item" ng-class="{'disabled': currentPage === totalPages}">
                                        <a class="page-link" href="javascript:void(0)" aria-label="Next" ng-click="goToPage(currentPage + 1)">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick View Modal -->
        <div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="quickViewModalLabel">Quick View</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" ng-if="quickViewProduct">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="quick-view-img">
                                    <img ng-src="@{{ quickViewProduct.primaryImage }}" alt="@{{ quickViewProduct.name }}" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="quick-view-content">
                                    <h2 class="product-name">
                                        <a href="/catalog/product/@{{ quickViewProduct.id }}">@{{ quickViewProduct.name }}</a>
                                    </h2>
                                    
                                    <div class="product-rating">
                                        <i class="fas fa-star" ng-repeat="n in [].constructor(quickViewProduct.rating) track by $index"></i>
                                        <i class="far fa-star" ng-repeat="n in [].constructor(5 - quickViewProduct.rating) track by $index"></i>
                                        <span class="rating-count">@{{ quickViewProduct.reviewCount }} Reviews</span>
                                    </div>
                                    
                                    <div class="product-price">
                                        <span class="price-current">IDR @{{ (quickViewProduct.price * 15500).toLocaleString('id-ID') }}</span>
                                        <span class="price-old" ng-if="quickViewProduct.oldPrice">IDR @{{ (quickViewProduct.oldPrice * 15500).toLocaleString('id-ID') }}</span>
                                    </div>
                                    
                                    <p class="product-description">@{{ quickViewProduct.description }}</p>
                                    
                                    <div class="color-selection">
                                        <label>Color:</label>
                                        <div class="color-options">
                                            <div class="color-option" 
                                                    ng-repeat="color in quickViewProduct.colors" 
                                                    ng-class="{'selected': selectedColor === color}"
                                                    ng-click="selectColor(color)" 
                                                    style="background-color: @{{ color.code }};" 
                                                    title="@{{ color.name }}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="size-selection">
                                        <label>Size:</label>
                                        <div class="size-options">
                                            <button class="size-option" 
                                                    ng-repeat="size in quickViewProduct.sizes" 
                                                    ng-class="{'selected': selectedSize === size}"
                                                    ng-click="selectSize(size)">
                                                @{{ size }}
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="quantity-selector">
                                        <label>Quantity:</label>
                                        <div class="quantity-input">
                                            <button class="quantity-btn minus" ng-click="decreaseQuantity()">-</button>
                                            <input type="text" ng-model="quantity" readonly>
                                            <button class="quantity-btn plus" ng-click="increaseQuantity()">+</button>
                                        </div>
                                    </div>
                                    
                                    <div class="quick-view-actions">
                                        <button class="btn btn-primary" ng-click="addToCartFromModal()">
                                            <i class="fas fa-shopping-cart"></i> Add to Cart
                                        </button>
                                        <a href="/catalog/product/@{{ quickViewProduct.id }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-info-circle"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/catalog.js') }}"></script>
    </body>
</html>