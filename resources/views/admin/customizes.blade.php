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
        
        /* Brand link styles */
        .brand-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: inherit;
        }
        
        .brand-link:hover {
            color: inherit;
            opacity: 0.9;
        }
        
        /* Sidebar menu link styles */
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            color: inherit;
            text-decoration: none;
            width: 100%;
        }
        
        .sidebar-menu li a i {
            margin-right: 15px;
            font-size: 1.2rem;
        }

        /* Blog Preview Styles */
        .blog-preview {
            max-height: 600px;
            overflow-y: auto;
        }

        .blog-preview .blog-hero {
            background-color: #f8f9fa;
            padding: 40px 0;
            text-align: center;
        }

        .blog-preview .blog-header-content {
            padding: 20px 0;
            text-align: center;
        }

        .blog-preview .blog-header-content h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .blog-preview .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .blog-preview .blog-card {
            position: relative;
        }

        .blog-preview .blog-img-container {
            margin-bottom: 15px;
            position: relative;
            overflow: hidden;
            padding-top: 75%;
        }

        .blog-preview .blog-card-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blog-preview .blog-category {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #777;
        }

        .blog-preview .blog-title {
            font-size: 1rem;
            margin-top: 5px;
        }

        .blog-preview .values-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .blog-preview .value-item {
            text-align: center;
            padding: 0 15px;
        }

        .blog-preview .value-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
        }

        .blog-preview .value-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .blog-preview .progress-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .blog-preview .progress-card {
            text-align: center;
        }

        .blog-preview .progress-img-container {
            margin-bottom: 15px;
            position: relative;
            overflow: hidden;
            padding-top: 75%;
        }

        .blog-preview .progress-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blog-preview .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .blog-preview .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
        }
        
        /* Hero Section */
        .hero-section {
            position: relative;
            height: 500px;
            color: white;
            text-align: center;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            padding: 0 20px;
        }
        
        .hero-title {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        
        /* Category Section */
        .category-section {
            padding: 50px 20px;
            text-align: center;
        }
        
        .category-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-top: 30px;
        }
        
        .category-item {
            position: relative;
            cursor: pointer;
            overflow: hidden;
            aspect-ratio: 1;
        }
        
        .category-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .category-name {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            font-weight: bold;
        }
        
        .category-item:hover .category-img {
            transform: scale(1.05);
        }
        
        /* Featured Grid */
        .featured-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 50px;
        }
        
        .featured-item {
            position: relative;
            height: 200px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow: hidden;
        }
        
        .featured-item::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            transition: background-color 0.3s ease;
        }
        
        .featured-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        
        .featured-title {
            font-size: 1.2rem;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .featured-item:hover::before {
            background-color: rgba(0, 0, 0, 0.6);
        }
        
        /* Mission Section */
        .mission-section {
            height: 300px;
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            margin-top: 50px;
        }
        
        .mission-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .mission-content {
            position: relative;
            z-index: 1;
            max-width: 600px;
            padding: 0 20px;
        }
        
        .mission-title {
            font-size: 1.8rem;
            margin-bottom: 20px;
            font-weight: bold;
            line-height: 1.4;
        }
        
        /* Control Card */
        .control-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .control-card h3 {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .category-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .featured-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .featured-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .category-grid {
                grid-template-columns: 1fr;
            }
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
            <div class="brand-text"><a href="/" style="text-decoration: none; color: inherit;">GARMENIQUE</a></div>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.products') }}">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.categories') }}">
                    <i class="fas fa-tags"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.sizes') }}">
                    <i class="fas fa-ruler"></i>
                    <span>Sizes</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.messages') }}">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.settings') }}">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="{{ route('admin.customizes') }}">
                    <i class="fas fa-paint-brush"></i>
                    <span>Customizes</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
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
                <!-- Homepage Controls -->
                <div ng-if="currentPage === 'homepage'">
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
                </div>
                
                <!-- Blog Controls -->
                <div ng-if="currentPage === 'blog'">
                    <!-- Blog Hero Section Controls -->
                    <div class="control-card">
                        <h3>Blog Hero Section</h3>
                        
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="blogHeroToggle" ng-model="site.blog.hero.enabled">
                            <label class="form-check-label" for="blogHeroToggle">Show Blog Hero Section</label>
                        </div>
                        
                        <div class="mb-3">
                            <label for="blogHeroTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="blogHeroTitle" ng-model="site.blog.hero.title">
                        </div>
                        
                        <div class="mb-3">
                            <label for="blogHeroSubtitle" class="form-label">Subtitle</label>
                            <textarea class="form-control" id="blogHeroSubtitle" rows="3" ng-model="site.blog.hero.subtitle"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="blogHeroBackground" class="form-label">Background Image</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="blogHeroBackground" ng-model="site.blog.hero.backgroundImage">
                                <button class="btn btn-outline-secondary" type="button">Browse</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Latest Articles Section Controls -->
                    <div class="control-card">
                        <h3>Latest Articles Section</h3>
                        
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="latestArticlesToggle" ng-model="site.blog.latestArticles.enabled">
                            <label class="form-check-label" for="latestArticlesToggle">Show Latest Articles Section</label>
                        </div>
                        
                        <div class="mb-3">
                            <label for="latestArticlesTitle" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="latestArticlesTitle" ng-model="site.blog.latestArticles.title">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Featured Articles</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Image</th>
                                            <th>Link</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="article in site.blog.latestArticles.articles">
                                            <td>
                                                <input type="text" class="form-control form-control-sm" ng-model="article.title">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" ng-model="article.category">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" ng-model="article.image">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" ng-model="article.link">
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" ng-click="removeArticle($index)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" ng-click="addArticle()">
                                <i class="fas fa-plus"></i> Add Article
                            </button>
                        </div>
                    </div>
                    
                    <!-- Values Section Controls -->
                    <div class="control-card">
                        <h3>Values Section</h3>
                        
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="valuesToggle" ng-model="site.blog.values.enabled">
                            <label class="form-check-label" for="valuesToggle">Show Values Section</label>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Value Items</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Icon</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="value in site.blog.values.items">
                                            <td>
                                                <input type="text" class="form-control form-control-sm" ng-model="value.title">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" ng-model="value.iconUrl" placeholder="Icon URL">
                                                <div style="width: 80px; height: 80px; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; background-color: #fff; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                                    <img ng-src="{% value.iconUrl || getDefaultIconUrl(value.title) %}" alt="{% value.title %}" style="width: 40px; height: 40px;">
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" ng-click="removeValue($index)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" ng-click="addValue()">
                                <i class="fas fa-plus"></i> Add Value
                            </button>
                        </div>
                    </div>
                    
                    <!-- Progress Section Controls -->
                    <div class="control-card">
                        <h3>Progress Section</h3>
                        
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="progressToggle" ng-model="site.blog.progress.enabled">
                            <label class="form-check-label" for="progressToggle">Show Progress Section</label>
                        </div>
                        
                        <div class="mb-3">
                            <label for="progressTitle" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="progressTitle" ng-model="site.blog.progress.title">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Progress Items</label>
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
                                        <tr ng-repeat="item in site.blog.progress.items">
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
                                                <button class="btn btn-sm btn-outline-danger" ng-click="removeProgressItem($index)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" ng-click="addProgressItem()">
                                <i class="fas fa-plus"></i> Add Progress Item
                            </button>
                        </div>
                    </div>
                    
                    <!-- Social Media Section Controls -->
                    <div class="control-card">
                        <h3>Social Media Section</h3>
                        
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="socialToggle" ng-model="site.blog.social.enabled">
                            <label class="form-check-label" for="socialToggle">Show Social Media Section</label>
                        </div>
                        
                        <div class="mb-3">
                            <label for="socialTitle" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="socialTitle" ng-model="site.blog.social.title">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Social Links</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Platform</th>
                                            <th>URL</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="link in site.blog.social.links">
                                            <td>
                                                <select class="form-select form-select-sm" ng-model="link.platform">
                                                    <option value="instagram">Instagram</option>
                                                    <option value="facebook">Facebook</option>
                                                    <option value="twitter">Twitter</option>
                                                    <option value="pinterest">Pinterest</option>
                                                    <option value="youtube">YouTube</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" ng-model="link.url">
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" ng-click="removeSocialLink($index)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" ng-click="addSocialLink()">
                                <i class="fas fa-plus"></i> Add Social Link
                            </button>
                        </div>
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
                <div class="preview-container" style="height: auto; margin-bottom: 40px;">
                    <!-- Homepage Preview -->
                    <div ng-if="currentPage === 'homepage'">
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
                    
                    <!-- Blog Preview -->
                    <div ng-if="currentPage === 'blog'">
                        <!-- Blog Hero Section -->
                        <div class="blog-hero" ng-if="site.blog.hero.enabled" ng-style="{'background-image': 'url(' + site.blog.hero.backgroundImage + ')', 'background-size': 'cover', 'background-position': 'center', 'position': 'relative', 'padding': '80px 0', 'color': '#fff'}">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6);"></div>
                            <div class="container" style="position: relative; z-index: 1;">
                                <div class="row">
                                    <div class="col-lg-8 col-md-10 mx-auto blog-header-content" style="padding: 60px 0; text-align: center;">
                                        <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: #ffffff; text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">{% site.blog.hero.title %}</h1>
                                        <p style="font-size: 1rem; line-height: 1.6; color: #ffffff; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">{% site.blog.hero.subtitle %}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Latest Articles Section -->
                        <div ng-if="site.blog.latestArticles.enabled" style="padding: 40px 15px;">
                            <div style="text-align: center; margin-bottom: 30px;">
                                <h2 style="font-size: 1.5rem; font-weight: 600; position: relative; display: inline-block;">
                                    {% site.blog.latestArticles.title %}
                                    <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 40px; height: 2px; background-color: #333;"></span>
                                </h2>
                            </div>
                            
                            <!-- Articles Grid -->
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 30px;">
                                <div ng-repeat="article in site.blog.latestArticles.articles" style="position: relative;">
                                    <div style="margin-bottom: 15px; position: relative; overflow: hidden; padding-top: 75%;">
                                        <img ng-src="{% article.image %}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <span style="font-size: 0.8rem; text-transform: uppercase; color: #777;">{% article.category %}</span>
                                        <h3 style="font-size: 1rem; margin-top: 5px;">{% article.title %}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Values Section -->
                        <div ng-if="site.blog.values.enabled" style="background-color: #f8f9fa; padding: 40px 15px;">
                            <div style="display: flex; justify-content: space-around; align-items: center; max-width: 800px; margin: 0 auto;">
                                <div ng-repeat="value in site.blog.values.items" style="text-align: center; padding: 0 15px;">
                                    <div style="width: 80px; height: 80px; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; background-color: #fff; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                        <img ng-src="{% value.iconUrl || getDefaultIconUrl(value.title) %}" alt="{% value.title %}" style="width: 40px; height: 40px;">
                                    </div>
                                    <h3 style="font-size: 1.1rem; font-weight: 600; margin-top: 15px;">{% value.title %}</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Section -->
                        <div ng-if="site.blog.progress.enabled" style="padding: 40px 15px;">
                            <div style="text-align: center; margin-bottom: 30px;">
                                <h2 style="font-size: 1.5rem; font-weight: 600; position: relative; display: inline-block;">
                                    {% site.blog.progress.title %}
                                    <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 40px; height: 2px; background-color: #333;"></span>
                                </h2>
                            </div>
                            
                            <!-- Progress Grid -->
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                                <div ng-repeat="item in site.blog.progress.items" style="text-align: center;">
                                    <div style="margin-bottom: 15px; position: relative; overflow: hidden; padding-top: 75%;">
                                        <img ng-src="{% item.image %}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <h3 style="font-size: 1rem; font-weight: 600;">{% item.title %}</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Section -->
                        <div ng-if="site.blog.social.enabled" style="padding: 40px 15px; text-align: center;">
                            <h2 style="font-size: 1.5rem; margin-bottom: 20px;">{% site.blog.social.title %}</h2>
                            
                            <div style="display: flex; justify-content: center; gap: 15px;">
                                <a ng-repeat="link in site.blog.social.links" ng-href="{% link.url.startsWith('http') ? link.url : 'https://' + link.url %}" target="_blank" style="width: 40px; height: 40px; border-radius: 50%; background-color: #333; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none;">
                                    <i class="fab" ng-class="'fa-' + link.platform"></i>
                                </a>
                            </div>
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
                },
                // Blog page customization settings
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
                            if ($scope.currentPage === 'homepage') {
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
                            // Blog page settings
                            else if ($scope.currentPage === 'blog') {
                                if (savedSettings.blog && savedSettings.blog.hero) {
                                    $scope.site.blog.hero.enabled = savedSettings.blog.hero.enabled;
                                    
                                    // Apply saved settings
                                    if (savedSettings.blog.hero.settings) {
                                        if (savedSettings.blog.hero.settings.title) {
                                            $scope.site.blog.hero.title = savedSettings.blog.hero.settings.title;
                                        }
                                        if (savedSettings.blog.hero.settings.subtitle) {
                                            $scope.site.blog.hero.subtitle = savedSettings.blog.hero.settings.subtitle;
                                        }
                                        if (savedSettings.blog.hero.settings.backgroundImage) {
                                            $scope.site.blog.hero.backgroundImage = savedSettings.blog.hero.settings.backgroundImage;
                                        }
                                    }
                                }
                                
                                if (savedSettings.blog && savedSettings.blog.latestArticles) {
                                    $scope.site.blog.latestArticles.enabled = savedSettings.blog.latestArticles.enabled;
                                    
                                    // Apply saved settings
                                    if (savedSettings.blog.latestArticles.settings) {
                                        if (savedSettings.blog.latestArticles.settings.title) {
                                            $scope.site.blog.latestArticles.title = savedSettings.blog.latestArticles.settings.title;
                                        }
                                        if (savedSettings.blog.latestArticles.settings.articles && savedSettings.blog.latestArticles.settings.articles.length > 0) {
                                            $scope.site.blog.latestArticles.articles = savedSettings.blog.latestArticles.settings.articles;
                                        }
                                    }
                                }
                                
                                if (savedSettings.blog && savedSettings.blog.values) {
                                    $scope.site.blog.values.enabled = savedSettings.blog.values.enabled;
                                    
                                    // Apply saved settings
                                    if (savedSettings.blog.values.settings && savedSettings.blog.values.settings.items && savedSettings.blog.values.settings.items.length > 0) {
                                        $scope.site.blog.values.items = savedSettings.blog.values.settings.items;
                                    }
                                }
                                
                                if (savedSettings.blog && savedSettings.blog.progress) {
                                    $scope.site.blog.progress.enabled = savedSettings.blog.progress.enabled;
                                    
                                    // Apply saved settings
                                    if (savedSettings.blog.progress.settings) {
                                        if (savedSettings.blog.progress.settings.title) {
                                            $scope.site.blog.progress.title = savedSettings.blog.progress.settings.title;
                                        }
                                        if (savedSettings.blog.progress.settings.items && savedSettings.blog.progress.settings.items.length > 0) {
                                            $scope.site.blog.progress.items = savedSettings.blog.progress.settings.items;
                                        }
                                    }
                                }
                                
                                if (savedSettings.blog && savedSettings.blog.social) {
                                    $scope.site.blog.social.enabled = savedSettings.blog.social.enabled;
                                    
                                    // Apply saved settings
                                    if (savedSettings.blog.social.settings) {
                                        if (savedSettings.blog.social.settings.title) {
                                            $scope.site.blog.social.title = savedSettings.blog.social.settings.title;
                                        }
                                        if (savedSettings.blog.social.settings.links && savedSettings.blog.social.settings.links.length > 0) {
                                            $scope.site.blog.social.links = savedSettings.blog.social.settings.links;
                                        }
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
            
            // Functions for blog page
            // Add article
            $scope.addArticle = function() {
                $scope.site.blog.latestArticles.articles.push({
                    title: 'New Article',
                    category: 'Style',
                    image: 'https://via.placeholder.com/600x400',
                    link: '#'
                });
            };
            
            // Remove article
            $scope.removeArticle = function(index) {
                $scope.site.blog.latestArticles.articles.splice(index, 1);
            };
            
            // Add value
            $scope.addValue = function() {
                $scope.site.blog.values.items.push({
                    title: 'New Value',
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/3601/3601569.png'
                });
            };
            
            // Remove value
            $scope.removeValue = function(index) {
                $scope.site.blog.values.items.splice(index, 1);
            };
            
            // Add progress item
            $scope.addProgressItem = function() {
                $scope.site.blog.progress.items.push({
                    title: 'New Progress Item',
                    image: 'https://via.placeholder.com/600x400',
                    link: '#'
                });
            };
            
            // Remove progress item
            $scope.removeProgressItem = function(index) {
                $scope.site.blog.progress.items.splice(index, 1);
            };
            
            // Add social link
            $scope.addSocialLink = function() {
                $scope.site.blog.social.links.push({
                    platform: 'instagram',
                    url: '#'
                });
            };
            
            // Remove social link
            $scope.removeSocialLink = function(index) {
                $scope.site.blog.social.links.splice(index, 1);
            };
            
            // Function to save changes
            $scope.saveChanges = function() {
                // Prepare data for saving
                var settingsToSave = {};
                
                if ($scope.currentPage === 'homepage') {
                    settingsToSave = {
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
                }
                else if ($scope.currentPage === 'blog') {
                    settingsToSave = {
                        blog: {
                            hero: {
                                enabled: $scope.site.blog.hero.enabled,
                                settings: {
                                    title: $scope.site.blog.hero.title,
                                    subtitle: $scope.site.blog.hero.subtitle,
                                    backgroundImage: $scope.site.blog.hero.backgroundImage
                                }
                            },
                            latestArticles: {
                                enabled: $scope.site.blog.latestArticles.enabled,
                                settings: {
                                    title: $scope.site.blog.latestArticles.title,
                                    articles: $scope.site.blog.latestArticles.articles
                                }
                            },
                            values: {
                                enabled: $scope.site.blog.values.enabled,
                                settings: {
                                    items: $scope.site.blog.values.items
                                }
                            },
                            progress: {
                                enabled: $scope.site.blog.progress.enabled,
                                settings: {
                                    title: $scope.site.blog.progress.title,
                                    items: $scope.site.blog.progress.items
                                }
                            },
                            social: {
                                enabled: $scope.site.blog.social.enabled,
                                settings: {
                                    title: $scope.site.blog.social.title,
                                    links: $scope.site.blog.social.links
                                }
                            }
                        }
                    };
                }
                
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
                
                // Delete settings from database
                $http.post('/admin/api/page-settings', {
                    page: $scope.currentPage,
                    settings: $scope.currentPage === 'homepage' ? {
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
                    } : {
                        blog: {
                            hero: {
                                enabled: $scope.site.blog.hero.enabled,
                                settings: {
                                    title: $scope.site.blog.hero.title,
                                    subtitle: $scope.site.blog.hero.subtitle,
                                    backgroundImage: $scope.site.blog.hero.backgroundImage
                                }
                            },
                            latestArticles: {
                                enabled: $scope.site.blog.latestArticles.enabled,
                                settings: {
                                    title: $scope.site.blog.latestArticles.title,
                                    articles: $scope.site.blog.latestArticles.articles
                                }
                            },
                            values: {
                                enabled: $scope.site.blog.values.enabled,
                                settings: {
                                    items: $scope.site.blog.values.items
                                }
                            },
                            progress: {
                                enabled: $scope.site.blog.progress.enabled,
                                settings: {
                                    title: $scope.site.blog.progress.title,
                                    items: $scope.site.blog.progress.items
                                }
                            },
                            social: {
                                enabled: $scope.site.blog.social.enabled,
                                settings: {
                                    title: $scope.site.blog.social.title,
                                    links: $scope.site.blog.social.links
                                }
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
            };
            
            // Mobile sidebar toggle
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('active');
            });
            
            // Load settings when controller initializes
            $scope.loadSettings();

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
        });
    </script>
</body>
</html> 