<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Garmenique - Premium Clothing Brand</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- AngularJS -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body ng-app="garmeniqueApp">
        <!-- Header Section -->
        <header class="header" ng-controller="HeaderController">
            <div class="container nav-container">
                <div class="logo-container">
                    <a href="#" class="logo">GARMENIQUE</a>
                </div>
                
                <nav class="main-nav" ng-class="{'active': isNavActive}">
                    <ul>
                        <li><a href="#" class="nav-item">Home</a></li>
                        <li><a href="#" class="nav-item">New Arrivals</a></li>
                        <li><a href="#" class="nav-item">Men</a></li>
                        <li><a href="#" class="nav-item">Women</a></li>
                        <li><a href="#" class="nav-item">Sale</a></li>
                        <li><a href="#" class="nav-item">Collections</a></li>
                        <li><a href="#" class="nav-item">About</a></li>
                        <li><a href="#" class="nav-item">Contact</a></li>
                    </ul>
                </nav>
                
                <div class="nav-icons">
                    <a href="#" class="nav-icon"><i class="fas fa-search"></i></a>
                    <a href="#" class="nav-icon"><i class="fas fa-user"></i></a>
                    <a href="#" class="nav-icon"><i class="fas fa-shopping-cart"></i></a>
                </div>
                
                <button class="mobile-toggle" ng-click="toggleNav()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1490725263030-1f0521cec8ec?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80');">
            <div class="container hero-container">
                <div class="hero-content">
                    <h1 class="hero-title">GARMENIQUE</h1>
                    <p class="hero-description">Elegance in every stitch. Premium clothing crafted for those who appreciate quality and style.</p>
                    <a href="#" class="btn">SHOP NOW</a>
                </div>
            </div>
        </section>

        <!-- Category Section -->
        <section class="category-section">
            <div class="container">
                <h2 class="section-title">Shop by Category</h2>
                <div class="category-grid" ng-controller="CategoryController">
                    <div class="category-item" ng-repeat="category in categories" 
                         ng-mouseenter="hover(category)" 
                         ng-mouseleave="unhover(category)"
                         ng-class="{'hovered': category.isHovered}">
                        <img ng-src="@{{category.imageUrl}}" alt="@{{category.name}}" class="category-img">
                        <h3 class="category-name">@{{category.name}}</h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Section -->
        <section class="featured-section">
            <div class="container">
                <div class="featured-grid" ng-controller="FeaturedController">
                    <div class="featured-item" ng-repeat="item in featuredItems"
                         ng-mouseenter="hover(item)"
                         ng-mouseleave="unhover(item)"
                         ng-class="{'hovered': item.isHovered}">
                        <img ng-src="@{{item.imageUrl}}" alt="@{{item.title}}" class="featured-img">
                        <div class="featured-content">
                            <h3 class="featured-title">@{{item.title}}</h3>
                            <a href="@{{item.link}}" class="btn">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="mission-section" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1553413077-190dd305871c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=70');">
            <div class="container">
                <h2 class="mission-title">We're on a Mission To Clean Up the Industry</h2>
                <a href="#" class="btn">LEARN MORE</a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer" ng-controller="NewsletterController">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-col">
                        <h4>Company</h4>
                        <ul class="footer-links">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Sustainability</a></li>
                            <li><a href="#">Press</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4>Our Store</h4>
                        <ul class="footer-links">
                            <li><a href="#">Store Locator</a></li>
                            <li><a href="#">Gift Cards</a></li>
                            <li><a href="#">Student Discount</a></li>
                            <li><a href="#">Refer a Friend</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4>Customer Care</h4>
                        <ul class="footer-links">
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Shipping & Returns</a></li>
                            <li><a href="#">Track Order</a></li>
                            <li><a href="#">FAQs</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4>Stay in Touch</h4>
                        <form class="search-form" ng-submit="subscribe()">
                            <input type="email" ng-model="email" placeholder="Email Address" class="search-input">
                            <button type="submit" class="search-button">→</button>
                        </form>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; 2023 Garmenique. All Rights Reserved. Terms & Privacy</p>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>
