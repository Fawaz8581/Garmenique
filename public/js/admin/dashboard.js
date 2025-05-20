// Garmenique Admin Dashboard AngularJS Controller
var app = angular.module('garmeniqueAdmin', []);

app.controller('DashboardController', function($scope, $http) {
    // Theme management
    $scope.theme = localStorage.getItem('garmeniqueTheme') || 'light';
    document.body.setAttribute('data-theme', $scope.theme);
    
    $scope.toggleTheme = function() {
        $scope.theme = $scope.theme === 'light' ? 'dark' : 'light';
        document.body.setAttribute('data-theme', $scope.theme);
        localStorage.setItem('garmeniqueTheme', $scope.theme);
    };
    
    // Sidebar management for mobile
    $scope.isSidebarActive = false;
    $scope.toggleSidebar = function() {
        $scope.isSidebarActive = !$scope.isSidebarActive;
    };
    
    // Navigation
    $scope.currentPage = 'dashboard';
    $scope.navigateTo = function(route) {
        $scope.currentPage = route;
        
        // Close sidebar on mobile after navigation
        if (window.innerWidth < 992) {
            $scope.isSidebarActive = false;
        }
    };
    
    // Logout
    $scope.logout = function() {
        window.location.href = '/login';
    };
    
    // Dashboard data
    $scope.dashboardData = {
        totalSales: '$25,024',
        totalOrders: '382',
        totalRevenue: '$58,542',
        salesGrowth: '80%',
        ordersGrowth: '65%',
        revenueGrowth: '75%'
    };
    
    // Sample data
    $scope.selectedDate = new Date();
    
    $scope.recentOrders = [
        { productName: 'Classic T-Shirt', productNumber: 'GA-1001', payment: '$49.99', status: 'Delivered' },
        { productName: 'Designer Jeans', productNumber: 'GA-1002', payment: '$89.99', status: 'Pending' },
        { productName: 'Summer Dress', productNumber: 'GA-1003', payment: '$65.50', status: 'Processing' },
        { productName: 'Winter Jacket', productNumber: 'GA-1004', payment: '$125.00', status: 'Shipped' },
        { productName: 'Silk Scarf', productNumber: 'GA-1005', payment: '$35.75', status: 'Delivered' },
    ];
    
    $scope.recentUpdates = [
        { 
            name: 'Emily Johnson', 
            avatar: 'https://randomuser.me/api/portraits/women/1.jpg', 
            message: 'Just purchased the new summer collection items' 
        },
        { 
            name: 'Alex Martinez', 
            avatar: 'https://randomuser.me/api/portraits/men/2.jpg', 
            message: 'Left a 5-star review for Designer Jeans' 
        },
        { 
            name: 'Sophia Williams', 
            avatar: 'https://randomuser.me/api/portraits/women/3.jpg', 
            message: 'Subscribed to the newsletter' 
        }
    ];
    
    // Products data
    $scope.products = [
        {
            id: 1,
            name: 'Classic T-Shirt',
            category: 'T-Shirts',
            price: 49.99,
            stock: 125,
            status: 'In Stock'
        },
        {
            id: 2,
            name: 'Designer Jeans',
            category: 'Jeans',
            price: 89.99,
            stock: 78,
            status: 'In Stock'
        },
        {
            id: 3,
            name: 'Summer Dress',
            category: 'Dresses',
            price: 65.50,
            stock: 42,
            status: 'Low Stock'
        },
        {
            id: 4,
            name: 'Winter Jacket',
            category: 'Outerwear',
            price: 125.00,
            stock: 15,
            status: 'Low Stock'
        },
        {
            id: 5,
            name: 'Silk Scarf',
            category: 'Accessories',
            price: 35.75,
            stock: 0,
            status: 'Out of Stock'
        }
    ];
    
    // Customers data
    $scope.customers = [
        {
            id: 1,
            name: 'Emily Johnson',
            email: 'emily.j@example.com',
            orders: 8,
            spent: '$452.65',
            status: 'Active'
        },
        {
            id: 2,
            name: 'Alex Martinez',
            email: 'alex.m@example.com',
            orders: 5,
            spent: '$278.50',
            status: 'Active'
        },
        {
            id: 3,
            name: 'Sophia Williams',
            email: 'sophia.w@example.com',
            orders: 3,
            spent: '$187.25',
            status: 'Active'
        }
    ];
    
    // Initialize dashboard
    $scope.init = function() {
        console.log('Dashboard initialized');
    };
    
    $scope.init();
}); 