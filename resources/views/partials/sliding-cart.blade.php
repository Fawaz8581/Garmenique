<!-- Sliding Cart Panel -->
<div class="sliding-cart-overlay" ng-class="{'active': isCartActive}" ng-click="closeCart()"></div>

<div class="sliding-cart-panel" ng-class="{'active': isCartActive}" ng-controller="CartController">
    <div class="sliding-cart-header">
        <h2>Your Cart</h2>
        <button type="button" class="close-btn" ng-click="closeCart()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="sliding-cart-body">
        <!-- Loading State -->
        <div class="cart-loading" ng-if="isLoading">
            <div class="spinner"></div>
            <p>Loading your cart...</p>
        </div>
        
        <!-- Auth Required Message -->
        <div class="auth-message" ng-if="!isAuthenticated && !isLoading">
            <p>Please log in to view your cart</p>
            <a href="/login" class="login-button">Login / Register</a>
        </div>
        
        <!-- Cart Items -->
        <div class="cart-items" ng-if="cartItems.length > 0 && isAuthenticated && !isLoading">
            <div class="cart-item" ng-repeat="item in cartItems">
                <div class="cart-item-image">
                    <img ng-src="@{{ item.image }}" alt="@{{ item.name }}">
                </div>
                <div class="cart-item-details">
                    <h4 class="cart-item-title">@{{ item.name }}</h4>
                    <p class="cart-item-variants">
                        @{{ item.size }} · @{{ item.color }}
                    </p>
                    <div class="cart-item-price">
                        <span class="current-price" ng-if="item.discount">IDR @{{ (item.price * (1 - item.discount/100) * 15500).toLocaleString('id-ID') }}</span>
                        <span class="current-price" ng-if="!item.discount">IDR @{{ (item.price * 15500).toLocaleString('id-ID') }}</span>
                        <span class="old-price" ng-if="item.discount">IDR @{{ (item.price * 15500).toLocaleString('id-ID') }}</span>
                        <span class="discount-badge" ng-if="item.discount">@{{ item.discount }}% Off</span>
                    </div>
                </div>
                <div class="cart-item-quantity">
                    <button class="quantity-btn minus" ng-click="decreaseQuantity(item)">−</button>
                    <input type="text" ng-model="item.quantity" readonly>
                    <button class="quantity-btn plus" ng-click="increaseQuantity(item)">+</button>
                </div>
            </div>
        </div>
        
        <!-- Empty Cart Message -->
        <div class="empty-cart" ng-if="cartItems.length === 0 && isAuthenticated && !isLoading">
            <p>Your cart is empty</p>
        </div>
    </div>
    
    <div class="sliding-cart-footer" ng-if="cartItems.length > 0 && isAuthenticated && !isLoading">
        <div class="cart-subtotal">
            <span>Subtotal (@{{ getTotalItems() }} items)</span>
            <span class="subtotal-price">IDR @{{ calculateSubtotal().toLocaleString('id-ID') }}</span>
        </div>
        <button class="checkout-btn" ng-click="proceedToCheckout()">CONTINUE TO CHECKOUT</button>
        <p class="sell-out-notice">Psst, get it now before it sells out.</p>
    </div>
</div>

<style>
.auth-message {
    text-align: center;
    padding: 30px 20px;
}

.auth-message p {
    margin-bottom: 15px;
    font-size: 16px;
    color: #333;
}

.login-button {
    display: inline-block;
    background-color: #3b82f6;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
}

.login-button:hover {
    background-color: #2563eb;
}

.cart-loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 200px;
}

.spinner {
    border: 4px solid rgba(0, 0, 0, 0.1);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border-left: 4px solid #3b82f6;
    animation: spin 1s linear infinite;
    margin-bottom: 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style> 