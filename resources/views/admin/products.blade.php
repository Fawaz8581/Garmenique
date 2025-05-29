<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <li class="menu-item active">
                <i class="fas fa-box"></i>
                <span>Products</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-tags"></i>
                <span>Categories</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-ruler"></i>
                <span>Sizes</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-envelope"></i>
                <span>Messages</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-paint-brush"></i>
                <span>Customizes</span>
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
                <div class="text-center p-5" id="loadingIndicator">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading products...</p>
                </div>
                
                <div class="text-center p-5 d-none" id="noProductsMessage">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h3>No Products Found</h3>
                    <p>Start by adding a new product using the button above.</p>
                </div>
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
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productPrice" class="form-label">Price (IDR)</label>
                                <input type="text" class="form-control" id="productPrice" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stock by Size</label>
                                <div class="mb-2">
                                    <select class="form-select" id="sizeType">
                                        <option value="clothing">Clothing Size</option>
                                        <option value="number">Number Size</option>
                                    </select>
                                    <div class="size-type-info mt-1">
                                        <small class="text-muted clothing-size-info">Clothing Size example (XXS, XS, S, M, L, XL, XXL)</small>
                                        <small class="text-muted number-size-info" style="display: none;">Number Size example (30, 31, 32, 33, 34, 35)</small>
                                    </div>
                                </div>
                                <div class="size-stock-container">
                                    <div class="clothing-size">
                                        @foreach($sizes->where('type', 'clothing') as $size)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input size-checkbox" type="checkbox" value="{{ $size->id }}" id="size_{{ $size->id }}" data-size-type="clothing">
                                            <label class="form-check-label" for="size_{{ $size->id }}">
                                                {{ $size->name }}
                                            </label>
                                            <input type="number" class="form-control size-stock" data-size-id="{{ $size->id }}" placeholder="Stock" disabled min="0">
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="number-size" style="display: none;">
                                        @foreach($sizes->where('type', 'number') as $size)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input size-checkbox" type="checkbox" value="{{ $size->id }}" id="size_{{ $size->id }}" data-size-type="number">
                                            <label class="form-check-label" for="size_{{ $size->id }}">
                                                {{ $size->name }}
                                            </label>
                                            <input type="number" class="form-control size-stock" data-size-id="{{ $size->id }}" placeholder="Stock" disabled min="0">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="productImage" accept="image/*">
                            <small class="form-text text-muted">Upload an image for the product</small>
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="productDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="addProductBtn">Add Product</button>
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
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editProductPrice" class="form-label">Price (IDR)</label>
                                <input type="text" class="form-control" id="editProductPrice" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stock by Size</label>
                                <div class="mb-2">
                                    <select class="form-select" id="editSizeType">
                                        <option value="clothing">Clothing Size</option>
                                        <option value="number">Number Size</option>
                                    </select>
                                    <div class="size-type-info mt-1">
                                        <small class="text-muted clothing-size-info">Clothing Size example (XXS, XS, S, M, L, XL, XXL)</small>
                                        <small class="text-muted number-size-info" style="display: none;">Number Size example (30, 31, 32, 33, 34, 35)</small>
                                    </div>
                                </div>
                                <div class="size-stock-container">
                                    <div class="clothing-size">
                                        @foreach($sizes->where('type', 'clothing') as $size)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input size-checkbox" type="checkbox" value="{{ $size->id }}" id="editSize_{{ $size->id }}" data-size-type="clothing">
                                            <label class="form-check-label" for="editSize_{{ $size->id }}">
                                                {{ $size->name }}
                                            </label>
                                            <input type="number" class="form-control size-stock" data-size-id="{{ $size->id }}" placeholder="Stock" disabled min="0">
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="number-size" style="display: none;">
                                        @foreach($sizes->where('type', 'number') as $size)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input size-checkbox" type="checkbox" value="{{ $size->id }}" id="editSize_{{ $size->id }}" data-size-type="number">
                                            <label class="form-check-label" for="editSize_{{ $size->id }}">
                                                {{ $size->name }}
                                            </label>
                                            <input type="number" class="form-control size-stock" data-size-id="{{ $size->id }}" placeholder="Stock" disabled min="0">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editProductImage" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="editProductImage" accept="image/*">
                            <small class="form-text text-muted">Upload a new image or keep the existing one</small>
                            <div id="currentImagePreview" class="mt-2" style="max-width: 200px; display: none;">
                                <img id="currentImage" src="" alt="Current Product Image" class="img-fluid">
                                <p class="mt-1 mb-0"><small>Current image</small></p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editProductDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editProductDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEditBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Details Modal -->
    <div class="modal fade" id="detailsProductModal" tabindex="-1" aria-labelledby="detailsProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsProductModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Product Name</label>
                                <p id="detailProductName" class="form-control-plaintext"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Category</label>
                                <p id="detailProductCategory" class="form-control-plaintext"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Price (IDR)</label>
                                <p id="detailProductPrice" class="form-control-plaintext"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p id="detailProductStatus" class="form-control-plaintext"></p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <p id="detailProductDescription" class="form-control-plaintext"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Product Image</label>
                        <div id="detailImagePreview" class="mt-2">
                            <img id="detailCurrentImage" src="" alt="Product Image" class="img-fluid" style="max-width: 200px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Stock by Size</label>
                        <div id="detailSizeGrid" class="size-stock-grid">
                            <!-- Size stock grid will be populated dynamically -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this right after the closing </nav> tag or at the top of the body -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1070">
        <div id="notificationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="toastTitle">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">
            </div>
        </div>
    </div>

    <style>
        .view-btn {
            background-color: #28a745;
            color: white;
            margin-right: 5px;
        }
        .view-btn:hover {
            background-color: #218838;
        }
        
        /* Ensure details buttons are green */
        button[onclick*="showProductDetails"],
        .details-btn {
            background-color: #28a745 !important;
            color: white;
        }
        
        button[onclick*="showProductDetails"]:hover,
        .details-btn:hover {
            background-color: #218838 !important;
            color: white;
        }
        
        .form-control-plaintext {
            padding: 0.375rem 0;
            margin-bottom: 0;
            color: #495057;
            background-color: transparent;
            border: solid transparent;
            border-width: 1px 0;
        }
        .toast-success {
            background-color: #d4edda !important;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .toast-error {
            background-color: #f8d7da !important;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        /* Button styles */
        .btn-primary {
            background-color: #14387F;
            border-color: #14387F;
            color: white;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #0e2b63;
            border-color: #0e2b63;
        }
        
        .add-btn {
            background-color: #14387F;
            border-color: #14387F;
            color: white;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.2s;
            border: none;
        }
        
        .add-btn:hover {
            background-color: #0e2b63;
        }
        
        .action-btn {
            background-color: #14387F;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            margin-right: 5px;
            font-size: 14px;
            transition: background-color 0.2s;
        }
        
        .action-btn:hover {
            background-color: #0e2b63;
            color: white;
        }
        
        .delete-btn {
            background-color: #dc3545;
        }
        
        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // API endpoints
        const API_ENDPOINTS = {
            products: '/admin/api/products',
            categories: '/admin/api/categories'
        };
        
        // DOM elements
        const productContainer = document.getElementById('productContainer');
        const productSearch = document.getElementById('productSearch');
        const addProductBtn = document.getElementById('addProductBtn');
        const saveEditBtn = document.getElementById('saveEditBtn');
        const dashboardLink = document.getElementById('dashboard-link');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const noProductsMessage = document.getElementById('noProductsMessage');
        const productCategory = document.getElementById('productCategory');
        const editProductCategory = document.getElementById('editProductCategory');
        
        // Global variables
        let products = [];
        let categories = [];
        
        // Initialize page
        function init() {
            // Set up CSRF token for AJAX requests
            const token = document.querySelector('meta[name="csrf-token"]').content;
            
            // Get categories first
            fetchCategories().then(() => {
                // Then get products
                fetchProducts();
            });
            
            // Set up event listeners
            setupEventListeners();
            
            // Initialize size type handlers
            setupSizeTypeHandlers();
        }
        
        // Fetch categories from API
        function fetchCategories() {
            return fetch(API_ENDPOINTS.categories)
                .then(response => response.json())
                .then(data => {
                    categories = data;
                    populateCategoryDropdowns();
                })
                .catch(error => {
                    console.error('Error fetching categories:', error);
                    alert('Error loading categories. Please try again.');
                });
        }
        
        // Populate category dropdowns
        function populateCategoryDropdowns() {
            const dropdowns = [productCategory, editProductCategory];
            dropdowns.forEach(dropdown => {
                if (dropdown) {
                    // Clear existing options except the first one
                    dropdown.innerHTML = '<option value="">Select Category</option>';
                    
                    // Add categories from the database
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        dropdown.appendChild(option);
                    });
                }
            });
        }
        
        // Fetch products from API
        function fetchProducts() {
            fetch(API_ENDPOINTS.products)
                .then(response => response.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        products = data;
                        console.log('Fetched products:', products);
                        
                        // Debug each product's sizes structure
                        products.forEach(product => {
                            console.log(`Product ${product.id} (${product.name}) sizes:`, product.sizes);
                            if (product.sizes) {
                                console.log(`Size keys for product ${product.id}:`, Object.keys(product.sizes));
                                console.log(`Size values for product ${product.id}:`, Object.values(product.sizes));
                            }
                        });
                        
                        renderProducts(products);
                        loadingIndicator.classList.add('d-none');
                        
                        if (products.length === 0) {
                            noProductsMessage.classList.remove('d-none');
                        } else {
                            noProductsMessage.classList.add('d-none');
                        }
                    } else {
                        console.error('Invalid data format received:', data);
                        showNotification('Error', 'Invalid data format received from server', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                    loadingIndicator.classList.add('d-none');
                    noProductsMessage.classList.remove('d-none');
                    noProductsMessage.querySelector('p').textContent = 'Error loading products. Please try again.';
                });
        }
        
        // Render products
        function renderProducts(productsArray) {
            // Clear product container except for loading and no products messages
            const elements = productContainer.querySelectorAll('.col-md-4');
            elements.forEach(el => el.remove());
            
            // Show no products message if empty
            if (productsArray.length === 0) {
                noProductsMessage.classList.remove('d-none');
                return;
            }
            
            noProductsMessage.classList.add('d-none');
            
            // Add product cards
            productsArray.forEach(product => {
                const productCard = createProductCard(product);
                productContainer.appendChild(productCard);
            });
            
            // Setup product buttons
            setupProductButtons();
        }
        
        // Create product card
        function createProductCard(product) {
            const col = document.createElement('div');
            col.className = 'col-md-4 col-lg-3 mb-4';
            
            // Determine stock status class
            let statusClass = '';
            let statusText = '';
            
            if (product.total_stock > 20) {
                statusClass = 'stock-in';
                statusText = 'In Stock';
            } else if (product.total_stock > 0) {
                statusClass = 'stock-low';
                statusText = 'Low Stock';
            } else {
                statusClass = 'stock-out';
                statusText = 'Out of Stock';
            }
            
            // Get category name
            const categoryName = product.category_name || 'Uncategorized';
            
            // Get product image
            const imageUrl = product.db_image_url 
                ? product.db_image_url 
                : (product.image_url
                    ? product.image_url
                    : 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80');
            
            // Format price with Indonesian number format
            const formattedPrice = new Intl.NumberFormat('id-ID').format(product.price);
            
            const actionsHtml = `
                <div class="product-actions">
                    <button class="action-btn view-btn" onclick="showProductDetails(${product.id})">
                        <i class="fas fa-eye"></i> Details
                    </button>
                    <button class="action-btn edit-product-btn" data-bs-toggle="modal" data-bs-target="#editProductModal">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="action-btn delete-btn delete-product-btn">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            `;
            
            col.innerHTML = `
                <div class="product-card" data-id="${product.id}">
                    <div class="product-image">
                        <img src="${imageUrl}" alt="${product.name}">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">${product.name}</h3>
                        <p class="product-category">${categoryName}</p>
                        <p class="product-price">IDR ${formattedPrice}</p>
                        <p class="product-stock">
                            <span class="stock-badge ${statusClass}">${statusText}</span>
                            <span class="ms-2">Total: ${product.total_stock} in stock</span>
                        </p>
                        ${actionsHtml}
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
                    const menuText = this.querySelector('span').textContent;
                    
                    // Remove active class from all items
                    document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
                    // Add active class to clicked item
                    this.classList.add('active');
                    
                    // Handle navigation
                    switch(menuText) {
                        case 'Dashboard':
                            window.location.href = '/admin';
                            break;
                        case 'Products':
                            window.location.href = '/admin/products';
                            break;
                        case 'Categories':
                            window.location.href = '/admin/categories';
                            break;
                        case 'Sizes':
                            window.location.href = '/admin/sizes';
                            break;
                        case 'Messages':
                            window.location.href = '/admin/messages';
                            break;
                        case 'Settings':
                            window.location.href = '/admin/settings';
                            break;
                        case 'Customizes':
                            window.location.href = '/admin/customizes';
                            break;
                        case 'Logout':
                            // Create a logout form and submit it
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '/logout';
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                            form.appendChild(csrfInput);
                            document.body.appendChild(form);
                            form.submit();
                            break;
                    }
                    
                    // Close sidebar on mobile after navigation
                    if (window.innerWidth < 992) {
                        document.getElementById('sidebar').classList.remove('active');
                    }
                });
            });
            
            // Search products
            productSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredProducts = products.filter(product => 
                    product.name.toLowerCase().includes(searchTerm) || 
                    (product.category_name && product.category_name.toLowerCase().includes(searchTerm))
                );
                renderProducts(filteredProducts);
            });
            
            // Add product
            addProductBtn.addEventListener('click', function() {
                const formData = new FormData();
                
                // Basic product data
                formData.append('name', document.getElementById('productName').value);
                formData.append('category_id', document.getElementById('productCategory').value);
                formData.append('price', document.getElementById('productPrice').value.replace(/\./g, ''));
                formData.append('description', document.getElementById('productDescription').value);
                
                // Handle image
                const imageFile = document.getElementById('productImage').files[0];
                if (imageFile) {
                    formData.append('image', imageFile);
                }

                // Get selected sizes
                const selectedSizes = [];
                document.querySelectorAll('#addProductModal .size-checkbox:checked').forEach(checkbox => {
                    const stockInput = checkbox.parentElement.querySelector('.size-stock');
                    if (stockInput) {
                        // Always include the size if checked, even if stock is 0
                        selectedSizes.push({
                            id: parseInt(checkbox.value),
                            stock: parseInt(stockInput.value) || 0
                        });
                    }
                });

                // Validate form data
                if (!formData.get('name')) {
                    showNotification('Error', 'Product name is required', 'error');
                    return;
                }

                if (!formData.get('category_id')) {
                    showNotification('Error', 'Category is required', 'error');
                    return;
                }

                if (!formData.get('price')) {
                    showNotification('Error', 'Price is required', 'error');
                    return;
                }

                if (selectedSizes.length === 0) {
                    showNotification('Error', 'At least one size must be selected', 'error');
                    return;
                }
                
                // Log the sizes data for debugging
                console.log('Selected sizes:', selectedSizes);
                console.log('Sizes JSON:', JSON.stringify(selectedSizes));
                
                // Append sizes as JSON string
                formData.append('sizes', JSON.stringify(selectedSizes));

                // Show loading state
                addProductBtn.disabled = true;
                addProductBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';
                
                // Disable close button during add
                const closeBtn = document.querySelector('#addProductModal .btn-close');
                if (closeBtn) closeBtn.disabled = true;
                
                // Disable cancel button during add
                const cancelBtn = document.querySelector('#addProductModal .btn-secondary');
                if (cancelBtn) cancelBtn.disabled = true;

                // Send request
                fetch('/admin/api/products', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || `Error: ${response.status} ${response.statusText}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Reset button state
                    addProductBtn.disabled = false;
                    addProductBtn.innerHTML = 'Add Product';
                    
                    // Re-enable close and cancel buttons
                    if (closeBtn) closeBtn.disabled = false;
                    if (cancelBtn) cancelBtn.disabled = false;
                    
                    if (data.success) {
                        console.log('Add successful, received data:', data);
                        
                        // Add new product to array
                        products.push(data.product);
                        
                        // Re-render products
                        renderProducts(products);
                        
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
                        modal.hide();
                        
                        // Reset form
                        document.getElementById('addProductForm').reset();
                        document.querySelectorAll('#addProductModal .size-checkbox').forEach(checkbox => {
                            checkbox.checked = false;
                            const stockInput = checkbox.parentElement.querySelector('.size-stock');
                            stockInput.disabled = true;
                            stockInput.value = '';
                        });
                        
                        // Show success notification
                        showNotification('Success', 'Product added successfully!', 'success');
                    } else {
                        console.error('Add failed:', data.message);
                        showNotification('Error', data.message || 'Failed to add product', 'error');
                    }
                })
                .catch(error => {
                    // Reset button state
                    addProductBtn.disabled = false;
                    addProductBtn.innerHTML = 'Add Product';
                    
                    // Re-enable close and cancel buttons
                    if (closeBtn) closeBtn.disabled = false;
                    if (cancelBtn) cancelBtn.disabled = false;
                    
                    console.error('Error:', error);
                    showNotification('Error', error.message || 'An error occurred while adding the product', 'error');
                });
            });
        
            // Save edited product
            saveEditBtn.addEventListener('click', function() {
                const id = document.getElementById('editProductId').value;
                const formData = new FormData();
                
                // Basic product data
                formData.append('_method', 'PUT');
                formData.append('name', document.getElementById('editProductName').value);
                formData.append('category_id', document.getElementById('editProductCategory').value);
                formData.append('price', document.getElementById('editProductPrice').value.replace(/\./g, ''));
                formData.append('description', document.getElementById('editProductDescription').value);
                
                // Handle image
                const imageFile = document.getElementById('editProductImage').files[0];
                if (imageFile) {
                    formData.append('image', imageFile);
                }

                // Get selected sizes
                const selectedSizes = [];
                document.querySelectorAll('#editProductModal .size-checkbox:checked').forEach(checkbox => {
                    const stockInput = checkbox.parentElement.querySelector('.size-stock');
                    if (stockInput) {
                        // Always include the size if checked, even if stock is 0
                        selectedSizes.push({
                            id: parseInt(checkbox.value),
                            stock: parseInt(stockInput.value) || 0
                        });
                    }
                });
                
                // Validate form data
                if (!formData.get('name')) {
                    showNotification('Error', 'Product name is required', 'error');
                    return;
                }

                if (!formData.get('category_id')) {
                    showNotification('Error', 'Category is required', 'error');
                    return;
                }

                if (!formData.get('price')) {
                    showNotification('Error', 'Price is required', 'error');
                    return;
                }

                if (selectedSizes.length === 0) {
                    showNotification('Error', 'At least one size must be selected', 'error');
                    return;
                }

                // Log the sizes data for debugging
                console.log('Selected sizes for edit:', selectedSizes);
                console.log('Sizes JSON for edit:', JSON.stringify(selectedSizes));
                
                // Append sizes as JSON string
                formData.append('sizes', JSON.stringify(selectedSizes));
                
                // Show loading state
                saveEditBtn.disabled = true;
                saveEditBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
                
                // Disable close button during update
                const closeBtn = document.querySelector('#editProductModal .btn-close');
                if (closeBtn) closeBtn.disabled = true;
                
                // Disable cancel button during update
                const cancelBtn = document.querySelector('#editProductModal .btn-secondary');
                if (cancelBtn) cancelBtn.disabled = true;

                // Send request
                fetch(`/admin/api/products/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || `Error: ${response.status} ${response.statusText}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Reset button state
                    saveEditBtn.disabled = false;
                    saveEditBtn.innerHTML = 'Save Changes';
                    
                    // Re-enable close and cancel buttons
                    if (closeBtn) closeBtn.disabled = false;
                    if (cancelBtn) cancelBtn.disabled = false;
                    
                    if (data.success) {
                        console.log('Update successful, received data:', data);
                        
                        // Update the product in the products array
                        const index = products.findIndex(p => p.id == id);
                        if (index !== -1) {
                            products[index] = data.product;
                        }
                        
                        // Re-render the products
                        renderProducts(products);
                        
                        // Close the modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
                        modal.hide();
                        
                        // Show success notification
                        showNotification('Success', 'Product updated successfully!', 'success');
                    } else {
                        console.error('Update failed:', data.message);
                        showNotification('Error', data.message || 'Failed to update product', 'error');
                    }
                })
                .catch(error => {
                    // Reset button state
                    saveEditBtn.disabled = false;
                    saveEditBtn.innerHTML = 'Save Changes';
                    
                    // Re-enable close and cancel buttons
                    if (closeBtn) closeBtn.disabled = false;
                    if (cancelBtn) cancelBtn.disabled = false;
                    
                    console.error('Error:', error);
                    showNotification('Error', error.message || 'An error occurred while updating the product', 'error');
                });
            });
            
            // Size type change handlers
            document.getElementById('sizeType').addEventListener('change', function() {
                const clothingSizes = document.querySelector('#addProductModal .clothing-size');
                const numberSizes = document.querySelector('#addProductModal .number-size');
                const clothingSizeInfo = document.querySelector('#addProductModal .clothing-size-info');
                const numberSizeInfo = document.querySelector('#addProductModal .number-size-info');
                
                if (this.value === 'clothing') {
                    clothingSizes.style.display = '';
                    numberSizes.style.display = 'none';
                    clothingSizeInfo.style.display = '';
                    numberSizeInfo.style.display = 'none';
                } else {
                    clothingSizes.style.display = 'none';
                    numberSizes.style.display = '';
                    clothingSizeInfo.style.display = 'none';
                    numberSizeInfo.style.display = '';
                }
            });

            document.getElementById('editSizeType').addEventListener('change', function() {
                const clothingSizes = document.querySelector('#editProductModal .clothing-size');
                const numberSizes = document.querySelector('#editProductModal .number-size');
                const clothingSizeInfo = document.querySelector('#editProductModal .clothing-size-info');
                const numberSizeInfo = document.querySelector('#editProductModal .number-size-info');
                
                if (this.value === 'clothing') {
                    clothingSizes.style.display = '';
                    numberSizes.style.display = 'none';
                    clothingSizeInfo.style.display = '';
                    numberSizeInfo.style.display = 'none';
                } else {
                    clothingSizes.style.display = 'none';
                    numberSizes.style.display = '';
                    clothingSizeInfo.style.display = 'none';
                    numberSizeInfo.style.display = '';
                }
            });

            // Category change handlers
            document.getElementById('productCategory').addEventListener('change', function() {
                const sizeType = document.getElementById('sizeType');
                sizeType.value = this.value === 'pants' ? 'number' : 'letter';
                sizeType.dispatchEvent(new Event('change'));
            });

            document.getElementById('editProductCategory').addEventListener('change', function() {
                const sizeType = document.getElementById('editSizeType');
                sizeType.value = this.value === 'pants' ? 'number' : 'letter';
                sizeType.dispatchEvent(new Event('change'));
            });
        }
        
        // Setup product buttons
        function setupProductButtons() {
            // Edit product
            document.querySelectorAll('.edit-product-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productCard = this.closest('.product-card');
                    const id = productCard.dataset.id;
                    const product = products.find(p => p.id == id);
                    
                    if (product) {
                        populateEditForm(product);
                    }
                });
            });
            
            // Delete product
            document.querySelectorAll('.delete-product-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this product?')) {
                        const productCard = this.closest('.product-card');
                        const id = productCard.dataset.id;
                        deleteProduct(id);
                    }
                });
            });
        }
        
        // Delete a product
        function deleteProduct(id) {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch(`${API_ENDPOINTS.products}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    products = products.filter(p => p.id != id);
                    renderProducts(products);
                    
                    // Show success message
                    alert('Product deleted successfully!');
                } else {
                    console.error('Error deleting product:', data);
                    alert('Error deleting product. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error deleting product:', error);
                alert('Error deleting product. Please try again.');
            });
        }
        
        // Populate edit form
        function populateEditForm(product) {
            document.getElementById('editProductId').value = product.id;
            document.getElementById('editProductName').value = product.name;
            document.getElementById('editProductCategory').value = product.category_id || '';
            document.getElementById('editProductPrice').value = new Intl.NumberFormat('id-ID').format(product.price);
            document.getElementById('editProductDescription').value = product.description || '';

            // Reset all checkboxes and stock inputs
            document.querySelectorAll('#editProductModal .size-checkbox').forEach(checkbox => {
                checkbox.checked = false;
                const stockInput = checkbox.parentElement.querySelector('.size-stock');
                stockInput.disabled = true;
                stockInput.value = '';
            });

            // Set size type based on category
            const sizeType = product.category_id === 'pants' ? 'number' : 'clothing';
            document.getElementById('editSizeType').value = sizeType;
            
            // Show/hide appropriate size sections
            const clothingSizes = document.querySelector('#editProductModal .clothing-size');
            const numberSizes = document.querySelector('#editProductModal .number-size');
            if (sizeType === 'clothing') {
                clothingSizes.style.display = '';
                numberSizes.style.display = 'none';
            } else {
                clothingSizes.style.display = 'none';
                numberSizes.style.display = '';
            }

            // Debug size data
            console.log('Populating form with product:', product);
            
            // Set existing sizes and stock
            if (product.sizes && product.sizes.length > 0) {
                console.log('Processing sizes:', product.sizes);
                
                product.sizes.forEach(size => {
                    console.log('Processing size:', size);
                    
                    if (size.id) {
                        console.log(`Looking for checkbox with value ${size.id}`);
                        const checkbox = document.querySelector(`#editProductModal .size-checkbox[value="${size.id}"]`);
                        if (checkbox) {
                            checkbox.checked = true;
                            const stockInput = checkbox.parentElement.querySelector('.size-stock');
                            stockInput.disabled = false;
                            stockInput.value = size.pivot.stock;
                            console.log(`Set stock input value to ${size.pivot.stock} for size ${size.name}`);
                        } else {
                            console.warn(`Checkbox not found for size ID: ${size.id}`);
                        }
                    }
                });
            } else {
                console.warn('No sizes data available for product:', product.id);
            }

            // Display current image if available
            const currentImagePreview = document.getElementById('currentImagePreview');
            const currentImage = document.getElementById('currentImage');
            if (product.db_image_url) {
                currentImage.src = product.db_image_url;
                currentImagePreview.style.display = 'block';
            } else if (product.image_url) {
                currentImage.src = product.image_url;
                currentImagePreview.style.display = 'block';
            } else {
                currentImagePreview.style.display = 'none';
            }
        }
        
        // Format price input
        function formatPriceInput(input) {
            // Remove non-numeric characters
            let value = input.value.replace(/[^\d]/g, '');
            
            // Format with thousand separators (Indonesian format)
            if (value.length > 0) {
                value = new Intl.NumberFormat('id-ID').format(parseInt(value));
            }
            
            input.value = value;
        }
        
        // Add event listeners for price inputs
        document.getElementById('productPrice').addEventListener('input', function() {
            formatPriceInput(this);
        });
        
        document.getElementById('editProductPrice').addEventListener('input', function() {
            formatPriceInput(this);
        });
        
        // Toggle between letter and number sizes
        function toggleSizeInputs(containerId, sizeType, existingSizes = null) {
            const container = document.getElementById(containerId);
            const sizeInputsContainer = container.querySelector('.row');
            sizeInputsContainer.innerHTML = ''; // Clear existing inputs
            
            let sizes = [];
            if (sizeType === 'letter') {
                sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
            } else {
                sizes = Array.from({length: 7}, (_, i) => (i + 29).toString());
            }
            
            sizes.forEach(size => {
                const col = document.createElement('div');
                col.className = 'col-4';
                
                // Get existing stock value if available
                const stockValue = existingSizes && existingSizes[size] !== undefined ? 
                    existingSizes[size] : 0;
                
                col.innerHTML = `
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text">${size}</span>
                        <input type="number" class="form-control ${containerId === 'edit-sizeInputs' ? 'edit-' : ''}size-stock" 
                               data-size="${size}" min="0" value="${stockValue}">
                    </div>
                `;
                sizeInputsContainer.appendChild(col);
            });
        }
        
        // Show product details
        function showProductDetails(productId) {
            const product = products.find(p => p.id == productId);
            if (!product) return;

            // Set basic details
            document.getElementById('detailProductName').textContent = product.name;
            document.getElementById('detailProductCategory').textContent = product.category_name;
            document.getElementById('detailProductPrice').textContent = new Intl.NumberFormat('id-ID').format(product.price);
            document.getElementById('detailProductStatus').textContent = product.status;
            document.getElementById('detailProductDescription').textContent = product.description || 'No description available';

            // Set image
            const detailImage = document.getElementById('detailCurrentImage');
            if (product.db_image_url) {
                detailImage.src = product.db_image_url;
                document.getElementById('detailImagePreview').style.display = 'block';
            } else if (product.image_url) {
                detailImage.src = product.image_url;
                document.getElementById('detailImagePreview').style.display = 'block';
            } else {
                document.getElementById('detailImagePreview').style.display = 'none';
            }

            // Set size grid
            const sizeGrid = document.getElementById('detailSizeGrid');
            sizeGrid.innerHTML = '';
            
            if (product.sizes) {
                Object.values(product.sizes).forEach(sizeData => {
                    const sizeBox = document.createElement('div');
                    sizeBox.className = 'size-stock';
                    sizeBox.innerHTML = `
                        <span class="size-label">${sizeData.name}</span>
                        <span class="size-quantity">${sizeData.stock}</span>
                    `;
                    sizeGrid.appendChild(sizeBox);
                });
            }

            // Show modal
            const detailsModal = new bootstrap.Modal(document.getElementById('detailsProductModal'));
            detailsModal.show();
        }
        
        // Add this function for showing notifications
        function showNotification(title, message, type = 'success') {
            const toast = document.getElementById('notificationToast');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');
            
            // Remove existing classes
            toast.classList.remove('toast-success', 'toast-error');
            
            // Add appropriate class based on type
            toast.classList.add(`toast-${type}`);
            
            toastTitle.textContent = title;
            toastMessage.textContent = message;
            
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        }
        
        // Handle size type selection
        document.getElementById('sizeType').addEventListener('change', function() {
            // Hide all size groups
            document.querySelectorAll('.size-group').forEach(group => {
                group.style.display = 'none';
            });
            
            // Show selected size group
            const selectedType = this.value;
            document.querySelector(`.${selectedType}-size`).style.display = 'block';
        });

        // Handle checkbox changes
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const stockInput = this.parentElement.querySelector('.size-stock');
                stockInput.disabled = !this.checked;
                if (!this.checked) {
                    stockInput.value = 0;
                }
            });
        });

        // Function to get selected sizes and their stock
        function getSelectedSizes() {
            const sizes = [];
            document.querySelectorAll('.form-check-input:checked').forEach(checkbox => {
                const stockInput = checkbox.parentElement.querySelector('.size-stock');
                sizes.push({
                    id: parseInt(checkbox.value),
                    stock: parseInt(stockInput.value) || 0
                });
            });
            return sizes;
        }
        
        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Check if the product.image route is correctly defined
            console.log('Checking product.image route...');
            try {
                const testRoute = '{{ route("product.image", ["id" => 1]) }}';
                console.log('Product image route: ' + testRoute);
            } catch (e) {
                console.error('Error getting product.image route:', e);
            }
            
            init();
        });
    </script>
</body>
</html> 
