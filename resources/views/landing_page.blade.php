<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Garmenique - Home</title>
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
                        <li><a href="/" class="nav-item active">HOME</a></li>
                        <li><a href="/catalog" class="nav-item">CATALOG</a></li>
                        <li><a href="/blog" class="nav-item">BLOG</a></li>
                        <li><a href="/about" class="nav-item">ABOUT</a></li>
                        <li><a href="/contact" class="nav-item">CONTACT</a></li>
                    </ul>
                </nav>
                
                @include('partials.nav-icons')
                
                <button class="mobile-toggle" ng-click="toggleNav()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $pageSettings['hero']['backgroundImage'] }}');">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">{{ $pageSettings['hero']['title'] }}</h1>
                    <p class="hero-description">{{ $pageSettings['hero']['subtitle'] }}</p>
                    <a href="{{ $pageSettings['hero']['buttonLink'] }}" class="btn">{{ $pageSettings['hero']['buttonText'] }}</a>
                </div>
            </div>
        </section>

        <!-- Category Section -->
        <section class="category-section">
            <div class="container">
                <h2 class="section-title">{{ $pageSettings['categories']['title'] }}</h2>
                <div class="category-grid">
                    @foreach($pageSettings['categories']['items'] as $category)
                    <div class="category-item">
                        <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" class="category-img">
                        <h3 class="category-name">{{ $category['name'] }}</h3>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Featured Section -->
        <section class="featured-section">
            <div class="container">
                <div class="featured-grid">
                    @foreach($pageSettings['featured']['items'] as $item)
                    <div class="featured-item" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.6)), url('{{ $item['image'] }}');">
                        <div class="featured-content">
                            <h3 class="featured-title">{{ $item['title'] }}</h3>
                            <a href="{{ $item['link'] }}" class="btn">SHOP NOW</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="mission-section" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $pageSettings['mission']['backgroundImage'] }}');">
            <div class="container">
                <h2 class="mission-title">{{ $pageSettings['mission']['title'] }}</h2>
                <a href="{{ $pageSettings['mission']['buttonLink'] }}" class="btn">{{ $pageSettings['mission']['buttonText'] }}</a>
            </div>
        </section>

        <!-- Include Sliding Cart Partial -->
        @include('partials.sliding-cart')

        <!-- Footer -->
        @include('partials.footer')

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/landingpage.js') }}"></script>
        <script src="{{ asset('js/cart.js') }}"></script>
    </body>
</html>