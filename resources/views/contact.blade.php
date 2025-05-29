<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Garmenique - Contact Us</title>
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
        <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
        <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <style>
            .error-message {
                color: #d9534f;
                font-size: 12px;
                margin-top: 5px;
                text-align: left;
            }
            
            input.ng-touched.ng-invalid, textarea.ng-touched.ng-invalid {
                border-color: #d9534f;
            }
            
            .alert {
                padding: 15px;
                margin-bottom: 20px;
                border: 1px solid transparent;
                border-radius: 4px;
            }
            
            .alert-success {
                color: #3c763d;
                background-color: #dff0d8;
                border-color: #d6e9c6;
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
                        <li><a href="/catalog" class="nav-item">CATALOG</a></li>
                        <li><a href="/blog" class="nav-item">BLOG</a></li>
                        <li><a href="/about" class="nav-item">ABOUT</a></li>
                        <li><a href="/contact" class="nav-item active">CONTACT</a></li>
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
        
        <!-- Contact Section -->
        <section class="contact-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-12">
                        <div class="contact-content text-center">
                            <div class="contact-header">
                                <span class="section-subtitle">{{ $contactSettings['hero']['title'] }}</span>
                                <h1 class="contact-title">{{ $contactSettings['hero']['subtitle'] }}</h1>
                                <p class="contact-description">{{ $contactSettings['hero']['description'] }}</p>
                            </div>
                            
                            @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                            @endif
                            
                            <div class="contact-form-container">
                                <form name="contactForm" class="contact-form" action="{{ route('contact.submit') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group">
                                            <input type="text" id="firstName" name="firstName" placeholder="First name*" required>
                                            @error('firstName')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="lastName" name="lastName" placeholder="Last name*" required>
                                            @error('lastName')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group full-width">
                                            <input type="email" id="email" name="email" placeholder="Email address*" required>
                                            @error('email')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group full-width">
                                        <textarea id="message" name="message" placeholder="{{ $contactSettings['form']['messagePlaceholder'] }}" rows="5" required></textarea>
                                        @error('message')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn-submit">{{ $contactSettings['form']['buttonText'] }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Contact Info Bar -->
        <div class="contact-info-bar">
            <div class="container">
                <div class="info-grid">
                    <div class="info-column">
                        <h3>VISIT US</h3>
                        <p>{{ $contactSettings['info']['address']['line1'] }}</p>
                        <p>{{ $contactSettings['info']['address']['line2'] }}</p>
                    </div>
                    
                    <div class="info-column">
                        <h3>CONTACT</h3>
                        <p>{{ $contactSettings['info']['email'] }}</p>
                        <p>{{ $contactSettings['info']['phone'] }}</p>
                    </div>
                    
                    <div class="info-column">
                        <h3>OPENING HOURS</h3>
                        <p>{{ $contactSettings['info']['hours']['weekdays'] }}</p>
                        <p>{{ $contactSettings['info']['hours']['weekends'] }}</p>
                    </div>
                </div>
            </div>
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
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Sustainability</a></li>
                            <li><a href="#">Press</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4>Our Store</h4>
                        <ul class="footer-links">
                            <li><a href="#">Store Locator</a></li>
                            <li><a href="#">Shipping & Returns</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Gift Cards</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4>Customer Service</h4>
                        <ul class="footer-links">
                            <li><a href="/contact">Contact Us</a></li>
                            <li><a href="#">Track Your Order</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4>Connect With Us</h4>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-pinterest"></i></a>
                        </div>
                        
                        <div class="newsletter">
                            <h5>Join Our Newsletter</h5>
                            <p>Get exclusive offers and updates</p>
                            <form class="newsletter-form">
                                <input type="email" placeholder="Your email address" required>
                                <button type="submit">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; 2025 Garmenique. All rights reserved.</p>
                </div>
            </div>
        </footer>
        
        <!-- Scripts -->
        <script src="{{ asset('js/contact.js') }}"></script>
    </body>
</html>