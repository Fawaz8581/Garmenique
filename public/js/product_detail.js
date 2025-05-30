// Initialize Angular App if not already defined
var app = angular.module('garmeniqueApp', []);

// Product Detail Controller
app.controller('ProductDetailController', ['$scope', '$window', '$http', function($scope, $window, $http) {
    // Get the product ID from the URL
    var url = $window.location.pathname;
    var productId = parseInt(url.substring(url.lastIndexOf('/') + 1));
    
    // Initialize product
    $scope.product = null;
    $scope.quantity = 1;
    $scope.selectedSize = null;
    $scope.selectedColor = null;
    $scope.selectedImage = null;
    $scope.reviewRating = 0;
    $scope.reviews = [];
    $scope.relatedProducts = [];
    
    // Load product data based on ID
    // In a real app, this would come from an API
    $scope.loadProduct = function() {
        // For now, we'll use the products data from catalog.js
        var allProducts = [];
        
       
        
        // Find product by ID
        $scope.product = allProducts.find(function(p) {
            return p.id === productId;
        });
        
        // If product found, set default selected color
        if ($scope.product && $scope.product.colors.length > 0) {
            $scope.selectedColor = $scope.product.colors[0];
        }
        
        // Generate related products (randomly for now)
        if ($scope.product) {
            var relatedIds = []; // To store generated IDs to avoid duplicates
            
            // Add product ID to avoid showing the current product
            relatedIds.push($scope.product.id);
            
            // Generate 4 random product IDs
            while (relatedIds.length < 5 && allProducts.length > 4) {
                var randomId = allProducts[Math.floor(Math.random() * allProducts.length)].id;
                if (relatedIds.indexOf(randomId) === -1) {
                    relatedIds.push(randomId);
                }
            }
            
            // Get related products based on the IDs
            $scope.relatedProducts = allProducts.filter(function(p) {
                // Check if the product ID is in the relatedIds array and not the current product
                return relatedIds.indexOf(p.id) !== -1 && p.id !== $scope.product.id;
            });
        }
        
        // Generate sample reviews
        $scope.generateSampleReviews();
    };
    
    // Generate sample reviews
    $scope.generateSampleReviews = function() {
        $scope.reviews = [
            {
                name: 'Sarah Johnson',
                date: 'September 12, 2023',
                rating: 5,
                comment: 'Absolutely love this product! The quality is excellent, and it fits perfectly. Will definitely buy more in different colors.'
            },
            {
                name: 'Michael Brown',
                date: 'August 28, 2023',
                rating: 4,
                comment: 'Great product overall. The material is high quality and comfortable. Only giving 4 stars because the sizing runs a bit large.'
            },
            {
                name: 'Emily Davis',
                date: 'July 15, 2023',
                rating: 5,
                comment: 'Exceeded my expectations! Fast shipping and the product looks exactly like the photos. Highly recommend!'
            },
            {
                name: 'David Wilson',
                date: 'June 30, 2023',
                rating: 3,
                comment: 'Decent product for the price. The color is slightly different from what\'s shown in the images, but overall acceptable quality.'
            }
        ];
    };
    
    // Get stars for rating display
    $scope.getStars = function(rating) {
        return new Array(rating);
    };
    
    // Get empty stars for rating display
    $scope.getEmptyStars = function(rating) {
        return new Array(5 - rating);
    };
    
    // Get random rating percentage for the bars in the reviews tab
    $scope.getRandomRatingPercentage = function(stars) {
        var percentages = {
            5: { width: '75%' },
            4: { width: '60%' },
            3: { width: '25%' },
            2: { width: '15%' },
            1: { width: '5%' }
        };
        
        return percentages[stars];
    };
    
    // Get random rating count for the bars in the reviews tab
    $scope.getRandomRatingCount = function(stars) {
        var counts = {
            5: 18,
            4: 12,
            3: 5,
            2: 3,
            1: 1
        };
        
        return counts[stars];
    };
    
    // Set review rating
    $scope.setReviewRating = function(rating) {
        $scope.reviewRating = rating;
    };
    
    // Helper function for product hover in related products
    $scope.hover = function(product) {
        product.isHovered = true;
    };
    
    // Helper function for product unhover in related products
    $scope.unhover = function(product) {
        product.isHovered = false;
    };
    
    // Quick view function for related products
    $scope.quickView = function(product) {
        alert('Quick view for: ' + product.name);
        // In a real app, this would open a modal with product details
    };
    
    // Add to compare function for related products
    $scope.addToCompare = function(product) {
        alert('Added to compare: ' + product.name);
        // In a real app, this would add the product to a comparison list
    };
    
    // Initialize by loading the product
    $scope.loadProduct();
    
    // Select the image to display in the main image area
    $scope.selectImage = function(image) {
        $scope.selectedImage = image;
    };
    
    // Select a color
    $scope.selectColor = function(color) {
        $scope.selectedColor = color;
    };
    
    // Select a size
    $scope.selectSize = function(size) {
        $scope.selectedSize = size;
    };
    
    // Increase quantity
    $scope.increaseQuantity = function() {
        $scope.quantity++;
    };
    
    // Decrease quantity
    $scope.decreaseQuantity = function() {
        if ($scope.quantity > 1) {
            $scope.quantity--;
        }
    };
    
    // Add to cart
    $scope.addToCart = function() {
        if(!$scope.selectedSize || !$scope.selectedColor) {
            alert('Please select a size and color');
            return;
        }
        
        var cartItem = {
            id: $scope.product.id,
            name: $scope.product.name,
            image: $scope.product.primaryImage,
            price: $scope.product.price,
            oldPrice: $scope.product.oldPrice,
            discount: $scope.product.discount,
            size: $scope.selectedSize,
            color: $scope.selectedColor.name,
            quantity: $scope.quantity
        };
        
        // Get the CartController scope
        var cartScope = angular.element(document.querySelector('[ng-controller="CartController"]')).scope();
        
        // Check if the cart scope exists
        if(cartScope) {
            // Add the item to cart
            cartScope.addToCart(cartItem);
            
            // Open the cart panel
            cartScope.openCart();
            
            // Apply changes to update the UI
            if(!$scope.$$phase) {
                $scope.$apply();
            }
        }
    };
    
    // Add to wishlist
    $scope.addToWishlist = function() {
        alert('Product added to wishlist');
        // In a real app, this would send the product to a wishlist service
    };
}]);

// Account Dropdown Controller
app.controller('AccountDropdownController', ['$scope', '$timeout', function($scope, $timeout) {
    $scope.isOpen = false;
    let hideTimeout;

    $scope.openDropdown = function() {
        if (hideTimeout) $timeout.cancel(hideTimeout);
        $scope.isOpen = true;
    };

    $scope.closeDropdown = function() {
        hideTimeout = $timeout(function() {
            $scope.isOpen = false;
        }, 200); // Small delay to improve user experience
    };
}]);

// Header Controller
app.controller('HeaderController', ['$scope', '$rootScope', function($scope, $rootScope) {
    $scope.isNavActive = false;
    $scope.isSearchActive = false;
    
    $scope.toggleNav = function() {
        $scope.isNavActive = !$scope.isNavActive;
    };
    
    $scope.toggleSearch = function() {
        $scope.isSearchActive = !$scope.isSearchActive;
    };
    
    $scope.closeSearch = function() {
        $scope.isSearchActive = false;
    };
    
    // Function to open cart using $rootScope broadcast
    $scope.openCartPanel = function() {
        $rootScope.$broadcast('openCart');
    };
}]);

// Search Controller
app.controller('SearchController', ['$scope', function($scope) {
    $scope.searchQuery = '';
    
    $scope.closeSearch = function() {
        var headerScope = angular.element(document.querySelector('[ng-controller="HeaderController"]')).scope();
        headerScope.closeSearch();
    };
    
    $scope.popularCategories = [
        {
            name: 'T-Shirts',
            image: 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80',
            isHovered: false
        },
        {
            name: 'Dresses',
            image: 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80',
            isHovered: false
        },
        {
            name: 'Outerwear',
            image: 'https://images.unsplash.com/photo-1551794840-8ae3b9c814d4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80',
            isHovered: false
        },
        {
            name: 'Accessories',
            image: 'https://images.unsplash.com/photo-1612902456551-333ac5afa26e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80',
            isHovered: false
        }
    ];
    
    $scope.hover = function(category) {
        category.isHovered = true;
    };
    
    $scope.unhover = function(category) {
        category.isHovered = false;
    };
}]);