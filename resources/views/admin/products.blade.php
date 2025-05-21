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
                                    <option value="tshirt">T-shirt</option>
                                    <option value="shirt">Shirt</option>
                                    <option value="jackets">Jackets</option>
                                    <option value="pants">Pants</option>
                                    <option value="hoodie">Hoodie</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productPrice" class="form-label">Price (IDR)</label>
                                <input type="text" class="form-control" id="productPrice" required>
                            </div>
                            <div class="col-md-6">
                                <label for="productStock" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" id="productStock" min="0">
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
                                    <option value="tshirt">T-shirt</option>
                                    <option value="shirt">Shirt</option>
                                    <option value="jackets">Jackets</option>
                                    <option value="pants">Pants</option>
                                    <option value="hoodie">Hoodie</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editProductPrice" class="form-label">Price (IDR)</label>
                                <input type="text" class="form-control" id="editProductPrice" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editProductStock" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" id="editProductStock" min="0">
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
        
        // Global variables
        let products = [];
        let categories = [];
        
        // Initialize page
        function init() {
            // Set up CSRF token for AJAX requests
            const token = document.querySelector('meta[name="csrf-token"]').content;
            
            // Get products from API
            fetchProducts();
            
            // Set up event listeners
            setupEventListeners();
        }
        
        // Fetch products from API
        function fetchProducts() {
            fetch(API_ENDPOINTS.products)
                .then(response => response.json())
                .then(data => {
                    products = data;
                    
                    // Add category_name property to products for display
                    products.forEach(product => {
                        if (product.category_id) {
                            const categoryMap = {
                                "tshirt": "T-shirt",
                                "shirt": "Shirt",
                                "jackets": "Jackets",
                                "pants": "Pants",
                                "hoodie": "Hoodie"
                            };
                            product.category_name = categoryMap[product.category_id] || 'Uncategorized';
                        } else {
                            product.category_name = 'Uncategorized';
                        }
                    });
                    
                    renderProducts(products);
                    loadingIndicator.classList.add('d-none');
                    
                    if (products.length === 0) {
                        noProductsMessage.classList.remove('d-none');
                    } else {
                        noProductsMessage.classList.add('d-none');
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
            
            if (product.stock > 20) {
                statusClass = 'stock-in';
                statusText = 'In Stock';
            } else if (product.stock > 0) {
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
            
            console.log('Product image URL:', imageUrl); // Debug log to verify image URL
            
            col.innerHTML = `
                <div class="product-card" data-id="${product.id}">
                    <div class="product-image">
                        <img src="${imageUrl}" alt="${product.name}">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">${product.name}</h3>
                        <p class="product-category">${categoryName}</p>
                        <p class="product-price">IDR ${parseFloat(product.price).toLocaleString('id-ID')}</p>
                        <p class="product-stock">
                            <span class="stock-badge ${statusClass}">${product.status || statusText}</span>
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
                    (product.category_name && product.category_name.toLowerCase().includes(searchTerm))
                );
                renderProducts(filteredProducts);
            });
            
            // Add product
            addProductBtn.addEventListener('click', function() {
                const name = document.getElementById('productName').value;
                const category_id = document.getElementById('productCategory').value;
                const price = parseInt(document.getElementById('productPrice').value.replace(/\./g, ''));
                const stock = parseInt(document.getElementById('productStock').value) || 0;
                const description = document.getElementById('productDescription').value;
                
                if (!name || !category_id || isNaN(price)) {
                    alert('Please fill in all required fields');
                    return;
                }
                
                const productData = {
                    name,
                    category_id: category_id,
                    price,
                    stock,
                    description
                };
                
                createProduct(productData);
            });
            
            // Save edited product
            saveEditBtn.addEventListener('click', function() {
                const id = document.getElementById('editProductId').value;
                const name = document.getElementById('editProductName').value;
                const category_id = document.getElementById('editProductCategory').value;
                const price = parseInt(document.getElementById('editProductPrice').value.replace(/\./g, ''));
                const stock = parseInt(document.getElementById('editProductStock').value) || 0;
                const description = document.getElementById('editProductDescription').value;
                
                if (!name || !category_id || isNaN(price)) {
                    alert('Please fill in all required fields');
                    return;
                }
                
                const productData = {
                    name,
                    category_id: category_id,
                    price,
                    stock,
                    description
                };
                
                updateProduct(id, productData);
            });
        }
        
        // Create a new product
        function createProduct(productData) {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const formData = new FormData();
            
            // Append all product data to FormData
            Object.keys(productData).forEach(key => {
                if (key !== 'image') {
                    formData.append(key, productData[key]);
                }
            });
            
            // Append the image file if exists
            const imageFile = document.getElementById('productImage').files[0];
            if (imageFile) {
                formData.append('image', imageFile);
                console.log('Image file appended:', imageFile.name, imageFile.type, imageFile.size);
            }
            
            fetch(API_ENDPOINTS.products, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    console.error('Server response not OK:', response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Server response:', data);
                if (data.success) {
                    products.push(data.product);
                    renderProducts(products);
                    
                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
                    modal.hide();
                    
                    // Reset form
                    document.getElementById('addProductForm').reset();
                    
                    // Show success message
                    alert('Product added successfully!');
                } else {
                    console.error('Error creating product:', data);
                    alert('Error adding product: ' + (data.message || 'Please try again.'));
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Error adding product. Please try again.');
            });
        }
        
        // Update a product
        function updateProduct(id, productData) {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const formData = new FormData();
            
            // Append all product data to FormData
            Object.keys(productData).forEach(key => {
                if (key !== 'image') {
                    formData.append(key, productData[key]);
                }
            });
            
            // Append the image file if exists
            const imageFile = document.getElementById('editProductImage').files[0];
            if (imageFile) {
                formData.append('image', imageFile);
                console.log('Edit image file appended:', imageFile.name, imageFile.type, imageFile.size);
            }
            
            // Append the _method field to simulate PUT request
            formData.append('_method', 'PUT');
            
            fetch(`${API_ENDPOINTS.products}/${id}`, {
                method: 'POST', // Using POST with _method for file uploads
                headers: {
                    'X-CSRF-TOKEN': token
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    console.error('Server response not OK:', response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Server response:', data);
                if (data.success) {
                    const index = products.findIndex(p => p.id == id);
                    if (index !== -1) {
                        products[index] = data.product;
                    }
                    renderProducts(products);
                    
                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
                    modal.hide();
                    
                    // Show success message
                    alert('Product updated successfully!');
                } else {
                    console.error('Error updating product:', data);
                    alert('Error updating product: ' + (data.message || 'Please try again.'));
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Error updating product. Please try again.');
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
        
        // Setup product buttons
        function setupProductButtons() {
            // Edit product
            document.querySelectorAll('.edit-product-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productCard = this.closest('.product-card');
                    const id = productCard.dataset.id;
                    const product = products.find(p => p.id == id);
                    
                    if (product) {
                        document.getElementById('editProductId').value = product.id;
                        document.getElementById('editProductName').value = product.name;
                        document.getElementById('editProductCategory').value = product.category_id || '';
                        document.getElementById('editProductPrice').value = product.price;
                        document.getElementById('editProductStock').value = product.stock;
                        document.getElementById('editProductDescription').value = product.description || '';
                        
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
        
        // Format price input
        function formatPriceInput(input) {
            // Remove non-numeric characters
            let value = input.value.replace(/[^\d]/g, '');
            
            // Format with thousand separators
            if (value.length > 0) {
                value = parseInt(value).toLocaleString('id-ID');
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
        
        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html> 
