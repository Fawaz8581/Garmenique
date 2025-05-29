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
        
        <style>
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

            /* Hide Angular content until it's loaded */
            [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
                display: none !important;
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
                        <li><a href="/catalog" class="nav-item">CATALOG</a></li>
                        <li><a href="/blog" class="nav-item">BLOG</a></li>
                        <li><a href="/about" class="nav-item active">ABOUT</a></li>
                        <li><a href="/contact" class="nav-item">CONTACT</a></li>
                    </ul>
                </nav>
                
                <div class="nav-icons">
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
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-pinterest"></i></a>
                            </div>
                            
                            <!-- Email Subscription Form -->
                            <div class="email-subscription">
                                <h5>Join Our Newsletter</h5>
                                <p>Get exclusive offers and updates</p>
                                <form class="subscription-form">
                                    <input type="email" placeholder="Your email address" required>
                                    <button type="submit">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; 2025 Garmenique. All rights reserved.</p>
                </div>
            </div>
        </footer>
        
        <!-- Scripts -->
        <script src="{{ asset('js/about.js') }}"></script>
    </body>
</html>