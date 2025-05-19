<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Garmenique - Blog</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/blog.search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body ng-app="garmeniqueApp" ng-controller="BlogController">
    <!-- Header Section -->
    <header class="header" ng-controller="HeaderController">
        <div class="container nav-container">
            <div class="logo-container">
                <a href="/" class="logo">GARMENIQUE</a>
            </div>
            
            <nav class="main-nav" ng-class="{'active': isNavActive}">
                <ul>
                    <li><a href="/" class="nav-item">Home</a></li>
                    <li><a href="/catalog" class="nav-item">Catalog</a></li>
                    <li><a href="/men" class="nav-item">Men</a></li>
                    <li><a href="/women" class="nav-item">Women</a></li>
                    <li><a href="/blog" class="nav-item active">Blog</a></li>
                    <li><a href="/about" class="nav-item">About</a></li>
                    <li><a href="/contact" class="nav-item">Contact</a></li>
                </ul>
            </nav>
            
            <div class="nav-icons">
                <a href="javascript:void(0)" class="nav-icon" ng-click="toggleSearch()"><i class="fas fa-search"></i></a>
                <a href="/account" class="nav-icon"><i class="fas fa-user"></i></a>
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
    
    <!-- Blog Header Section -->
    <section class="blog-hero">
        <div class="container">
            <div class="blog-header-content">
                <h1>Garmenique</h1>
                <p class="mission-statement">We're on a mission to change the fashion industry.<br>These are the people, stories, and ideas that will help us get there.</p>
            </div>
        </div>
    </section>

    <!-- Latest Articles Section -->
    <section class="blog-latest">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">The Latest</h2>
                <div class="section-title-underline"></div>
            </div>
            
            <!-- Featured Articles Grid (First Row) -->
            <div class="blog-grid">
                <!-- How To Style Winter Whites -->
                <div class="blog-card">
                    <a href="#" class="blog-card-link">
                        <div class="blog-img-container">
                            <img src="https://images.unsplash.com/photo-1603808033192-082d6919d3e1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="How To Style Winter Whites" class="blog-card-img">
                        </div>
                        <div class="blog-card-content">
                            <span class="blog-category">Style</span>
                            <h3 class="blog-title">How To Style Winter Whites</h3>
                        </div>
                    </a>
                </div>
                
                <!-- We Won A Glossy Award -->
                <div class="blog-card">
                    <a href="#" class="blog-card-link">
                        <div class="blog-img-container">
                            <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="We Won A Glossy Award" class="blog-card-img">
                        </div>
                        <div class="blog-card-content">
                            <span class="blog-category">Transparency</span>
                            <h3 class="blog-title">We Won A Glossy Award</h3>
                        </div>
                    </a>
                </div>
                
                <!-- Coordinate Your Style -->
                <div class="blog-card">
                    <a href="#" class="blog-card-link">
                        <div class="blog-img-container">
                            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Coordinate Your Style" class="blog-card-img">
                        </div>
                        <div class="blog-card-content">
                            <span class="blog-category">Style</span>
                            <h3 class="blog-title">Coordinate Your Style: Matching Outfits for Everyone</h3>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Regular Articles Grid (Second Row) -->
            <div class="blog-grid">
                <!-- Black Friday Fund 2023 -->
                <div class="blog-card">
                    <a href="#" class="blog-card-link">
                        <div class="blog-img-container">
                            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Black Friday Fund 2023" class="blog-card-img">
                        </div>
                        <div class="blog-card-content">
                            <span class="blog-category">Transparency</span>
                            <h3 class="blog-title">Black Friday Fund 2023</h3>
                        </div>
                    </a>
                </div>
                
                <!-- What to Wear this Season -->
                <div class="blog-card">
                    <a href="#" class="blog-card-link">
                        <div class="blog-img-container">
                            <img src="https://cdn.mos.cms.futurecdn.net/SJ44Y9266PtpReDDNtWQJJ.jpg" alt="Holiday Outfits & Ideas" class="blog-card-img">
                        </div>
                        <div class="blog-card-content">
                            <span class="blog-category">Style</span>
                            <h3 class="blog-title">What to Wear this Season: Holiday Outfits & Ideas</h3>
                        </div>
                    </a>
                </div>
                
                <!-- Thanksgiving Outfit Ideas -->
                <div class="blog-card">
                    <a href="#" class="blog-card-link">
                        <div class="blog-img-container">
                            <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Thanksgiving Outfit Ideas" class="blog-card-img">
                        </div>
                        <div class="blog-card-content">
                            <span class="blog-category">Style</span>
                            <h3 class="blog-title">Thanksgiving Outfit Ideas</h3>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="#" class="btn-load-more">LOAD MORE ARTICLES</a>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="blog-values">
        <div class="container">
            <div class="values-container">
                <div class="value-item">
                    <div class="value-icon">
                        <img src="{{ asset('images/icons/keep-clean.svg') }}" alt="Keep it Clean">
                    </div>
                    <h3>Keep it Clean</h3>
                </div>
                
                <div class="value-item">
                    <div class="value-icon">
                        <img src="{{ asset('images/icons/do-right.svg') }}" alt="Do right by people">
                    </div>
                    <h3>Do right by people</h3>
                </div>
                
                <div class="value-item">
                    <div class="value-icon">
                        <img src="{{ asset('images/icons/keep-circular.svg') }}" alt="Keep it Circular">
                    </div>
                    <h3>Keep it Circular</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Progress Section -->
    <section class="blog-progress">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">Our Progress</h2>
                <div class="section-title-underline"></div>
            </div>
            
            <div class="progress-grid">
                <!-- Carbon Commitment -->
                <div class="progress-card">
                    <div class="progress-img-container">
                        <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Carbon Commitment" class="progress-img">
                    </div>
                    <h3 class="progress-title">Carbon Commitment</h3>
                </div>
                
                <!-- Environmental Initiatives -->
                <div class="progress-card">
                    <div class="progress-img-container">
                        <img src="https://images.unsplash.com/photo-1556905055-8f358a7a47b2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Environmental Initiatives" class="progress-img">
                    </div>
                    <h3 class="progress-title">Environmental Initiatives</h3>
                </div>
                
                <!-- Better Factories -->
                <div class="progress-card">
                    <div class="progress-img-container">
                        <img src="https://images.unsplash.com/photo-1529720317453-c8da503f2051?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Better Factories" class="progress-img">
                    </div>
                    <h3 class="progress-title">Better Factories</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Media Section -->
    <section class="blog-social">
        <div class="container">
            <h2 class="section-title">Follow us on social for more</h2>
            
            <div class="social-links">
                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fab fa-pinterest-p"></i></a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Shop</h4>
                    <ul class="footer-links">
                        <li><a href="#">Men's</a></li>
                        <li><a href="#">Women's</a></li>
                        <li><a href="#">Accessories</a></li>
                        <li><a href="#">Gift Cards</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Company</h4>
                    <ul class="footer-links">
                        <li><a href="/about">Our Story</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Help</h4>
                    <ul class="footer-links">
                        <li><a href="/contact">Contact Us</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Shipping & Returns</a></li>
                        <li><a href="#">Order Tracking</a></li>
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

    <!-- Bootstrap JS and AngularJS app -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/landingpage.js') }}"></script>
    <script src="{{ asset('js/blog.js') }}"></script>
</body>
</html>
