// Garmenique About Page JavaScript
var app = angular.module('garmeniqueApp', []);

// Header Controller
app.controller('HeaderController', ['$scope', '$window', '$rootScope', function($scope, $window, $rootScope) {
    // Mobile Navigation Toggle
    $scope.isNavActive = false;
    
    $scope.toggleNav = function() {
        $scope.isNavActive = !$scope.isNavActive;
    };
    
    // Search Panel Toggle
    $scope.toggleSearch = function() {
        $rootScope.$broadcast('toggleSearch');
    };
    
    // Sticky Header
    var headerHeight = 0;
    
    angular.element(document).ready(function() {
        var header = document.querySelector('.header');
        headerHeight = header ? header.offsetHeight : 0;
    });
    
    angular.element($window).on('scroll', function() {
        $scope.$apply(function() {
            if ($window.scrollY > headerHeight) {
                angular.element(document.querySelector('.header')).addClass('sticky');
            } else {
                angular.element(document.querySelector('.header')).removeClass('sticky');
            }
        });
    });
}]);

// Search Controller
app.controller('SearchController', ['$scope', '$rootScope', '$document', function($scope, $rootScope, $document) {
    $scope.isSearchActive = false;
    $scope.searchQuery = '';
    
    // Toggle search panel visibility
    $rootScope.$on('toggleSearch', function() {
        $scope.isSearchActive = !$scope.isSearchActive;
        if ($scope.isSearchActive) {
            document.body.style.overflow = 'hidden';
            setTimeout(function() {
                document.querySelector('.search-input').focus();
            }, 400);
            
            // Add ESC key listener when search is active
            $document.on('keydown', handleEscKeypress);
            
            // Add overlay click listener
            angular.element(document.querySelector('.search-overlay')).on('click', $scope.closeSearch);
        } else {
            document.body.style.overflow = '';
            
            // Remove listeners when search is closed
            $document.off('keydown', handleEscKeypress);
        }
    });
    
    // Handle ESC key to close search
    function handleEscKeypress(e) {
        if (e.keyCode === 27) { // ESC key code
            $scope.$apply(function() {
                $scope.closeSearch();
            });
        }
    }
    
    // Close search panel
    $scope.closeSearch = function() {
        $scope.isSearchActive = false;
        document.body.style.overflow = '';
        
        // Remove listeners
        $document.off('keydown', handleEscKeypress);
    };
    
    // Click outside search panel to close
    angular.element(document).on('click', function(e) {
        // If search is active and click is outside search panel and not on search icon
        if ($scope.isSearchActive && 
            !angular.element(e.target).closest('.search-panel').length && 
            !angular.element(e.target).closest('.nav-icons .fa-search').length) {
            
            $scope.$apply(function() {
                $scope.closeSearch();
            });
        }
    });
    
    // Popular categories in search
    $scope.popularCategories = [
        {
            name: "Women's Sweaters",
            image: "https://images.unsplash.com/photo-1626497764746-6dc36546b388?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80",
            isHovered: false
        },
        {
            name: "Women's Bottoms",
            image: "https://images.lee.com/is/image/Lee/112340541-HERO?$PDP24-XXLARGE$&fit=crop",
            isHovered: false
        },
        {
            name: "Women's Boots",
            image: "https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80",
            isHovered: false
        },
        {
            name: "Men's Best Sellers",
            image: "https://images.unsplash.com/photo-1617137968427-85924c800a22?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80",
            isHovered: false
        }
    ];
    
    // Hover functions
    $scope.hover = function(item) {
        item.isHovered = true;
    };
    
    $scope.unhover = function(item) {
        item.isHovered = false;
    };
    
    // Perform search
    $scope.performSearch = function() {
        // Search logic would go here
        console.log('Searching for:', $scope.searchQuery);
    };
}]);

// Account Dropdown Controller
app.controller('AccountDropdownController', ['$scope', '$timeout', function($scope, $timeout) {
    $scope.isOpen = false;
    let hideTimeout;

    $scope.openDropdown = function() {
        if (hideTimeout) $timeout.cancel(hideTimeout);
        $scope.isOpen = true;
    };

    $scope.closeDropdown = function() {
        hideTimeout = $timeout(function() {
            $scope.isOpen = false;
        }, 200); // Small delay to improve user experience
    };
}]);

// Initialize image galleries if needed
document.addEventListener('DOMContentLoaded', function() {
    // Add scroll animations
    const sections = document.querySelectorAll('.ethical-approach, .designed-section, .transparency-section, .meet-explore');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                }
            });
        }, { threshold: 0.1 });
        
        sections.forEach(section => {
            observer.observe(section);
        });
    } else {
        // Fallback for browsers that don't support IntersectionObserver
        sections.forEach(section => {
            section.classList.add('in-view');
        });
    }
    
    // Update navigation active state based on current page
    const navItems = document.querySelectorAll('.nav-item');
    const currentPath = window.location.pathname;
    
    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href === currentPath) {
            item.classList.add('active');
        }
    });
});