// Garmenique AngularJS App

// Angular module definition
var app = angular.module('garmeniqueApp', []);

// Header Controller
app.controller('HeaderController', ['$scope', '$window', '$rootScope', function($scope, $window, $rootScope) {
    // Mobile Navigation Toggle
    $scope.isNavActive = false;
    
    $scope.toggleNav = function() {
        $scope.isNavActive = !$scope.isNavActive;
    };
    
    // Search Panel Toggle
    $scope.toggleSearch = function() {
        $rootScope.$broadcast('toggleSearch');
    };
    
    // Cart Toggle
    $scope.isCartActive = false;
    
    $scope.toggleCart = function() {
        $scope.isCartActive = !$scope.isCartActive;
        $rootScope.$broadcast('toggleCart', $scope.isCartActive);
    };
    
    // Listen for cart update events from other pages/controllers
    window.addEventListener('message', function(event) {
        if (event.data && event.data.type === 'cartUpdated') {
            $scope.$apply(function() {
                $rootScope.$broadcast('cartUpdated', event.data.cart);
            });
        }
    });
    
    // Sticky Header
    var headerHeight = 0;
    
    angular.element(document).ready(function() {
        var header = document.querySelector('.header');
        headerHeight = header ? header.offsetHeight : 0;
    });
    
    angular.element($window).on('scroll', function() {
        $scope.$apply(function() {
            if ($window.scrollY > headerHeight) {
                angular.element(document.querySelector('.header')).addClass('sticky');
            } else {
                angular.element(document.querySelector('.header')).removeClass('sticky');
            }
        });
    });
}]);

// Search Controller
app.controller('SearchController', ['$scope', '$rootScope', '$document', function($scope, $rootScope, $document) {
    $scope.isSearchActive = false;
    $scope.searchQuery = '';
    
    // Toggle search panel visibility
    $rootScope.$on('toggleSearch', function() {
        $scope.isSearchActive = !$scope.isSearchActive;
        if ($scope.isSearchActive) {
            document.body.style.overflow = 'hidden';
            setTimeout(function() {
                document.querySelector('.search-input').focus();
            }, 400);
            
            // Add ESC key listener when search is active
            $document.on('keydown', handleEscKeypress);
            
            // Add overlay click listener
            angular.element(document.querySelector('.search-overlay')).on('click', $scope.closeSearch);
        } else {
            document.body.style.overflow = '';
            
            // Remove listeners when search is closed
            $document.off('keydown', handleEscKeypress);
        }
    });
    
    // Handle ESC key to close search
    function handleEscKeypress(e) {
        if (e.keyCode === 27) { // ESC key code
            $scope.$apply(function() {
                $scope.closeSearch();
            });
        }
    }
    
    // Close search panel
    $scope.closeSearch = function() {
        $scope.isSearchActive = false;
        document.body.style.overflow = '';
        
        // Remove listeners
        $document.off('keydown', handleEscKeypress);
    };
    
    // Click outside search panel to close
    angular.element(document).on('click', function(e) {
        // If search is active and click is outside search panel and not on search icon
        if ($scope.isSearchActive && 
            !angular.element(e.target).closest('.search-panel').length && 
            !angular.element(e.target).closest('.nav-icons .fa-search').length) {
            
            $scope.$apply(function() {
                $scope.closeSearch();
            });
        }
    });
    
    // Popular categories for search page
    $scope.popularCategories = [
        {
            name: "Women's Sweaters",
            image: "https://images.unsplash.com/photo-1626497764746-6dc36546b388?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80",
            isHovered: false
        },
        {
            name: "Women's Bottoms",
            image: "https://images.lee.com/is/image/Lee/112340541-HERO?$PDP24-XXLARGE$&fit=crop",
            isHovered: false
        },
        {
            name: "Women's Boots",
            image: "https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80",
            isHovered: false
        },
        {
            name: "Men's Best Sellers",
            image: "https://images.unsplash.com/photo-1617137968427-85924c800a22?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80",
            isHovered: false
        }
    ];
    
    // Hover functions
    $scope.hover = function(item) {
        item.isHovered = true;
    };
    
    $scope.unhover = function(item) {
        item.isHovered = false;
    };
    
    // Perform search
    $scope.performSearch = function() {
        // Search logic would go here
        console.log('Searching for:', $scope.searchQuery);
    };
}]);

// Category Controller
app.controller('CategoryController', ['$scope', function($scope) {
    // Categories data with responsive image URLs
    $scope.categories = [
        {
            name: 'Jackets',
            imageUrl: 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80',
            isHovered: false
        },
        {
            name: 'Vests',
            imageUrl: 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80',
            isHovered: false
        },
        {
            name: 'Pants',
            imageUrl: 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80',
            isHovered: false
        },
        {
            name: 'Sweaters',
            imageUrl: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80',
            isHovered: false
        },
        {
            name: 'Outerwear',
            imageUrl: 'https://images.unsplash.com/photo-1564584217132-2271feaeb3c5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80',
            isHovered: false
        }
    ];
    
    // Hover functions
    $scope.hover = function(item) {
        item.isHovered = true;
    };
    
    $scope.unhover = function(item) {
        item.isHovered = false;
    };
}]);

// Featured Controller
app.controller('FeaturedController', ['$scope', function($scope) {
    // Featured items data with responsive image URLs
    $scope.featuredItems = [
        {
            title: 'New Arrivals',
            imageUrl: 'https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            link: '#',
            isHovered: false
        },
        {
            title: 'Best Sellers',
            imageUrl: 'https://images.unsplash.com/photo-1485125639709-a60c3a500bf1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            link: '#',
            isHovered: false
        },
        {
            title: 'The Holiday Outfit',
            imageUrl: 'https://images.unsplash.com/photo-1543076447-215ad9ba6923?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            link: '#',
            isHovered: false
        }
    ];
    
    // Hover functions
    $scope.hover = function(item) {
        item.isHovered = true;
    };
    
    $scope.unhover = function(item) {
        item.isHovered = false;
    };
}]);

// Newsletter Controller
app.controller('NewsletterController', ['$scope', function($scope) {
    $scope.email = '';
    
    $scope.subscribe = function() {
        if ($scope.email) {
            // In a real application, this would send the email to the server
            alert('Thank you for subscribing with: ' + $scope.email);
            $scope.email = '';
        }
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

// Cart Controller
app.controller('CartController', ['$scope', '$http', '$rootScope', function($scope, $http, $rootScope) {
    // Initialize cart items
    $scope.cartItems = [];
    $scope.isCartActive = false;
    
    // Toggle cart visibility
    $scope.toggleCart = function() {
        $scope.isCartActive = !$scope.isCartActive;
    };
    
    // Listen for toggle events from header
    $rootScope.$on('toggleCart', function(event, isActive) {
        $scope.isCartActive = isActive;
    });
    
    // Listen for cart update events
    $rootScope.$on('cartUpdated', function(event, cart) {
        $scope.cartItems = cart || [];
        // Save to session storage as backup
        try {
            sessionStorage.setItem('cart', JSON.stringify($scope.cartItems));
        } catch (e) {
            console.error('Error saving cart to session storage:', e);
        }
    });
    
    // Load cart data
    $scope.loadCart = function() {
        $http.get('/get-cart')
            .then(function(response) {
                if (response.data.cart) {
                    $scope.cartItems = response.data.cart;
                }
            })
            .catch(function(error) {
                console.error('Error loading cart:', error);
                // Fallback to session storage if server request fails
                try {
                    let cartData = JSON.parse(sessionStorage.getItem('cart') || '[]');
                    $scope.cartItems = cartData;
                } catch (error) {
                    console.error('Error loading cart from session storage:', error);
                    $scope.cartItems = [];
                }
            });
    };
    
    // Calculate total price
    $scope.getTotal = function() {
        return $scope.cartItems.reduce(function(total, item) {
            return total + (item.price * item.quantity);
        }, 0);
    };
    
    // Increment quantity
    $scope.incrementQuantity = function(item) {
        item.quantity++;
        $scope.updateCart(item);
    };
    
    // Decrement quantity
    $scope.decrementQuantity = function(item) {
        if (item.quantity > 1) {
            item.quantity--;
            $scope.updateCart(item);
        }
    };
    
    // Remove item from cart
    $scope.removeItem = function(item) {
        $scope.cartItems = $scope.cartItems.filter(function(cartItem) {
            return !(cartItem.id === item.id && cartItem.size === item.size);
        });
        
        // Update cart on server
        $http.post('/api/remove-from-cart', {
            productId: item.id,
            size: item.size
        })
        .then(function(response) {
            console.log('Item removed from cart:', response.data);
        })
        .catch(function(error) {
            console.error('Error removing item from cart:', error);
        });
        
        // Update session storage
        try {
            sessionStorage.setItem('cart', JSON.stringify($scope.cartItems));
        } catch (e) {
            console.error('Error saving cart to session storage:', e);
        }
    };
    
    // Update cart item
    $scope.updateCart = function(item) {
        $http.post('/api/update-cart', {
            productId: item.id,
            size: item.size,
            quantity: item.quantity
        })
        .then(function(response) {
            console.log('Cart updated:', response.data);
        })
        .catch(function(error) {
            console.error('Error updating cart:', error);
        });
        
        // Update session storage
        try {
            sessionStorage.setItem('cart', JSON.stringify($scope.cartItems));
        } catch (e) {
            console.error('Error saving cart to session storage:', e);
        }
    };
    
    // Load cart on controller initialization
    $scope.loadCart();
}]);