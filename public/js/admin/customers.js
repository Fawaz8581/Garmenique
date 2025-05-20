// Garmenique Admin Customers AngularJS Controller
var app = angular.module('garmeniqueAdmin');

app.controller('CustomersController', function($scope, $http) {
    // Customers data
    $scope.customers = [
        {
            id: 1,
            name: 'Emily Johnson',
            email: 'emily.j@example.com',
            phone: '+1 (555) 123-4567',
            address: '123 Main St, New York, NY',
            orders: 8,
            spent: '$452.65',
            status: 'Active',
            joinDate: '2023-01-15'
        },
        {
            id: 2,
            name: 'Alex Martinez',
            email: 'alex.m@example.com',
            phone: '+1 (555) 234-5678',
            address: '456 Oak Ave, Los Angeles, CA',
            orders: 5,
            spent: '$278.50',
            status: 'Active',
            joinDate: '2023-02-22'
        },
        {
            id: 3,
            name: 'Sophia Williams',
            email: 'sophia.w@example.com',
            phone: '+1 (555) 345-6789',
            address: '789 Pine Rd, Chicago, IL',
            orders: 3,
            spent: '$187.25',
            status: 'Active',
            joinDate: '2023-03-10'
        },
        {
            id: 4,
            name: 'James Brown',
            email: 'james.b@example.com',
            phone: '+1 (555) 456-7890',
            address: '101 Maple Dr, Houston, TX',
            orders: 1,
            spent: '$75.99',
            status: 'Inactive',
            joinDate: '2023-04-05'
        },
        {
            id: 5,
            name: 'Olivia Davis',
            email: 'olivia.d@example.com',
            phone: '+1 (555) 567-8901',
            address: '202 Cedar Ln, Seattle, WA',
            orders: 7,
            spent: '$390.45',
            status: 'Active',
            joinDate: '2023-01-30'
        }
    ];
    
    // Customer to view details
    $scope.selectedCustomer = null;
    
    // Filter and sort options
    $scope.customerFilter = '';
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
    
    // View customer details
    $scope.viewCustomer = function(customer) {
        $scope.selectedCustomer = angular.copy(customer);
    };
    
    $scope.closeDetails = function() {
        $scope.selectedCustomer = null;
    };
    
    // Customer orders - mock data
    $scope.getCustomerOrders = function(customerId) {
        // This would typically come from an API call
        return [
            {
                id: 'ORD-' + customerId + '-001',
                date: '2023-05-10',
                total: '$125.99',
                status: 'Delivered',
                items: [
                    { name: 'Classic T-Shirt', quantity: 1, price: '$49.99' },
                    { name: 'Silk Scarf', quantity: 2, price: '$75.50' }
                ]
            },
            {
                id: 'ORD-' + customerId + '-002',
                date: '2023-06-15',
                total: '$89.99',
                status: 'Processing',
                items: [
                    { name: 'Designer Jeans', quantity: 1, price: '$89.99' }
                ]
            }
        ];
    };
    
    // Update customer status
    $scope.updateStatus = function(customer, status) {
        var index = $scope.customers.findIndex(c => c.id === customer.id);
        if (index !== -1) {
            $scope.customers[index].status = status;
            if ($scope.selectedCustomer && $scope.selectedCustomer.id === customer.id) {
                $scope.selectedCustomer.status = status;
            }
        }
    };
    
    // Delete customer
    $scope.deleteCustomer = function(id) {
        if (confirm('Are you sure you want to delete this customer?')) {
            $scope.customers = $scope.customers.filter(c => c.id !== id);
            if ($scope.selectedCustomer && $scope.selectedCustomer.id === id) {
                $scope.selectedCustomer = null;
            }
        }
    };
    
    // Initialize customers controller
    $scope.init = function() {
        console.log('Customers controller initialized');
    };
    
    $scope.init();
}); 