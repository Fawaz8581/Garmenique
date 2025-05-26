angular.module('garmeniqueApp', [])
    .controller('CheckoutController', ['$scope', '$http', function($scope, $http) {
        // Initialize step counter
        $scope.currentStep = 1;
        
        // Initialize address option
        $scope.addressOption = '';
        
        // Initialize phone option
        $scope.phoneOption = '';
        
        // Initialize shipping info
        $scope.shippingInfo = {
            firstName: '',
            lastName: '',
            email: '',
            address: '',
            city: '',
            postalCode: '',
            countryCode: '',
            phoneNumber: ''
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
        
        // Setup CSRF token for AJAX requests
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            $http.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        } else {
            console.error('CSRF token not found');
        }

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
        
        // Handle phone option selection
        $scope.selectPhoneOption = function(option) {
            $scope.phoneOption = option;
            
            if (option === 'saved') {
                // Load user's saved phone number
                $http.get('/api/user-address')
                    .then(function(response) {
                        if (response.data) {
                            // Phone number is already displayed from the server-side,
                            // but we'll store it for submission
                            $scope.shippingInfo.savedCountryCode = response.data.country_code || '';
                            $scope.shippingInfo.savedPhoneNumber = response.data.phone_number || '';
                        }
                    })
                    .catch(function(error) {
                        console.error('Error loading user phone number:', error);
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
            
            // Check if phone option is selected
            if (!$scope.phoneOption) {
                alert('Please select a phone number option (saved phone or new phone).');
                return false;
            }
            
            // Validate phone number if new phone option is selected
            if ($scope.phoneOption === 'new') {
                if (!$scope.shippingInfo.countryCode || !$scope.shippingInfo.phoneNumber) {
                    alert('Please enter a valid phone number with country code.');
                    return false;
                }
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
            // Final validation
            if (!$scope.validateShippingInfo() || !$scope.validatePaymentInfo()) {
                return;
            }
            
            // Prepare order data
            const orderData = {
                shippingInfo: {
                    firstName: $scope.shippingInfo.firstName,
                    lastName: $scope.shippingInfo.lastName,
                    email: $scope.shippingInfo.email,
                    address: $scope.shippingInfo.address,
                    city: $scope.shippingInfo.city,
                    postalCode: $scope.shippingInfo.postalCode,
                },
                paymentInfo: {
                    method: $scope.paymentMethod,
                    // Only include card details if credit card is selected
                    ...$scope.paymentMethod === 'credit' && {
                        cardNumber: $scope.paymentInfo.cardNumber,
                        expiryDate: $scope.paymentInfo.expiryDate,
                        cvv: $scope.paymentInfo.cvv
                    }
                },
                cart: $scope.cart,
                subtotal: $scope.subtotal,
                shipping: $scope.shipping,
                total: $scope.total
            };
            
            // Add phone information based on selected option
            if ($scope.phoneOption === 'saved') {
                orderData.shippingInfo.countryCode = $scope.shippingInfo.savedCountryCode;
                orderData.shippingInfo.phoneNumber = $scope.shippingInfo.savedPhoneNumber;
            } else if ($scope.phoneOption === 'new') {
                orderData.shippingInfo.countryCode = $scope.shippingInfo.countryCode;
                orderData.shippingInfo.phoneNumber = $scope.shippingInfo.phoneNumber;
            }
            
            // Show processing notification
            $scope.showNotification('Processing your order...', false);
            
            // Send order data to server
            console.log('Sending order data:', orderData);
            $http.post('/api/orders', orderData)
                .then(function(response) {
                    console.log('Order response:', response.data);
                    if (response.data.success) {
                        // Clear cart in session storage
                        sessionStorage.removeItem('cart');
                        
                        // Redirect to success page
                        window.location.href = '/order-success';
                    } else {
                        $scope.showNotification('Error: ' + response.data.message);
                    }
                })
                .catch(function(error) {
                    console.error('Error submitting order:', error);
                    // Log detailed error information
                    if (error.data) {
                        console.error('Error details:', error.data);
                    }
                    $scope.showNotification('An error occurred while processing your order. Please try again.');
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