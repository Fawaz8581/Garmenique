<div class="nav-icons">
    @auth
        @if(Auth::user()->role !== 'admin')
            <!-- Only show message and cart icons for non-admin users -->
            <a href="{{ route('user.messages') }}" class="nav-icon"><i class="fas fa-envelope"></i></a>
            <!-- Account dropdown in the middle -->
            @include('partials.account-dropdown')
            <!-- Cart icon on the right -->
            <a href="javascript:void(0)" class="nav-icon" ng-click="openCartPanel()"><i class="fas fa-shopping-cart"></i></a>
        @endif
    @else
        <!-- Show all icons for guests -->
        <a href="{{ route('user.messages') }}" class="nav-icon"><i class="fas fa-envelope"></i></a>
        <!-- Account dropdown in the middle -->
        @include('partials.account-dropdown')
        <!-- Cart icon on the right -->
        <a href="javascript:void(0)" class="nav-icon" ng-click="openCartPanel()"><i class="fas fa-shopping-cart"></i></a>
    @endauth
    
    <!-- Admin users only have account dropdown, which is already included above -->
    @auth
        @if(Auth::user()->role === 'admin')
            @include('partials.account-dropdown')
        @endif
    @endauth
</div>
