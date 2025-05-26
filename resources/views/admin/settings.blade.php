<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Garmenique - Admin Settings</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Admin Settings">
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
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
            <li class="menu-item">
                <i class="fas fa-ruler"></i>
                <span>Sizes</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-envelope"></i>
                <span>Messages</span>
            </li>
            <li class="menu-item active">
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
            <h1 class="page-title">Settings</h1>
            
            <div class="user-section">
                <div class="user-info">
                    <h4 class="user-name">Garmenique</h4>
                    <p class="user-role">Admin</p>
                </div>
            </div>
        </div>
        
        <!-- Settings Content -->
        <div class="settings-section">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="section-title">Admin Settings</h2>
                    <p class="text-muted">Configure your admin dashboard settings here.</p>
                    
                    <!-- Settings Navigation Tabs -->
                    <ul class="nav nav-tabs mt-4" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="store-tab" data-bs-toggle="tab" data-bs-target="#store-settings" 
                                    type="button" role="tab" aria-controls="store-settings" aria-selected="true">
                                <i class="fas fa-store me-2"></i>Store Settings
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user-settings" 
                                    type="button" role="tab" aria-controls="user-settings" aria-selected="false">
                                <i class="fas fa-users me-2"></i>User Settings
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system-settings" 
                                    type="button" role="tab" aria-controls="system-settings" aria-selected="false">
                                <i class="fas fa-server me-2"></i>System Settings
                            </button>
                        </li>
                    </ul>
                    
                    <!-- Settings Tab Content -->
                    <div class="tab-content p-3 border border-top-0 rounded-bottom" id="settingsTabContent">
                        <!-- Store Settings -->
                        <div class="tab-pane fade show active" id="store-settings" role="tabpanel" aria-labelledby="store-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="storeName" class="form-label">Store Name</label>
                                        <input type="text" class="form-control" id="storeName" value="Garmenique">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="storeEmail" class="form-label">Store Email</label>
                                        <input type="email" class="form-control" id="storeEmail" value="info@garmenique.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="currencySymbol" class="form-label">Currency Symbol</label>
                                        <input type="text" class="form-control" id="currencySymbol" value="IDR">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="taxRate" class="form-label">Tax Rate (%)</label>
                                        <input type="number" class="form-control" id="taxRate" value="10">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="button" class="btn btn-primary">Save Store Settings</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Settings -->
                        <div class="tab-pane fade" id="user-settings" role="tabpanel" aria-labelledby="user-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="adminEmail" class="form-label">Admin Email</label>
                                        <input type="email" class="form-control" id="adminEmail" value="admin@garmenique.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="passwordReset" class="form-label">Password Reset</label>
                                        <button type="button" class="btn btn-outline-danger form-control">Change Password</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="notificationSettings" class="form-label">Notification Settings</label>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="newOrderNotif" checked>
                                            <label class="form-check-label" for="newOrderNotif">
                                                Receive email notifications for new orders
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="lowStockNotif" checked>
                                            <label class="form-check-label" for="lowStockNotif">
                                                Receive email notifications for low stock items
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="button" class="btn btn-primary">Save User Settings</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- System Settings -->
                        <div class="tab-pane fade" id="system-settings" role="tabpanel" aria-labelledby="system-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="maintenanceMode" class="form-label">Maintenance Mode</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="maintenanceMode">
                                            <label class="form-check-label" for="maintenanceMode">Enable Maintenance Mode</label>
                                        </div>
                                        <small class="form-text text-muted">When enabled, your store will be inaccessible to regular users.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cacheSettings" class="form-label">Cache Settings</label>
                                        <button type="button" class="btn btn-outline-secondary form-control">Clear Cache</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="logLevel" class="form-label">Log Level</label>
                                        <select class="form-select" id="logLevel">
                                            <option>Debug</option>
                                            <option selected>Info</option>
                                            <option>Warning</option>
                                            <option>Error</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="button" class="btn btn-primary">Save System Settings</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
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
    </script>
</body>
</html> 