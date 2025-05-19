// Product Detail Controller
app.controller('ProductDetailController', ['$scope', '$window', '$http', function($scope, $window, $http) {
    // Get the product ID from the URL
    var url = $window.location.pathname;
    var productId = parseInt(url.substring(url.lastIndexOf('/') + 1));
    
    // Initialize product
    $scope.product = null;
    $scope.quantity = 1;
    $scope.selectedSize = null;
    $scope.selectedColor = null;
    $scope.selectedImage = null;
    $scope.reviewRating = 0;
    $scope.reviews = [];
    $scope.relatedProducts = [];
    
    // Load product data based on ID
    // In a real app, this would come from an API
    $scope.loadProduct = function() {
        // For now, we'll use the products data from catalog.js
        var allProducts = [];
        
        // Check if catalogController exists and get products from there
        if (angular.element(document.querySelector('[ng-controller="CatalogController"]')).scope()) {
            allProducts = angular.element(document.querySelector('[ng-controller="CatalogController"]')).scope().products;
        } else {
            // If not, define a sample product data
            allProducts = [
                {
                    id: 1,
                    name: 'Classic Cotton T-Shirt',
                    categoryId: 1,
                    primaryImage: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                    hoverImage: 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                    additionalImage1: 'https://www.frenchconnection.com/cdn/shop/files/LEAD_569ZE10_600copy.jpg?v=1716301996',
                    additionalImage2: 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
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
                    additionalImage1: 'https://images.unsplash.com/photo-1582552938357-32b906df40cb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                    additionalImage2: 'https://images.unsplash.com/photo-1565084888279-aca607ecce0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
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
                    additionalImage1: 'https://images.unsplash.com/photo-1551028719-00167b16eac5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                    additionalImage2: 'https://images.unsplash.com/photo-1584273143981-41c073dfe8f8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
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
                    additionalImage1: 'https://images.unsplash.com/photo-1520975954732-35dd22299614?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                    additionalImage2: 'https://images.unsplash.com/photo-1551794840-8ae3b9c814d4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
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
                    additionalImage1: 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                    additionalImage2: 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
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
        }
        
        // Find product by ID
        $scope.product = allProducts.find(function(p) {
            return p.id === productId;
        });
        
        // If product found, set default selected color
        if ($scope.product && $scope.product.colors.length > 0) {
            $scope.selectedColor = $scope.product.colors[0];
        }
        
        // Generate related products (randomly for now)
        if ($scope.product) {
            var relatedIds = []; // To store generated IDs to avoid duplicates
            
            // Add product ID to avoid showing the current product
            relatedIds.push($scope.product.id);
            
            // Generate 4 random product IDs
            while (relatedIds.length < 5 && allProducts.length > 4) {
                var randomId = allProducts[Math.floor(Math.random() * allProducts.length)].id;
                if (relatedIds.indexOf(randomId) === -1) {
                    relatedIds.push(randomId);
                }
            }
            
            // Get related products based on the IDs
            $scope.relatedProducts = allProducts.filter(function(p) {
                // Check if the product ID is in the relatedIds array and not the current product
                return relatedIds.indexOf(p.id) !== -1 && p.id !== $scope.product.id;
            });
        }
        
        // Generate sample reviews
        $scope.generateSampleReviews();
    };
    
    // Generate sample reviews
    $scope.generateSampleReviews = function() {
        $scope.reviews = [
            {
                name: 'Sarah Johnson',
                date: 'September 12, 2023',
                rating: 5,
                comment: 'Absolutely love this product! The quality is excellent, and it fits perfectly. Will definitely buy more in different colors.'
            },
            {
                name: 'Michael Brown',
                date: 'August 28, 2023',
                rating: 4,
                comment: 'Great product overall. The material is high quality and comfortable. Only giving 4 stars because the sizing runs a bit large.'
            },
            {
                name: 'Emily Davis',
                date: 'July 15, 2023',
                rating: 5,
                comment: 'Exceeded my expectations! Fast shipping and the product looks exactly like the photos. Highly recommend!'
            },
            {
                name: 'David Wilson',
                date: 'June 30, 2023',
                rating: 3,
                comment: 'Decent product for the price. The color is slightly different from what\'s shown in the images, but overall acceptable quality.'
            }
        ];
    };
    
    // Get stars for rating display
    $scope.getStars = function(rating) {
        return new Array(rating);
    };
    
    // Get empty stars for rating display
    $scope.getEmptyStars = function(rating) {
        return new Array(5 - rating);
    };
    
    // Get random rating percentage for the bars in the reviews tab
    $scope.getRandomRatingPercentage = function(stars) {
        var percentages = {
            5: { width: '75%' },
            4: { width: '60%' },
            3: { width: '25%' },
            2: { width: '15%' },
            1: { width: '5%' }
        };
        
        return percentages[stars];
    };
    
    // Get random rating count for the bars in the reviews tab
    $scope.getRandomRatingCount = function(stars) {
        var counts = {
            5: 18,
            4: 12,
            3: 5,
            2: 3,
            1: 1
        };
        
        return counts[stars];
    };
    
    // Set review rating
    $scope.setReviewRating = function(rating) {
        $scope.reviewRating = rating;
    };
    
    // Helper function for product hover in related products
    $scope.hover = function(product) {
        product.isHovered = true;
    };
    
    // Helper function for product unhover in related products
    $scope.unhover = function(product) {
        product.isHovered = false;
    };
    
    // Quick view function for related products
    $scope.quickView = function(product) {
        alert('Quick view for: ' + product.name);
        // In a real app, this would open a modal with product details
    };
    
    // Add to compare function for related products
    $scope.addToCompare = function(product) {
        alert('Added to compare: ' + product.name);
        // In a real app, this would add the product to a comparison list
    };
    
    // Initialize by loading the product
    $scope.loadProduct();
    
    // Select the image to display in the main image area
    $scope.selectImage = function(image) {
        $scope.selectedImage = image;
    };
    
    // Select a color
    $scope.selectColor = function(color) {
        $scope.selectedColor = color;
    };
    
    // Select a size
    $scope.selectSize = function(size) {
        $scope.selectedSize = size;
    };
    
    // Increase quantity
    $scope.increaseQuantity = function() {
        $scope.quantity++;
    };
    
    // Decrease quantity
    $scope.decreaseQuantity = function() {
        if ($scope.quantity > 1) {
            $scope.quantity--;
        }
    };
    
    // Add to cart
    $scope.addToCart = function() {
        if (!$scope.selectedSize) {
            alert('Please select a size before adding to cart');
            return;
        }
        
        if (!$scope.selectedColor) {
            alert('Please select a color before adding to cart');
            return;
        }
        
        alert('Product added to cart');
        // In a real app, this would send the product to a cart service
    };
    
    // Add to wishlist
    $scope.addToWishlist = function() {
        alert('Product added to wishlist');
        // In a real app, this would send the product to a wishlist service
    };
}]); 