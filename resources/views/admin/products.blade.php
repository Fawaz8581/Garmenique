<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garmenique - Products Management</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Products Management">
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin Products CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/products.css') }}">
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="menu-toggle d-lg-none" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-logo"><img src="{{ asset('images/icons/GarmeniqueLogo.png') }}" alt="Garmenique Logo" style="width: 100%; height: 100%; object-fit: contain;"></div>
            <div class="brand-text">GARMENIQUE</div>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item" id="dashboard-link">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-users"></i>
                <span>Customers</span>
            </li>
            <li class="menu-item active">
                <i class="fas fa-box"></i>
                <span>Products</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-envelope"></i>
                <span>Messages</span>
                <span class="notification-badge">14</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-file-alt"></i>
                <span>Reports</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h1 class="page-title">Products</h1>
            
            <div class="user-section">
                <div class="user-info">
                    <h4 class="user-name">Garmenique</h4>
                    <p class="user-role">Admin</p>
                </div>
            </div>
        </div>
        
        <!-- Products Section -->
        <div class="products-section">
            <div class="filter-section">
                <div class="search-box">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search products..." id="productSearch">
                    </div>
                </div>
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>
            
            <div class="row" id="productContainer">
                <!-- Product cards will be added here by JavaScript -->
            </div>
        </div>
    </div>
    
    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="add-product-form" id="addProductForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="productCategory" class="form-label">Category</label>
                                <select class="form-select" id="productCategory" required>
                                    <option value="">Select Category</option>
                                    <option value="T-Shirts">T-Shirts</option>
                                    <option value="Jeans">Jeans</option>
                                    <option value="Dresses">Dresses</option>
                                    <option value="Outerwear">Outerwear</option>
                                    <option value="Accessories">Accessories</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productPrice" class="form-label">Price ($)</label>
                                <input type="number" class="form-control" id="productPrice" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-6">
                                <label for="productStock" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" id="productStock" min="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="productImage" placeholder="https://example.com/image.jpg">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="addProductBtn" data-bs-dismiss="modal">Add Product</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="edit-product-form" id="editProductForm">
                        <input type="hidden" id="editProductId">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editProductName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="editProductName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editProductCategory" class="form-label">Category</label>
                                <select class="form-select" id="editProductCategory" required>
                                    <option value="">Select Category</option>
                                    <option value="T-Shirts">T-Shirts</option>
                                    <option value="Jeans">Jeans</option>
                                    <option value="Dresses">Dresses</option>
                                    <option value="Outerwear">Outerwear</option>
                                    <option value="Accessories">Accessories</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editProductPrice" class="form-label">Price ($)</label>
                                <input type="number" class="form-control" id="editProductPrice" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editProductStock" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" id="editProductStock" min="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editProductImage" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="editProductImage" placeholder="https://example.com/image.jpg">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEditBtn" data-bs-dismiss="modal">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sample products data
        const products = [
            {
                id: 1,
                name: 'Classic T-Shirt',
                category: 'T-Shirts',
                price: 49.99,
                stock: 125,
                image: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                status: 'In Stock'
            },
            {
                id: 2,
                name: 'Designer Jeans',
                category: 'Jeans',
                price: 89.99,
                stock: 78,
                image: 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                status: 'In Stock'
            },
            {
                id: 3,
                name: 'Summer Dress',
                category: 'Dresses',
                price: 65.50,
                stock: 42,
                image: 'https://images.unsplash.com/photo-1492707892479-7bc8d5a4ee93?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                status: 'Low Stock'
            },
            {
                id: 4,
                name: 'Winter Jacket',
                category: 'Outerwear',
                price: 125.00,
                stock: 15,
                image: 'https://images.unsplash.com/photo-1551028719-00167b16eac5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                status: 'Low Stock'
            },
            {
                id: 5,
                name: 'Silk Scarf',
                category: 'Accessories',
                price: 35.75,
                stock: 0,
                image: 'https://assets.vogue.com/photos/589208b00e6cdc8a1928e3ef/master/pass/celebrity-style-reese-witherspoon.jpg',
                status: 'Out of Stock'
            }
        ];
        
        // DOM elements
        const productContainer = document.getElementById('productContainer');
        const productSearch = document.getElementById('productSearch');
        const addProductBtn = document.getElementById('addProductBtn');
        const saveEditBtn = document.getElementById('saveEditBtn');
        const dashboardLink = document.getElementById('dashboard-link');
        
        // Initialize page
        function init() {
            // Render products
            renderProducts(products);
            
            // Set up event listeners
            setupEventListeners();
            
            // Set current date
            const today = new Date();
            if (document.getElementById('selectedDate')) {
                document.getElementById('selectedDate').valueAsDate = today;
            }
        }
        
        // Render products
        function renderProducts(productsArray) {
            productContainer.innerHTML = '';
            
            productsArray.forEach(product => {
                const productCard = createProductCard(product);
                productContainer.appendChild(productCard);
            });
        }
        
        // Create product card
        function createProductCard(product) {
            const col = document.createElement('div');
            col.className = 'col-md-4 col-lg-3 mb-4';
            
            // Determine stock status class
            let statusClass = '';
            if (product.status === 'In Stock') {
                statusClass = 'stock-in';
            } else if (product.status === 'Low Stock') {
                statusClass = 'stock-low';
            } else {
                statusClass = 'stock-out';
            }
            
            col.innerHTML = `
                <div class="product-card" data-id="${product.id}">
                    <div class="product-image">
                        <img src="${product.image}" alt="${product.name}">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">${product.name}</h3>
                        <p class="product-category">${product.category}</p>
                        <p class="product-price">$${product.price.toFixed(2)}</p>
                        <p class="product-stock">
                            <span class="stock-badge ${statusClass}">${product.status}</span>
                            <span class="ms-2">${product.stock} in stock</span>
                        </p>
                        <div class="product-actions">
                            <button class="action-btn edit-product-btn" data-bs-toggle="modal" data-bs-target="#editProductModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn delete-btn delete-product-btn">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            return col;
        }
        
        // Set up event listeners
        function setupEventListeners() {
            // Sidebar toggle for mobile
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('active');
            });
            
            // Menu item click
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active class from all items
                    menuItems.forEach(i => i.classList.remove('active'));
                    // Add active class to clicked item
                    this.classList.add('active');
                    
                    // Close sidebar on mobile after navigation
                    if (window.innerWidth < 992) {
                        document.getElementById('sidebar').classList.remove('active');
                    }
                });
            });
            
            // Dashboard link
            dashboardLink.addEventListener('click', function() {
                window.location.href = '/admin';
            });
            
            // Search products
            productSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredProducts = products.filter(product => 
                    product.name.toLowerCase().includes(searchTerm) || 
                    product.category.toLowerCase().includes(searchTerm)
                );
                renderProducts(filteredProducts);
                setupProductButtons();
            });
            
            // Add product
            addProductBtn.addEventListener('click', function() {
                const name = document.getElementById('productName').value;
                const category = document.getElementById('productCategory').value;
                const price = parseFloat(document.getElementById('productPrice').value);
                const stock = parseInt(document.getElementById('productStock').value) || 0;
                const image = document.getElementById('productImage').value || 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80';
                
                if (!name || !category || isNaN(price)) {
                    alert('Please fill in all required fields');
                    return;
                }
                
                const status = stock > 0 ? (stock <= 20 ? 'Low Stock' : 'In Stock') : 'Out of Stock';
                
                const newId = Math.max(...products.map(p => p.id)) + 1;
                
                const newProduct = {
                    id: newId,
                    name,
                    category,
                    price,
                    stock,
                    image,
                    status
                };
                
                products.push(newProduct);
                renderProducts(products);
                setupProductButtons();
                
                // Reset form
                document.getElementById('addProductForm').reset();
            });
            
            // Save edited product
            saveEditBtn.addEventListener('click', function() {
                const id = parseInt(document.getElementById('editProductId').value);
                const name = document.getElementById('editProductName').value;
                const category = document.getElementById('editProductCategory').value;
                const price = parseFloat(document.getElementById('editProductPrice').value);
                const stock = parseInt(document.getElementById('editProductStock').value) || 0;
                const image = document.getElementById('editProductImage').value;
                
                if (!name || !category || isNaN(price)) {
                    alert('Please fill in all required fields');
                    return;
                }
                
                const status = stock > 0 ? (stock <= 20 ? 'Low Stock' : 'In Stock') : 'Out of Stock';
                
                const index = products.findIndex(p => p.id === id);
                if (index !== -1) {
                    products[index] = {
                        ...products[index],
                        name,
                        category,
                        price,
                        stock,
                        image: image || products[index].image,
                        status
                    };
                    
                    renderProducts(products);
                    setupProductButtons();
                }
            });
            
            // Setup edit and delete buttons
            setupProductButtons();
        }
        
        // Setup product buttons
        function setupProductButtons() {
            // Edit product
            document.querySelectorAll('.edit-product-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productCard = this.closest('.product-card');
                    const id = parseInt(productCard.dataset.id);
                    const product = products.find(p => p.id === id);
                    
                    if (product) {
                        document.getElementById('editProductId').value = product.id;
                        document.getElementById('editProductName').value = product.name;
                        document.getElementById('editProductCategory').value = product.category;
                        document.getElementById('editProductPrice').value = product.price;
                        document.getElementById('editProductStock').value = product.stock;
                        document.getElementById('editProductImage').value = product.image;
                    }
                });
            });
            
            // Delete product
            document.querySelectorAll('.delete-product-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this product?')) {
                        const productCard = this.closest('.product-card');
                        const id = parseInt(productCard.dataset.id);
                        
                        const index = products.findIndex(p => p.id === id);
                        if (index !== -1) {
                            products.splice(index, 1);
                            renderProducts(products);
                            setupProductButtons();
                        }
                    }
                });
            });
        }
        
        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html> 