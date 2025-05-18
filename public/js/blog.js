// Garmenique Blog AngularJS Controllers

// Initialize Angular app if it doesn't exist yet
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

// Blog Controller
app.controller('BlogController', ['$scope', function($scope) {
    // Featured Articles (First Row)
    $scope.featuredArticles = [
        {
            title: 'How To Style Winter Whites',
            category: 'Style',
            image: 'images/blog/winter-white.jpg',
            link: '#'
        },
        {
            title: 'We Won A Glossy Award',
            category: 'Transparency',
            image: 'images/blog/glossy-award.jpg',
            link: '#'
        },
        {
            title: 'Coordinate Your Style: Matching Outfits for Everyone',
            category: 'Style',
            image: 'images/blog/matching-outfits.jpg',
            link: '#'
        }
    ];
    
    // Regular Articles (Second Row)
    $scope.regularArticles = [
        {
            title: 'Black Friday Fund 2023',
            category: 'Transparency',
            image: 'images/blog/black-friday.jpg',
            link: '#'
        },
        {
            title: 'What to Wear this Season: Holiday Outfits & Ideas',
            category: 'Style',
            image: 'images/blog/holiday-outfits.jpg',
            link: '#'
        },
        {
            title: 'Thanksgiving Outfit Ideas',
            category: 'Style',
            image: 'images/blog/thanksgiving.jpg',
            link: '#'
        }
    ];
    
    // Progress Initiatives
    $scope.progressInitiatives = [
        {
            title: 'Carbon Commitment',
            image: 'images/blog/carbon-commitment.jpg'
        },
        {
            title: 'Environmental Initiatives',
            image: 'images/blog/environmental.jpg'
        },
        {
            title: 'Better Factories',
            image: 'images/blog/factories.jpg'
        }
    ];
    
    // Subscribe to newsletter
    $scope.email = '';
    $scope.subscribe = function() {
        if($scope.email) {
            console.log('Subscribing with email: ' + $scope.email);
            alert('Thank you for subscribing to our newsletter!');
            $scope.email = '';
        }
    };
}]);

// Define the SearchController for the blog page
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
    
    // Popular categories for search page
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
    
    // Search functionality
    $scope.performSearch = function() {
        console.log('Searching for: ' + $scope.searchQuery);
    };
}]);

// Newsletter Controller
app.controller('NewsletterController', ['$scope', function($scope) {
    $scope.email = '';
    
    $scope.subscribe = function() {
        if ($scope.email) {
            // In a real application, this would send the email to the server
            alert('Thank you for subscribing with: ' + $scope.email);
            $scope.email = '';
        }
    };
}]); 