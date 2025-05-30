<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="garmeniqueApp" ng-cloak>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Garmenique - Blog</title>
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
        <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
        <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <style>
            /* Angular JS cloak - hide angular bindings until loaded */
            [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
                display: none !important;
            }
            
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
            
            /* Cart icon specific styling */
            .cart-icon {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* Mobile toggle button styling */
            .mobile-menu-btn {
                display: none;
            }
            
            @media (max-width: 991px) {
                .mobile-menu-btn {
                    display: block;
                }
            }
            
            .mobile-toggle {
                display: block;
                background: transparent;
                border: none;
                cursor: pointer;
                padding: 0;
                z-index: 102;
                position: relative;
                width: 30px;
                height: 24px;
            }
            
            .toggle-bar {
                display: block;
                width: 100%;
                height: 2px;
                background-color: #333;
                margin: 5px 0;
                transition: all 0.3s ease;
            }
            
            @media (max-width: 991px) {
                .mobile-toggle {
                    display: block;
                }
                
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

            /* Blog-specific styles */
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
    <body ng-controller="BlogController">
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
                        <li><a href="/blog" class="nav-item active">BLOG</a></li>
                        <li><a href="/about" class="nav-item">ABOUT</a></li>
                        <li><a href="/contact" class="nav-item">CONTACT</a></li>
                    </ul>
                </nav>
                
                <div class="nav-icons">
                    <a href="{{ route('user.messages') }}" class="nav-icon"><i class="fas fa-envelope"></i></a>
                    @include('partials.account-dropdown')
                    <a href="javascript:void(0)" class="nav-icon cart-icon" ng-click="openCartPanel()">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
                
                <div class="mobile-menu-btn">
                    <button type="button" class="mobile-toggle" ng-click="toggleNav()">
                        <span class="toggle-bar"></span>
                        <span class="toggle-bar"></span>
                        <span class="toggle-bar"></span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Blog Header Section -->
        <section class="blog-hero ng-cloak" ng-if="pageSettings.blog.hero.enabled" ng-style="{'background-image': 'url(' + pageSettings.blog.hero.backgroundImage + ')', 'background-size': 'cover', 'background-position': 'center', 'position': 'relative', 'padding': '80px 0', 'color': '#fff'}">
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
        <section class="blog-latest ng-cloak" ng-if="pageSettings.blog.latestArticles.enabled">
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
            </div>
        </section>

        <!-- Values Section -->
        <section class="blog-values ng-cloak" ng-if="pageSettings.blog.values.enabled">
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
        <section class="blog-progress ng-cloak" ng-if="pageSettings.blog.progress.enabled">
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
        <section class="blog-social ng-cloak" ng-if="pageSettings.blog.social.enabled">
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
        @include('partials.footer')

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        <script src="{{ asset('js/landingpage.js') }}"></script>
        <script src="{{ asset('js/cart.js') }}"></script>
        
        <script>
            // Initialize Angular module if it doesn't exist yet
            if (typeof angular !== 'undefined') {
                if (!angular.module('garmeniqueApp', false)) {
                    angular.module('garmeniqueApp', []);
                }
            }
            
            // Blog Controller
            (function() {
                // Use existing Angular module
                var app = angular.module('garmeniqueApp');
                
                // Blog Controller
                app.controller('BlogController', ['$scope', '$http', function($scope, $http) {
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
                }]);
            })();
            
            // Additional script to ensure mobile toggle works correctly
            document.addEventListener('DOMContentLoaded', function() {
                // Fix any potential issues with the mobile toggle button
                const mobileToggleBtn = document.querySelector('.mobile-toggle');
                if (mobileToggleBtn) {
                    mobileToggleBtn.innerHTML = `
                        <span class="toggle-bar"></span>
                        <span class="toggle-bar"></span>
                        <span class="toggle-bar"></span>
                    `;
                }
            });
        </script>
    </body>
</html>