angular.module('garmeniqueApp', [])
    .controller('CheckoutController', ['$scope', '$http', function($scope, $http) {
        // Initialize step counter
        $scope.currentStep = 1;
        
        // Initialize address option
        $scope.addressOption = '';
        
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

        // Google address search input
        $scope.googleAddress = '';

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

        // Handle address option selection
        $scope.selectAddressOption = function(option) {
            $scope.addressOption = option;
            
            if (option === 'saved') {
                // Load user's saved address
                $http.get('/api/user-address')
                    .then(function(response) {
                        if (response.data && response.data.address) {
                            $scope.shippingInfo.address = response.data.address;
                            // Set empty values for hidden fields
                            $scope.shippingInfo.city = '';
                            $scope.shippingInfo.postalCode = '';
                        }
                    })
                    .catch(function(error) {
                        console.error('Error loading user address:', error);
                    });
            }
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
            // Check if address option is selected
            if (!$scope.addressOption) {
                alert('Please select an address option (saved address or Google Maps).');
                return false;
            }
            
            if (!$scope.shippingInfo.firstName || 
                !$scope.shippingInfo.lastName || 
                !$scope.shippingInfo.email || 
                !$scope.shippingInfo.address) {
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
        
        // Show error notification
        $scope.showNotification = function(message, isError = true) {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.position = 'fixed';
            notification.style.bottom = '20px';
            notification.style.left = '50%';
            notification.style.transform = 'translateX(-50%)';
            notification.style.backgroundColor = isError ? 'rgba(220, 53, 69, 0.9)' : 'rgba(40, 167, 69, 0.9)';
            notification.style.color = 'white';
            notification.style.padding = '15px 25px';
            notification.style.borderRadius = '5px';
            notification.style.zIndex = '9999';
            notification.style.maxWidth = '80%';
            notification.style.textAlign = 'center';
            notification.textContent = message;
            
            // Add to document
            document.body.appendChild(notification);
            
            // Remove after 5 seconds
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 5000);
        };
        
        // Submit order
        $scope.submitOrder = function() {
            if (!$scope.validateShippingInfo() || !$scope.validatePaymentInfo()) {
                return;
            }
            
            // Show loading notification
            $scope.showNotification('Processing your order...', false);
            
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
                    if (response.data && response.data.success) {
                        // Clear cart from both server and session storage
                        sessionStorage.removeItem('cart');
                        $http.post('/save-cart', { cart: [] })
                            .then(function() {
                                // Redirect to success page
                                window.location.href = '/order-success';
                            })
                            .catch(function(error) {
                                console.error('Error clearing cart:', error);
                                // Still redirect to success page since order was placed
                                window.location.href = '/order-success';
                            });
                    } else {
                        // Handle unexpected success response format
                        console.error('Unexpected response format:', response);
                        $scope.showNotification('There was an error processing your order. Please try again.');
                    }
                })
                .catch(function(error) {
                    console.error('Error placing order:', error);
                    
                    let errorMessage = 'There was an error processing your order. Please try again.';
                    
                    // Try to extract more specific error message
                    if (error.data && error.data.message) {
                        errorMessage = error.data.message;
                    } else if (error.data && error.data.error) {
                        errorMessage = error.data.error;
                    } else if (error.status === 422) {
                        errorMessage = 'Please check your information and try again.';
                        
                        // Handle validation errors
                        if (error.data && error.data.errors) {
                            const firstError = Object.values(error.data.errors)[0];
                            if (Array.isArray(firstError) && firstError.length > 0) {
                                errorMessage = firstError[0];
                            }
                        }
                    } else if (error.status === 401) {
                        errorMessage = 'Please login to complete your order.';
                    } else if (error.status === 500) {
                        errorMessage = 'Server error. Please try again later.';
                    }
                    
                    $scope.showNotification(errorMessage);
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