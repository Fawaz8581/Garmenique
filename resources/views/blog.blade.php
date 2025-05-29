<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Garmenique - Blog</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Premium Clothing Brand">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="images/icons/GarmeniqueLogo.png" type="image/png">

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
    <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
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
        
        .nav-icons {
            flex: 1;
            max-width: 120px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        /* Values Section Styling */
        .blog-values {
            background-color: #f8f9fa;
            padding: 60px 0;
            margin: 40px 0;
        }

        .values-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 900px;
            margin: 0 auto;
        }

        .value-item {
            text-align: center;
            padding: 0 20px;
            transition: transform 0.3s ease;
        }

        .value-item:hover {
            transform: translateY(-5px);
        }

        .value-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .value-icon i {
            color: #14387F !important;
        }

        .value-item h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .values-container {
                flex-direction: column;
                gap: 30px;
            }
        }
    </style>
</head>
<body ng-app="garmeniqueApp" ng-controller="BlogController">
    <!-- Header Section -->
    <header class="header" ng-controller="HeaderController">
        <div class="container nav-container">
            <div class="logo-container">
                <a href="/" class="logo">
                    GARMENIQUE
                </a>
            </div>
            
            <nav class="main-nav" ng-class="{'active': isNavActive}">
                <ul>
                    <li><a href="/" class="nav-item">HOME</a></li>
                    <li><a href="/catalog" class="nav-item">CATALOG</a></li>
                    <li><a href="/blog" class="nav-item active">BLOG</a></li>
                    <li><a href="/about" class="nav-item">ABOUT</a></li>
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
    
    <!-- Blog Header Section -->
    <section class="blog-hero" ng-if="pageSettings.blog.hero.enabled" ng-style="{'background-image': 'url(' + pageSettings.blog.hero.backgroundImage + ')', 'background-size': 'cover', 'background-position': 'center', 'position': 'relative', 'padding': '80px 0', 'color': '#fff'}">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6);"></div>
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto blog-header-content">
                    <h1 style="font-size: 2.8rem; font-weight: 700; margin-bottom: 1.5rem; color: #ffffff; text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">@{{ pageSettings.blog.hero.title }}</h1>
                    <p class="mission-statement" style="font-size: 1.2rem; line-height: 1.8; color: #ffffff; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">@{{ pageSettings.blog.hero.subtitle }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Articles Section -->
    <section class="blog-latest" ng-if="pageSettings.blog.latestArticles.enabled">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">@{{ pageSettings.blog.latestArticles.title }}</h2>
                <div class="section-title-underline"></div>
            </div>
            
            <!-- Featured Articles Grid (First Row) -->
            <div class="blog-grid">
                <div class="blog-card" ng-repeat="article in pageSettings.blog.latestArticles.articles | limitTo:3">
                    <a href="@{{ article.link }}" class="blog-card-link">
                        <div class="blog-img-container">
                            <img ng-src="@{{ article.image }}" alt="@{{ article.title }}" class="blog-card-img">
                        </div>
                        <div class="blog-card-content">
                            <span class="blog-category">@{{ article.category }}</span>
                            <h3 class="blog-title">@{{ article.title }}</h3>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Regular Articles Grid (Second Row) -->
            <div class="blog-grid" ng-if="pageSettings.blog.latestArticles.articles.length > 3">
                <div class="blog-card" ng-repeat="article in pageSettings.blog.latestArticles.articles | limitTo:3:3">
                    <a href="@{{ article.link }}" class="blog-card-link">
                        <div class="blog-img-container">
                            <img ng-src="@{{ article.image }}" alt="@{{ article.title }}" class="blog-card-img">
                        </div>
                        <div class="blog-card-content">
                            <span class="blog-category">@{{ article.category }}</span>
                            <h3 class="blog-title">@{{ article.title }}</h3>
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
    <section class="blog-values" ng-if="pageSettings.blog.values.enabled">
        <div class="container">
            <div class="values-container">
                <div class="value-item" ng-repeat="value in pageSettings.blog.values.items">
                    <div class="value-icon">
                        <img ng-src="@{{ value.iconUrl || getDefaultIconUrl(value.title) }}" alt="@{{ value.title }}" style="width: 40px; height: 40px;">
                    </div>
                    <h3>@{{ value.title }}</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Progress Section -->
    <section class="blog-progress" ng-if="pageSettings.blog.progress.enabled">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">@{{ pageSettings.blog.progress.title }}</h2>
                <div class="section-title-underline"></div>
            </div>
            
            <div class="progress-grid">
                <div class="progress-card" ng-repeat="item in pageSettings.blog.progress.items">
                    <div class="progress-img-container">
                        <img ng-src="@{{ item.image }}" alt="@{{ item.title }}" class="progress-img">
                    </div>
                    <h3 class="progress-title">@{{ item.title }}</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Media Section -->
    <section class="blog-social" ng-if="pageSettings.blog.social.enabled">
        <div class="container">
            <h2 class="section-title">@{{ pageSettings.blog.social.title }}</h2>
            
            <div class="social-links">
                <a ng-repeat="link in pageSettings.blog.social.links" ng-href="@{{ link.url.startsWith('http') ? link.url : 'https://' + link.url }}" class="social-link" target="_blank">
                    <i class="fab" ng-class="'fa-' + link.platform"></i>
                </a>
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
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        // Initialize AngularJS app
        var app = angular.module('garmeniqueApp', []);
        
        // Configure AngularJS to work with Laravel
        app.config(function($interpolateProvider) {
            $interpolateProvider.startSymbol('@{{');
            $interpolateProvider.endSymbol('}}');
        });
        
        // Blog Controller
        app.controller('BlogController', function($scope, $http) {
            // Helper function to get default icon URL based on value title
            $scope.getDefaultIconUrl = function(title) {
                switch(title) {
                    case 'Keep it Clean':
                        return 'https://cdn-icons-png.flaticon.com/512/2313/2313878.png';
                    case 'Do right by people':
                        return 'https://cdn-icons-png.flaticon.com/512/1006/1006657.png';
                    case 'Keep it Circular':
                        return 'https://cdn-icons-png.flaticon.com/512/3299/3299668.png';
                    default:
                        return 'https://cdn-icons-png.flaticon.com/512/3601/3601569.png'; // Default icon
                }
            };
            
            // Default page settings
            $scope.pageSettings = {
                blog: {
                    hero: {
                        enabled: true,
                        title: 'Garmenique',
                        subtitle: 'We\'re on a mission to change the fashion industry. These are the people, stories, and ideas that will help us get there.',
                        backgroundImage: 'https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80'
                    },
                    latestArticles: {
                        enabled: true,
                        title: 'The Latest',
                        articles: [
                            { 
                                title: 'How To Style Winter Whites', 
                                category: 'Style', 
                                image: 'https://images.unsplash.com/photo-1603808033192-082d6919d3e1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                                link: '#'
                            },
                            { 
                                title: 'We Won A Glossy Award', 
                                category: 'Transparency', 
                                image: 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                                link: '#'
                            },
                            { 
                                title: 'Coordinate Your Style: Matching Outfits for Everyone', 
                                category: 'Style', 
                                image: 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                                link: '#'
                            },
                            { 
                                title: 'Black Friday Fund 2023', 
                                category: 'Transparency', 
                                image: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                                link: '#'
                            },
                            { 
                                title: 'What to Wear this Season: Holiday Outfits & Ideas', 
                                category: 'Style', 
                                image: 'https://cdn.mos.cms.futurecdn.net/SJ44Y9266PtpReDDNtWQJJ.jpg',
                                link: '#'
                            },
                            { 
                                title: 'Thanksgiving Outfit Ideas', 
                                category: 'Style', 
                                image: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                                link: '#'
                            }
                        ]
                    },
                    values: {
                        enabled: true,
                        items: [
                            { title: 'Keep it Clean', iconUrl: 'https://cdn-icons-png.flaticon.com/512/2313/2313878.png' },
                            { title: 'Do right by people', iconUrl: 'https://cdn-icons-png.flaticon.com/512/1006/1006657.png' },
                            { title: 'Keep it Circular', iconUrl: 'https://cdn-icons-png.flaticon.com/512/3299/3299668.png' }
                        ]
                    },
                    progress: {
                        enabled: true,
                        title: 'Our Progress',
                        items: [
                            { 
                                title: 'Carbon Commitment', 
                                image: 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                                link: '#'
                            },
                            { 
                                title: 'Environmental Initiatives', 
                                image: 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                                link: '#'
                            },
                            { 
                                title: 'Better Factories', 
                                image: 'https://images.unsplash.com/photo-1529720317453-c8da503f2051?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                                link: '#'
                            }
                        ]
                    },
                    social: {
                        enabled: true,
                        title: 'Follow us on social for more',
                        links: [
                            { platform: 'instagram', url: 'instagram.com/Garmenique' },
                            { platform: 'facebook', url: 'facebook.com/Garmenique' },
                            { platform: 'twitter', url: 'twitter.com/Garmenique' },
                            { platform: 'pinterest', url: 'pinterest.com/Garmenique' }
                        ]
                    }
                }
            };
            
            // Load page settings from the server
            $http.get('/admin/api/page-settings?page=blog')
                .then(function(response) {
                    if (response.data.success && response.data.settings && response.data.settings.blog) {
                        // Merge saved settings with defaults
                        var savedSettings = response.data.settings;
                        
                        // Hero section
                        if (savedSettings.blog.hero) {
                            $scope.pageSettings.blog.hero.enabled = savedSettings.blog.hero.enabled;
                            
                            if (savedSettings.blog.hero.settings) {
                                if (savedSettings.blog.hero.settings.title) {
                                    $scope.pageSettings.blog.hero.title = savedSettings.blog.hero.settings.title;
                                }
                                if (savedSettings.blog.hero.settings.subtitle) {
                                    $scope.pageSettings.blog.hero.subtitle = savedSettings.blog.hero.settings.subtitle;
                                }
                                if (savedSettings.blog.hero.settings.backgroundImage) {
                                    $scope.pageSettings.blog.hero.backgroundImage = savedSettings.blog.hero.settings.backgroundImage;
                                }
                            }
                        }
                        
                        // Latest articles section
                        if (savedSettings.blog.latestArticles) {
                            $scope.pageSettings.blog.latestArticles.enabled = savedSettings.blog.latestArticles.enabled;
                            
                            if (savedSettings.blog.latestArticles.settings) {
                                if (savedSettings.blog.latestArticles.settings.title) {
                                    $scope.pageSettings.blog.latestArticles.title = savedSettings.blog.latestArticles.settings.title;
                                }
                                if (savedSettings.blog.latestArticles.settings.articles && savedSettings.blog.latestArticles.settings.articles.length > 0) {
                                    $scope.pageSettings.blog.latestArticles.articles = savedSettings.blog.latestArticles.settings.articles;
                                }
                            }
                        }
                        
                        // Values section
                        if (savedSettings.blog.values) {
                            $scope.pageSettings.blog.values.enabled = savedSettings.blog.values.enabled;
                            
                            if (savedSettings.blog.values.settings && savedSettings.blog.values.settings.items && savedSettings.blog.values.settings.items.length > 0) {
                                $scope.pageSettings.blog.values.items = savedSettings.blog.values.settings.items;
                            }
                        }
                        
                        // Progress section
                        if (savedSettings.blog.progress) {
                            $scope.pageSettings.blog.progress.enabled = savedSettings.blog.progress.enabled;
                            
                            if (savedSettings.blog.progress.settings) {
                                if (savedSettings.blog.progress.settings.title) {
                                    $scope.pageSettings.blog.progress.title = savedSettings.blog.progress.settings.title;
                                }
                                if (savedSettings.blog.progress.settings.items && savedSettings.blog.progress.settings.items.length > 0) {
                                    $scope.pageSettings.blog.progress.items = savedSettings.blog.progress.settings.items;
                                }
                            }
                        }
                        
                        // Social section
                        if (savedSettings.blog.social) {
                            $scope.pageSettings.blog.social.enabled = savedSettings.blog.social.enabled;
                            
                            if (savedSettings.blog.social.settings) {
                                if (savedSettings.blog.social.settings.title) {
                                    $scope.pageSettings.blog.social.title = savedSettings.blog.social.settings.title;
                                }
                                if (savedSettings.blog.social.settings.links && savedSettings.blog.social.settings.links.length > 0) {
                                    $scope.pageSettings.blog.social.links = savedSettings.blog.social.settings.links;
                                }
                            }
                        }
                    }
                })
                .catch(function(error) {
                    console.error('Error loading page settings:', error);
                });
        });
        
        // Header Controller
        app.controller('HeaderController', function($scope) {
            $scope.isNavActive = false;
            
            $scope.toggleNav = function() {
                $scope.isNavActive = !$scope.isNavActive;
            };
        });
        
        // Search Controller
        app.controller('SearchController', function($scope) {
            $scope.isSearchActive = false;
            $scope.searchQuery = '';
            
            $scope.popularCategories = [
                { name: 'TOPS', image: 'https://images.unsplash.com/photo-1562157873-818bc0726f68?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80', isHovered: false },
                { name: 'PANTS', image: 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80', isHovered: false },
                { name: 'DRESSES', image: 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80', isHovered: false },
                { name: 'OUTERWEAR', image: 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80', isHovered: false }
            ];
            
            $scope.openSearch = function() {
                $scope.isSearchActive = true;
            };
            
            $scope.closeSearch = function() {
                $scope.isSearchActive = false;
                $scope.searchQuery = '';
            };
            
            $scope.hover = function(category) {
                category.isHovered = true;
            };
            
            $scope.unhover = function(category) {
                category.isHovered = false;
            };
        });
    </script>
</body>
</html>