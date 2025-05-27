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
            phoneNumber: '',
            expedition: 'jne' // Default shipping expedition
        };
        
        // Initialize shipping rates object
        $scope.shippingRates = {
            jne: 0,
            jnt: 0,
            sicepat: 0
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
        $scope.shipping = 0; // Fixed shipping rate
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
            
            // Calculate shipping based on selected expedition and address
            if ($scope.shippingInfo.expedition) {
                $scope.calculateShippingCost($scope.shippingInfo.expedition);
            } else {
                // Default to JNE if no expedition selected yet
                $scope.shippingInfo.expedition = 'jne';
                $scope.calculateShippingCost('jne');
            }
            
            // Calculate total
            $scope.total = $scope.subtotal + $scope.shipping;

            // Log calculations for debugging
            console.log('Cart:', $scope.cart);
            console.log('Subtotal:', $scope.subtotal);
            console.log('Shipping:', $scope.shipping);
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
                            
                            // Recalculate shipping when address changes
                            if ($scope.shippingInfo.expedition) {
                                $scope.calculateShippingCost($scope.shippingInfo.expedition);
                                $scope.total = $scope.subtotal + $scope.shipping;
                            }
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
        
        // Handle shipping expedition selection
        $scope.selectShippingExpedition = function(expedition) {
            // Store previous expedition to check if it's changing
            let previousExpedition = $scope.shippingInfo.expedition;
            
            // Update selected expedition
            $scope.shippingInfo.expedition = expedition;
            
            // Calculate shipping based on address and expedition
            // This will update the shipping cost display for the newly selected expedition
            $scope.calculateShippingCost(expedition);
            
            // Recalculate total
            $scope.total = $scope.subtotal + $scope.shipping;
        };
        
        // This section was moved to the initialization part of the controller
        
        // Calculate shipping cost based on address and expedition
        $scope.calculateShippingCost = function(expedition) {
            // Default rates if calculation fails
            let defaultRates = {
                'jne': 20000,
                'jnt': 18000,
                'sicepat': 25000
            };
            
            // If no address, show placeholder rates but don't apply them to the total
            if (!$scope.shippingInfo.address) {
                // Calculate rates for all expeditions (just for display)
                $scope.shippingRates = {
                    jne: defaultRates['jne'],
                    jnt: defaultRates['jnt'],
                    sicepat: defaultRates['sicepat']
                };
                
                // Set shipping to 0 until address is provided
                $scope.shipping = 0;
                return;
            }
            
            // Get destination city from address
            let address = $scope.shippingInfo.address.toLowerCase();
            let destinationCity = '';
            
            // Try to extract city from address
            // Common Indonesian cities
            let cities = ['jakarta', 'surabaya', 'bandung', 'medan', 'semarang', 'makassar', 
                         'palembang', 'tangerang', 'depok', 'bekasi', 'batam', 'pekanbaru',
                         'yogyakarta', 'malang', 'denpasar', 'balikpapan', 'padang', 'manado'];
            
            // Find city in address
            for (let city of cities) {
                if (address.includes(city)) {
                    destinationCity = city;
                    break;
                }
            }
            
            // If no city found, check for province
            if (!destinationCity) {
                let provinces = ['jawa barat', 'jawa timur', 'jawa tengah', 'banten', 'dki jakarta',
                                'sumatera utara', 'sumatera selatan', 'sumatera barat', 'kalimantan',
                                'sulawesi', 'bali', 'nusa tenggara', 'papua', 'maluku'];
                
                for (let province of provinces) {
                    if (address.includes(province)) {
                        destinationCity = province;
                        break;
                    }
                }
            }
            
            // If still no location found, use default rates
            if (!destinationCity) {
                $scope.shippingRates = {
                    jne: defaultRates['jne'],
                    jnt: defaultRates['jnt'],
                    sicepat: defaultRates['sicepat']
                };
                
                $scope.shipping = $scope.shippingRates[expedition];
                return;
            }
            
            // Shipping rates from Bogor to various destinations (in IDR)
            // These rates are simplified estimates and should be replaced with actual API calls
            let shippingRateData = {
                // JNE rates (Regular service)
                'jne': {
                    'jakarta': 15000,
                    'depok': 12000,
                    'tangerang': 18000,
                    'bekasi': 18000,
                    'bandung': 22000,
                    'surabaya': 35000,
                    'yogyakarta': 30000,
                    'semarang': 28000,
                    'medan': 50000,
                    'makassar': 60000,
                    'bali': 45000,
                    'jawa barat': 20000,
                    'jawa timur': 35000,
                    'jawa tengah': 28000,
                    'banten': 18000,
                    'dki jakarta': 15000,
                    'sumatera': 45000,
                    'kalimantan': 55000,
                    'sulawesi': 60000,
                    'default': 40000
                },
                // J&T rates
                'jnt': {
                    'jakarta': 13000,
                    'depok': 10000,
                    'tangerang': 16000,
                    'bekasi': 16000,
                    'bandung': 20000,
                    'surabaya': 32000,
                    'yogyakarta': 28000,
                    'semarang': 26000,
                    'medan': 48000,
                    'makassar': 58000,
                    'bali': 42000,
                    'jawa barat': 18000,
                    'jawa timur': 32000,
                    'jawa tengah': 26000,
                    'banten': 16000,
                    'dki jakarta': 13000,
                    'sumatera': 42000,
                    'kalimantan': 52000,
                    'sulawesi': 58000,
                    'default': 38000
                },
                // SiCepat rates
                'sicepat': {
                    'jakarta': 18000,
                    'depok': 15000,
                    'tangerang': 20000,
                    'bekasi': 20000,
                    'bandung': 25000,
                    'surabaya': 38000,
                    'yogyakarta': 33000,
                    'semarang': 30000,
                    'medan': 55000,
                    'makassar': 65000,
                    'bali': 48000,
                    'jawa barat': 23000,
                    'jawa timur': 38000,
                    'jawa tengah': 30000,
                    'banten': 20000,
                    'dki jakarta': 18000,
                    'sumatera': 50000,
                    'kalimantan': 60000,
                    'sulawesi': 65000,
                    'default': 45000
                }
            };
            
            // Calculate rates for all expeditions
            let expeditions = ['jne', 'jnt', 'sicepat'];
            
            expeditions.forEach(function(exp) {
                let rates = shippingRateData[exp] || {};
                let found = false;
                
                // Find the most specific match
                for (let location in rates) {
                    if (destinationCity.includes(location) || location.includes(destinationCity)) {
                        $scope.shippingRates[exp] = rates[location];
                        found = true;
                        break;
                    }
                }
                
                // If no specific match found, use default for that expedition
                if (!found) {
                    $scope.shippingRates[exp] = rates['default'] || defaultRates[exp];
                }
            });
            
            // Set current shipping cost based on selected expedition
            $scope.shipping = $scope.shippingRates[expedition];
            
            // Log for debugging
            console.log('Shipping calculation:', {
                expedition: expedition,
                destination: destinationCity,
                rates: $scope.shippingRates,
                selectedRate: $scope.shipping
            });
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
            
            // Check if shipping expedition is selected
            if (!$scope.shippingInfo.expedition) {
                alert('Please select a shipping expedition (JNE, J&T, or SiCepat).');
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
                    expedition: $scope.shippingInfo.expedition
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
                        
                        // Clear cart in server session
                        $http.post('/api/clear-cart')
                            .then(function(response) {
                                console.log('Server cart cleared successfully:', response.data);
                                
                                // Clear cart in Angular model
                                $scope.cart = [];
                                $scope.calculateTotals();
                                
                                // Also clear cart in local storage if it exists
                                if (window.localStorage) {
                                    try {
                                        localStorage.removeItem('cart');
                                    } catch (e) {
                                        console.error('Error clearing localStorage cart:', e);
                                    }
                                }
                                
                                // Broadcast cart update event to other controllers
                                if (window.parent && window.parent.postMessage) {
                                    window.parent.postMessage({type: 'cartUpdated', cart: []}, '*');
                                }
                                
                                // Save empty cart to server
                                $http.post('/save-cart', { cart: [] })
                                    .then(function(response) {
                                        console.log('Empty cart saved to server:', response.data);
                                    })
                                    .catch(function(error) {
                                        console.error('Error saving empty cart to server:', error);
                                    });
                                
                                // Redirect to success page
                                window.location.href = '/order-success';
                            })
                            .catch(function(error) {
                                console.error('Error clearing server cart:', error);
                                // Continue with redirect even if cart clearing fails
                                window.location.href = '/order-success';
                            });
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