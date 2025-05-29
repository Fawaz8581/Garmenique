// Garmenique About Page JavaScript
var app = angular.module('garmeniqueApp', []);

// About Page Controller
app.controller('AboutController', ['$scope', '$http', function($scope, $http) {
    // Default page settings
    $scope.pageSettings = {
        about: {
            hero: {
                enabled: true,
                title: 'WE BELIEVE WE CAN ALL MAKE A DIFFERENCE',
                subtitle: 'We\'re on a mission to create beautiful, durable clothing while minimizing our environmental impact and maximizing our positive social impact. We believe in transparency, ethical practices, and creating garments that stand the test of time.',
                backgroundImage: 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80'
            },
            ethicalApproach: {
                enabled: true,
                title: 'Our ethical approach',
                description: 'We partner with ethical factories around the world, ensuring safe working conditions and fair wages for all workers involved in creating our garments. We believe that quality clothing starts with quality treatment of the people who make it.',
                image: 'https://images.unsplash.com/photo-1551232864-3f0890e580d9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80'
            },
            designedToLast: {
                enabled: true,
                title: 'Designed to last',
                description: 'We design our garments with longevity in mind, using high-quality materials and timeless designs. Our products are meant to be worn for years, not seasons, reducing the need for constant replacement and minimizing waste.',
                images: [
                    {
                        url: 'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                        alt: 'Clothing Rack'
                    },
                    {
                        url: 'https://images.unsplash.com/photo-1523380677598-64d85d015339?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                        alt: 'Colorful Textile'
                    }
                ]
            },
            transparent: {
                enabled: true,
                title: 'Radically Transparent',
                description: 'We believe in full transparency about our materials, costs, and manufacturing processes. We want you to know exactly what goes into making your clothes and why they cost what they do.',
                colors: [
                    { hex: '#E6D9B8' },
                    { hex: '#999999' }
                ]
            },
            explore: {
                enabled: true,
                title: 'Meet our Explore',
                categories: [
                    { 
                        title: 'Fabric Selection', 
                        image: 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                    },
                    { 
                        title: 'Design Process', 
                        image: 'https://images.unsplash.com/photo-1604881988758-f76ad2f7aac1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                    },
                    { 
                        title: 'Production', 
                        image: 'https://images.unsplash.com/photo-1581873372796-635b67ca2008?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                    },
                    { 
                        title: 'Quality Control', 
                        image: 'https://images.unsplash.com/photo-1617419250411-98aa962b070f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                    }
                ]
            },
            factoryImages: {
                enabled: true,
                images: [
                    { 
                        url: 'https://images.unsplash.com/photo-1525171254930-643fc658b64e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80', 
                        alt: 'Factory detail' 
                    },
                    { 
                        url: 'https://images.unsplash.com/photo-1675176785803-bffbbb0cd2f4?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Z2FybWVudCUyMGZhY3Rvcnl8ZW58MHx8MHx8fDA%3D', 
                        alt: 'Worker closeup' 
                    }
                ]
            }
        }
    };
    
    // Load page settings from the server
    $http.get('/admin/api/page-settings?page=about')
        .then(function(response) {
            if (response.data.success && response.data.settings && response.data.settings.about) {
                // Merge saved settings with defaults
                var savedSettings = response.data.settings;
                
                // Hero section
                if (savedSettings.about.hero) {
                    $scope.pageSettings.about.hero.enabled = savedSettings.about.hero.enabled;
                    
                    if (savedSettings.about.hero.settings) {
                        if (savedSettings.about.hero.settings.title) {
                            $scope.pageSettings.about.hero.title = savedSettings.about.hero.settings.title;
                        }
                        if (savedSettings.about.hero.settings.subtitle) {
                            $scope.pageSettings.about.hero.subtitle = savedSettings.about.hero.settings.subtitle;
                        }
                        if (savedSettings.about.hero.settings.backgroundImage) {
                            $scope.pageSettings.about.hero.backgroundImage = savedSettings.about.hero.settings.backgroundImage;
                        }
                    }
                }
                
                // Ethical Approach section
                if (savedSettings.about.ethicalApproach) {
                    $scope.pageSettings.about.ethicalApproach.enabled = savedSettings.about.ethicalApproach.enabled;
                    
                    if (savedSettings.about.ethicalApproach.settings) {
                        if (savedSettings.about.ethicalApproach.settings.title) {
                            $scope.pageSettings.about.ethicalApproach.title = savedSettings.about.ethicalApproach.settings.title;
                        }
                        if (savedSettings.about.ethicalApproach.settings.description) {
                            $scope.pageSettings.about.ethicalApproach.description = savedSettings.about.ethicalApproach.settings.description;
                        }
                        if (savedSettings.about.ethicalApproach.settings.image) {
                            $scope.pageSettings.about.ethicalApproach.image = savedSettings.about.ethicalApproach.settings.image;
                        }
                    }
                }
                
                // Designed to Last section
                if (savedSettings.about.designedToLast) {
                    $scope.pageSettings.about.designedToLast.enabled = savedSettings.about.designedToLast.enabled;
                    
                    if (savedSettings.about.designedToLast.settings) {
                        if (savedSettings.about.designedToLast.settings.title) {
                            $scope.pageSettings.about.designedToLast.title = savedSettings.about.designedToLast.settings.title;
                        }
                        if (savedSettings.about.designedToLast.settings.description) {
                            $scope.pageSettings.about.designedToLast.description = savedSettings.about.designedToLast.settings.description;
                        }
                        if (savedSettings.about.designedToLast.settings.images && savedSettings.about.designedToLast.settings.images.length > 0) {
                            $scope.pageSettings.about.designedToLast.images = savedSettings.about.designedToLast.settings.images;
                        }
                    }
                }
                
                // Transparent section
                if (savedSettings.about.transparent) {
                    $scope.pageSettings.about.transparent.enabled = savedSettings.about.transparent.enabled;
                    
                    if (savedSettings.about.transparent.settings) {
                        if (savedSettings.about.transparent.settings.title) {
                            $scope.pageSettings.about.transparent.title = savedSettings.about.transparent.settings.title;
                        }
                        if (savedSettings.about.transparent.settings.description) {
                            $scope.pageSettings.about.transparent.description = savedSettings.about.transparent.settings.description;
                        }
                        if (savedSettings.about.transparent.settings.colors && savedSettings.about.transparent.settings.colors.length > 0) {
                            $scope.pageSettings.about.transparent.colors = savedSettings.about.transparent.settings.colors;
                        }
                    }
                }
                
                // Explore section
                if (savedSettings.about.explore) {
                    $scope.pageSettings.about.explore.enabled = savedSettings.about.explore.enabled;
                    
                    if (savedSettings.about.explore.settings) {
                        if (savedSettings.about.explore.settings.title) {
                            $scope.pageSettings.about.explore.title = savedSettings.about.explore.settings.title;
                        }
                        if (savedSettings.about.explore.settings.categories && savedSettings.about.explore.settings.categories.length > 0) {
                            $scope.pageSettings.about.explore.categories = savedSettings.about.explore.settings.categories;
                        }
                    }
                }
                
                // Factory Images section
                if (savedSettings.about.factoryImages) {
                    $scope.pageSettings.about.factoryImages.enabled = savedSettings.about.factoryImages.enabled;
                    
                    if (savedSettings.about.factoryImages.settings) {
                        if (savedSettings.about.factoryImages.settings.images && savedSettings.about.factoryImages.settings.images.length > 0) {
                            $scope.pageSettings.about.factoryImages.images = savedSettings.about.factoryImages.settings.images;
                        }
                    }
                }
            }
        })
        .catch(function(error) {
            console.error('Error loading page settings:', error);
        });
}]);

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