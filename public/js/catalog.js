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
        // In a real app, this would add the product to the cart
        alert('Added to cart: ' + product.name);
    };
    
    // Add to cart from modal
    $scope.addToCartFromModal = function() {
        if ($scope.quickViewProduct && $scope.selectedSize && $scope.selectedColor) {
            alert('Added to cart: ' + $scope.quickViewProduct.name + '\nSize: ' + $scope.selectedSize + '\nColor: ' + $scope.selectedColor.name + '\nQuantity: ' + $scope.quantity);
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