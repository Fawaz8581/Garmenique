// Garmenique Admin Products AngularJS Controller
var app = angular.module('garmeniqueAdmin');

app.controller('ProductsController', function($scope, $http) {
    // Products data
    $scope.products = [
        {
            id: 1,
            name: 'Classic T-Shirt',
            category: 'T-Shirts',
            price: 149000,
            stock: 125,
            image: 'https://via.placeholder.com/150',
            status: 'In Stock'
        },
        {
            id: 2,
            name: 'Designer Jeans',
            category: 'Jeans',
            price: 399000,
            stock: 78,
            image: 'https://via.placeholder.com/150',
            status: 'In Stock'
        },
        {
            id: 3,
            name: 'Summer Dress',
            category: 'Dresses',
            price: 275000,
            stock: 42,
            image: 'https://via.placeholder.com/150',
            status: 'Low Stock'
        },
        {
            id: 4,
            name: 'Winter Jacket',
            category: 'Outerwear',
            price: 450000,
            stock: 15,
            image: 'https://via.placeholder.com/150',
            status: 'Low Stock'
        },
        {
            id: 5,
            name: 'Silk Scarf',
            category: 'Accessories',
            price: 125000,
            stock: 0,
            image: 'https://via.placeholder.com/150',
            status: 'Out of Stock'
        }
    ];
    
    // New product model
    $scope.newProduct = {
        name: '',
        category: '',
        price: '',
        stock: '',
        image: ''
    };
    
    // Categories
    $scope.categories = ['T-Shirts', 'Jeans', 'Dresses', 'Outerwear', 'Accessories'];
    
    // Product to edit
    $scope.editProduct = null;
    
    // Filter and sort options
    $scope.productFilter = '';
    $scope.sortKey = 'name';
    $scope.sortReverse = false;
    
    // Sort function
    $scope.sort = function(key) {
        if ($scope.sortKey === key) {
            $scope.sortReverse = !$scope.sortReverse;
        } else {
            $scope.sortKey = key;
            $scope.sortReverse = false;
        }
    };
    
    // Add product
    $scope.addProduct = function() {
        if (!$scope.newProduct.name || !$scope.newProduct.category || !$scope.newProduct.price) {
            alert('Please fill in all required fields');
            return;
        }
        
        var newId = $scope.products.length > 0 ? Math.max(...$scope.products.map(p => p.id)) + 1 : 1;
        
        var product = {
            id: newId,
            name: $scope.newProduct.name,
            category: $scope.newProduct.category,
            price: parseFloat($scope.newProduct.price),
            stock: parseInt($scope.newProduct.stock) || 0,
            image: $scope.newProduct.image || 'https://via.placeholder.com/150',
            status: parseInt($scope.newProduct.stock) > 0 ? (parseInt($scope.newProduct.stock) <= 20 ? 'Low Stock' : 'In Stock') : 'Out of Stock'
        };
        
        $scope.products.push(product);
        
        // Reset form
        $scope.newProduct = {
            name: '',
            category: '',
            price: '',
            stock: '',
            image: ''
        };
    };
    
    // Edit product
    $scope.startEdit = function(product) {
        $scope.editProduct = angular.copy(product);
    };
    
    $scope.saveEdit = function() {
        if (!$scope.editProduct) return;
        
        var index = $scope.products.findIndex(p => p.id === $scope.editProduct.id);
        if (index !== -1) {
            // Update stock status based on quantity
            $scope.editProduct.status = parseInt($scope.editProduct.stock) > 0 ? 
                (parseInt($scope.editProduct.stock) <= 20 ? 'Low Stock' : 'In Stock') : 'Out of Stock';
                
            $scope.products[index] = angular.copy($scope.editProduct);
        }
        
        $scope.cancelEdit();
    };
    
    $scope.cancelEdit = function() {
        $scope.editProduct = null;
    };
    
    // Delete product
    $scope.deleteProduct = function(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            $scope.products = $scope.products.filter(p => p.id !== id);
        }
    };
    
    // Initialize products controller
    $scope.init = function() {
        console.log('Products controller initialized');
    };
    
    $scope.init();
}); 