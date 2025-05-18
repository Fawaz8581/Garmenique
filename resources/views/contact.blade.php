<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Contact - Garmenique</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- AngularJS -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
        <link rel="stylesheet" href="{{ asset('css/about.search.css') }}">
        <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
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
                        <li><a href="/" class="nav-item">Home</a></li>
                        <li><a href="#" class="nav-item">Catalog</a></li>
                        <li><a href="#" class="nav-item">Men</a></li>
                        <li><a href="#" class="nav-item">Women</a></li>
                        <li><a href="/blog" class="nav-item">Blog</a></li>
                        <li><a href="/about" class="nav-item">About</a></li>
                        <li><a href="/contact" class="nav-item active">Contact</a></li>
                    </ul>
                </nav>
                
                <div class="nav-icons">
                    <a href="javascript:void(0)" class="nav-icon" ng-click="toggleSearch()"><i class="fas fa-search"></i></a>
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
                            <li><a href="#">BEST SELLERS</a></li>
                            <li><a href="#">CLOTHING</a></li>
                            <li><a href="#">TOPS & SWEATERS</a></li>
                            <li><a href="#">PANTS & JEANS</a></li>
                            <li><a href="#">OUTERWEAR</a></li>
                            <li><a href="#">SHOES & BAGS</a></li>
                            <li><a href="#">SALE</a></li>
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
                <div class="contact-content">
                    <div class="contact-header">
                        <span class="section-subtitle">Contact Us</span>
                        <h1 class="contact-title">Let's talk about<br>your question</h1>
                        <p class="contact-description">Drop us a line through the form below and we'll get back to you</p>
                    </div>
                    
                    <div class="contact-form-container">
                        <form class="contact-form" ng-controller="ContactFormController" ng-submit="submitForm()">
                            <div class="form-row">
                                <div class="form-group">
                                    <input type="text" id="firstName" placeholder="First name*" ng-model="formData.firstName" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="lastName" placeholder="Last name*" ng-model="formData.lastName" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <input type="email" id="email" placeholder="Email address*" ng-model="formData.email" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="jobRole" placeholder="Job role" ng-model="formData.jobRole">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <input type="text" id="companyDomain" placeholder="Company domain" ng-model="formData.companyDomain">
                                </div>
                            </div>
                            
                            <div class="form-group full-width">
                                <textarea id="message" placeholder="Tell us what you're hoping to achieve with Garmenique. We're here to help bring your fashion needs to life!" ng-model="formData.message" rows="5" required></textarea>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn-submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Additional Information Section -->
        <section class="contact-info-section">
            <div class="container">
                <div class="info-grid">
                    <div class="info-item">
                        <h3>Visit Us</h3>
                        <p>Jl. Bogor Raya No. 1</p>
                        <p>Bogor, NY 16110</p>
                    </div>
                    
                    <div class="info-item">
                        <h3>Contact</h3>
                        <p>info@garmenique.com</p>
                        <p>+62 012345678</p>
                    </div>
                    
                    <div class="info-item">
                        <h3>Opening Hours</h3>
                        <p>Mon - Fri: 9:00 AM - 6:00 PM</p>
                        <p>Sat: 10:00 AM - 5:00 PM</p>
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
                            <li><a href="/contact">Contact Us</a></li>
                            <li><a href="#">Shipping & Returns</a></li>
                            <li><a href="#">Track Order</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4>Our Social Media</h4>
                        <div class="social-email-section">
                            <div class="social-icons">
                                <a href="#" class="social-icon-circle"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon-circle"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-icon-circle"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-icon-circle"><i class="fab fa-pinterest"></i></a>
                                <a href="#" class="social-icon-circle"><i class="fab fa-youtube"></i></a>
                            </div>
                            <p class="email-title">Stay in Touch</p>
                            <form class="email-form">
                                <input type="email" placeholder="Email Address" class="email-input" required>
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
        <script src="{{ asset('js/contact.js') }}"></script>
    </body>
</html> 