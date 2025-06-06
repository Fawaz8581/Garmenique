<!-- Account Dropdown -->
<div class="account-dropdown-wrapper">
    @auth
        @if(Auth::user()->role === 'admin')
            <!-- Admin: Only show logo with dropdown toggle -->
            <a href="javascript:void(0)" class="nav-icon account-toggle" id="accountDropdownToggle">
                <img src="{{ asset('images/icons/GarmeniqueLogo.png') }}" alt="Admin" class="admin-nav-icon" style="width: 48px; height: auto; margin: 0 5px; display: block;">
            </a>
            <!-- Admin dropdown with limited options -->
            <div class="account-dropdown" id="accountDropdownMenu">
                <div class="dropdown-header">
                    <p>Admin: {{ Auth::user()->name }}</p>
                </div>
                <a href="/admin" class="dropdown-item">Dashboard</a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" class="dropdown-item-form">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                </form>
            </div>
        @else
            <!-- Regular user: Show user icon with dropdown toggle -->
            <a href="javascript:void(0)" class="nav-icon account-toggle" id="accountDropdownToggle">
                <i class="fas fa-user"></i>
            </a>
            <!-- Regular user dropdown with all options -->
            <div class="account-dropdown" id="accountDropdownMenu">
                <div class="dropdown-header">
                    <p>Hello, {{ Auth::user()->name }}</p>
                </div>
                <a href="/account/settings" class="dropdown-item">My Account</a>
                <a href="/account/orders" class="dropdown-item">My Orders</a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" class="dropdown-item-form">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                </form>
            </div>
        @endif
    @else
        <!-- Guest user: Show user icon with dropdown toggle -->
        <a href="javascript:void(0)" class="nav-icon account-toggle" id="accountDropdownToggle">
            <i class="fas fa-user"></i>
        </a>
        <!-- Guest dropdown with login/register options -->
        <div class="account-dropdown" id="accountDropdownMenu">
            <div class="dropdown-header">
                <p>Your Account</p>
            </div>
            <a href="{{ route('login') }}" class="dropdown-item">Login</a>
            <a href="{{ route('register') }}" class="dropdown-item">Register</a>
        </div>
    @endauth
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

/* Admin icon styling */
.admin-nav-icon {
    width: 20px;
    height: 20px;
    object-fit: contain;
    border-radius: 50%;
    border: 2px solid #14387F;
    padding: 2px;
    background-color: white;
}
</style>

<script>
    // Wait for document to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        @auth
            @if(Auth::user()->role === 'admin')
                // For admin users, use the same click behavior as regular users
                const accountToggle = document.getElementById('accountDropdownToggle');
                const accountMenu = document.getElementById('accountDropdownMenu');
                
                if (accountToggle && accountMenu) {
                    accountToggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        accountMenu.classList.toggle('show');
                    });
                    
                    // Close dropdown when clicking elsewhere
                    document.addEventListener('click', function(e) {
                        if (accountMenu.classList.contains('show') && 
                            !accountMenu.contains(e.target) && 
                            e.target !== accountToggle) {
                            accountMenu.classList.remove('show');
                        }
                    });
                }
            @else
                // For regular users, use the standard toggle behavior
                const accountToggle = document.getElementById('accountDropdownToggle');
                const accountMenu = document.getElementById('accountDropdownMenu');
                
                if (accountToggle && accountMenu) {
                    accountToggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        accountMenu.classList.toggle('show');
                    });
                    
                    // Close dropdown when clicking elsewhere
                    document.addEventListener('click', function(e) {
                        if (accountMenu.classList.contains('show') && 
                            !accountMenu.contains(e.target) && 
                            e.target !== accountToggle) {
                            accountMenu.classList.remove('show');
                        }
                    });
                }
            @endif
        @else
            // For guests, use the standard toggle behavior
            const accountToggle = document.getElementById('accountDropdownToggle');
            const accountMenu = document.getElementById('accountDropdownMenu');
            
            if (accountToggle && accountMenu) {
                accountToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    accountMenu.classList.toggle('show');
                });
                
                // Close dropdown when clicking elsewhere
                document.addEventListener('click', function(e) {
                    if (accountMenu.classList.contains('show') && 
                        !accountMenu.contains(e.target) && 
                        e.target !== accountToggle) {
                        accountMenu.classList.remove('show');
                    }
                });
            }
        @endauth
    });
</script> 