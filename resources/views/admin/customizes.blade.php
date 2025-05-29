<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Garmenique - Admin Customizes</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Admin Customizes">
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
            <li class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </li>
            <li class="menu-item active">
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
            <h1 class="page-title">Customizes</h1>
            
            <div class="user-section">
                <div class="user-info">
                    <h4 class="user-name">Garmenique</h4>
                    <p class="user-role">Admin</p>
                </div>
            </div>
        </div>
        
        <!-- Customizes Content -->
        <div class="customizes-section">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="section-title">Customize Your Website</h2>
                    <p class="text-muted">Customize the appearance and layout of your website.</p>
                    
                    <!-- Customizes Navigation Tabs -->
                    <ul class="nav nav-tabs mt-4" id="customizesTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="theme-tab" data-bs-toggle="tab" data-bs-target="#theme-settings" 
                                    type="button" role="tab" aria-controls="theme-settings" aria-selected="true">
                                <i class="fas fa-palette me-2"></i>Theme
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="homepage-tab" data-bs-toggle="tab" data-bs-target="#homepage-settings" 
                                    type="button" role="tab" aria-controls="homepage-settings" aria-selected="false">
                                <i class="fas fa-home me-2"></i>Homepage
                            </button>
                        </li>
                    </ul>
                    
                    <!-- Customizes Tab Content -->
                    <div class="tab-content p-3 border border-top-0 rounded-bottom" id="customizesTabContent">
                        <!-- Theme Settings -->
                        <div class="tab-pane fade show active" id="theme-settings" role="tabpanel" aria-labelledby="theme-tab">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="mb-3">Theme Settings</h4>
                                    <p class="text-muted">Customize your website's theme, colors, and fonts.</p>
                                    
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        This feature will be available soon.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Homepage Settings -->
                        <div class="tab-pane fade" id="homepage-settings" role="tabpanel" aria-labelledby="homepage-tab">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="mb-3">Homepage Settings</h4>
                                    <p class="text-muted">Customize your website's homepage layout and content.</p>
                                    
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        This feature will be available soon.
                                    </div>
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
    </script>
</body>
</html> 