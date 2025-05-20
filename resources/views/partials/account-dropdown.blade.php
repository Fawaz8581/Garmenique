<!-- Account Dropdown -->
<div class="dropdown-wrapper" ng-controller="AccountDropdownController" ng-mouseenter="openDropdown()" ng-mouseleave="closeDropdown()">
    <a href="javascript:void(0)" class="nav-icon"><i class="fas fa-user"></i></a>
    <div class="account-dropdown" ng-class="{'show': isOpen}">
        @auth
            <a href="/account/settings" class="dropdown-item">Settings</a>
            <a href="/account/orders" class="dropdown-item">Your Orders</a>
            <a href="javascript:void(0)" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="dropdown-item">Login</a>
            <a href="{{ route('register') }}" class="dropdown-item">Register</a>
        @endauth
    </div>
</div> 