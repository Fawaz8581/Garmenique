<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Garmenique - Categories Management</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Categories Management">
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
                <i class="fas fa-box"></i>
                <span>Products</span>
            </li>
            <li class="menu-item active">
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
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h1 class="page-title">Categories</h1>
            
            <div class="user-section">
                <div class="user-info">
                    <h4 class="user-name">Garmenique</h4>
                    <p class="user-role">Admin</p>
                </div>
            </div>
        </div>
        
        <!-- Categories Section -->
        <div class="categories-section">
            <div class="filter-section">
                <div class="search-box">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search categories..." id="categorySearch">
                    </div>
                </div>
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Products Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                        <!-- Categories will be loaded here dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoryDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="categoryDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="addCategoryBtn">Add Category</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        <input type="hidden" id="editCategoryId">
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editCategoryName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategoryDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editCategoryDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCategoryBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // API endpoints
        const API_ENDPOINTS = {
            categories: '/admin/api/categories'
        };

        // DOM elements
        const categoriesTableBody = document.getElementById('categoriesTableBody');
        const categorySearch = document.getElementById('categorySearch');
        const addCategoryBtn = document.getElementById('addCategoryBtn');
        const saveCategoryBtn = document.getElementById('saveCategoryBtn');
        const dashboardLink = document.getElementById('dashboard-link');

        // Global variables
        let categories = [];

        // Initialize page
        function init() {
            // Set up CSRF token for AJAX requests
            const token = document.querySelector('meta[name="csrf-token"]').content;
            
            // Get categories from API
            fetchCategories();
            
            // Set up event listeners
            setupEventListeners();
        }

        // Fetch categories from API
        function fetchCategories() {
            fetch(API_ENDPOINTS.categories)
                .then(response => response.json())
                .then(data => {
                    categories = data;
                    renderCategories(categories);
                })
                .catch(error => {
                    console.error('Error fetching categories:', error);
                    alert('Error loading categories. Please try again.');
                });
        }

        // Render categories
        function renderCategories(categoriesArray) {
            categoriesTableBody.innerHTML = '';
            
            categoriesArray.forEach(category => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${category.id}</td>
                    <td>${category.name}</td>
                    <td>${category.description || '-'}</td>
                    <td>${category.products_count || 0}</td>
                    <td>
                        <button class="btn btn-sm btn-primary edit-category-btn" data-id="${category.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-category-btn" data-id="${category.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                categoriesTableBody.appendChild(row);
            });

            // Setup category buttons
            setupCategoryButtons();
        }

        // Set up event listeners
        function setupEventListeners() {
            // Sidebar toggle for mobile
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('active');
            });

            // Menu items click
            document.querySelectorAll('.menu-item').forEach(item => {
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
                    }
                    
                    // Close sidebar on mobile after navigation
                    if (window.innerWidth < 992) {
                        document.getElementById('sidebar').classList.remove('active');
                    }
                });
            });

            // Search categories
            categorySearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredCategories = categories.filter(category => 
                    category.name.toLowerCase().includes(searchTerm) || 
                    (category.description && category.description.toLowerCase().includes(searchTerm))
                );
                renderCategories(filteredCategories);
            });

            // Add category
            addCategoryBtn.addEventListener('click', function() {
                const name = document.getElementById('categoryName').value;
                const description = document.getElementById('categoryDescription').value;

                if (!name) {
                    alert('Please enter a category name');
                    return;
                }

                fetch(API_ENDPOINTS.categories, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ name, description })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchCategories();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
                        modal.hide();
                        document.getElementById('categoryName').value = '';
                        document.getElementById('categoryDescription').value = '';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding category');
                });
            });

            // Save edited category
            saveCategoryBtn.addEventListener('click', function() {
                const id = document.getElementById('editCategoryId').value;
                const name = document.getElementById('editCategoryName').value;
                const description = document.getElementById('editCategoryDescription').value;

                if (!name) {
                    alert('Please enter a category name');
                    return;
                }

                fetch(`${API_ENDPOINTS.categories}/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ name, description })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchCategories();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editCategoryModal'));
                        modal.hide();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating category');
                });
            });
        }

        // Setup category buttons
        function setupCategoryButtons() {
            // Edit category
            document.querySelectorAll('.edit-category-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const category = categories.find(c => c.id == id);
                    
                    if (category) {
                        document.getElementById('editCategoryId').value = category.id;
                        document.getElementById('editCategoryName').value = category.name;
                        document.getElementById('editCategoryDescription').value = category.description || '';
                        
                        const modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
                        modal.show();
                    }
                });
            });

            // Delete category
            document.querySelectorAll('.delete-category-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this category?')) {
                        const id = this.dataset.id;
                        
                        fetch(`${API_ENDPOINTS.categories}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                fetchCategories();
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting category');
                        });
                    }
                });
            });
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html> 