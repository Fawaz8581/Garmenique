<!-- Account Dropdown -->
<div class="account-dropdown-wrapper">
    <a href="javascript:void(0)" class="nav-icon account-toggle" id="accountDropdownToggle">
        <i class="fas fa-user"></i>
    </a>
    <div class="account-dropdown" id="accountDropdownMenu">
        @auth
            <div class="dropdown-header">
                <p>Hello, {{ Auth::user()->name }}</p>
            </div>
            <a href="/account/settings" class="dropdown-item">My Account</a>
            <a href="/account/orders" class="dropdown-item">My Orders</a>
            <a href="/wishlist" class="dropdown-item">Wishlist</a>
            <div class="dropdown-divider"></div>
            <form action="{{ route('logout') }}" method="POST" class="dropdown-item-form">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
            </form>
        @else
            <div class="dropdown-header">
                <p>Your Account</p>
            </div>
            <a href="{{ route('login') }}" class="dropdown-item">Login</a>
            <a href="{{ route('register') }}" class="dropdown-item">Register</a>
        @endauth
    </div>
</div>

<style>
/* Account dropdown specific styling */
.account-dropdown-wrapper {
    position: relative;
    display: inline-block;
}

.account-dropdown {
    position: absolute;
    top: 100%;
    right: -10px;
    background-color: white;
    border: 1px solid #e5e5e5;
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    min-width: 180px;
    display: none;
    z-index: 1000;
    text-align: left;
    padding: 8px 0;
    margin-top: 10px;
}

.account-dropdown.show {
    display: block;
}

.dropdown-header {
    padding: 8px 16px;
    border-bottom: 1px solid #e5e5e5;
    margin-bottom: 5px;
}

.dropdown-header p {
    margin: 0;
    font-size: 14px;
    font-weight: 500;
}

.dropdown-item {
    padding: 8px 16px;
    color: #333;
    text-decoration: none;
    display: block;
    font-size: 14px;
    transition: background-color 0.2s;
}

.dropdown-item:hover {
    background-color: #f7f7f7;
}

.dropdown-divider {
    height: 1px;
    background-color: #e5e5e5;
    margin: 5px 0;
}

.dropdown-item-form {
    margin: 0;
}

.dropdown-item-form button {
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.dropdown-item-form button:hover {
    background-color: #f7f7f7;
}
</style>

<script>
    // Wait for document to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const accountToggle = document.getElementById('accountDropdownToggle');
        const accountMenu = document.getElementById('accountDropdownMenu');
        
        // Toggle dropdown when clicking the account icon
        if (accountToggle && accountMenu) {
            accountToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                accountMenu.classList.toggle('show');
            });
            
            // Close dropdown when clicking elsewhere on the page
            document.addEventListener('click', function(e) {
                if (accountMenu.classList.contains('show') && !accountMenu.contains(e.target) && e.target !== accountToggle) {
                    accountMenu.classList.remove('show');
                }
            });
        }
    });
</script> 