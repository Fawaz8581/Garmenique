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
                                        <option value="letter">Letter Size (XS-XXL)</option>
                                        <option value="number">Number Size (29-35)</option>
                                    </select>
                                </div>
                                <div id="sizeInputs" class="size-inputs">
                                    <div class="row g-2">
                                        <!-- Letter Sizes -->
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">XS</span>
                                                <input type="number" class="form-control size-stock" data-size="XS" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">S</span>
                                                <input type="number" class="form-control size-stock" data-size="S" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">M</span>
                                                <input type="number" class="form-control size-stock" data-size="M" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">L</span>
                                                <input type="number" class="form-control size-stock" data-size="L" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">XL</span>
                                                <input type="number" class="form-control size-stock" data-size="XL" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">XXL</span>
                                                <input type="number" class="form-control size-stock" data-size="XXL" min="0" value="0">
                                            </div>
                                        </div>
                                        <!-- Number Sizes -->
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">29</span>
                                                <input type="number" class="form-control size-stock" data-size="29" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">30</span>
                                                <input type="number" class="form-control size-stock" data-size="30" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">31</span>
                                                <input type="number" class="form-control size-stock" data-size="31" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">32</span>
                                                <input type="number" class="form-control size-stock" data-size="32" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">33</span>
                                                <input type="number" class="form-control size-stock" data-size="33" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">34</span>
                                                <input type="number" class="form-control size-stock" data-size="34" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">35</span>
                                                <input type="number" class="form-control size-stock" data-size="35" min="0" value="0">
                                            </div>
                                        </div>
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
                                        <option value="letter">Letter Size (XS-XXL)</option>
                                        <option value="number">Number Size (29-35)</option>
                                    </select>
                                </div>
                                <div id="edit-sizeInputs" class="size-inputs">
                                    <div class="row g-2">
                                        <!-- Letter Sizes -->
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">XS</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="XS" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">S</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="S" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">M</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="M" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">L</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="L" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">XL</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="XL" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 letter-size">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">XXL</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="XXL" min="0" value="0">
                                            </div>
                                        </div>
                                        <!-- Number Sizes -->
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">29</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="29" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">30</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="30" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">31</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="31" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">32</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="32" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">33</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="33" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">34</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="34" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-4 number-size" style="display: none;">
                                            <div class="input-group input-group-sm mb-2">
                                                <span class="input-group-text">35</span>
                                                <input type="number" class="form-control edit-size-stock" data-size="35" min="0" value="0">
                                            </div>
                                        </div>
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
                    products.forEach(product => {
                            console.log(`Product ${product.id} sizes:`, product.sizes);
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
            const imageUrl = product.image_url
                ? product.image_url
                : 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80';
            
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
                formData.append('price', document.getElementById('productPrice').value);
                formData.append('description', document.getElementById('productDescription').value);
                
                // Handle sizes
                const sizes = {};
                const sizeInputs = document.querySelectorAll('#sizeInputs input[type="number"]:not([style*="display: none"])');
                sizeInputs.forEach(input => {
                    const stock = parseInt(input.value) || 0;
                    if (stock > 0) {
                        sizes[input.dataset.size] = stock;
                    }
                });
                formData.append('sizes', JSON.stringify(sizes));
            
                // Handle image
            const imageFile = document.getElementById('productImage').files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }
            
                // Send request
                fetch('/admin/api/products', {
                method: 'POST',
                headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
                .then(response => response.json())
            .then(data => {
                if (data.success) {
                        location.reload();
                } else {
                        alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding product');
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
                
                // Handle sizes with detailed logging
                const sizes = {};
                const sizeInputs = document.querySelectorAll('#edit-sizeInputs input[type="number"]:not([style*="display: none"])');
                console.log('Found size inputs:', sizeInputs.length);
                
                sizeInputs.forEach(input => {
                    const size = input.dataset.size;
                    const stock = parseInt(input.value) || 0;
                    sizes[size] = stock;
                    console.log(`Processing size ${size} with stock ${stock} from input:`, input);
                });
                
                console.log('Final sizes object:', sizes);
                formData.append('sizes', JSON.stringify(sizes));
                
                // Handle image
            const imageFile = document.getElementById('editProductImage').files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }
            
                // Send request with detailed response logging
                fetch(`/admin/api/products/${id}`, {
                    method: 'POST',
                headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
                .then(response => response.json())
            .then(data => {
                console.log('Server response:', data);
                if (data.success) {
                        // Log the received product data
                        console.log('Received updated product:', data.product);
                        console.log('Product sizes:', data.product.sizes);
                        
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
                    console.error('Error:', error);
                    showNotification('Error', 'An error occurred while updating the product', 'error');
                });
            });
            
            // Size type change handlers
            document.getElementById('sizeType').addEventListener('change', function() {
                const letterSizes = document.querySelectorAll('#sizeInputs .letter-size');
                const numberSizes = document.querySelectorAll('#sizeInputs .number-size');
                
                letterSizes.forEach(el => el.style.display = this.value === 'letter' ? '' : 'none');
                numberSizes.forEach(el => el.style.display = this.value === 'number' ? '' : 'none');
            });

            document.getElementById('editSizeType').addEventListener('change', function() {
                const letterSizes = document.querySelectorAll('#edit-sizeInputs .letter-size');
                const numberSizes = document.querySelectorAll('#edit-sizeInputs .number-size');
                
                letterSizes.forEach(el => el.style.display = this.value === 'letter' ? '' : 'none');
                numberSizes.forEach(el => el.style.display = this.value === 'number' ? '' : 'none');
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
            console.log('Populating form with product:', product);
            console.log('Product sizes:', product.sizes);
                    
                        document.getElementById('editProductId').value = product.id;
                        document.getElementById('editProductName').value = product.name;
                        document.getElementById('editProductCategory').value = product.category_id || '';
            document.getElementById('editProductPrice').value = new Intl.NumberFormat('id-ID').format(product.price);
                        document.getElementById('editProductDescription').value = product.description || '';
            
            // Set size type based on category
            const editSizeType = document.getElementById('editSizeType');
            editSizeType.value = product.category_id === 'pants' ? 'number' : 'letter';
            
            // Update size inputs visibility with existing sizes
            toggleSizeInputs('edit-sizeInputs', editSizeType.value, product.sizes);
                        
                        // Display current image if available
                        const currentImagePreview = document.getElementById('currentImagePreview');
                        const currentImage = document.getElementById('currentImage');
                        if (product.image_url) {
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

            console.log('Showing details for product:', product);
            console.log('Product sizes:', product.sizes);

            // Set basic details
            document.getElementById('detailProductName').textContent = product.name;
            document.getElementById('detailProductCategory').textContent = product.category_name;
            document.getElementById('detailProductPrice').textContent = new Intl.NumberFormat('id-ID').format(product.price);
            document.getElementById('detailProductStatus').textContent = product.status;
            document.getElementById('detailProductDescription').textContent = product.description || 'No description available';

            // Set image
            const detailImage = document.getElementById('detailCurrentImage');
            if (product.image_url) {
                detailImage.src = product.image_url;
                document.getElementById('detailImagePreview').style.display = 'block';
            } else {
                document.getElementById('detailImagePreview').style.display = 'none';
            }

            // Set size grid
            const sizeGrid = document.getElementById('detailSizeGrid');
            sizeGrid.innerHTML = '';
            
            const isNumberSize = product.category_id === 'pants';
            const sizes = isNumberSize ? 
                Array.from({length: 7}, (_, i) => (i + 29).toString()) : 
                ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

            sizes.forEach(size => {
                const stock = parseInt(product.sizes[size]) || 0;
                console.log(`Size ${size} stock:`, stock); // Debug log
                const sizeBox = document.createElement('div');
                sizeBox.className = 'size-stock';
                sizeBox.innerHTML = `
                    <span class="size-label">${size}</span>
                    <span class="size-quantity">${stock}</span>
                `;
                sizeGrid.appendChild(sizeBox);
            });

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
        
        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html> 
