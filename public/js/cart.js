// Garmenique Cart System

(function() {
    // Create or use existing Angular module
    var app;
    try {
        app = angular.module('garmeniqueApp');
    } catch (err) {
        app = angular.module('garmeniqueApp', []);
    }

    // Cart Controller - Handles the sliding cart functionality
    app.controller('CartController', ['$scope', '$window', '$rootScope', '$http', '$timeout', function($scope, $window, $rootScope, $http, $timeout) {
        // Initialize cart
        $scope.isCartActive = false;
        $scope.cartItems = [];
        $scope.isAuthenticated = false;
        $scope.isLoading = true;
        
        // Setup CSRF token for all AJAX requests
        var token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            $http.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        } else {
            console.error('CSRF token not found');
        }
        
        // Check if user is authenticated
        function checkAuth() {
            $scope.isLoading = true;
            return $http.get('/check-auth?_=' + new Date().getTime(), {
                headers: {'Cache-Control': 'no-cache'}
            })
            .then(function(response) {
                console.log('Auth check response:', response.data);
                $scope.isAuthenticated = response.data.authenticated;
                
                if ($scope.isAuthenticated) {
                    $scope.userId = response.data.user_id;
                    return loadCartFromSession();
                } else {
                    // If not logged in, show empty cart
                    $scope.cartItems = [];
                    $scope.isLoading = false;
                }
            })
            .catch(function(error) {
                console.error('Auth check error:', error);
                $scope.isLoading = false;
            });
        }
        
        // Load cart from session storage
        function loadCartFromSession() {
            return $http.get('/get-cart?_=' + new Date().getTime(), {
                headers: {'Cache-Control': 'no-cache'}
            })
            .then(function(response) {
                console.log('Get cart response:', response.data);
                if (response.data.cart && Array.isArray(response.data.cart)) {
                    $scope.cartItems = response.data.cart;
                } else {
                    $scope.cartItems = [];
                }
                $scope.isLoading = false;
            })
            .catch(function(error) {
                console.error('Error loading cart from session:', error);
                $scope.cartItems = [];
                $scope.isLoading = false;
            });
        }
        
        // Save cart to session for authenticated users
        function saveCartToSession() {
            if (!$scope.isAuthenticated) {
                console.error('Cannot save cart: not authenticated');
                return Promise.reject('Not authenticated');
            }
            
            return $http.post('/save-cart', {
                cart: $scope.cartItems
            })
            .then(function(response) {
                console.log('Cart saved to session:', response.data);
                return response;
            })
            .catch(function(error) {
                console.error('Error saving cart to session:', error);
                throw error;
            });
        }
        
        // Initialize by checking auth status
        $timeout(function() {
            checkAuth();
        }, 100);
        
        // Force re-check auth when cart is opened
        $scope.recheckAuth = function() {
            return checkAuth();
        };
        
        // Listen for broadcast events
        $rootScope.$on('openCart', function() {
            $scope.recheckAuth().then(function() {
                $scope.openCart();
            });
        });
        
        // Open cart function
        $scope.openCart = function() {
            $scope.isCartActive = true;
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        };
        
        // Close cart function
        $scope.closeCart = function() {
            $scope.isCartActive = false;
            document.body.style.overflow = ''; // Restore scrolling
        };
        
        // Add to cart function
        $scope.addToCart = function(item) {
            console.log("Adding item to cart:", item);
            
            // Always recheck auth before adding
            $scope.recheckAuth().then(function() {
                console.log("Auth status after recheck:", $scope.isAuthenticated);
                
                if (!$scope.isAuthenticated) {
                    console.log("Not authenticated, redirecting to login");
                    alert('Please login to add items to your cart');
                    $window.location.href = '/login';
                    return;
                }
                
                console.log("Proceeding with add to cart");
                
                // Check if the item is already in the cart
                var existingItem = $scope.cartItems.find(function(cartItem) {
                    return cartItem.id === item.id && 
                        cartItem.size === item.size && 
                        cartItem.color === item.color;
                });
                
                if(existingItem) {
                    // If item exists, increase quantity
                    existingItem.quantity += item.quantity || 1;
                } else {
                    // Otherwise add new item
                    $scope.cartItems.push(item);
                }
                
                // Save cart
                saveCartToSession().then(function() {
                    // Open the cart on success
                    $scope.openCart();
                    
                    // Apply changes to update the UI
                    if(!$scope.$$phase) {
                        $scope.$apply();
                    }
                }).catch(function(err) {
                    console.error("Error saving cart:", err);
                    // Try one more auth check if saving fails
                    checkAuth().then(function() {
                        if ($scope.isAuthenticated) {
                            saveCartToSession();
                        } else {
                            alert('Session expired. Please log in again.');
                            $window.location.href = '/login';
                        }
                    });
                });
            }).catch(function(error) {
                console.error("Error checking auth:", error);
                alert('Error checking login status. Please refresh the page and try again.');
            });
        };
        
        // Increase quantity
        $scope.increaseQuantity = function(item) {
            $scope.recheckAuth().then(function() {
                if (!$scope.isAuthenticated) {
                    alert('Please login to manage your cart');
                    $window.location.href = '/login';
                    return;
                }
                
                item.quantity++;
                saveCartToSession();
            });
        };
        
        // Decrease quantity
        $scope.decreaseQuantity = function(item) {
            $scope.recheckAuth().then(function() {
                if (!$scope.isAuthenticated) {
                    alert('Please login to manage your cart');
                    $window.location.href = '/login';
                    return;
                }
                
                if(item.quantity > 1) {
                    item.quantity--;
                } else {
                    // Remove item if quantity becomes 0
                    var index = $scope.cartItems.indexOf(item);
                    if(index !== -1) {
                        $scope.cartItems.splice(index, 1);
                    }
                }
                
                saveCartToSession();
            });
        };
        
        // Calculate subtotal
        $scope.calculateSubtotal = function() {
            var subtotal = 0;
            $scope.cartItems.forEach(function(item) {
                var price = item.discount ? 
                    item.price * (1 - item.discount/100) : 
                    item.price;
                subtotal += price * item.quantity;
            });
            return subtotal * 15500; // Converting to IDR
        };
        
        // Get total items
        $scope.getTotalItems = function() {
            var total = 0;
            $scope.cartItems.forEach(function(item) {
                total += item.quantity;
            });
            return total;
        };
        
        // Proceed to checkout
        $scope.proceedToCheckout = function() {
            $scope.recheckAuth().then(function() {
                if (!$scope.isAuthenticated) {
                    alert('Please login to checkout');
                    $window.location.href = '/login';
                    return;
                }
                
                $window.location.href = '/checkout';
            });
        };
    }]);

    // Extend HeaderController with openCartPanel function if it exists
    app.run(['$rootScope', function($rootScope) {
        // Find the HeaderController if it exists
        angular.element(document).ready(function() {
            var headerScope = angular.element(document.querySelector('[ng-controller="HeaderController"]')).scope();
            if (headerScope) {
                // Add openCartPanel function to HeaderController
                headerScope.openCartPanel = function() {
                    $rootScope.$broadcast('openCart');
                };
                
                // Apply changes
                if (!headerScope.$$phase) {
                    headerScope.$apply();
                }
            }
        });
    }]);
})(); 