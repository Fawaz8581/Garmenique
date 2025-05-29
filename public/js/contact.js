// Garmenique Contact Page JavaScript
var app = angular.module('garmeniqueApp', []);

// Contact Page Controller
app.controller('ContactPageController', ['$scope', '$http', function($scope, $http) {
    // Default page settings
    $scope.pageSettings = {
        contact: {
            hero: {
                enabled: true,
                title: 'CONTACT US',
                subtitle: "Let's talk about your question",
                description: "Drop us a line through the form below and we'll get back to you"
            },
            form: {
                enabled: true,
                messagePlaceholder: "Your message...",
                buttonText: "SEND"
            },
            info: {
                enabled: true,
                address: {
                    line1: "123 Main St",
                    line2: "Suite 404"
                },
                email: "info@garmenique.com",
                phone: "+1 (555) 123-4567",
                hours: {
                    weekdays: "9:00 AM - 5:00 PM",
                    weekends: "10:00 AM - 3:00 PM"
                }
            }
        }
    };
    
    // Load page settings from the server
    $http.get('/admin/api/page-settings?page=contact')
        .then(function(response) {
            if (response.data.success && response.data.settings && response.data.settings.contact) {
                // Merge saved settings with defaults
                var savedSettings = response.data.settings;
                
                // Hero section
                if (savedSettings.contact.hero) {
                    $scope.pageSettings.contact.hero.enabled = savedSettings.contact.hero.enabled;
                    
                    if (savedSettings.contact.hero.settings) {
                        if (savedSettings.contact.hero.settings.title) {
                            $scope.pageSettings.contact.hero.title = savedSettings.contact.hero.settings.title;
                        }
                        if (savedSettings.contact.hero.settings.subtitle) {
                            $scope.pageSettings.contact.hero.subtitle = savedSettings.contact.hero.settings.subtitle;
                        }
                        if (savedSettings.contact.hero.settings.description) {
                            $scope.pageSettings.contact.hero.description = savedSettings.contact.hero.settings.description;
                        }
                    }
                }
                
                // Form section
                if (savedSettings.contact.form) {
                    $scope.pageSettings.contact.form.enabled = savedSettings.contact.form.enabled;
                    
                    if (savedSettings.contact.form.settings) {
                        if (savedSettings.contact.form.settings.messagePlaceholder) {
                            $scope.pageSettings.contact.form.messagePlaceholder = savedSettings.contact.form.settings.messagePlaceholder;
                        }
                        if (savedSettings.contact.form.settings.buttonText) {
                            $scope.pageSettings.contact.form.buttonText = savedSettings.contact.form.settings.buttonText;
                        }
                    }
                }
                
                // Info section
                if (savedSettings.contact.info) {
                    $scope.pageSettings.contact.info.enabled = savedSettings.contact.info.enabled;
                    
                    if (savedSettings.contact.info.settings) {
                        if (savedSettings.contact.info.settings.address) {
                            if (savedSettings.contact.info.settings.address.line1) {
                                $scope.pageSettings.contact.info.address.line1 = savedSettings.contact.info.settings.address.line1;
                            }
                            if (savedSettings.contact.info.settings.address.line2) {
                                $scope.pageSettings.contact.info.address.line2 = savedSettings.contact.info.settings.address.line2;
                            }
                        }
                        if (savedSettings.contact.info.settings.email) {
                            $scope.pageSettings.contact.info.email = savedSettings.contact.info.settings.email;
                        }
                        if (savedSettings.contact.info.settings.phone) {
                            $scope.pageSettings.contact.info.phone = savedSettings.contact.info.settings.phone;
                        }
                        if (savedSettings.contact.info.settings.hours) {
                            if (savedSettings.contact.info.settings.hours.weekdays) {
                                $scope.pageSettings.contact.info.hours.weekdays = savedSettings.contact.info.settings.hours.weekdays;
                            }
                            if (savedSettings.contact.info.settings.hours.weekends) {
                                $scope.pageSettings.contact.info.hours.weekends = savedSettings.contact.info.settings.hours.weekends;
                            }
                        }
                    }
                }
            }
        })
        .catch(function(error) {
            console.error('Error loading page settings:', error);
        });
}]);

// Contact Form Controller
app.controller('ContactFormController', ['$scope', '$http', function($scope, $http) {
    // Initialize form data
    $scope.formData = {
        firstName: '',
        lastName: '',
        email: '',
        message: ''
    };
    
    // Form submission
    $scope.submitForm = function() {
        if ($scope.contactForm.$valid) {
            $http.post('/contact/submit', $scope.formData)
                .then(function(response) {
                    if (response.data.success) {
                        alert('Your message has been sent successfully!');
                        $scope.formData = {
                            firstName: '',
                            lastName: '',
                            email: '',
                            message: ''
                        };
                        $scope.contactForm.$setPristine();
                        $scope.contactForm.$setUntouched();
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                })
                .catch(function(error) {
                    console.error('Error submitting form:', error);
                    alert('An error occurred while sending your message. Please try again later.');
                });
        }
    };
}]);

// Header Controller
app.controller('HeaderController', ['$scope', '$window', '$rootScope', function($scope, $window, $rootScope) {
    // Mobile Navigation Toggle
    $scope.isNavActive = false;
    
    $scope.toggleNav = function() {
        $scope.isNavActive = !$scope.isNavActive;
    };
    
    // Cart Panel Toggle
    $scope.openCartPanel = function() {
        $rootScope.$broadcast('openCartPanel');
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
    
    // Popular categories for search panel
    $scope.popularCategories = [
        {
            name: 'Dresses',
            image: 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80',
            isHovered: false
        },
        {
            name: 'Tops',
            image: 'https://images.unsplash.com/photo-1562157873-818bc0726f68?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80',
            isHovered: false
        },
        {
            name: 'Pants',
            image: 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80',
            isHovered: false
        },
        {
            name: 'Accessories',
            image: 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80',
            isHovered: false
        }
    ];
    
    // Toggle search panel visibility
    $scope.closeSearch = function() {
        $scope.isSearchActive = false;
        document.body.style.overflow = '';
        $document.off('keydown', handleEscKeypress);
    };
    
    // Handle hover effect
    $scope.hover = function(category) {
        category.isHovered = true;
    };
    
    $scope.unhover = function(category) {
        category.isHovered = false;
    };
    
    // Handle ESC key to close search
    function handleEscKeypress(e) {
        if (e.keyCode === 27) { // ESC key
            $scope.$apply(function() {
                $scope.closeSearch();
            });
        }
    }
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