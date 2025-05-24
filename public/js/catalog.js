// Garmenique Catalog AngularJS App

// Angular module definition (existing module from landing page)
var app = angular.module('garmeniqueApp', []);

// Header Controller (reused from landing page)
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
    
    // Function to open cart using $rootScope broadcast
    $scope.openCartPanel = function() {
        $rootScope.$broadcast('openCart');
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

// Search Controller (reused from landing page)
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
}]);

// Catalog Controller
app.controller('CatalogController', ['$scope', '$window', function($scope, $window) {
    // View Mode (grid or list)
    $scope.viewMode = 'grid';
    
    // Set view mode function
    $scope.setViewMode = function(mode) {
        $scope.viewMode = mode;
    };
    
    // Categories for filtering
    $scope.categories = [
        { id: 1, name: 'Tops & T-shirts', count: 32, selected: false },
        { id: 2, name: 'Jackets', count: 18, selected: false },
        { id: 3, name: 'Pants & Jeans', count: 24, selected: false },
        { id: 4, name: 'Sweaters', count: 16, selected: false },
        { id: 5, name: 'Dresses', count: 22, selected: false },
        { id: 6, name: 'Shoes', count: 15, selected: false },
        { id: 7, name: 'Accessories', count: 29, selected: false }
    ];
    
    // Sizes for filtering
    $scope.sizes = [
        { id: 1, label: 'XS', selected: false },
        { id: 2, label: 'S', selected: false },
        { id: 3, label: 'M', selected: false },
        { id: 4, label: 'L', selected: false },
        { id: 5, label: 'XL', selected: false },
        { id: 6, label: 'XXL', selected: false }
    ];
    
    // Colors for filtering
    $scope.colors = [
        { id: 1, name: 'Black', code: '#000000', selected: false },
        { id: 2, name: 'White', code: '#FFFFFF', selected: false },
        { id: 3, name: 'Red', code: '#D42E2E', selected: false },
        { id: 4, name: 'Blue', code: '#2E6ED4', selected: false },
        { id: 5, name: 'Green', code: '#2ED45B', selected: false },
        { id: 6, name: 'Yellow', code: '#EED41E', selected: false },
        { id: 7, name: 'Purple', code: '#9C2ED4', selected: false },
        { id: 8, name: 'Brown', code: '#8B4513', selected: false }
    ];
    
    // Price range for filtering
    $scope.priceRange = {
        min: null,
        max: null
    };
    
    // Sorting options
    $scope.sortOption = 'featured';
    
    // Pagination
    $scope.currentPage = 1;
    $scope.itemsPerPage = 6;
    $scope.totalPages = 1;
    
    // Go to page function
    $scope.goToPage = function(page) {
        if (page < 1 || page > $scope.totalPages) {
            return;
        }
        $scope.currentPage = page;
    };
    
    // Get pages array for pagination
    $scope.getPages = function() {
        var pages = [];
        var maxPages = Math.min($scope.totalPages, 5);
        
        var startPage = Math.max(1, $scope.currentPage - 2);
        var endPage = Math.min($scope.totalPages, startPage + maxPages - 1);
        
        if (endPage - startPage + 1 < maxPages) {
            startPage = Math.max(1, endPage - maxPages + 1);
        }
        
        for (var i = startPage; i <= endPage; i++) {
            pages.push(i);
        }
        
        return pages;
    };
    
    // Products data (in a real app, this would come from an API)
    $scope.products = [
        {
            id: 1,
            name: 'Classic Cotton T-Shirt',
            categoryId: 1,
            primaryImage: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            hoverImage: 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            price: 29.99,
            oldPrice: null,
            discount: null,
            isNew: true,
            colors: [
                { name: 'Black', code: '#000000' },
                { name: 'White', code: '#FFFFFF' },
                { name: 'Blue', code: '#2E6ED4' }
            ],
            sizes: ['S', 'M', 'L', 'XL'],
            rating: 4,
            reviewCount: 12,
            isHovered: false,
            description: 'Premium quality cotton t-shirt with a classic fit. Perfect for everyday wear and extremely comfortable.'
        },
        {
            id: 2,
            name: 'Slim Fit Jeans',
            categoryId: 3,
            primaryImage: 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            hoverImage: 'https://images.unsplash.com/photo-1608234808654-2a8875faa7fd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            price: 59.99,
            oldPrice: 79.99,
            discount: 25,
            isNew: false,
            colors: [
                { name: 'Blue', code: '#2E6ED4' },
                { name: 'Black', code: '#000000' }
            ],
            sizes: ['28', '30', '32', '34', '36'],
            rating: 5,
            reviewCount: 28,
            isHovered: false,
            description: 'Modern slim fit jeans with stretch for maximum comfort. Features a classic five-pocket design and versatile wash.'
        },
        {
            id: 3,
            name: 'Wool Blend Sweater',
            categoryId: 4,
            primaryImage: 'https://images.unsplash.com/photo-1584273143981-41c073dfe8f8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            hoverImage: 'https://images.unsplash.com/photo-1584273143981-41c073dfe8f8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            price: 89.99,
            oldPrice: null,
            discount: null,
            isNew: true,
            colors: [
                { name: 'Brown', code: '#8B4513' },
                { name: 'Green', code: '#2ED45B' },
                { name: 'Black', code: '#000000' }
            ],
            sizes: ['S', 'M', 'L', 'XL'],
            rating: 4,
            reviewCount: 9,
            isHovered: false,
            description: 'Cozy wool blend sweater perfect for colder weather. Features a relaxed fit and ribbed collar, cuffs, and hem.'
        },
        {
            id: 4,
            name: 'Leather Jacket',
            categoryId: 2,
            primaryImage: 'https://images.unsplash.com/photo-1551028719-00167b16eac5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            hoverImage: 'https://images.unsplash.com/photo-1521223890158-f9f7c3d5d504?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            price: 199.99,
            oldPrice: 249.99,
            discount: 20,
            isNew: false,
            colors: [
                { name: 'Black', code: '#000000' },
                { name: 'Brown', code: '#8B4513' }
            ],
            sizes: ['S', 'M', 'L', 'XL'],
            rating: 5,
            reviewCount: 17,
            isHovered: false,
            description: 'Premium leather jacket with a classic biker design. Features multiple pockets, a durable zipper closure, and a quilted lining.'
        },
        {
            id: 5,
            name: 'Floral Summer Dress',
            categoryId: 5,
            primaryImage: 'https://images.unsplash.com/photo-1492707892479-7bc8d5a4ee93?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            hoverImage: 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            price: 79.99,
            oldPrice: 119.99,
            discount: 33,
            isNew: true,
            colors: [
                { name: 'Floral', code: '#FF9CAA' },
                { name: 'Blue', code: '#2E6ED4' }
            ],
            sizes: ['XS', 'S', 'M', 'L'],
            rating: 4,
            reviewCount: 23,
            isHovered: false,
            description: 'Beautiful floral print summer dress with a flattering silhouette. Made from lightweight, breathable fabric perfect for warm weather.'
        },
        {
            id: 6,
            name: 'Canvas Sneakers',
            categoryId: 6,
            primaryImage: 'https://images.unsplash.com/photo-1604001307862-2d953b875079?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            hoverImage: 'https://images.unsplash.com/photo-1604001307862-2d953b875079?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            price: 49.99,
            oldPrice: null,
            discount: null,
            isNew: false,
            colors: [
                { name: 'White', code: '#FFFFFF' },
                { name: 'Black', code: '#000000' },
                { name: 'Red', code: '#D42E2E' }
            ],
            sizes: ['38', '39', '40', '41', '42', '43', '44'],
            rating: 4,
            reviewCount: 31,
            isHovered: false,
            description: 'Classic canvas sneakers with a timeless design. Features a durable rubber sole and cushioned insole for all-day comfort.'
        },
        {
            id: 7,
            name: 'Leather Belt',
            categoryId: 7,
            primaryImage: 'https://images.unsplash.com/photo-1624623278313-a930126a11c3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            hoverImage: 'https://images.unsplash.com/photo-1612902456551-333ac5afa26e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            price: 39.99,
            oldPrice: 59.99,
            discount: 33,
            isNew: false,
            colors: [
                { name: 'Brown', code: '#8B4513' },
                { name: 'Black', code: '#000000' }
            ],
            sizes: ['S', 'M', 'L', 'XL'],
            rating: 5,
            reviewCount: 14,
            isHovered: false,
            description: 'Premium genuine leather belt with a classic buckle design. Versatile and durable, perfect for both casual and formal outfits.'
        },
        {
            id: 8,
            name: 'Silk Scarf',
            categoryId: 7,
            primaryImage: 'https://assets.vogue.com/photos/589208b00e6cdc8a1928e3ef/master/pass/celebrity-style-reese-witherspoon.jpg',
            hoverImage: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTj9ZV6bEgOBw2fF55XnsZhgk4sjR58R_X1QA&s',
            price: 69.99,
            oldPrice: null,
            discount: null,
            isNew: true,
            colors: [
                { name: 'Multicolor', code: '#FF9CAA' },
                { name: 'Blue', code: '#2E6ED4' }
            ],
            sizes: ['One Size'],
            rating: 4,
            reviewCount: 9,
            isHovered: false,
            description: 'Luxurious silk scarf with a beautiful pattern. Adds an elegant touch to any outfit and can be styled in multiple ways.'
        },
        {
            id: 9,
            name: 'Denim Shorts',
            categoryId: 3,
            primaryImage: 'https://images.unsplash.com/photo-1577900232427-18219b9166a0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            hoverImage: 'https://images.unsplash.com/photo-1577900232427-18219b9166a0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            price: 49.99,
            oldPrice: 69.99,
            discount: 29,
            isNew: false,
            colors: [
                { name: 'Blue', code: '#2E6ED4' },
                { name: 'Black', code: '#000000' }
            ],
            sizes: ['28', '30', '32', '34', '36'],
            rating: 4,
            reviewCount: 16,
            isHovered: false,
            description: 'Classic denim shorts with a comfortable fit. Perfect for casual summer days and features a vintage-inspired wash.'
        },
        {
            id: 10,
            name: 'Lightweight Cardigan',
            categoryId: 4,
            primaryImage: 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            hoverImage: 'https://images.unsplash.com/photo-1620799139507-2a76f79a2f4d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            price: 69.99,
            oldPrice: null,
            discount: null,
            isNew: true,
            colors: [
                { name: 'Gray', code: '#808080' },
                { name: 'Navy', code: '#000080' },
                { name: 'Beige', code: '#F5F5DC' }
            ],
            sizes: ['S', 'M', 'L', 'XL'],
            rating: 4,
            reviewCount: 11,
            isHovered: false,
            description: 'Soft and lightweight cardigan with an open front design. Perfect for layering in any season and adds a touch of elegance to your outfit.'
        },
        {
            id: 11,
            name: 'Canvas Tote Bag',
            categoryId: 7,
            primaryImage: 'https://images.meesho.com/images/products/362459576/etoo8_512.webp',
            hoverImage: 'https://images.unsplash.com/photo-1572196284554-4e321b0e7e0b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            price: 34.99,
            oldPrice: null,
            discount: null,
            isNew: false,
            colors: [
                { name: 'Natural', code: '#F5F5DC' },
                { name: 'Black', code: '#000000' }
            ],
            sizes: ['One Size'],
            rating: 5,
            reviewCount: 19,
            isHovered: false,
            description: 'Durable canvas tote bag with plenty of space for your essentials. Features sturdy handles and an inner pocket for small items.'
        },
        {
            id: 12,
            name: 'Patterned Button-Up Shirt',
            categoryId: 1,
            primaryImage: 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            hoverImage: 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
            price: 59.99,
            oldPrice: 79.99,
            discount: 25,
            isNew: false,
            colors: [
                { name: 'Blue Pattern', code: '#2E6ED4' },
                { name: 'Green Pattern', code: '#2ED45B' }
            ],
            sizes: ['S', 'M', 'L', 'XL', 'XXL'],
            rating: 4,
            reviewCount: 13,
            isHovered: false,
            description: 'Stylish button-up shirt with a modern pattern. Made from comfortable, breathable fabric and features a regular fit.'
        }
    ];
    
    // Filtered products
    $scope.filteredProducts = [];
    
    // Initialize filtered products
    function initializeFilteredProducts() {
        $scope.filteredProducts = $scope.products.slice();
        $scope.totalPages = Math.ceil($scope.filteredProducts.length / $scope.itemsPerPage);
    }
    
    // Initialize on controller load
    initializeFilteredProducts();
    
    // Filter products function
    $scope.filterProducts = function() {
        $scope.filteredProducts = $scope.products.filter(function(product) {
            // Category filter
            var categorySelected = $scope.categories.some(function(cat) {
                return cat.selected;
            });
            
            if (categorySelected) {
                var categoryMatch = $scope.categories.some(function(cat) {
                    return cat.selected && product.categoryId === cat.id;
                });
                
                if (!categoryMatch) {
                    return false;
                }
            }
            
            // Size filter
            var sizeSelected = $scope.sizes.some(function(size) {
                return size.selected;
            });
            
            if (sizeSelected) {
                var sizeMatch = $scope.sizes.some(function(size) {
                    return size.selected && product.sizes.includes(size.label);
                });
                
                if (!sizeMatch) {
                    return false;
                }
            }
            
            // Color filter
            var colorSelected = $scope.colors.some(function(color) {
                return color.selected;
            });
            
            if (colorSelected) {
                var colorMatch = $scope.colors.some(function(color) {
                    return color.selected && product.colors.some(function(pc) {
                        return pc.code === color.code;
                    });
                });
                
                if (!colorMatch) {
                    return false;
                }
            }
            
            // Price filter
            if ($scope.priceRange.min !== null && $scope.priceRange.min > 0) {
                if (product.price < $scope.priceRange.min) {
                    return false;
                }
            }
            
            if ($scope.priceRange.max !== null && $scope.priceRange.max > 0) {
                if (product.price > $scope.priceRange.max) {
                    return false;
                }
            }
            
            return true;
        });
        
        // Apply sorting after filtering
        $scope.sortProducts();
        
        // Update pagination
        $scope.totalPages = Math.ceil($scope.filteredProducts.length / $scope.itemsPerPage);
        $scope.currentPage = 1;
    };
    
    // Sort products function
    $scope.sortProducts = function() {
        switch ($scope.sortOption) {
            case 'price_low':
                $scope.filteredProducts.sort(function(a, b) {
                    return a.price - b.price;
                });
                break;
            case 'price_high':
                $scope.filteredProducts.sort(function(a, b) {
                    return b.price - a.price;
                });
                break;
            case 'newest':
                $scope.filteredProducts.sort(function(a, b) {
                    return (b.isNew ? 1 : 0) - (a.isNew ? 1 : 0);
                });
                break;
            case 'name_asc':
                $scope.filteredProducts.sort(function(a, b) {
                    return a.name.localeCompare(b.name);
                });
                break;
            case 'name_desc':
                $scope.filteredProducts.sort(function(a, b) {
                    return b.name.localeCompare(a.name);
                });
                break;
            default: // featured
                $scope.filteredProducts.sort(function(a, b) {
                    return a.id - b.id;
                });
                break;
        }
    };
    
    // Toggle size selection
    $scope.toggleSize = function(size) {
        size.selected = !size.selected;
        $scope.filterProducts();
    };
    
    // Toggle color selection
    $scope.toggleColor = function(color) {
        color.selected = !color.selected;
        $scope.filterProducts();
    };
    
    // Reset all filters
    $scope.resetFilters = function() {
        // Reset categories
        $scope.categories.forEach(function(cat) {
            cat.selected = false;
        });
        
        // Reset sizes
        $scope.sizes.forEach(function(size) {
            size.selected = false;
        });
        
        // Reset colors
        $scope.colors.forEach(function(color) {
            color.selected = false;
        });
        
        // Reset price range
        $scope.priceRange.min = null;
        $scope.priceRange.max = null;
        
        // Reset to default sort
        $scope.sortOption = 'featured';
        
        // Apply filters
        $scope.filterProducts();
    };
    
    // Hover functions
    $scope.hover = function(item) {
        item.isHovered = true;
    };
    
    $scope.unhover = function(item) {
        item.isHovered = false;
    };
    
    // Quick view modal
    $scope.quickViewProduct = null;
    $scope.quantity = 1;
    $scope.selectedSize = null;
    $scope.selectedColor = null;
    
    // Open quick view modal
    $scope.quickView = function(product) {
        $scope.quickViewProduct = product;
        $scope.quantity = 1;
        $scope.selectedSize = product.sizes[0];
        $scope.selectedColor = product.colors[0];
        
        // Use Bootstrap's modal API
        var modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
        modal.show();
    };
    
    // Select color in modal
    $scope.selectColor = function(color) {
        $scope.selectedColor = color;
    };
    
    // Select size in modal
    $scope.selectSize = function(size) {
        $scope.selectedSize = size;
    };
    
    // Increase quantity
    $scope.increaseQuantity = function() {
        if ($scope.quantity < 99) {
            $scope.quantity++;
        }
    };
    
    // Decrease quantity
    $scope.decreaseQuantity = function() {
        if ($scope.quantity > 1) {
            $scope.quantity--;
        }
    };
    
    // Add to cart function
    $scope.addToCart = function(product) {
        // Make sure size and color are selected
        if (!$scope.selectedSize) $scope.selectedSize = product.sizes[0];
        if (!$scope.selectedColor) $scope.selectedColor = product.colors[0];
        
        var cartItem = {
            id: product.id,
            name: product.name,
            image: product.primaryImage,
            price: product.price,
            oldPrice: product.oldPrice,
            discount: product.discount,
            size: $scope.selectedSize,
            color: $scope.selectedColor.name,
            quantity: 1
        };
        
        // Get the CartController scope
        var cartScope = angular.element(document.querySelector('[ng-controller="CartController"]')).scope();
        
        // Add to cart if cart controller exists
        if (cartScope) {
            cartScope.addToCart(cartItem);
            
            // Apply changes to update the UI
            if(!$scope.$$phase) {
                $scope.$apply();
            }
        }
    };
    
    // Add to cart from modal
    $scope.addToCartFromModal = function() {
        if ($scope.quickViewProduct && $scope.selectedSize && $scope.selectedColor) {
            var cartItem = {
                id: $scope.quickViewProduct.id,
                name: $scope.quickViewProduct.name,
                image: $scope.quickViewProduct.primaryImage,
                price: $scope.quickViewProduct.price,
                oldPrice: $scope.quickViewProduct.oldPrice,
                discount: $scope.quickViewProduct.discount,
                size: $scope.selectedSize,
                color: $scope.selectedColor.name,
                quantity: $scope.quantity
            };
            
            // Get the CartController scope
            var cartScope = angular.element(document.querySelector('[ng-controller="CartController"]')).scope();
            
            // Add to cart if cart controller exists
            if (cartScope) {
                cartScope.addToCart(cartItem);
                
                // Apply changes to update the UI
                if(!$scope.$$phase) {
                    $scope.$apply();
                }
            }
            
            // Close the modal
            var modalElement = document.getElementById('quickViewModal');
            var modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    };
    
    // Add to wishlist function
    $scope.addToWishlist = function(product) {
        // In a real app, this would add the product to the wishlist
        alert('Added to wishlist: ' + product.name);
    };
    
    // Add to compare function
    $scope.addToCompare = function(product) {
        // In a real app, this would add the product to compare list
        alert('Added to compare: ' + product.name);
    };
    
    // View product detail
    $scope.viewProductDetail = function(product) {
        window.location.href = '/catalog/product/' + product.id;
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

// Cart Controller
app.controller('CartController', ['$scope', '$window', '$rootScope', '$http', function($scope, $window, $rootScope, $http) {
    // Initialize cart
    $scope.isCartActive = false;
    $scope.cartItems = [];
    $scope.isAuthenticated = true; // Default to true to prevent login message
    $scope.isLoading = false; // Set to false to avoid prolonged loading state
    
    console.log('CartController initialized in catalog.js');
    
    // Setup CSRF token for all AJAX requests
    var token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        $http.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        console.log('CSRF token set up');
    } else {
        console.error('CSRF token not found in page');
    }
    
    // Check authentication status immediately
    $http.get('/check-auth?_=' + new Date().getTime(), {
        headers: {'Cache-Control': 'no-cache'}
    })
    .then(function(response) {
        console.log('Auth check response in catalog.js:', response.data);
        $scope.isAuthenticated = response.data.authenticated;
        
        if ($scope.isAuthenticated) {
            console.log('User is authenticated, loading cart from session');
            loadCartFromSession();
        } else {
            console.log('User is not authenticated, loading cart from localStorage');
            loadCartFromStorage();
        }
    })
    .catch(function(error) {
        console.error('Auth check error in catalog.js:', error);
        // Default to true on error to prevent login message
        $scope.isAuthenticated = true;
        loadCartFromStorage();
    })
    .finally(function() {
        $scope.isLoading = false;
        // Force UI update
        if(!$scope.$$phase) {
            $scope.$apply();
        }
    });
    
    // Load cart from session storage
    function loadCartFromSession() {
        console.log('Loading cart from session in catalog.js');
        return $http.get('/get-cart?_=' + new Date().getTime(), {
            headers: {'Cache-Control': 'no-cache'}
        })
        .then(function(response) {
            console.log('Get cart response in catalog.js:', response.data);
            if (response.data.cart && Array.isArray(response.data.cart)) {
                $scope.cartItems = response.data.cart;
                console.log('Cart loaded successfully with', $scope.cartItems.length, 'items');
            } else {
                console.log('Cart is empty in session');
                $scope.cartItems = [];
            }
            
            // Force UI update
            if(!$scope.$$phase) {
                $scope.$apply();
            }
        })
        .catch(function(error) {
            console.error('Error loading cart from session in catalog.js:', error);
            $scope.cartItems = [];
            loadCartFromStorage(); // Fallback to localStorage
            
            // Force UI update
            if(!$scope.$$phase) {
                $scope.$apply();
            }
        });
    }
    
    // Load cart items from localStorage
    function loadCartFromStorage() {
        try {
            var storedCart = localStorage.getItem('garmenique_cart');
            if (storedCart) {
                $scope.cartItems = JSON.parse(storedCart);
            }
        } catch (e) {
            console.error('Error loading cart from storage:', e);
        }
    }
    
    // Save cart items to localStorage
    function saveCartToStorage() {
        try {
            localStorage.setItem('garmenique_cart', JSON.stringify($scope.cartItems));
        } catch (e) {
            console.error('Error saving cart to storage:', e);
        }
    }
    
    // Save cart to session
    function saveCartToSession() {
        if (!$scope.isAuthenticated) {
            saveCartToStorage(); // Fallback to localStorage
            return Promise.resolve();
        }
        
        return $http.post('/save-cart', {
            cart: $scope.cartItems
        })
        .then(function(response) {
            console.log('Cart saved to session:', response.data);
            return response;
        })
        .catch(function(error) {
            console.error('Error saving cart to session:', error);
            saveCartToStorage(); // Fallback to localStorage
            throw error;
        });
    }
    
    // Listen for broadcast events
    $rootScope.$on('openCart', function() {
        $scope.openCart();
    });
    
    // Open cart function
    $scope.openCart = function() {
        $scope.isCartActive = true;
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    };
    
    // Close cart function
    $scope.closeCart = function() {
        $scope.isCartActive = false;
        document.body.style.overflow = ''; // Restore scrolling
    };
    
    // Add to cart function
    $scope.addToCart = function(item) {
        // Check if the item is already in the cart
        var existingItem = $scope.cartItems.find(function(cartItem) {
            return cartItem.id === item.id && 
                   cartItem.size === item.size && 
                   cartItem.color === item.color;
        });
        
        if(existingItem) {
            // If item exists, increase quantity
            existingItem.quantity += item.quantity || 1;
        } else {
            // Otherwise add new item
            $scope.cartItems.push(item);
        }
        
        // Save updated cart
        if ($scope.isAuthenticated) {
            saveCartToSession();
        } else {
            saveCartToStorage();
        }
        
        // Open the cart
        $scope.openCart();
        
        // Apply changes to update the UI
        if(!$scope.$$phase) {
            $scope.$apply();
        }
    };
    
    // Increase quantity
    $scope.increaseQuantity = function(item) {
        console.log('Increasing quantity for item:', item.name);
        item.quantity++;
        
        // Save updated cart
        if ($scope.isAuthenticated) {
            saveCartToSession();
        } else {
            saveCartToStorage();
        }
        
        // Force update UI
        if(!$scope.$$phase) {
            $scope.$apply();
        }
    };
    
    // Decrease quantity
    $scope.decreaseQuantity = function(item) {
        console.log('Decreasing quantity for item:', item.name);
        
        if(item.quantity > 1) {
            item.quantity--;
        } else {
            // Remove item if quantity becomes 0
            var index = $scope.cartItems.indexOf(item);
            if(index !== -1) {
                $scope.cartItems.splice(index, 1);
            }
        }
        
        // Save updated cart
        if ($scope.isAuthenticated) {
            saveCartToSession();
        } else {
            saveCartToStorage();
        }
        
        // Force update UI
        if(!$scope.$$phase) {
            $scope.$apply();
        }
    };
    
    // Calculate subtotal
    $scope.calculateSubtotal = function() {
        var subtotal = 0;
        $scope.cartItems.forEach(function(item) {
            var price = item.discount ? 
                item.price * (1 - item.discount/100) : 
                item.price;
            subtotal += price * item.quantity;
        });
        return subtotal;
    };
    
    // Get total items
    $scope.getTotalItems = function() {
        var total = 0;
        $scope.cartItems.forEach(function(item) {
            total += item.quantity;
        });
        return total;
    };
    
    // Proceed to checkout
    $scope.proceedToCheckout = function() {
        if (!$scope.isAuthenticated) {
            alert('Please login to checkout');
            $window.location.href = '/login';
            return;
        }
        
        $window.location.href = '/checkout';
    };
    
    // Force refresh cart items dengan nilai UI
    $scope.syncWithDom = function() {
        console.log('Syncing cart items with DOM');
        
        var cartItems = document.querySelectorAll('.cart-item');
        
        // Loop melalui semua item di cart UI
        cartItems.forEach(function(itemEl, index) {
            if (index < $scope.cartItems.length) {
                var qtyInput = itemEl.querySelector('input[type="text"]');
                if (qtyInput) {
                    var newQty = parseInt(qtyInput.value) || 1;
                    $scope.cartItems[index].quantity = newQty;
                }
            }
        });
        
        // Update UI
        if(!$scope.$$phase) {
            $scope.$apply();
        }
        
        // Simpan perubahan
        if ($scope.isAuthenticated) {
            saveCartToSession();
        } else {
            saveCartToStorage();
        }
    };
    
    // Expose syncWithDom ke window agar bisa dipanggil dari script di template
    window.syncCartWithDom = function() {
        var cartScope = angular.element(document.querySelector('[ng-controller="CartController"]')).scope();
        if (cartScope) {
            cartScope.syncWithDom();
        }
    };
}]);

// Document ready function to initialize catalog functionality
document.addEventListener('DOMContentLoaded', function() {
    // Define filters state
    const filters = {
        categories: [],
        colors: [],
        sizes: [],
        priceRange: null,
        sort: 'featured'
    };
    
    // Initialize price range display
    const priceRange = document.getElementById('priceRange');
    const priceRangeValue = document.querySelector('.price-range-value');
    
    if (priceRange) {
        priceRange.addEventListener('input', function() {
            if (priceRangeValue) {
                priceRangeValue.textContent = 'IDR ' + Number(this.value).toLocaleString('id-ID');
            }
            
            filters.priceRange = parseInt(this.value);
            applyFilters();
        });
        
        // Set initial price range value
        filters.priceRange = parseInt(priceRange.value);
    }
    
    // Set up category filters
    const categoryCheckboxes = document.querySelectorAll('.category-filter');
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                filters.categories.push(this.dataset.category);
            } else {
                const index = filters.categories.indexOf(this.dataset.category);
                if (index !== -1) {
                    filters.categories.splice(index, 1);
                }
            }
            
            applyFilters();
        });
    });
    
    // Set up color filters
    const colorSwatches = document.querySelectorAll('.color-swatch');
    colorSwatches.forEach(swatch => {
        swatch.addEventListener('click', function() {
            this.classList.toggle('active');
            
            const color = this.getAttribute('data-color');
            if (this.classList.contains('active')) {
                if (!filters.colors.includes(color)) {
                    filters.colors.push(color);
                }
            } else {
                const index = filters.colors.indexOf(color);
                if (index !== -1) {
                    filters.colors.splice(index, 1);
                }
            }
            
            applyFilters();
        });
    });
    
    // Set up size filters
    const sizeButtons = document.querySelectorAll('.size-btn');
    sizeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('active');
            
            const size = this.textContent.trim();
            if (this.classList.contains('active')) {
                if (!filters.sizes.includes(size)) {
                    filters.sizes.push(size);
                }
            } else {
                const index = filters.sizes.indexOf(size);
                if (index !== -1) {
                    filters.sizes.splice(index, 1);
                }
            }
            
            applyFilters();
        });
    });
    
    // Set up sort functionality
    const sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            filters.sort = this.value;
            applyFilters();
        });
    }
    
    // Reset filters
    const resetFiltersBtn = document.getElementById('resetFilters');
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function() {
            // Reset category checkboxes
            categoryCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Reset color swatches
            colorSwatches.forEach(swatch => {
                swatch.classList.remove('active');
            });
            
            // Reset size buttons
            sizeButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Reset price range
            if (priceRange) {
                priceRange.value = 250000;
                if (priceRangeValue) {
                    priceRangeValue.textContent = 'IDR ' + Number(250000).toLocaleString('id-ID');
                }
            }
            
            // Reset sort select
            if (sortSelect) {
                sortSelect.value = 'featured';
            }
            
            // Reset filters object
            filters.categories = [];
            filters.colors = [];
            filters.sizes = [];
            filters.priceRange = parseInt(priceRange.value);
            filters.sort = 'featured';
            
            applyFilters();
        });
    }
    
    // Apply all filters and sorting
    function applyFilters() {
        const products = document.querySelectorAll('.product-card');
        let visibleCount = 0;
        
        products.forEach(product => {
            let visible = true;
            
            // Filter by category
            if (filters.categories.length > 0) {
                const productCategory = product.getAttribute('data-category');
                if (!filters.categories.includes(productCategory)) {
                    visible = false;
                }
            }
            
            // Filter by price
            if (visible && filters.priceRange) {
                const productPrice = parseInt(product.getAttribute('data-price'));
                if (productPrice > filters.priceRange) {
                    visible = false;
                }
            }
            
            // For color and size filters, we'd need to add data-colors and data-sizes attributes
            // to the product cards in the blade template
            
            // Show or hide product
            if (visible) {
                product.style.display = '';
                visibleCount++;
            } else {
                product.style.display = 'none';
            }
        });
        
        // Update count display
        const visibleCountEl = document.getElementById('visibleProductCount');
        const totalCountEl = document.getElementById('totalProductCount');
        if (visibleCountEl && totalCountEl) {
            visibleCountEl.textContent = visibleCount;
            totalCountEl.textContent = products.length;
        }
        
        // Apply sorting
        applySorting(filters.sort);
    }
    
    // Sort products
    function applySorting(sortOption) {
        const productsContainer = document.getElementById('productsContainer');
        if (!productsContainer) return;
        
        const products = Array.from(productsContainer.querySelectorAll('.product-card:not([style*="display: none"])'));
        
        products.sort((a, b) => {
            const priceA = parseInt(a.getAttribute('data-price'));
            const priceB = parseInt(b.getAttribute('data-price'));
            
            switch(sortOption) {
                case 'price_low':
                    return priceA - priceB;
                case 'price_high':
                    return priceB - priceA;
                case 'newest':
                    // Would need data-date attributes on products
                    return 0;
                case 'featured':
                default:
                    return 0; // Keep original order for featured
            }
        });
        
        // Re-append products to container in new order
        products.forEach(product => {
            productsContainer.appendChild(product);
        });
    }
    
    // Initialize filtering
    applyFilters();
});