<!DOCTYPE html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Garmenique - Admin Dashboard</title>    <meta name="keyword" content="Garmenique">    <meta name="description" content="Garmenique - Admin Dashboard">    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">    <!-- Bootstrap CSS -->    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">        <!-- Google Fonts -->    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">        <!-- Font Awesome -->    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">        <!-- Admin Dashboard CSS -->    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}"
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
            <li class="menu-item active">
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
            <h1 class="page-title">Dashboard</h1>
            
            <div class="user-section">
                <div class="user-info">
                    <h4 class="user-name">Garmenique</h4>
                    <p class="user-role">Admin</p>
                </div>
            </div>
        </div>
        
        <!-- Date Selector -->
        <div class="date-selector">
            <input type="date" class="date-input" id="selectedDate">
        </div>
        
        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card">
                        <div class="d-flex align-items-start">
                            <div>
                                <div class="card-icon icon-sales">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h3 class="card-title">Total Sales</h3>
                                <h2 class="card-value">$25,024</h2>
                                <p class="card-period">Last 24 Hours</p>
                            </div>
                            <div class="progress-container">
                                <svg class="progress-circle">
                                    <circle cx="40" cy="40" r="35" fill="none" stroke="#eee" stroke-width="5"></circle>
                                    <circle cx="40" cy="40" r="35" fill="none" stroke="#2a5298" stroke-width="5" 
                                            stroke-dasharray="220" stroke-dashoffset="44" transform="rotate(-90 40 40)"></circle>
                                </svg>
                                <div class="progress-percentage">80%</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card">
                        <div class="d-flex align-items-start">
                            <div>
                                <div class="card-icon icon-orders">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <h3 class="card-title">Total Orders</h3>
                                <h2 class="card-value">382</h2>
                                <p class="card-period">Last 24 Hours</p>
                            </div>
                            <div class="progress-container">
                                <svg class="progress-circle">
                                    <circle cx="40" cy="40" r="35" fill="none" stroke="#eee" stroke-width="5"></circle>
                                    <circle cx="40" cy="40" r="35" fill="none" stroke="#2a5298" stroke-width="5" 
                                            stroke-dasharray="220" stroke-dashoffset="77" transform="rotate(-90 40 40)"></circle>
                                </svg>
                                <div class="progress-percentage">65%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Recent Orders -->
            <div class="col-lg-12 mb-4">
                <div class="updates-section">
                    <h2 class="section-title">Recent Orders</h2>
                    <div class="orders-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Number</th>
                                    <th>Payments</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Classic T-Shirt</td>
                                    <td>GA-1001</td>
                                    <td>$49.99</td>
                                    <td><span class="status-badge status-delivered">Delivered</span></td>
                                    <td><button class="action-btn">Details</button></td>
                                </tr>
                                <tr>
                                    <td>Designer Jeans</td>
                                    <td>GA-1002</td>
                                    <td>$89.99</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td><button class="action-btn">Details</button></td>
                                </tr>
                                <tr>
                                    <td>Summer Dress</td>
                                    <td>GA-1003</td>
                                    <td>$65.50</td>
                                    <td><span class="status-badge status-processing">Processing</span></td>
                                    <td><button class="action-btn">Details</button></td>
                                </tr>
                                <tr>
                                    <td>Winter Jacket</td>
                                    <td>GA-1004</td>
                                    <td>$125.00</td>
                                    <td><span class="status-badge status-shipped">Shipped</span></td>
                                    <td><button class="action-btn">Details</button></td>
                                </tr>
                                <tr>
                                    <td>Silk Scarf</td>
                                    <td>GA-1005</td>
                                    <td>$35.75</td>
                                    <td><span class="status-badge status-delivered">Delivered</span></td>
                                    <td><button class="action-btn">Details</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Set current date in the date selector
        document.getElementById('selectedDate').valueAsDate = new Date();
        
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