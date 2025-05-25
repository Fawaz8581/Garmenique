angular.module('garmeniqueApp', [])
    .controller('CheckoutController', ['$scope', '$http', function($scope, $http) {
        // Initialize step counter
        $scope.currentStep = 1;
        
        // Initialize shipping info
        $scope.shippingInfo = {
            firstName: '',
            lastName: '',
            email: '',
            address: '',
            city: '',
            postalCode: ''
        };
        
        // Initialize payment info
        $scope.paymentInfo = {
            cardNumber: '',
            expiryDate: '',
            cvv: ''
        };
        
        // Initialize payment method
        $scope.paymentMethod = '';
        
        // Initialize cart and totals
        $scope.cart = [];
        $scope.subtotal = 0;
        $scope.shipping = 50000; // Fixed shipping rate
        $scope.total = 0;

        // Function to format number to IDR
        $scope.formatIDR = function(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        };
        
        // Load cart data from server
        $scope.loadCart = function() {
            $http.get('/get-cart')
                .then(function(response) {
                    if (response.data.cart) {
                        $scope.cart = response.data.cart;
                        $scope.calculateTotals();
                    }
                })
                .catch(function(error) {
                    console.error('Error loading cart:', error);
                    // Fallback to session storage if server request fails
                    try {
                        let cartData = JSON.parse(sessionStorage.getItem('cart') || '[]');
                        $scope.cart = cartData;
                        $scope.calculateTotals();
                    } catch (error) {
                        console.error('Error loading cart from session storage:', error);
                        $scope.cart = [];
                        $scope.calculateTotals();
                    }
                });
        };
        
        // Calculate totals
        $scope.calculateTotals = function() {
            // Calculate subtotal
            $scope.subtotal = $scope.cart.reduce((total, item) => {
                let price = parseFloat(item.price) || 0;
                let quantity = parseInt(item.quantity) || 0;
                return total + (price * quantity);
            }, 0);
            
            // Fixed shipping rate
            $scope.shipping = 50000;
            
            // Calculate total
            $scope.total = $scope.subtotal + $scope.shipping;

            // Log calculations for debugging
            console.log('Cart:', $scope.cart);
            console.log('Subtotal:', $scope.subtotal);
            console.log('Total:', $scope.total);
        };
        
        // Load initial cart data
        $scope.loadCart();
        
        // Handle payment method selection
        $scope.selectPaymentMethod = function(method) {
            $scope.paymentMethod = method;
        };
        
        // Navigation functions
        $scope.nextStep = function() {
            // Check if cart is empty
            if ($scope.cart.length === 0) {
                alert('Your cart is empty. Please add items to your cart before proceeding.');
                window.location.href = '/catalog';
                return;
            }

            // Validate current step
            if ($scope.currentStep === 1) {
                if (!$scope.validateShippingInfo()) {
                    return;
                }
            } else if ($scope.currentStep === 2) {
                if (!$scope.validatePaymentInfo()) {
                    return;
                }
            }
            
            if ($scope.currentStep < 3) {
                $scope.currentStep++;
            }
        };
        
        $scope.previousStep = function() {
            if ($scope.currentStep > 1) {
                $scope.currentStep--;
            }
        };
        
        // Validation functions
        $scope.validateShippingInfo = function() {
            if (!$scope.shippingInfo.firstName || 
                !$scope.shippingInfo.lastName || 
                !$scope.shippingInfo.email || 
                !$scope.shippingInfo.address || 
                !$scope.shippingInfo.city || 
                !$scope.shippingInfo.postalCode) {
                alert('Please fill in all shipping information fields.');
                return false;
            }
            return true;
        };
        
        $scope.validatePaymentInfo = function() {
            if (!$scope.paymentMethod) {
                alert('Please select a payment method.');
                return false;
            }
            
            if ($scope.paymentMethod === 'credit') {
                if (!$scope.paymentInfo.cardNumber || 
                    !$scope.paymentInfo.expiryDate || 
                    !$scope.paymentInfo.cvv) {
                    alert('Please fill in all credit card information.');
                    return false;
                }
            }
            
            return true;
        };
        
        // Submit order
        $scope.submitOrder = function() {
            if (!$scope.validateShippingInfo() || !$scope.validatePaymentInfo()) {
                return;
            }
            
            const orderData = {
                shipping: $scope.shippingInfo,
                payment: {
                    method: $scope.paymentMethod,
                    details: $scope.paymentMethod === 'credit' ? $scope.paymentInfo : {}
                },
                cart: $scope.cart,
                totals: {
                    subtotal: $scope.subtotal,
                    shipping: $scope.shipping,
                    total: $scope.total
                }
            };

            // Add CSRF token to headers
            $http.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Send order to server
            $http.post('/api/orders', orderData)
                .then(function(response) {
                    // Clear cart from both server and session storage
                    sessionStorage.removeItem('cart');
                    $http.post('/save-cart', { cart: [] })
                        .then(function() {
                            // Redirect to success page
                            window.location.href = '/order-success';
                        });
                })
                .catch(function(error) {
                    console.error('Error placing order:', error);
                    alert('There was an error processing your order. Please try again.');
                });
        };

        // Watch for cart changes in session storage
        window.addEventListener('storage', function(e) {
            if (e.key === 'cart') {
                $scope.$apply(function() {
                    $scope.loadCart();
                });
            }
        });

        // Reload cart data periodically to ensure sync
        setInterval(function() {
            $scope.$apply(function() {
                $scope.loadCart();
            });
        }, 5000); // Reload every 5 seconds
    }]); 