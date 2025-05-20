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
        <!-- Cart Items -->
        <div class="cart-items" ng-if="cartItems.length > 0">
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
        <div class="empty-cart" ng-if="cartItems.length === 0">
            <p>Your cart is empty</p>
        </div>
    </div>
    
    <div class="sliding-cart-footer" ng-if="cartItems.length > 0">
        <div class="cart-subtotal">
            <span>Subtotal (@{{ getTotalItems() }} items)</span>
            <span class="subtotal-price">IDR @{{ calculateSubtotal().toLocaleString('id-ID') }}</span>
        </div>
        <button class="checkout-btn" ng-click="proceedToCheckout()">CONTINUE TO CHECKOUT</button>
        <p class="sell-out-notice">Psst, get it now before it sells out.</p>
    </div>
</div> 