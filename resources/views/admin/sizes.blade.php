<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Garmenique - Size Management</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Size Management">
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin Products CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/products.css') }}">

    <style>
        .size-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .size-card h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.5rem;
        }
        .size-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .size-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f8f9fa;
        }
        .size-name {
            margin-right: 15px;
            font-weight: 500;
        }
        .size-actions {
            display: flex;
            gap: 5px;
        }
        .action-btn {
            border: none;
            background: none;
            padding: 5px;
            cursor: pointer;
            color: #666;
            transition: color 0.2s;
        }
        .edit-btn:hover {
            color: #007bff;
        }
        .delete-btn:hover {
            color: #dc3545;
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
        
        .size-type-info {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
    </style>
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
            <div class="brand-text"><a href="/" style="text-decoration: none; color: inherit;">GARMENIQUE</a></div>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-box"></i>
                <span>Products</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-tags"></i>
                <span>Categories</span>
            </li>
            <li class="menu-item active">
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
            <h1 class="page-title">Size Management</h1>
            
            <div class="user-section">
                <div class="user-info">
                    <h4 class="user-name">Garmenique</h4>
                    <p class="user-role">Admin</p>
                </div>
            </div>
        </div>
        
        <!-- Size Management Section -->
        <div class="container-fluid mt-4">
            <div class="row">
                <!-- Number Sizes -->
                <div class="col-md-6">
                    <div class="size-card">
                        <h2>Number Sizes</h2>
                        <p class="size-type-info">Example: 30, 31, 32, 33, 34, 35</p>
                        <div class="size-list" id="numberSizeList">
                            <!-- Size items will be loaded here -->
                        </div>
                        <button class="btn btn-primary add-size-btn" onclick="showAddSizeModal('number')">
                            <i class="fas fa-plus me-1"></i> Add Number Size
                        </button>
                    </div>
                </div>

                <!-- Clothing Sizes -->
                <div class="col-md-6">
                    <div class="size-card">
                        <h2>Clothing Sizes</h2>
                        <p class="size-type-info">Example: XXS, XS, S, M, L, XL, XXL</p>
                        <div class="size-list" id="clothingSizeList">
                            <!-- Size items will be loaded here -->
                        </div>
                        <button class="btn btn-primary add-size-btn" onclick="showAddSizeModal('clothing')">
                            <i class="fas fa-plus me-1"></i> Add Clothing Size
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Size Modal -->
    <div class="modal fade" id="addSizeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addSizeForm">
                        <input type="hidden" id="sizeType">
                        <div class="mb-3">
                            <label for="sizeName" class="form-label">Size Name</label>
                            <input type="text" class="form-control" id="sizeName" required>
                            <small class="form-text text-muted" id="sizeNameHelp"></small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="addSize()">Add Size</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Size Modal -->
    <div class="modal fade" id="editSizeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editSizeForm">
                        <input type="hidden" id="editSizeId">
                        <input type="hidden" id="editSizeType">
                        <div class="mb-3">
                            <label for="editSizeName" class="form-label">Size Name</label>
                            <input type="text" class="form-control" id="editSizeName" required>
                            <small class="form-text text-muted" id="editSizeNameHelp"></small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="updateSize()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize modals
        const addSizeModal = new bootstrap.Modal(document.getElementById('addSizeModal'));
        const editSizeModal = new bootstrap.Modal(document.getElementById('editSizeModal'));

        // Validation functions
        function validateNumberInput(event) {
            // Allow only numbers
            const input = event.target;
            const value = input.value;
            
            // HTML5 number input should handle this, but adding as extra validation
            if (!/^\d*$/.test(value)) {
                // If non-numeric characters are entered, remove them
                input.value = value.replace(/[^\d]/g, '');
            }
        }
        
        function validateLetterInput(event) {
            // Allow only letters
            const input = event.target;
            const value = input.value;
            
            if (!/^[A-Za-z]*$/.test(value)) {
                // If non-letter characters are entered, remove them
                input.value = value.replace(/[^A-Za-z]/g, '');
            }
        }

        // Load sizes on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadSizes();
            setupEventListeners();
        });

        // Setup event listeners
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
                });
            });
        }

        // Load sizes from API
        function loadSizes() {
            fetch('/admin/api/sizes')
                .then(response => response.json())
                .then(sizes => {
                    const numberSizes = sizes.filter(size => size.type === 'number');
                    const clothingSizes = sizes.filter(size => size.type === 'clothing');

                    renderSizes('numberSizeList', numberSizes);
                    renderSizes('clothingSizeList', clothingSizes);
                })
                .catch(error => console.error('Error loading sizes:', error));
        }

        // Render sizes in the list
        function renderSizes(containerId, sizes) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';

            sizes.forEach(size => {
                const sizeItem = document.createElement('div');
                sizeItem.className = 'size-item';
                sizeItem.innerHTML = `
                    <span class="size-name">${size.name}</span>
                    <div class="size-actions">
                        <button class="action-btn edit-btn" onclick="showEditSizeModal(${size.id}, '${size.type}', '${size.name}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn delete-btn" onclick="deleteSize(${size.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                container.appendChild(sizeItem);
            });
        }

        // Show add size modal
        function showAddSizeModal(type) {
            document.getElementById('sizeType').value = type;
            document.getElementById('sizeName').value = '';
            
            const sizeNameInput = document.getElementById('sizeName');
            const sizeNameHelp = document.getElementById('sizeNameHelp');
            
            if (type === 'number') {
                sizeNameHelp.textContent = 'Enter a number size (e.g., 30, 31, 32)';
                sizeNameInput.setAttribute('pattern', '[0-9]+');
                sizeNameInput.setAttribute('title', 'Please enter numbers only');
                sizeNameInput.setAttribute('type', 'number');
                sizeNameInput.setAttribute('min', '1');
                
                // Remove any existing event listeners
                sizeNameInput.removeEventListener('input', validateNumberInput);
                sizeNameInput.removeEventListener('input', validateLetterInput);
                
                // Add event listener for number validation
                sizeNameInput.addEventListener('input', validateNumberInput);
            } else {
                sizeNameHelp.textContent = 'Enter a clothing size (e.g., XS, S, M)';
                sizeNameInput.setAttribute('pattern', '[A-Za-z]+');
                sizeNameInput.setAttribute('title', 'Please enter letters only');
                sizeNameInput.setAttribute('type', 'text');
                
                // Remove any existing event listeners
                sizeNameInput.removeEventListener('input', validateNumberInput);
                sizeNameInput.removeEventListener('input', validateLetterInput);
                
                // Add event listener for letter validation
                sizeNameInput.addEventListener('input', validateLetterInput);
            }
            
            addSizeModal.show();
        }

        // Show edit size modal
        function showEditSizeModal(id, type, name) {
            document.getElementById('editSizeId').value = id;
            document.getElementById('editSizeType').value = type;
            document.getElementById('editSizeName').value = name;
            
            const editSizeNameInput = document.getElementById('editSizeName');
            const editSizeNameHelp = document.getElementById('editSizeNameHelp');
            
            if (type === 'number') {
                editSizeNameHelp.textContent = 'Enter a number size (e.g., 30, 31, 32)';
                editSizeNameInput.setAttribute('pattern', '[0-9]+');
                editSizeNameInput.setAttribute('title', 'Please enter numbers only');
                editSizeNameInput.setAttribute('type', 'number');
                editSizeNameInput.setAttribute('min', '1');
                
                // Remove any existing event listeners
                editSizeNameInput.removeEventListener('input', validateNumberInput);
                editSizeNameInput.removeEventListener('input', validateLetterInput);
                
                // Add event listener for number validation
                editSizeNameInput.addEventListener('input', validateNumberInput);
            } else {
                editSizeNameHelp.textContent = 'Enter a clothing size (e.g., XS, S, M)';
                editSizeNameInput.setAttribute('pattern', '[A-Za-z]+');
                editSizeNameInput.setAttribute('title', 'Please enter letters only');
                editSizeNameInput.setAttribute('type', 'text');
                
                // Remove any existing event listeners
                editSizeNameInput.removeEventListener('input', validateNumberInput);
                editSizeNameInput.removeEventListener('input', validateLetterInput);
                
                // Add event listener for letter validation
                editSizeNameInput.addEventListener('input', validateLetterInput);
            }
            
            editSizeModal.show();
        }

        // Add new size
        function addSize() {
            const type = document.getElementById('sizeType').value;
            const name = document.getElementById('sizeName').value;

            if (!name) {
                alert('Please enter a size name');
                return;
            }

            // Validate number sizes (only numbers)
            if (type === 'number' && !/^\d+$/.test(name)) {
                alert('Number sizes must contain only numbers');
                return;
            }

            // Validate clothing sizes (only letters)
            if (type === 'clothing' && !/^[A-Za-z]+$/.test(name)) {
                alert('Clothing sizes must contain only letters');
                return;
            }

            fetch('/admin/api/sizes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ type, name })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadSizes();
                    addSizeModal.hide();
                } else {
                    alert(data.message || 'Error adding size');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding size');
            });
        }

        // Update size
        function updateSize() {
            const id = document.getElementById('editSizeId').value;
            const type = document.getElementById('editSizeType').value;
            const name = document.getElementById('editSizeName').value;

            if (!name) {
                alert('Please enter a size name');
                return;
            }

            // Validate number sizes (only numbers)
            if (type === 'number' && !/^\d+$/.test(name)) {
                alert('Number sizes must contain only numbers');
                return;
            }

            // Validate clothing sizes (only letters)
            if (type === 'clothing' && !/^[A-Za-z]+$/.test(name)) {
                alert('Clothing sizes must contain only letters');
                return;
            }

            fetch(`/admin/api/sizes/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ type, name })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadSizes();
                    editSizeModal.hide();
                } else {
                    alert(data.message || 'Error updating size');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating size');
            });
        }

        // Delete size
        function deleteSize(id) {
            if (confirm('Are you sure you want to delete this size?')) {
                fetch(`/admin/api/sizes/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadSizes();
                    } else {
                        alert(data.message || 'Error deleting size');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting size');
                });
            }
        }
    </script>
</body>
</html> 