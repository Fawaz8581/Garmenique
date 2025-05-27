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
    <link rel="stylesheet" href="{{ asset('css/landing.page.search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
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
                    <li><a href="/catalog" class="nav-item">CATALOG</a></li>
                    <li><a href="/blog" class="nav-item">BLOG</a></li>
                    <li><a href="/about" class="nav-item">ABOUT</a></li>
                    <li><a href="/contact" class="nav-item">CONTACT</a></li>
                </ul>
            </nav>
            
            <div class="nav-icons">
                <a href="/messages" class="nav-icon"><i class="fas fa-envelope"></i></a>
                @include('partials.account-dropdown')
                <a href="javascript:void(0)" class="nav-icon cart-icon" ng-click="toggleCart()">
                    <i class="fas fa-shopping-cart"></i>
                </a>
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
                                                    {{ $order->shipping_info['city'] }}, {{ $order->shipping_info['postalCode'] }}
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
                                                                    $expeditionName = 'JNE - Regular delivery';
                                                                    $expeditionIcon = 'fa-truck';
                                                                    $expeditionColor = 'text-primary';
                                                                    break;
                                                                case 'jnt':
                                                                    $expeditionName = 'J&T Express - Regular delivery';
                                                                    $expeditionIcon = 'fa-shipping-fast';
                                                                    $expeditionColor = 'text-danger';
                                                                    break;
                                                                case 'sicepat':
                                                                    $expeditionName = 'SiCepat - Regular delivery';
                                                                    $expeditionIcon = 'fa-bolt';
                                                                    $expeditionColor = 'text-success';
                                                                    break;
                                                            }
                                                        }
                                                    @endphp
                                                    <i class="fas {{ $expeditionIcon }} {{ $expeditionColor }}"></i>
                                                    {{ $expeditionName }}
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
                                                    
                                                    @if(strtolower($order->status) === 'shipped')
                                                        @php
                                                            $trackingUrl = '#';
                                                            if(isset($order->shipping_info['expedition'])) {
                                                                switch($order->shipping_info['expedition']) {
                                                                    case 'jne':
                                                                        $trackingUrl = 'https://jne.co.id/tracking-package';
                                                                        break;
                                                                    case 'jnt':
                                                                        $trackingUrl = 'https://jet.co.id/track';
                                                                        break;
                                                                    case 'sicepat':
                                                                        $trackingUrl = 'https://www.sicepat.com/';
                                                                        break;
                                                                }
                                                            }
                                                        @endphp
                                                        <a href="{{ $trackingUrl }}" class="btn-track-order" target="_blank">
                                                            <i class="fas fa-map-marker-alt me-2"></i> Track Your Order
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

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" ng-class="{'active': isCartActive}" ng-controller="CartController">
        <div class="cart-header">
            <h3>Shopping Cart</h3>
            <button class="close-cart" ng-click="toggleCart()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="cart-items" ng-if="cartItems.length > 0">
            <div class="cart-item" ng-repeat="item in cartItems">
                <div class="cart-item-image">
                    <img ng-src="@{{item.image}}" alt="@{{item.name}}">
                </div>
                <div class="cart-item-details">
                    <h4>@{{item.name}}</h4>
                    <p>Size: @{{item.size}}</p>
                    <div class="cart-item-price">
                        <span>IDR @{{item.price | number:0}}</span>
                        <div class="quantity-controls">
                            <button ng-click="decrementQuantity(item)">-</button>
                            <span>@{{item.quantity}}</span>
                            <button ng-click="incrementQuantity(item)">+</button>
                        </div>
                    </div>
                </div>
                <button class="remove-item" ng-click="removeItem(item)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        
        <div class="empty-cart" ng-if="cartItems.length === 0">
            <i class="fas fa-shopping-cart"></i>
            <p>Your cart is empty</p>
            <a href="/catalog" class="btn btn-primary">Continue Shopping</a>
        </div>

        <div class="cart-footer" ng-if="cartItems.length > 0">
            <div class="cart-total">
                <span>Total:</span>
                <span>IDR @{{getTotal() | number:0}}</span>
            </div>
            <a href="/checkout" class="btn btn-primary checkout-btn">Proceed to Checkout</a>
        </div>
    </div>

    <!-- Cart Overlay -->
    <div class="cart-overlay" ng-class="{'active': isCartActive}" ng-click="toggleCart()"></div>

    <!-- Scripts -->
    <script src="{{ asset('js/landingpage.js') }}"></script>
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