<!DOCTYPE html>
<html lang="en" ng-app="garmeniqueAdmin">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Garmenique - Admin Customizes</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Admin Customizes">
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    
    <!-- AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    
    <style>
        /* Custom styles for the admin interface */
        .preview-container {
            max-width: 100%;
            margin: 0 auto;
            border: 1px solid #ddd;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* Hero Section */
        .hero-section {
            position: relative;
            height: 500px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-position: center;
            background-size: cover;
            padding: 0;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            padding: 0 20px;
        }
        
        .hero-title {
            font-size: 3.5rem;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 1.5rem;
            letter-spacing: 2px;
        }
        
        .hero-subtitle {
            margin-bottom: 2rem;
            font-size: 1.1rem;
            line-height: 1.6;
            font-weight: 400;
            padding: 0 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #fff;
            color: #000;
            border: none;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            text-decoration: none;
            border-radius: 0;
        }
        
        /* Category Section */
        .category-section {
            padding: 40px 15px;
            text-align: center;
        }
        
        .section-title {
            position: relative;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 30px;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background-color: #333;
        }
        
        .category-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .category-item {
            text-align: center;
        }
        
        .category-img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            margin-bottom: 10px;
        }
        
        .category-name {
            font-size: 0.8rem;
            text-transform: uppercase;
            font-weight: 600;
        }
        
        /* Featured Section */
        .featured-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .featured-item {
            position: relative;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background-position: center;
            background-size: cover;
        }
        
        .featured-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.6));
            z-index: 1;
        }
        
        .featured-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }
        
        .featured-title {
            font-size: 1rem;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        /* Mission Section */
        .mission-section {
            position: relative;
            height: 200px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-position: center;
            background-size: cover;
            padding: 20px;
        }
        
        .mission-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }
        
        .mission-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }
        
        .mission-title {
            font-size: 1.5rem;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        /* Footer */
        .footer {
            background-color: #1a1a1a;
            color: white;
            padding: 40px 15px 20px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .footer-col h4 {
            font-size: 1rem;
            text-transform: uppercase;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #ccc;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-icons {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .social-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .social-icon:hover {
            background-color: #555;
        }
        
        .email-form {
            display: flex;
            margin-top: 15px;
        }
        
        .email-input {
            flex: 1;
            padding: 8px 12px;
            border: none;
            background-color: #333;
            color: white;
        }
        
        .email-button {
            background-color: #555;
            border: none;
            color: white;
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .email-button:hover {
            background-color: #666;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #333;
            font-size: 0.9rem;
            color: #999;
        }
        
        .control-card {
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .control-card h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body ng-controller="CustomizeController">
    <!-- Mobile Menu Toggle -->
    <button class="menu-toggle d-lg-none" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-logo"><img src="{{ asset('images/icons/GarmeniqueLogo.png') }}" alt="Garmenique Logo" style="width: 100%; height: 100%; object-fit: contain;"></div>
            <div class="brand-text">GARMENIQUE</div>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-box"></i>
                <span>Products</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-tags"></i>
                <span>Categories</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-ruler"></i>
                <span>Sizes</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-envelope"></i>
                <span>Messages</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </li>
            <li class="menu-item active">
                <i class="fas fa-paint-brush"></i>
                <span>Customizes</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h1 class="page-title">Customize Your Website</h1>
            
            <div class="user-section">
                <div class="user-info">
                    <h4 class="user-name">Garmenique</h4>
                    <p class="user-role">Admin</p>
                </div>
            </div>
        </div>
        
        <!-- Page Tabs -->
        <div class="mb-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $page == 'homepage' ? 'active' : '' }}" href="{{ route('admin.customizes', 'homepage') }}">Homepage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $page == 'blog' ? 'active' : '' }}" href="{{ route('admin.customizes', 'blog') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $page == 'about' ? 'active' : '' }}" href="{{ route('admin.customizes', 'about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $page == 'contact' ? 'active' : '' }}" href="{{ route('admin.customizes', 'contact') }}">Contact</a>
                </li>
            </ul>
        </div>
        
        <div class="row">
            <!-- Left Column: Controls -->
            <div class="col-lg-6 mb-4">
                <!-- Hero Section Controls -->
                <div class="control-card">
                    <h3>Hero Section</h3>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="heroToggle" ng-model="site.hero.enabled">
                        <label class="form-check-label" for="heroToggle">Show Hero Section</label>
                    </div>
                    
                    <div class="mb-3">
                        <label for="heroTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="heroTitle" ng-model="site.hero.title">
                    </div>
                    
                    <div class="mb-3">
                        <label for="heroSubtitle" class="form-label">Subtitle</label>
                        <textarea class="form-control" id="heroSubtitle" rows="3" ng-model="site.hero.subtitle"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="heroBackground" class="form-label">Background Image</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="heroBackground" ng-model="site.hero.backgroundImage">
                            <button class="btn btn-outline-secondary" type="button">Browse</button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="heroButtonText" class="form-label">Button Text</label>
                        <input type="text" class="form-control" id="heroButtonText" ng-model="site.hero.buttonText">
                    </div>
                    
                    <div class="mb-3">
                        <label for="heroButtonLink" class="form-label">Button Link</label>
                        <input type="text" class="form-control" id="heroButtonLink" ng-model="site.hero.buttonLink">
                    </div>
                </div>
                
                <!-- Categories Section Controls -->
                <div class="control-card">
                    <h3>Shop By Category Section</h3>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="categoryToggle" ng-model="site.categories.enabled">
                        <label class="form-check-label" for="categoryToggle">Show Categories Section</label>
                    </div>
                    
                    <div class="mb-3">
                        <label for="categoryTitle" class="form-label">Section Title</label>
                        <input type="text" class="form-control" id="categoryTitle" ng-model="site.categories.title">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Categories (Max 5)</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Link</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="category in site.categories.items">
                                        <td>
                                            <input type="text" class="form-control form-control-sm" ng-model="category.name">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" ng-model="category.image">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" ng-model="category.link">
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-danger" ng-click="removeCategory($index)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-sm btn-outline-primary" ng-click="addCategory()" ng-disabled="site.categories.items.length >= 5">
                            <i class="fas fa-plus"></i> Add Category
                        </button>
                        <small class="text-muted">Maximum 5 categories</small>
                    </div>
                </div>
                
                <!-- Featured Section Controls -->
                <div class="control-card">
                    <h3>Featured Collections</h3>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="featuredToggle" ng-model="site.featured.enabled">
                        <label class="form-check-label" for="featuredToggle">Show Featured Section</label>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Featured Items</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Link</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in site.featured.items">
                                        <td>
                                            <input type="text" class="form-control form-control-sm" ng-model="item.title">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" ng-model="item.image">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" ng-model="item.link">
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-danger" ng-click="removeFeatured($index)">
                                                <i class="fas fa-trash"></i>
                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-sm btn-outline-primary" ng-click="addFeatured()">
                            <i class="fas fa-plus"></i> Add Featured Item
                            </button>
                    </div>
                </div>
                
                <!-- Mission Section Controls -->
                <div class="control-card">
                    <h3>Mission Section</h3>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="missionToggle" ng-model="site.mission.enabled">
                        <label class="form-check-label" for="missionToggle">Show Mission Section</label>
                    </div>
                    
                    <div class="mb-3">
                        <label for="missionTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="missionTitle" ng-model="site.mission.title">
                    </div>
                    
                    <div class="mb-3">
                        <label for="missionBackground" class="form-label">Background Image</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="missionBackground" ng-model="site.mission.backgroundImage">
                            <button class="btn btn-outline-secondary" type="button">Browse</button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="missionButtonText" class="form-label">Button Text</label>
                        <input type="text" class="form-control" id="missionButtonText" ng-model="site.mission.buttonText">
                    </div>
                    
                    <div class="mb-3">
                        <label for="missionButtonLink" class="form-label">Button Link</label>
                        <input type="text" class="form-control" id="missionButtonLink" ng-model="site.mission.buttonLink">
                    </div>
                </div>
                
                <!-- Save Changes Button -->
                <div class="text-end mb-4">
                    <button class="btn btn-danger me-2" ng-click="confirmReset()">
                        <i class="fas fa-undo me-1"></i> Reset to Default
                    </button>
                    <button class="btn btn-primary" ng-click="saveChanges()">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </div>
            
            <!-- Right Column: Preview -->
            <div class="col-lg-6">
                <div class="preview-container">
                    <!-- Hero Section -->
                    <div class="hero-section" ng-if="site.hero.enabled" ng-style="{'background-image': 'url(' + site.hero.backgroundImage + ')'}">
                        <div class="container">
                            <div class="hero-content">
                                <h1 class="hero-title">{% site.hero.title %}</h1>
                                <p class="hero-subtitle">{% site.hero.subtitle %}</p>
                                <a href="#" class="btn">{% site.hero.buttonText %}</a>
                            </div>
                                    </div>
                                </div>
                    
                    <!-- Shop by Category Section -->
                    <div class="category-section" ng-if="site.categories.enabled">
                        <h2 class="section-title">{% site.categories.title %}</h2>
                        
                        <div class="category-grid">
                            <div class="category-item" ng-repeat="category in site.categories.items">
                                <img ng-src="{% category.image %}" class="category-img" alt="{% category.name %}">
                                <div class="category-name">{% category.name %}</div>
                            </div>
                        </div>
                        
                        <!-- Featured Collections -->
                        <div class="featured-grid" ng-if="site.featured.enabled">
                            <div class="featured-item" ng-repeat="item in site.featured.items" ng-style="{'background-image': 'url(' + item.image + ')'}">
                                <div class="featured-content">
                                    <h3 class="featured-title">{% item.title %}</h3>
                                    <button class="btn btn-light btn-sm">SHOP NOW</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mission Section -->
                    <div class="mission-section" ng-if="site.mission.enabled" ng-style="{'background-image': 'url(' + site.mission.backgroundImage + ')'}">
                        <div class="mission-content">
                            <h2 class="mission-title">{% site.mission.title %}</h2>
                            <button class="btn btn-light">{% site.mission.buttonText %}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AngularJS App -->
    <script>
        var app = angular.module('garmeniqueAdmin', []);
        
        app.config(function($interpolateProvider) {
            // Change Angular's default brackets to avoid conflict with Laravel Blade
            $interpolateProvider.startSymbol('{%');
            $interpolateProvider.endSymbol('%}');
        });
        
        app.controller('CustomizeController', function($scope, $http) {
            // Current page being edited
            $scope.currentPage = '{{ $page }}';
            
            // Initialize the site data with default values
            $scope.site = {
                hero: {
                    enabled: true,
                    title: 'GARMENIQUE',
                    subtitle: 'Elegance in every stitch. Premium clothing crafted for those who appreciate quality and style.',
                    backgroundImage: 'https://images.unsplash.com/photo-1490725263030-1f0521cec8ec?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                    buttonText: 'SHOP NOW',
                    buttonLink: '/catalog'
                },
                categories: {
                    enabled: true,
                    title: 'SHOP BY CATEGORY',
                    items: [
                        { name: 'JACKETS', image: 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80', link: '/catalog?category=jackets' },
                        { name: 'VESTS', image: 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80', link: '/catalog?category=vests' },
                        { name: 'PANTS', image: 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80', link: '/catalog?category=pants' },
                        { name: 'SWEATERS', image: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80', link: '/catalog?category=sweaters' },
                        { name: 'OUTERWEAR', image: 'https://images.unsplash.com/photo-1564584217132-2271feaeb3c5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80', link: '/catalog?category=outerwear' }
                    ]
                },
                featured: {
                    enabled: true,
                    items: [
                        { title: 'NEW ARRIVALS', image: 'https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80', link: '/catalog?collection=new' },
                        { title: 'BEST SELLERS', image: 'https://images.unsplash.com/photo-1485125639709-a60c3a500bf1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80', link: '/catalog?collection=best' },
                        { title: 'THE HOLIDAY OUTFIT', image: 'https://images.unsplash.com/photo-1543076447-215ad9ba6923?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80', link: '/catalog?collection=holiday' }
                    ]
                },
                mission: {
                    enabled: true,
                    title: 'WE\'RE ON A MISSION TO CLEAN UP THE INDUSTRY',
                    backgroundImage: 'https://images.unsplash.com/photo-1553413077-190dd305871c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=70',
                    buttonText: 'LEARN MORE',
                    buttonLink: '/about'
                }
            };

            // Store default settings for reset functionality
            $scope.defaultSettings = JSON.parse(JSON.stringify($scope.site));

            // Load settings from database
            $scope.loadSettings = function() {
                $http.get('/admin/api/page-settings?page=' + $scope.currentPage)
                    .then(function(response) {
                        if (response.data.success && response.data.settings) {
                            // Merge saved settings with defaults
                            var savedSettings = response.data.settings;
                            
                            // Update each section if it exists in saved settings
                            if (savedSettings.hero) {
                                $scope.site.hero.enabled = savedSettings.hero.enabled;
                                
                                // Apply saved settings
                                if (savedSettings.hero.settings) {
                                    if (savedSettings.hero.settings.title) {
                                        $scope.site.hero.title = savedSettings.hero.settings.title;
                                    }
                                    if (savedSettings.hero.settings.subtitle) {
                                        $scope.site.hero.subtitle = savedSettings.hero.settings.subtitle;
                                    }
                                    if (savedSettings.hero.settings.backgroundImage) {
                                        $scope.site.hero.backgroundImage = savedSettings.hero.settings.backgroundImage;
                                    }
                                    if (savedSettings.hero.settings.buttonText) {
                                        $scope.site.hero.buttonText = savedSettings.hero.settings.buttonText;
                                    }
                                    if (savedSettings.hero.settings.buttonLink) {
                                        $scope.site.hero.buttonLink = savedSettings.hero.settings.buttonLink;
                                    }
                                }
                            }
                            
                            if (savedSettings.categories) {
                                $scope.site.categories.enabled = savedSettings.categories.enabled;
                                
                                // Apply saved settings
                                if (savedSettings.categories.settings) {
                                    if (savedSettings.categories.settings.title) {
                                        $scope.site.categories.title = savedSettings.categories.settings.title;
                                    }
                                    if (savedSettings.categories.settings.items && savedSettings.categories.settings.items.length > 0) {
                                        $scope.site.categories.items = savedSettings.categories.settings.items;
                                    }
                                }
                            }
                            
                            if (savedSettings.featured) {
                                $scope.site.featured.enabled = savedSettings.featured.enabled;
                                
                                // Apply saved settings
                                if (savedSettings.featured.settings && savedSettings.featured.settings.items && savedSettings.featured.settings.items.length > 0) {
                                    $scope.site.featured.items = savedSettings.featured.settings.items;
                                }
                            }
                            
                            if (savedSettings.mission) {
                                $scope.site.mission.enabled = savedSettings.mission.enabled;
                                
                                // Apply saved settings
                                if (savedSettings.mission.settings) {
                                    if (savedSettings.mission.settings.title) {
                                        $scope.site.mission.title = savedSettings.mission.settings.title;
                                    }
                                    if (savedSettings.mission.settings.backgroundImage) {
                                        $scope.site.mission.backgroundImage = savedSettings.mission.settings.backgroundImage;
                                    }
                                    if (savedSettings.mission.settings.buttonText) {
                                        $scope.site.mission.buttonText = savedSettings.mission.settings.buttonText;
                                    }
                                    if (savedSettings.mission.settings.buttonLink) {
                                        $scope.site.mission.buttonLink = savedSettings.mission.settings.buttonLink;
                                    }
                                }
                            }
                        }
                    })
                    .catch(function(error) {
                        console.error('Error loading settings:', error);
                    });
            };
            
            // Function to add a new category
            $scope.addCategory = function() {
                if ($scope.site.categories.items.length < 5) {
                    $scope.site.categories.items.push({
                        name: 'NEW CATEGORY',
                        image: 'https://via.placeholder.com/300x300',
                        link: '/catalog?category=new'
                    });
                }
            };
            
            // Function to remove a category
            $scope.removeCategory = function(index) {
                $scope.site.categories.items.splice(index, 1);
            };
            
            // Function to add a featured item
            $scope.addFeatured = function() {
                $scope.site.featured.items.push({
                    title: 'NEW COLLECTION',
                    image: 'https://via.placeholder.com/600x400',
                    link: '/catalog?collection=new'
                });
            };
            
            // Function to remove a featured item
            $scope.removeFeatured = function(index) {
                $scope.site.featured.items.splice(index, 1);
            };
            
            // Function to save changes
            $scope.saveChanges = function() {
                // Prepare data for saving
                var settingsToSave = {
                    hero: {
                        enabled: $scope.site.hero.enabled,
                        settings: {
                            title: $scope.site.hero.title,
                            subtitle: $scope.site.hero.subtitle,
                            backgroundImage: $scope.site.hero.backgroundImage,
                            buttonText: $scope.site.hero.buttonText,
                            buttonLink: $scope.site.hero.buttonLink
                        }
                    },
                    categories: {
                        enabled: $scope.site.categories.enabled,
                        settings: {
                            title: $scope.site.categories.title,
                            items: $scope.site.categories.items
                        }
                    },
                    featured: {
                        enabled: $scope.site.featured.enabled,
                        settings: {
                            items: $scope.site.featured.items
                        }
                    },
                    mission: {
                        enabled: $scope.site.mission.enabled,
                        settings: {
                            title: $scope.site.mission.title,
                            backgroundImage: $scope.site.mission.backgroundImage,
                            buttonText: $scope.site.mission.buttonText,
                            buttonLink: $scope.site.mission.buttonLink
                        }
                    }
                };
                
                // Send to server
                $http.post('/admin/api/page-settings', {
                    page: $scope.currentPage,
                    settings: settingsToSave
                })
                .then(function(response) {
                    if (response.data.success) {
                        alert('Your changes have been saved successfully!');
                    } else {
                        alert('Error: ' + (response.data.message || 'Unknown error'));
                    }
                })
                .catch(function(error) {
                    console.error('Error saving settings:', error);
                    alert('Error saving settings. Please try again.');
                });
            };
            
            // Function to confirm reset
            $scope.confirmReset = function() {
                if (confirm('Are you sure you want to reset all settings to default? This will remove all customizations you have made.')) {
                    $scope.resetToDefault();
                }
            };
            
            // Function to reset settings to default
            $scope.resetToDefault = function() {
                // Reset all settings to default
                $scope.site = JSON.parse(JSON.stringify($scope.defaultSettings));
                
                // If we're on the homepage, also delete settings from database
                if ($scope.currentPage === 'homepage') {
                    $http.post('/admin/api/page-settings', {
                        page: $scope.currentPage,
                        settings: {
                            hero: {
                                enabled: $scope.site.hero.enabled,
                                settings: {
                                    title: $scope.site.hero.title,
                                    subtitle: $scope.site.hero.subtitle,
                                    backgroundImage: $scope.site.hero.backgroundImage,
                                    buttonText: $scope.site.hero.buttonText,
                                    buttonLink: $scope.site.hero.buttonLink
                                }
                            },
                            categories: {
                                enabled: $scope.site.categories.enabled,
                                settings: {
                                    title: $scope.site.categories.title,
                                    items: $scope.site.categories.items
                                }
                            },
                            featured: {
                                enabled: $scope.site.featured.enabled,
                                settings: {
                                    items: $scope.site.featured.items
                                }
                            },
                            mission: {
                                enabled: $scope.site.mission.enabled,
                                settings: {
                                    title: $scope.site.mission.title,
                                    backgroundImage: $scope.site.mission.backgroundImage,
                                    buttonText: $scope.site.mission.buttonText,
                                    buttonLink: $scope.site.mission.buttonLink
                                }
                            }
                        }
                    })
                    .then(function(response) {
                        if (response.data.success) {
                            alert('Settings have been reset to default successfully!');
                        } else {
                            alert('Error: ' + (response.data.message || 'Unknown error'));
                        }
                    })
                    .catch(function(error) {
                        console.error('Error resetting settings:', error);
                        alert('Error resetting settings. Please try again.');
                    });
                }
            };
            
            // Mobile sidebar toggle
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('active');
            });
            
            // Load settings when controller initializes
            $scope.loadSettings();
        });
    </script>
</body>
</html> 