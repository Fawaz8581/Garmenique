var app = angular.module('garmenique', []);

app.controller('MainController', ['$scope', '$http', function($scope, $http) {
    // Cart Panel State
    $scope.isCartActive = false;
    $scope.isLoading = true;
    $scope.cartItems = [];
    $scope.isAuthenticated = false;

    // Check authentication status
    $http.get('/api/auth/check').then(function(response) {
        $scope.isAuthenticated = response.data.authenticated;
        if ($scope.isAuthenticated) {
            loadCart();
        } else {
            $scope.isLoading = false;
        }
    }).catch(function(error) {
        console.error('Error checking auth status:', error);
        $scope.isLoading = false;
    });

    // Load cart items
    function loadCart() {
        $http.get('/api/cart').then(function(response) {
            $scope.cartItems = response.data;
            $scope.isLoading = false;
        }).catch(function(error) {
            console.error('Error loading cart:', error);
            $scope.isLoading = false;
        });
    }

    // Open cart panel
    $scope.openCartPanel = function() {
        $scope.isCartActive = true;
        document.body.style.overflow = 'hidden';
    };

    // Close cart panel
    $scope.closeCart = function() {
        $scope.isCartActive = false;
        document.body.style.overflow = '';
    };

    // Get total items in cart
    $scope.getTotalItems = function() {
        return $scope.cartItems.reduce(function(total, item) {
            return total + (item.quantity || 0);
        }, 0);
    };

    // Calculate subtotal
    $scope.calculateSubtotal = function() {
        return $scope.cartItems.reduce(function(total, item) {
            var price = item.price * (1 - (item.discount || 0) / 100);
            return total + (price * (item.quantity || 0));
        }, 0);
    };

    // Increase item quantity
    $scope.increaseQuantity = function(item) {
        $http.post('/api/cart/increase', {
            product_id: item.id,
            size: item.size
        }).then(function(response) {
            item.quantity++;
        }).catch(function(error) {
            console.error('Error increasing quantity:', error);
        });
    };

    // Decrease item quantity
    $scope.decreaseQuantity = function(item) {
        if (item.quantity > 1) {
            $http.post('/api/cart/decrease', {
                product_id: item.id,
                size: item.size
            }).then(function(response) {
                item.quantity--;
            }).catch(function(error) {
                console.error('Error decreasing quantity:', error);
            });
        } else {
            $http.post('/api/cart/remove', {
                product_id: item.id,
                size: item.size
            }).then(function(response) {
                var index = $scope.cartItems.indexOf(item);
                if (index > -1) {
                    $scope.cartItems.splice(index, 1);
                }
            }).catch(function(error) {
                console.error('Error removing item:', error);
            });
        }
    };

    // Proceed to checkout
    $scope.proceedToCheckout = function() {
        window.location.href = '/checkout';
    };
}]); 