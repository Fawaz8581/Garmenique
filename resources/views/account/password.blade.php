<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Garmenique - Change Password</title>
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
    <link rel="stylesheet" href="{{ asset('css/landing.page.search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
    <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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

    <!-- Search Overlay -->
    <div class="search-overlay" ng-class="{'active': isSearchActive}"></div>

    <!-- Search Panel (Hidden by default) -->
    <div class="search-panel" ng-controller="SearchController" ng-class="{'active': isSearchActive}">
        <div class="container">
            <!-- Search Bar -->
            <div class="search-container">
                <div class="d-flex align-items-center">
                    <input type="text" class="search-input" placeholder="Search" ng-model="searchQuery" autofocus>
                    <a href="javascript:void(0)" class="cancel-btn" ng-click="closeSearch()">Cancel</a>
                </div>
            </div>

            <div class="search-content">
                <!-- Categories Navigation as Bullets -->
                <div class="categories-list">
                    <ul>
                        <li><a href="/catalog">BEST SELLERS</a></li>
                        <li><a href="/catalog">CLOTHING</a></li>
                        <li><a href="/catalog">TOPS & SWEATERS</a></li>
                        <li><a href="/catalog">PANTS & JEANS</a></li>
                        <li><a href="/catalog">OUTERWEAR</a></li>
                        <li><a href="/catalog">SHOES & BAGS</a></li>
                        <li><a href="/catalog">SALE</a></li>
                    </ul>
                </div>

                <!-- Popular Categories -->
                <section class="popular-categories">
                    <h2>Popular Categories</h2>
                    <div class="row">
                        <div class="col-6 col-md-3" ng-repeat="category in popularCategories">
                            <div class="category-card" ng-mouseenter="hover(category)" ng-mouseleave="unhover(category)" ng-class="{'hovered': category.isHovered}">
                                <img ng-src="@{{ category.image }}" alt="@{{ category.name }}" class="card-img-top">
                                <h5 class="category-card-title">@{{ category.name }}</h5>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

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
                        <li><a href="{{ route('account.password') }}" class="active">Password</a></li>
                        <li><a href="{{ route('account.contact') }}">Contact Information</a></li>
                        <li><a href="{{ route('account.orders') }}">Your Orders</a></li>
                        <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">Logout</a></li>
                    </ul>
                    <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                
                <div class="account-main">
                    <h2>Change Password</h2>
                    
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
                    
                    <form method="POST" action="{{ route('account.update.password') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn-save">Update Password</button>
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
    
    <!-- Cart Functionality Script -->
    <script>
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
                
                // Define HeaderController if it doesn't already exist
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
            
            // Handle quantity action function (for onclick handlers)
            window.handleQuantityAction = function(action, button) {
                if (action === 'increase') {
                    // Instead of using click(), directly call the appropriate function
                    increaseQuantity.call(button);
                } else if (action === 'decrease') {
                    // Instead of using click(), directly call the appropriate function
                    decreaseQuantity.call(button);
                }
            };
            
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
