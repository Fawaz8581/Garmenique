<script>
    // Listen for cart update events from other pages
    window.addEventListener('message', function(event) {
        if (event.data && event.data.type === 'cartUpdated') {
            // Update the cart UI
            var cartItems = document.getElementById('cartItems');
            var cartTotal = document.getElementById('cartTotal');
            var cartCount = document.getElementById('cartCount');
            
            if (cartItems && event.data.cart && event.data.cart.length === 0) {
                // Clear cart UI
                cartItems.innerHTML = '<div class="empty-cart-message">Your cart is empty</div>';
                if (cartTotal) cartTotal.textContent = 'IDR 0';
                if (cartCount) cartCount.textContent = '0';
                
                // If Angular is available, update the cart controller
                if (window.angular) {
                    var scope = angular.element(document.querySelector('[ng-controller="CartController"]')).scope();
                    if (scope) {
                        scope.$apply(function() {
                            scope.cartItems = [];
                        });
                    }
                }
            }
        }
    });
</script> 