<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Garmenique - About Us</title>
        <meta name="keyword" content="Garmenique">
        <meta name="description" content="Garmenique - Premium Clothing Brand">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="icon" href="images/icons/GarmeniqueLogo.png" type="image/png">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- AngularJS -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
        <link rel="stylesheet" href="{{ asset('css/about.search.css') }}">
        <link rel="stylesheet" href="{{ asset('css/about.css') }}">
        <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">
        
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
                        <li><a href="/about" class="nav-item active">ABOUT</a></li>
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
        
        <!-- Hero Section -->
        <section class="hero-about" style="background-image: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('https://images.unsplash.com/photo-1556905055-8f358a7a47b2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80');">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">We believe we can all make a difference</h1>
                    <div class="hero-description">
                        <p>At Garmenique, we truly believe that what we make matters. That's why we're native with the land, ethical factories around the world, and our suppliers. When we're open about our practices, we inspire others to share their own stories with you—down to the raw materials, production partner, and little defining details. We call it Radical Transparency.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ethical Approach Section -->
        <section class="ethical-approach">
            <div class="container">
                <div class="approach-grid">
                    <div class="approach-content">
                        <h2>Our ethical approach</h2>
                        <p>We're committed to creating beautiful, quality clothing while minimizing our environmental impact and ensuring the well-being of the people who make our products.</p>
                    </div>
                    <div class="approach-image">
                        <img src="https://images.unsplash.com/photo-1559582798-678dfc71ccd8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Worker in ethical factory">
                    </div>
                </div>
            </div>
        </section>

        <!-- Factory Images Section -->
        <section class="factory-images">
            <div class="factory-grid">
                <div class="factory-image">
                    <img src="https://images.unsplash.com/photo-1525171254930-643fc658b64e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Factory detail">
                </div>
                <div class="factory-image">
                    <img src="https://images.unsplash.com/photo-1675176785803-bffbbb0cd2f4?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Z2FybWVudCUyMGZhY3Rvcnl8ZW58MHx8MHx8fDA%3D" alt="Worker closeup">
                </div>
            </div>
        </section>

        <!-- Designed Section -->
        <section class="designed-section">
            <div class="container">
                <div class="designed-grid">
                    <div class="designed-content">
                        <h2>Designed to last</h2>
                        <p>Our designs focus on timeless style and durability. We create pieces that transcend seasons, made with quality materials and expert craftsmanship that stand the test of time.</p>
                    </div>
                    <div class="designed-images">
                        <div class="fabric-sample">
                            <img src="https://images.unsplash.com/photo-1551537482-f2075a1d41f2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Fabric sample">
                        </div>
                        <div class="pattern-image">
                            <img src="https://images.unsplash.com/photo-1594040226829-7f251ab46d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Pattern design">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Transparency Section -->
        <section class="transparency-section">
            <div class="container">
                <h2>Radically Transparent</h2>
                <p>We believe in full transparency about our materials, manufacturing process, and pricing. This approach allows you to make informed choices and understand the true value of what you're purchasing.</p>
                <div class="color-palette">
                    <div class="color-swatch beige"></div>
                    <div class="color-swatch gray"></div>
                </div>
            </div>
        </section>

        <!-- Meet Our Explore Section -->
        <section class="meet-explore">
            <div class="container">
                <h2>Meet our Explore</h2>
                <div class="explore-grid">
                    <div class="explore-item">
                        <img src="https://images.unsplash.com/photo-1586075010923-2dd4570fb338?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Explore item 1">
                        <p>Fabric Selection</p>
                    </div>
                    <div class="explore-item">
                        <img src="https://images.unsplash.com/photo-1604881988758-f76ad2f7aac1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Explore item 2">
                        <p>Design Process</p>
                    </div>
                    <div class="explore-item">
                        <img src="https://images.unsplash.com/photo-1581873372796-635b67ca2008?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Explore item 3">
                        <p>Production</p>
                    </div>
                    <div class="explore-item">
                        <img src="https://images.unsplash.com/photo-1617419250411-98aa962b070f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Explore item 4">
                        <p>Quality Control</p>
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

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/about.js') }}"></script>
        <script src="{{ asset('js/cart.js') }}"></script>
    </body>
</html>