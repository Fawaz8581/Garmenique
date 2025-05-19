<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@{{ product.name }} - Garmenique</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- AngularJS -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
        <link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
        <link rel="stylesheet" href="{{ asset('css/landing.page.search.css') }}">
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
                        <li><a href="/" class="nav-item">HOME</a></li>
                        <li><a href="/catalog" class="nav-item">CATALOG</a></li>
                        <li><a href="/men" class="nav-item">MEN</a></li>
                        <li><a href="/women" class="nav-item">WOMEN</a></li>
                        <li><a href="/blog" class="nav-item">BLOG</a></li>
                        <li><a href="/about" class="nav-item">ABOUT</a></li>
                        <li><a href="/contact" class="nav-item">CONTACT</a></li>
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
        
        <!-- Product Detail Section -->
        <section class="product-detail-section" ng-controller="ProductDetailController">
            <div class="container">
                <div class="breadcrumb-container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">HOME</a></li>
                            <li class="breadcrumb-item"><a href="/catalog">CATALOG</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@{{ product.name }}</li>
                        </ol>
                    </nav>
                </div>
                
                <div class="row" ng-if="product">
                    <!-- Product Images Grid on Left -->
                    <div class="col-md-7">
                        <div class="product-images-grid">
                            <!-- Main large image -->
                            <div class="main-product-image">
                                <img ng-src="@{{ selectedImage || product.primaryImage }}" alt="@{{ product.name }} - Full View" class="img-fluid">
                            </div>
                            
                            <!-- Thumbnails Grid -->
                            <div class="product-thumbnails">
                                <div class="thumbnail-item" ng-class="{'active': selectedImage === product.primaryImage || !selectedImage}" ng-click="selectImage(product.primaryImage)">
                                    <img ng-src="@{{ product.primaryImage }}" alt="@{{ product.name }} Thumbnail 1" class="img-fluid">
                                </div>
                                <div class="thumbnail-item" ng-class="{'active': selectedImage === product.hoverImage}" ng-click="selectImage(product.hoverImage)">
                                    <img ng-src="@{{ product.hoverImage }}" alt="@{{ product.name }} Thumbnail 2" class="img-fluid">
                                </div>
                                <div class="thumbnail-item" ng-class="{'active': selectedImage === product.additionalImage1}" ng-click="selectImage(product.additionalImage1)" ng-if="product.additionalImage1">
                                    <img ng-src="@{{ product.additionalImage1 }}" alt="@{{ product.name }} Thumbnail 3" class="img-fluid">
                                </div>
                                <div class="thumbnail-item" ng-class="{'active': selectedImage === product.additionalImage2}" ng-click="selectImage(product.additionalImage2)" ng-if="product.additionalImage2">
                                    <img ng-src="@{{ product.additionalImage2 }}" alt="@{{ product.name }} Thumbnail 4" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Info on Right -->
                    <div class="col-md-5">
                        <div class="product-info">
                            <h1 class="product-title">@{{ product.name }}</h1>
                            
                            <!-- Product Reference ID -->
                            <div class="product-ref-id mb-3">
                                <span class="text-muted">REF: @{{ product.id }}</span>
                            </div>
                            
                            <!-- Product Rating Stars -->
                            <div class="product-rating mb-3">
                                <div class="stars">
                                    <i class="fas fa-star" ng-repeat="i in getStars(product.rating) track by $index"></i>
                                    <i class="far fa-star" ng-repeat="i in getEmptyStars(product.rating) track by $index"></i>
                                </div>
                                <span class="review-count">(@{{ product.reviewCount }} Reviews)</span>
                            </div>
                            
                            <!-- Product Price -->
                            <div class="product-price mb-4">
                                <span class="current-price" ng-class="{'has-discount': product.discount}">$@{{ product.price.toFixed(2) }}</span>
                                <span class="old-price" ng-if="product.oldPrice">$@{{ product.oldPrice.toFixed(2) }}</span>
                                <span class="discount-badge" ng-if="product.discount">-@{{ product.discount }}%</span>
                            </div>
                            
                            <!-- Short Product Description -->
                            <div class="product-short-desc mb-4">
                                <p>@{{ product.description }}</p>
                            </div>
                            
                            <!-- Product Colors -->
                            <div class="product-colors mb-4">
                                <h5>Color: <span>@{{ selectedColor.name }}</span></h5>
                                <div class="color-options">
                                    <button ng-repeat="color in product.colors" 
                                            ng-click="selectColor(color)" 
                                            ng-class="{'active': selectedColor.name === color.name}" 
                                            class="color-btn" 
                                            style="background-color: @{{ color.code }};" 
                                            title="@{{ color.name }}">
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Product Sizes -->
                            <div class="product-sizes mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5>Size: <span>@{{ selectedSize || 'Select size' }}</span></h5>
                                    <a href="#" class="size-guide">Size Guide</a>
                                </div>
                                <div class="size-options">
                                    <button ng-repeat="size in product.sizes" 
                                            ng-click="selectSize(size)" 
                                            ng-class="{'active': selectedSize === size}" 
                                            class="size-btn">
                                        @{{ size }}
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Quantity Selector -->
                            <div class="quantity-selector mb-4">
                                <h5>Quantity:</h5>
                                <div class="quantity-input">
                                    <button class="quantity-btn" ng-click="decreaseQuantity()">-</button>
                                    <input type="text" ng-model="quantity" readonly>
                                    <button class="quantity-btn" ng-click="increaseQuantity()">+</button>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="product-actions mb-4">
                                <button class="btn btn-primary add-to-cart-btn" ng-click="addToCart()">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                                <button class="btn btn-outline-secondary wishlist-btn" ng-click="addToWishlist()">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                            
                            <!-- Product Meta Info -->
                            <div class="product-meta mb-4">
                                <div class="meta-item">
                                    <i class="fas fa-truck"></i>
                                    <span>Free shipping on orders over $100</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-undo"></i>
                                    <span>30-day easy returns</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>2-year warranty</span>
                                </div>
                            </div>
                            
                            <!-- Social Sharing -->
                            <div class="social-sharing">
                                <span>Share:</span>
                                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-icon"><i class="fab fa-pinterest-p"></i></a>
                                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Product Details Tabs -->
                <div class="product-tabs mt-5">
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="additional-info-tab" data-bs-toggle="tab" data-bs-target="#additional-info" type="button" role="tab" aria-controls="additional-info" aria-selected="false">Additional Information</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews (@{{ product.reviewCount }})</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="productTabsContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <p>@{{ product.description }}</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consequat elit vel volutpat hendrerit. Donec euismod, justo eget congue convallis, nisl nunc dapibus ipsum, a faucibus dui ex quis sapien. Proin eget semper enim. Mauris vel felis vel augue aliquam sodales.</p>
                            <ul>
                                <li>Made from premium materials</li>
                                <li>Designed for comfort and style</li>
                                <li>Perfect for everyday wear</li>
                                <li>Machine washable</li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="additional-info" role="tabpanel" aria-labelledby="additional-info-tab">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Material</th>
                                        <td>100% Cotton</td>
                                    </tr>
                                    <tr>
                                        <th>Colors</th>
                                        <td>
                                            <span ng-repeat="color in product.colors">
                                                @{{ color.name }}@{{ $last ? '' : ', ' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sizes</th>
                                        <td>
                                            <span ng-repeat="size in product.sizes">
                                                @{{ size }}@{{ $last ? '' : ', ' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Care Instructions</th>
                                        <td>Machine wash cold, tumble dry low</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="reviews-summary">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="overall-rating">
                                            <h3>@{{ product.rating }}.0</h3>
                                            <div class="stars">
                                                <i class="fas fa-star" ng-repeat="i in getStars(product.rating) track by $index"></i>
                                                <i class="far fa-star" ng-repeat="i in getEmptyStars(product.rating) track by $index"></i>
                                            </div>
                                            <p>Based on @{{ product.reviewCount }} reviews</p>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="rating-bars">
                                            <div class="rating-bar" ng-repeat="i in [5, 4, 3, 2, 1]">
                                                <span class="rating-level">@{{ i }} stars</span>
                                                <div class="progress">
                                                    <div class="progress-bar" ng-style="getRandomRatingPercentage(i)"></div>
                                                </div>
                                                <span class="rating-count">@{{ getRandomRatingCount(i) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Reviews List -->
                            <div class="reviews-list">
                                <div class="review" ng-repeat="review in reviews">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <h5>@{{ review.name }}</h5>
                                            <div class="review-meta">
                                                <span class="review-date">@{{ review.date }}</span>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <div class="stars">
                                                <i class="fas fa-star" ng-repeat="i in getStars(review.rating) track by $index"></i>
                                                <i class="far fa-star" ng-repeat="i in getEmptyStars(review.rating) track by $index"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <p>@{{ review.comment }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Write a Review Form -->
                            <div class="write-review">
                                <h4>Write a Review</h4>
                                <form>
                                    <div class="mb-3">
                                        <label for="reviewerName" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="reviewerName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reviewerEmail" class="form-label">Your Email</label>
                                        <input type="email" class="form-control" id="reviewerEmail" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Your Rating</label>
                                        <div class="rating-input">
                                            <i class="far fa-star" ng-repeat="i in [1, 2, 3, 4, 5]" ng-click="setReviewRating(i)" ng-class="{'fas': reviewRating >= i}"></i>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reviewContent" class="form-label">Your Review</label>
                                        <textarea class="form-control" id="reviewContent" rows="5" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- You May Also Like -->
                <div class="related-products mt-5">
                    <h3>You May Also Like</h3>
                    <div class="row row-cols-2 row-cols-md-4 g-4">
                        <div class="col" ng-repeat="relatedProduct in relatedProducts">
                            <div class="product-card" ng-mouseenter="hover(relatedProduct)" ng-mouseleave="unhover(relatedProduct)">
                                <div class="product-card-img">
                                    <a href="/catalog/product/@{{ relatedProduct.id }}">
                                        <img ng-src="@{{ relatedProduct.isHovered ? relatedProduct.hoverImage : relatedProduct.primaryImage }}" alt="@{{ relatedProduct.name }}" class="img-fluid">
                                    </a>
                                    <div class="product-actions" ng-if="relatedProduct.isHovered">
                                        <button class="action-btn" ng-click="quickView(relatedProduct)" title="Quick View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn" ng-click="addToWishlist(relatedProduct)" title="Add to Wishlist">
                                            <i class="far fa-heart"></i>
                                        </button>
                                        <button class="action-btn" ng-click="addToCompare(relatedProduct)" title="Compare">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                    </div>
                                    <span class="product-badge new" ng-if="relatedProduct.isNew">New</span>
                                    <span class="product-badge discount" ng-if="relatedProduct.discount">-@{{ relatedProduct.discount }}%</span>
                                </div>
                                <div class="product-card-info">
                                    <h3 class="product-title">
                                        <a href="/catalog/product/@{{ relatedProduct.id }}">@{{ relatedProduct.name }}</a>
                                    </h3>
                                    <div class="product-price">
                                        <span class="current-price" ng-class="{'has-discount': relatedProduct.discount}">$@{{ relatedProduct.price.toFixed(2) }}</span>
                                        <span class="old-price" ng-if="relatedProduct.oldPrice">$@{{ relatedProduct.oldPrice.toFixed(2) }}</span>
                                    </div>
                                    <div class="product-rating">
                                        <div class="stars">
                                            <i class="fas fa-star" ng-repeat="i in getStars(relatedProduct.rating) track by $index"></i>
                                            <i class="far fa-star" ng-repeat="i in getEmptyStars(relatedProduct.rating) track by $index"></i>
                                        </div>
                                        <span class="review-count">(@{{ relatedProduct.reviewCount }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <a href="#" class="social-icon-circle"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon-circle"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-icon-circle"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-icon-circle"><i class="fab fa-pinterest"></i></a>
                            </div>
                            <p class="email-title">Sign Up for Updates</p>
                            <form class="email-form">
                                <input type="email" placeholder="Enter your email" class="email-input" required>
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

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Angular Controllers -->
        <script src="{{ asset('js/catalog.js') }}"></script>
        <script src="{{ asset('js/product_detail.js') }}"></script>
    </body>
</html> 