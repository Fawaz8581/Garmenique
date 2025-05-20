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
    app.controller('CartController', ['$scope', '$window', '$rootScope', function($scope, $window, $rootScope) {
        // Initialize cart
        $scope.isCartActive = false;
        $scope.cartItems = [];
        
        // Load cart items from localStorage on initialization
        function loadCartFromStorage() {
            try {
                var storedCart = localStorage.getItem('garmenique_cart');
                if (storedCart) {
                    $scope.cartItems = JSON.parse(storedCart);
                }
            } catch (e) {
                console.error('Error loading cart from storage:', e);
            }
        }
        
        // Save cart items to localStorage
        function saveCartToStorage() {
            try {
                localStorage.setItem('garmenique_cart', JSON.stringify($scope.cartItems));
            } catch (e) {
                console.error('Error saving cart to storage:', e);
            }
        }
        
        // Initialize from localStorage
        loadCartFromStorage();
        
        // Listen for broadcast events
        $rootScope.$on('openCart', function() {
            $scope.openCart();
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
            
            // Save updated cart to localStorage
            saveCartToStorage();
            
            // Open the cart
            $scope.openCart();
            
            // Apply changes to update the UI
            if(!$scope.$$phase) {
                $scope.$apply();
            }
        };
        
        // Increase quantity
        $scope.increaseQuantity = function(item) {
            item.quantity++;
            saveCartToStorage();
        };
        
        // Decrease quantity
        $scope.decreaseQuantity = function(item) {
            if(item.quantity > 1) {
                item.quantity--;
            } else {
                // Remove item if quantity becomes 0
                var index = $scope.cartItems.indexOf(item);
                if(index !== -1) {
                    $scope.cartItems.splice(index, 1);
                }
            }
            saveCartToStorage();
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
            $window.location.href = '/checkout';
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