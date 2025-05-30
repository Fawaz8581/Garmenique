<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Garmenique - Contact Information</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Premium Clothing Brand">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
    <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .phone-input-container {
            display: flex;
            width: 100%;
            margin: 5px 0;
        }

        .country-select {
            position: relative;
            min-width: 90px;
        }

        .selected-flag {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            cursor: pointer;
            background: white;
        }

        .country-flag {
            width: 24px;
            height: 16px;
            margin-right: 5px;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .selected-dial-code {
            color: #333;
            font-size: 14px;
        }

        .arrow {
            margin-left: 5px;
            font-size: 12px;
        }

        .country-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 300px;
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border: 1px solid #ddd;
            border-radius: 0 0 4px 4px;
            z-index: 100;
            display: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .country-dropdown.show {
            display: block;
        }

        .country-search {
            position: sticky;
            top: 0;
            padding: 8px;
            background: white;
            border-bottom: 1px solid #eee;
            z-index: 2;
        }
        
        .country-search input {
            width: 100%;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .country-list {
            width: 100%;
        }

        .country-option {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }

        .country-option:hover {
            background-color: #f5f5f5;
        }

        .country-name {
            margin-left: 8px;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
        }

        .dial-code {
            margin-left: auto;
            color: #777;
            font-size: 14px;
        }

        .phone-number-input {
            flex-grow: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-left: none;
            border-radius: 0 4px 4px 0;
            outline: none;
        }

        textarea.form-control {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 5px 0;
            background: #fff;
            resize: none;
            outline: none;
            overflow-y: hidden;
            overflow-x: visible;
            min-height: 24px;
            font-family: inherit;
            font-size: inherit;
            line-height: 1.5;
            display: block;
            white-space: pre-wrap;
            word-wrap: break-word;
            box-sizing: border-box;
        }

        .address-field {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 14px;
            box-sizing: border-box;
        }
        
        .address-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .address-full-width {
            grid-column: 1 / -1;
        }
        
        .address-section-heading {
            font-weight: 500;
            margin: 20px 0 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
    </style>
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
                    <li><a href="/blog" class="nav-item">BLOG</a></li>
                    <li><a href="/about" class="nav-item">ABOUT</a></li>
                    <li><a href="/contact" class="nav-item">CONTACT</a></li>
                </ul>
            </nav>
            
            <div class="nav-icons">
                <a href="{{ route('user.messages') }}" class="nav-icon"><i class="fas fa-envelope"></i></a>
                @include('partials.account-dropdown')
                <a href="javascript:void(0)" class="nav-icon" ng-click="openCartPanel()"><i class="fas fa-shopping-cart"></i></a>
            </div>
            
            <button class="mobile-toggle" ng-click="toggleNav()">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <!-- Account Settings Section -->
    <section class="account-section mt-3">
        <div class="account-container mt-3">
            <!-- Spacer -->
            <div class="spacer py-2"></div>
            
            <div class="account-header">
                <h1>Account Settings</h1>
                <p>Manage your account information and preferences</p>
            </div>
            
            <div class="account-content">
                <div class="account-sidebar">
                    <ul class="account-nav">
                        <li><a href="{{ route('account.settings') }}">Profile Settings</a></li>
                        <li><a href="{{ route('account.password') }}">Password</a></li>
                        <li><a href="{{ route('account.contact') }}" class="active">Contact Information</a></li>
                        <li><a href="{{ route('account.orders') }}">Your Orders</a></li>
                        <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">Logout</a></li>
                    </ul>
                    <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                
                <div class="account-main">
                    <h2>Contact Information</h2>
                    
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('account.update.contact') }}">
                        @csrf
                        
                        <!-- Phone Number Section -->
                        <div class="address-section-heading">Phone Number</div>
                        
                        <div class="form-group">
                            <div class="phone-input-container">
                                <div class="country-select">
                                    <div class="selected-flag" onclick="toggleCountryDropdown()">
                                        <div class="country-flag" id="selected-country-flag" style="background-image: url('https://flagcdn.com/w40/id.png')"></div>
                                        <span class="selected-dial-code">{{ Auth::user()->country_code ?? '+62' }}</span>
                                        <span class="arrow">▼</span>
                                    </div>
                                    <div class="country-dropdown" id="countryDropdown">
                                        <div class="country-search">
                                            <input type="text" placeholder="Search countries" id="country-search-input" onkeyup="filterCountries()">
                                        </div>
                                        <div class="country-list" id="country-list">
                                            <!-- Countries will be loaded via JavaScript -->
                                        </div>
                                    </div>
                                </div>
                                <input type="tel" id="phone" name="phone_number" class="phone-number-input" placeholder="Enter your phone number" value="{{ Auth::user()->phone_number ?? '' }}">
                                <input type="hidden" id="country_code" name="country_code" value="{{ Auth::user()->country_code ?? '+62' }}">
                            </div>
                        </div>
                        
                        <!-- Address Section -->
                        <div class="address-section-heading">Address Information</div>
                        
                        <div class="form-group">
                            <label for="address">Current Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="Enter your full address" rows="3" oninput="expandTextarea(this)">{{ Auth::user()->address ?? '' }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <div class="address-field-container">
                                <label for="street_address">Street Address</label>
                                <input type="text" id="street_address" name="street_address" class="address-field address-full-width" placeholder="Enter your street address, building, house number">
                            </div>
                            
                            <div class="address-grid">
                                <div>
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" class="address-field" placeholder="City" value="{{ Auth::user()->city ?? '' }}">
                                </div>
                                <div>
                                    <label for="state">State/Province</label>
                                    <input type="text" id="state" name="state" class="address-field" placeholder="State or province">
                                </div>
                            </div>
                            
                            <div class="address-grid">
                                <div>
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" id="postal_code" name="postal_code" class="address-field" placeholder="Postal/ZIP code" value="{{ Auth::user()->postal_code ?? '' }}">
                                </div>
                                <div>
                                    <label for="country">Country</label>
                                    <input type="text" id="country" name="country" class="address-field" placeholder="Country">
                                </div>
                            </div>
                            
                            <div class="address-field-container">
                                <label for="address_notes">Address Notes (Optional)</label>
                                <textarea id="address_notes" name="address_notes" class="form-control" rows="2" placeholder="Landmark, delivery instructions, etc."></textarea>
                            </div>
                            
                            <div style="text-align: right; margin-top: 10px; margin-bottom: 20px;">
                                <button type="button" class="btn-save" onclick="saveFullAddressWithNotes()">Update Address Format</button>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-save">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- End account dashboard content -->

    <!-- Include Sliding Cart Partial -->
    @include('partials.sliding-cart')

    <!-- Footer -->
    @include('partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/landingpage.js') }}"></script>
    <script>
        // Country data with flags, names, and dial codes
        const countries = [
            { code: "af", name: "Afghanistan", dialCode: "+93" },
            { code: "al", name: "Albania", dialCode: "+355" },
            { code: "dz", name: "Algeria", dialCode: "+213" },
            { code: "as", name: "American Samoa", dialCode: "+1684" },
            { code: "ad", name: "Andorra", dialCode: "+376" },
            { code: "ao", name: "Angola", dialCode: "+244" },
            { code: "ai", name: "Anguilla", dialCode: "+1264" },
            { code: "ag", name: "Antigua and Barbuda", dialCode: "+1268" },
            { code: "ar", name: "Argentina", dialCode: "+54" },
            { code: "am", name: "Armenia", dialCode: "+374" },
            { code: "aw", name: "Aruba", dialCode: "+297" },
            { code: "au", name: "Australia", dialCode: "+61" },
            { code: "at", name: "Austria", dialCode: "+43" },
            { code: "az", name: "Azerbaijan", dialCode: "+994" },
            { code: "bs", name: "Bahamas", dialCode: "+1242" },
            { code: "bh", name: "Bahrain", dialCode: "+973" },
            { code: "bd", name: "Bangladesh", dialCode: "+880" },
            { code: "bb", name: "Barbados", dialCode: "+1246" },
            { code: "by", name: "Belarus", dialCode: "+375" },
            { code: "be", name: "Belgium", dialCode: "+32" },
            { code: "bz", name: "Belize", dialCode: "+501" },
            { code: "bj", name: "Benin", dialCode: "+229" },
            { code: "bm", name: "Bermuda", dialCode: "+1441" },
            { code: "bt", name: "Bhutan", dialCode: "+975" },
            { code: "bo", name: "Bolivia", dialCode: "+591" },
            { code: "ba", name: "Bosnia and Herzegovina", dialCode: "+387" },
            { code: "bw", name: "Botswana", dialCode: "+267" },
            { code: "br", name: "Brazil", dialCode: "+55" },
            { code: "bn", name: "Brunei", dialCode: "+673" },
            { code: "bg", name: "Bulgaria", dialCode: "+359" },
            { code: "bf", name: "Burkina Faso", dialCode: "+226" },
            { code: "bi", name: "Burundi", dialCode: "+257" },
            { code: "kh", name: "Cambodia", dialCode: "+855" },
            { code: "cm", name: "Cameroon", dialCode: "+237" },
            { code: "ca", name: "Canada", dialCode: "+1" },
            { code: "cv", name: "Cape Verde", dialCode: "+238" },
            { code: "ky", name: "Cayman Islands", dialCode: "+1345" },
            { code: "cf", name: "Central African Republic", dialCode: "+236" },
            { code: "td", name: "Chad", dialCode: "+235" },
            { code: "cl", name: "Chile", dialCode: "+56" },
            { code: "cn", name: "China", dialCode: "+86" },
            { code: "id", name: "Indonesia", dialCode: "+62" },
            { code: "us", name: "United States", dialCode: "+1" },
            // Note: This is a shortened list, for all countries, include the full list from settings.blade.php
        ];

        // Populate country list when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            populateCountryList(countries);
            
            // Set Indonesia as the default selected country or use saved country
            const savedCountryCode = document.getElementById('country_code').value;
            let countryToUse;
            
            if (savedCountryCode) {
                countryToUse = countries.find(country => country.dialCode === savedCountryCode);
            }
            
            if (!countryToUse) {
                countryToUse = countries.find(country => country.code === 'id');
            }
            
            if (countryToUse) {
                selectCountry(countryToUse.code, countryToUse.dialCode, countryToUse.name);
            }
            
            // Adjust address textarea height on load if it contains data
            const addressTextarea = document.getElementById('address');
            if (addressTextarea && addressTextarea.value) {
                expandTextarea(addressTextarea);
            }
        });

        function populateCountryList(countriesData) {
            const countryList = document.getElementById('country-list');
            countryList.innerHTML = '';
            
            countriesData.forEach(country => {
                const option = document.createElement('div');
                option.className = 'country-option';
                option.innerHTML = `
                    <div class="country-flag" style="background-image: url('https://flagcdn.com/w40/${country.code}.png')"></div>
                    <span class="country-name">${country.name}</span>
                    <span class="dial-code">${country.dialCode}</span>
                `;
                option.onclick = function() {
                    selectCountry(country.code, country.dialCode, country.name);
                };
                countryList.appendChild(option);
            });
        }

        function toggleCountryDropdown() {
            document.getElementById('countryDropdown').classList.toggle('show');
            if (document.getElementById('countryDropdown').classList.contains('show')) {
                document.getElementById('country-search-input').focus();
            }
        }

        function selectCountry(code, dialCode, name) {
            // Update the selected country button
            document.getElementById('selected-country-flag').style.backgroundImage = `url('https://flagcdn.com/w40/${code}.png')`;
            document.querySelector('.selected-dial-code').textContent = dialCode;
            
            // Update hidden input with the selected country code
            document.getElementById('country_code').value = dialCode;
            
            // Hide the dropdown
            document.getElementById('countryDropdown').classList.remove('show');
        }

        function filterCountries() {
            const input = document.getElementById('country-search-input');
            const filter = input.value.toUpperCase();
            const filteredCountries = countries.filter(country => 
                country.name.toUpperCase().includes(filter) || 
                country.dialCode.includes(filter)
            );
            
            populateCountryList(filteredCountries);
        }

        // Close the dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.closest('.country-select')) {
                document.getElementById('countryDropdown').classList.remove('show');
            }
        }

        // Function to adjust textarea height
        function adjustTextareaHeight(element) {
            element.style.height = "";
            element.style.height = Math.min(element.scrollHeight, 300) + "px";
        }

        // Function to expand textarea when text enters a new line
        function expandTextarea(element) {
            element.style.height = "";
            element.style.height = Math.min(element.scrollHeight, 300) + "px";
            
            // Reset width first
            element.style.width = "100%";
            
            // Set a timeout to allow text to render before measuring
            setTimeout(function() {
                // If scrollWidth is greater than clientWidth, text is overflowing
                if (element.scrollWidth > element.clientWidth) {
                    element.style.width = (element.scrollWidth + 20) + "px";
                }
            }, 0);
        }

        // Save full address including notes with a single button
        function saveFullAddressWithNotes() {
            const streetAddress = document.getElementById('street_address').value;
            const city = document.getElementById('city').value;
            const state = document.getElementById('state').value;
            const postalCode = document.getElementById('postal_code').value;
            const country = document.getElementById('country').value;
            const notes = document.getElementById('address_notes').value.trim();
            
            if (!streetAddress) {
                alert('Please enter at least a street address');
                return;
            }
            
            // Compile address
            let fullAddress = streetAddress;
            if (city) fullAddress += ', ' + city;
            if (state) fullAddress += ', ' + state;
            if (postalCode) fullAddress += ' ' + postalCode;
            if (country) fullAddress += ', ' + country;
            
            // Add notes if provided
            if (notes) {
                fullAddress += '\n\nNotes: ' + notes;
            }
            
            // Set the address field
            const addressField = document.getElementById('address');
            addressField.value = fullAddress;
            
            expandTextarea(addressField);
            
            // Clear the form fields
            document.getElementById('street_address').value = '';
            document.getElementById('city').value = '';
            document.getElementById('state').value = '';
            document.getElementById('postal_code').value = '';
            document.getElementById('country').value = '';
            document.getElementById('address_notes').value = '';
            
            // Show confirmation
            alert('Address format has been updated');
        }

        // Create the CartController in case it wasn't properly registered
        (function() {
            try {
                var app = angular.module('garmeniqueApp');
                
                // Define CartController only if it doesn't already exist
                if (!app._invokeQueue || !app._invokeQueue.some(function(q) { 
                    return q[1] === 'controller' && q[2][0] === 'CartController'; 
                })) {
                    app.controller('CartController', ['$scope', '$rootScope', '$http', '$window', function($scope, $rootScope, $http, $window) {
                        // Basic cart properties
                        $scope.isCartActive = false;
                        $scope.cartItems = [];
                        $scope.isAuthenticated = true;
                        $scope.isLoading = true;  // Set to true while loading
                        
                        // Load cart from server
                        function loadCartFromSession() {
                            console.log("Loading cart from session");
                            $scope.isLoading = true;
                            
                            $http.get('/get-cart?_=' + new Date().getTime(), {
                                headers: {'Cache-Control': 'no-cache'}
                            })
                            .then(function(response) {
                                console.log('Get cart response:', response.data);
                                if (response.data.cart && Array.isArray(response.data.cart)) {
                                    $scope.cartItems = response.data.cart;
                                }
                                $scope.isLoading = false;
                            })
                            .catch(function(error) {
                                console.error('Error loading cart from session:', error);
                                $scope.isLoading = false;
                            });
                        }
                        
                        // Check auth status and load cart
                        function checkAuth() {
                            $http.get('/check-auth?_=' + new Date().getTime(), {
                                headers: {'Cache-Control': 'no-cache'}
                            })
                            .then(function(response) {
                                console.log('Auth check response:', response.data);
                                $scope.isAuthenticated = response.data.authenticated;
                                
                                if ($scope.isAuthenticated) {
                                    loadCartFromSession();
                                } else {
                                    $scope.isLoading = false;
                                }
                            })
                            .catch(function(error) {
                                console.error('Auth check error:', error);
                                $scope.isLoading = false;
                            });
                        }
                        
                        // Save cart to session
                        $scope.saveCartToSession = function() {
                            console.log("Saving cart to session");
                            
                            if (!$scope.isAuthenticated) {
                                console.log("Not authenticated, can't save cart");
                                return Promise.reject("Not authenticated");
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
                        };
                        
                        // Required cart functions
                        $scope.openCart = function() {
                            console.log("Opening cart");
                            $scope.isCartActive = true;
                            document.body.style.overflow = 'hidden';
                        };
                        
                        $scope.closeCart = function() {
                            console.log("Closing cart");
                            $scope.isCartActive = false;
                            document.body.style.overflow = '';
                        };
                        
                        $scope.increaseQuantity = function(item) {
                            item.quantity = (item.quantity || 1) + 1;
                            $scope.saveCartToSession();
                        };
                        
                        $scope.decreaseQuantity = function(item) {
                            if (item.quantity > 1) {
                                item.quantity--;
                            } else {
                                var index = $scope.cartItems.indexOf(item);
                                if (index !== -1) {
                                    $scope.cartItems.splice(index, 1);
                                }
                            }
                            $scope.saveCartToSession();
                        };
                        
                        $scope.calculateSubtotal = function() {
                            var total = 0;
                            $scope.cartItems.forEach(function(item) {
                                var price = item.price;
                                if (item.discount) {
                                    price = price * (1 - item.discount/100);
                                }
                                total += price * item.quantity;
                            });
                            return total;
                        };
                        
                        $scope.getTotalItems = function() {
                            var count = 0;
                            $scope.cartItems.forEach(function(item) {
                                count += item.quantity;
                            });
                            return count;
                        };
                        
                        // Proceed to checkout function
                        $scope.proceedToCheckout = function() {
                            if (!$scope.isAuthenticated) {
                                alert('Please login to checkout');
                                $window.location.href = '/login';
                                return;
                            }
                            
                            $window.location.href = '/checkout';
                        };
                        
                        // Listen for both openCart and openCartPanel events
                        $rootScope.$on('openCart', function() {
                            console.log("Received openCart event");
                            $scope.openCart();
                        });
                        
                        $rootScope.$on('openCartPanel', function() {
                            console.log("Received openCartPanel event");
                            $scope.openCart();
                        });
                        
                        // Initialize by checking auth and loading cart
                        checkAuth();
                    }]);
                }
                
                // Define HeaderController only if it doesn't already exist
                if (!app._invokeQueue || !app._invokeQueue.some(function(q) { 
                    return q[1] === 'controller' && q[2][0] === 'HeaderController'; 
                })) {
                    app.controller('HeaderController', ['$scope', '$rootScope', function($scope, $rootScope) {
                        $scope.isNavActive = false;
                        
                        $scope.toggleNav = function() {
                            $scope.isNavActive = !$scope.isNavActive;
                        };
                        
                        // Send both openCart and openCartPanel events for compatibility
                        $scope.openCartPanel = function() {
                            console.log("Broadcasting openCart and openCartPanel events");
                            $rootScope.$broadcast('openCart');
                            $rootScope.$broadcast('openCartPanel');
                        };
                    }]);
                }
            } catch(e) {
                console.error("Error setting up controllers:", e);
            }
        })();
        
        // Add function to manually load cart data if Angular fails
        function loadCartDataManually() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/get-cart?_=' + new Date().getTime(), true);
            xhr.setRequestHeader('Cache-Control', 'no-cache');
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        
                        if (response.cart && Array.isArray(response.cart) && response.cart.length > 0) {
                            var cartItemsContainer = document.querySelector('.cart-items');
                            var emptyCartMessage = document.querySelector('.empty-cart');
                            var cartFooter = document.querySelector('.sliding-cart-footer');
                            
                            if (cartItemsContainer && emptyCartMessage && cartFooter) {
                                // Hide empty cart message and show footer
                                emptyCartMessage.style.display = 'none';
                                cartFooter.style.display = 'block';
                                
                                // Clear existing items
                                cartItemsContainer.innerHTML = '';
                                
                                // Add each item
                                var totalItems = 0;
                                var subtotal = 0;
                                
                                response.cart.forEach(function(item) {
                                    var itemHtml = `
                                        <div class="cart-item">
                                            <div class="cart-item-image">
                                                <img src="${item.image}" alt="${item.name}">
                                            </div>
                                            <div class="cart-item-details">
                                                <h4 class="cart-item-title">${item.name}</h4>
                                                <p class="cart-item-variants">${item.size} · ${item.color}</p>
                                                <div class="cart-item-price">`;
                                    
                                    if (item.discount) {
                                        var discountedPrice = item.price * (1 - item.discount/100);
                                        itemHtml += `
                                            <span class="current-price">IDR ${Math.round(discountedPrice).toLocaleString('id-ID')}</span>
                                            <span class="old-price">IDR ${Math.round(item.price).toLocaleString('id-ID')}</span>
                                            <span class="discount-badge">${item.discount}% Off</span>`;
                                        subtotal += discountedPrice * item.quantity;
                                    } else {
                                        itemHtml += `<span class="current-price">IDR ${Math.round(item.price).toLocaleString('id-ID')}</span>`;
                                        subtotal += item.price * item.quantity;
                                    }
                                    
                                    itemHtml += `
                                                </div>
                                            </div>
                                            <div class="cart-item-quantity">
                                                <button class="quantity-btn minus" onclick="handleQuantityAction('decrease', this)">−</button>
                                                <input type="text" value="${item.quantity}" readonly>
                                                <button class="quantity-btn plus" onclick="handleQuantityAction('increase', this)">+</button>
                                            </div>
                                        </div>`;
                                    
                                    cartItemsContainer.innerHTML += itemHtml;
                                    totalItems += item.quantity;
                                });
                                
                                // Update subtotal
                                var subtotalEl = document.querySelector('.subtotal-price');
                                var itemsCountEl = document.querySelector('.cart-subtotal span:first-child');
                                
                                if (subtotalEl) {
                                    subtotalEl.textContent = 'IDR ' + Math.round(subtotal).toLocaleString('id-ID');
                                }
                                
                                if (itemsCountEl) {
                                    itemsCountEl.textContent = 'Subtotal (' + totalItems + ' items)';
                                }
                                
                                // Set up quantity buttons
                                setupQuantityButtons();
                                setupCheckoutButton();
                            }
                        }
                    } catch (e) {
                        console.error('Error parsing cart data:', e);
                    }
                }
            };
            
            xhr.onerror = function() {
                console.error('Error loading cart data');
            };
            
            xhr.send();
        }
        
        // Ensure cart functionality works even without Angular
        document.addEventListener('DOMContentLoaded', function() {
            // Load cart data manually as a fallback
            loadCartDataManually();
            
            // Open cart panel when clicking the cart icon
            var cartButtons = document.querySelectorAll('[ng-click="openCartPanel()"]');
            cartButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    console.log("Cart button clicked");
                    var cartPanel = document.querySelector('.sliding-cart-panel');
                    var cartOverlay = document.querySelector('.sliding-cart-overlay');
                    
                    if (cartPanel && cartOverlay) {
                        cartPanel.classList.add('active');
                        cartOverlay.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                });
            });
            
            // Close cart panel when clicking the close button or overlay
            var closeBtn = document.querySelector('.sliding-cart-panel .close-btn');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    var cartPanel = document.querySelector('.sliding-cart-panel');
                    var cartOverlay = document.querySelector('.sliding-cart-overlay');
                    
                    if (cartPanel && cartOverlay) {
                        cartPanel.classList.remove('active');
                        cartOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            }
            
            var cartOverlay = document.querySelector('.sliding-cart-overlay');
            if (cartOverlay) {
                cartOverlay.addEventListener('click', function() {
                    var cartPanel = document.querySelector('.sliding-cart-panel');
                    
                    if (cartPanel) {
                        cartPanel.classList.remove('active');
                        this.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            }
            
            // Handle quantity action function (for onclick handlers)
            window.handleQuantityAction = function(action, button) {
                if (action === 'increase') {
                    increaseQuantity.call(button);
                } else if (action === 'decrease') {
                    decreaseQuantity.call(button);
                }
            };
            
            // Add DOM-based quantity buttons functionality
            function setupQuantityButtons() {
                var minusButtons = document.querySelectorAll('.quantity-btn.minus');
                var plusButtons = document.querySelectorAll('.quantity-btn.plus');
                
                minusButtons.forEach(function(btn) {
                    // Remove any existing click listeners first
                    btn.removeEventListener('click', decreaseQuantity);
                    // Add a new one
                    btn.addEventListener('click', decreaseQuantity);
                });
                
                plusButtons.forEach(function(btn) {
                    // Remove any existing click listeners first
                    btn.removeEventListener('click', increaseQuantity);
                    // Add a new one
                    btn.addEventListener('click', increaseQuantity);
                });
            }
            
            // Separate functions for event handlers
            function decreaseQuantity() {
                var inputEl = this.parentNode.querySelector('input');
                if (!inputEl) return;
                
                var currentVal = parseInt(inputEl.value) || 1;
                if (currentVal > 1) {
                    inputEl.value = currentVal - 1;
                } else {
                    // Remove item if quantity goes to 0
                    var itemContainer = this.closest('.cart-item');
                    if (itemContainer) {
                        itemContainer.style.opacity = '0.5';
                        setTimeout(function() {
                            itemContainer.remove();
                            
                            // Check if cart is empty
                            var remainingItems = document.querySelectorAll('.cart-item');
                            if (remainingItems.length === 0) {
                                var emptyCart = document.querySelector('.empty-cart');
                                var cartFooter = document.querySelector('.sliding-cart-footer');
                                
                                if (emptyCart) emptyCart.style.display = 'block';
                                if (cartFooter) cartFooter.style.display = 'none';
                            }
                        }, 300);
                    }
                }
                
                // Update subtotal
                updateSubtotal();
                
                // Save changes to server
                saveCartChanges();
            }
            
            function increaseQuantity() {
                var inputEl = this.parentNode.querySelector('input');
                if (!inputEl) return;
                
                var currentVal = parseInt(inputEl.value) || 1;
                inputEl.value = currentVal + 1;
                
                // Update subtotal
                updateSubtotal();
                
                // Save changes to server
                saveCartChanges();
            }
            
            // Function to update subtotal
            function updateSubtotal() {
                var subtotal = 0;
                var totalItems = 0;
                
                document.querySelectorAll('.cart-item').forEach(function(item) {
                    var priceEl = item.querySelector('.current-price');
                    var qtyEl = item.querySelector('input');
                    
                    if (priceEl && qtyEl) {
                        // Extract only the numeric part and handle thousands separator properly
                        var priceText = priceEl.textContent.replace('IDR ', '').trim();
                        var price = parseFloat(priceText.replace(/\./g, '').replace(/,/g, '.'));
                        var qty = parseInt(qtyEl.value) || 1;
                        
                        subtotal += price * qty;
                        totalItems += qty;
                    }
                });
                
                // Update displayed subtotal
                var subtotalEl = document.querySelector('.subtotal-price');
                var itemsCountEl = document.querySelector('.cart-subtotal span:first-child');
                
                if (subtotalEl) {
                    subtotalEl.textContent = 'IDR ' + Math.round(subtotal).toLocaleString('id-ID');
                }
                
                if (itemsCountEl) {
                    itemsCountEl.textContent = 'Subtotal (' + totalItems + ' items)';
                }
            }
            
            // Add checkout button click handler
            function setupCheckoutButton() {
                var checkoutBtn = document.querySelector('.checkout-btn');
                if (checkoutBtn && !checkoutBtn.hasAttribute('data-handler-added')) {
                    checkoutBtn.setAttribute('data-handler-added', 'true');
                    checkoutBtn.addEventListener('click', function() {
                        // Check if user is authenticated
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', '/check-auth?_=' + new Date().getTime(), true);
                        xhr.setRequestHeader('Cache-Control', 'no-cache');
                        
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                try {
                                    var response = JSON.parse(xhr.responseText);
                                    if (response.authenticated) {
                                        window.location.href = '/checkout';
                                    } else {
                                        alert('Please login to checkout');
                                        window.location.href = '/login';
                                    }
                                } catch (e) {
                                    console.error('Error parsing auth response:', e);
                                    // Default to login screen if can't verify
                                    alert('Please login to checkout');
                                    window.location.href = '/login';
                                }
                            } else {
                                // Default to login screen if can't verify
                                alert('Please login to checkout');
                                window.location.href = '/login';
                            }
                        };
                        
                        xhr.onerror = function() {
                            console.error('Error checking auth status');
                            // Default to login screen if error
                            alert('Please login to checkout');
                            window.location.href = '/login';
                        };
                        
                        xhr.send();
                    });
                }
            }
            
            // Function to save cart changes to server
            function saveCartChanges() {
                var cartItems = [];
                
                document.querySelectorAll('.cart-item').forEach(function(item) {
                    var titleEl = item.querySelector('.cart-item-title');
                    var variantsEl = item.querySelector('.cart-item-variants');
                    var priceEl = item.querySelector('.current-price');
                    var discountEl = item.querySelector('.discount-badge');
                    var qtyEl = item.querySelector('input');
                    var imgEl = item.querySelector('img');
                    
                    if (titleEl && variantsEl && priceEl && qtyEl) {
                        var variantsParts = variantsEl.textContent.split('·');
                        // Extract only the numeric part and handle thousands separator properly
                        var priceText = priceEl.textContent.replace('IDR ', '').trim();
                        var price = parseFloat(priceText.replace(/\./g, '').replace(/,/g, '.'));
                        
                        var cartItem = {
                            name: titleEl.textContent.trim(),
                            size: variantsParts[0].trim(),
                            color: variantsParts[1].trim(),
                            price: price,
                            quantity: parseInt(qtyEl.value) || 1
                        };
                        
                        if (imgEl && imgEl.src) {
                            cartItem.image = imgEl.src;
                        }
                        
                        if (discountEl) {
                            cartItem.discount = parseInt(discountEl.textContent) || 0;
                        }
                        
                        cartItems.push(cartItem);
                    }
                });
                
                // Send to server
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/save-cart', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log('Cart saved successfully');
                    } else {
                        console.error('Error saving cart:', xhr.statusText);
                    }
                };
                
                xhr.onerror = function() {
                    console.error('Network error when saving cart');
                };
                
                xhr.send(JSON.stringify({ cart: cartItems }));
            }
            
            // Set up quantity buttons
            setupQuantityButtons();
            // Set up checkout button
            setupCheckoutButton();
            
            // Monitor DOM changes to handle dynamically added cart items
            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length > 0) {
                        setupQuantityButtons();
                        setupCheckoutButton();
                    }
                });
            });
            
            var cartItems = document.querySelector('.cart-items');
            if (cartItems) {
                observer.observe(cartItems, { childList: true, subtree: true });
            }
            
            // Also observe the entire sliding cart panel for changes
            var slidingCartPanel = document.querySelector('.sliding-cart-panel');
            if (slidingCartPanel) {
                observer.observe(slidingCartPanel, { childList: true, subtree: true });
            } else {
                // If the sliding cart panel doesn't exist yet, observe the body
                // to catch when it gets added to the DOM
                observer.observe(document.body, { childList: true, subtree: false });
                
                // Set up a timeout to check for the sliding cart panel every 500ms
                var checkInterval = setInterval(function() {
                    var panel = document.querySelector('.sliding-cart-panel');
                    if (panel) {
                        clearInterval(checkInterval);
                        observer.observe(panel, { childList: true, subtree: true });
                        setupCheckoutButton();
                    }
                }, 500);
            }
        });
    </script>
</body>
</html>
