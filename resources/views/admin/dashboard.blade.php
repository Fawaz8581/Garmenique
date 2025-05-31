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
            <div class="brand-text"><a href="/" style="text-decoration: none; color: inherit;">GARMENIQUE</a></div>
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
            <h1 class="page-title">Dashboard</h1>
            
            <div class="user-section">
                <div class="user-info">
                    <h4 class="user-name">Garmenique</h4>
                    <p class="user-role">Admin</p>
                </div>
            </div>
        </div>
        
        <!-- Date Selector -->
        <div class="date-selector d-flex align-items-center">
            <div class="me-3">
                <label for="selectedDate" class="form-label mb-0 me-2">Date:</label>
                <input type="date" class="date-input" id="selectedDate" value="{{ $selectedDate->format('Y-m-d') }}">
            </div>
            <div class="me-3">
                @if(!$showAllDates)
                <button id="allDatesBtn" class="btn btn-primary">
                    <i class="fas fa-calendar-alt me-1"></i> All Dates
                </button>
                @else
                <button id="filterByDateBtn" class="btn btn-outline-primary">
                    <i class="fas fa-filter me-1"></i> Filter by Date
                </button>
                @endif
            </div>
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
                                <h2 class="card-value">IDR {{ number_format($totalSales, 0, ',', '.') }}</h2>
                                <p class="card-period">Last 24 Hours</p>
                            </div>
                            <div class="progress-container">
                                <svg class="progress-circle">
                                    <circle cx="40" cy="40" r="35" fill="none" stroke="#eee" stroke-width="5"></circle>
                                    <circle cx="40" cy="40" r="35" fill="none" stroke="#2a5298" stroke-width="5" 
                                            stroke-dasharray="220" stroke-dashoffset="{{ 220 - ($salesPercentage * 2.2) }}" transform="rotate(-90 40 40)"></circle>
                                </svg>
                                <div class="progress-percentage">{{ $salesPercentage }}%</div>
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
                                <h2 class="card-value">{{ $totalOrders }}</h2>
                                <p class="card-period">Last 24 Hours</p>
                            </div>
                            <div class="progress-container">
                                <svg class="progress-circle">
                                    <circle cx="40" cy="40" r="35" fill="none" stroke="#eee" stroke-width="5"></circle>
                                    <circle cx="40" cy="40" r="35" fill="none" stroke="#2a5298" stroke-width="5" 
                                            stroke-dasharray="220" stroke-dashoffset="{{ 220 - ($ordersPercentage * 2.2) }}" transform="rotate(-90 40 40)"></circle>
                                </svg>
                                <div class="progress-percentage">{{ $ordersPercentage }}%</div>
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
                    
                    <!-- Search and Filter Bar -->
                    <div class="search-filter-bar mb-3">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" id="orderSearchInput" placeholder="Search by Product Name, Product Number or Shipping Method...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" id="orderStatusFilter">
                                    <option value="">All Statuses</option>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="packing">Packing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="completed">Completed</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="orders-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Number</th>
                                    <th>Shipping Method</th>
                                    <th>Payments</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>{{ $order['product_name'] }}</td>
                                    <td>{{ $order['product_number'] }}</td>
                                    <td>
                                        @php
                                            $expedition = isset($order['shipping_info']['expedition']) ? $order['shipping_info']['expedition'] : 'N/A';
                                            $expeditionName = 'N/A';
                                            
                                            if ($expedition === 'jne') {
                                                $expeditionName = 'JNE';
                                            } elseif ($expedition === 'jnt') {
                                                $expeditionName = 'J&T Express';
                                            } elseif ($expedition === 'sicepat') {
                                                $expeditionName = 'SiCepat';
                                            } elseif ($expedition === 'pos') {
                                                $expeditionName = 'POS Indonesia';
                                            } elseif ($expedition === 'tiki') {
                                                $expeditionName = 'TIKI';
                                            }
                                        @endphp
                                        {{ $expeditionName }}
                                    </td>
                                    <td>IDR {{ number_format($order['total'], 0, ',', '.') }}</td>
                                    <td><span class="status-badge status-{{ strtolower($order['status']) }}">{{ ucfirst($order['status']) }}</span></td>
                                    <td class="action-buttons">
                                        <button class="action-btn details-btn" data-order-id="{{ $order['id'] }}">Details</button>
                                        <button class="action-btn edit-btn" data-order-id="{{ $order['id'] }}" 
                                                data-bs-toggle="modal" data-bs-target="#editOrderModal" 
                                                data-order-number="{{ $order['order_number'] }}"
                                                data-order-status="{{ $order['status'] }}">Edit</button>
                                        @if(in_array(strtolower($order['status']), ['success', 'confirmed', 'packing', 'shipped', 'delivered', 'completed']))
                                            <a href="{{ route('admin.invoice.download', ['order_id' => $order['id']]) }}" class="action-btn invoice-btn" target="_blank" style="text-decoration: none;">Invoice</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No orders found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            <div class="custom-pagination">
                                @if ($recentOrdersPaginated->hasPages())
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($recentOrdersPaginated->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $recentOrdersPaginated->appends(request()->except('page'))->previousPageUrl() }}" rel="prev">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $urlParams = request()->except('page');
                                        @endphp
                                        @foreach ($recentOrdersPaginated->getUrlRange(1, $recentOrdersPaginated->lastPage()) as $page => $url)
                                            @php
                                                $urlWithParams = Request::url() . '?' . http_build_query(array_merge($urlParams, ['page' => $page]));
                                            @endphp
                                            @if ($page == $recentOrdersPaginated->currentPage())
                                                <li class="page-item active" aria-current="page">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $urlWithParams }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($recentOrdersPaginated->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $recentOrdersPaginated->appends(request()->except('page'))->nextPageUrl() }}" rel="next">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                            </li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Order Modal -->
    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOrderModalLabel">Edit Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editOrderForm">
                        <input type="hidden" id="editOrderId" name="order_id">
                        <div class="mb-3">
                            <label for="orderNumber" class="form-label">Order Number</label>
                            <input type="text" class="form-control" id="orderNumber" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="orderStatus" class="form-label">Status</label>
                            <select class="form-select" id="orderStatus" name="status">
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="packing">Packing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="orderNote" class="form-label">Note to Customer</label>
                            <textarea class="form-control" id="orderNote" name="note" rows="3" placeholder="Add a note that will be visible to the customer"></textarea>
                            <small class="text-muted">This note will be visible in the customer's order history.</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveOrderStatus">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="order-info-section mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Order Number:</strong> <span id="detailOrderNumber"></span></p>
                                <p><strong>Order Date:</strong> <span id="detailOrderDate"></span></p>
                                <p><strong>Status:</strong> <span id="detailOrderStatus"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Customer Name:</strong> <span id="detailCustomerName"></span></p>
                                <p><strong>Email:</strong> <span id="detailCustomerEmail"></span></p>
                                <p><strong>Phone:</strong> <span id="detailCustomerPhone"></span></p>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="border-bottom pb-2 mb-3">Products</h6>
                    <div id="orderProductsList" class="mb-4">
                        <!-- Products will be inserted here dynamically -->
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Shipping Address</h6>
                            <p id="detailShippingAddress"></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Order Summary</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="detailSubtotal"></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span id="detailShipping"></span>
                            </div>
                            <div class="d-flex justify-content-between font-weight-bold">
                                <strong>Total:</strong>
                                <strong id="detailTotal"></strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span id="invoiceButtonContainer">
                        <!-- Tombol invoice akan ditampilkan disini melalui JavaScript -->
                    </span>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize date selector and filters on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial date value if not already set
            if (!document.getElementById('selectedDate').value) {
                document.getElementById('selectedDate').valueAsDate = new Date();
            }
            
            // Make sure pagination listeners are properly attached on page load
            attachPaginationListeners();
            
            // Fix URL parameters to ensure consistency
            fixUrlParameters();
            
            // Date selector change event
            document.getElementById('selectedDate').addEventListener('change', function() {
                // Only trigger navigation if not in all dates mode or if the input is not disabled
                if (!this.disabled) {
                    // Reload the page with the new date parameter
                    const url = new URL(window.location.href);
                    url.searchParams.delete('all_dates'); // Remove all_dates parameter if exists
                    url.searchParams.delete('page'); // Reset to page 1
                    url.searchParams.set('date', this.value);
                    window.location.href = url.toString();
                }
            });
            
            // Function to fix URL parameters to ensure consistency
            function fixUrlParameters() {
                const currentUrl = new URL(window.location.href);
                let needsUpdate = false;
                
                // Check if all_dates and date parameters are both present (they should be mutually exclusive)
                if (currentUrl.searchParams.has('all_dates') && currentUrl.searchParams.has('date')) {
                    // If both exist, prioritize all_dates
                    currentUrl.searchParams.delete('date');
                    needsUpdate = true;
                }
                
                // Ensure page parameter is a valid number
                if (currentUrl.searchParams.has('page')) {
                    const page = parseInt(currentUrl.searchParams.get('page'));
                    if (isNaN(page) || page < 1) {
                        currentUrl.searchParams.set('page', '1');
                        needsUpdate = true;
                    }
                }
                
                // Update URL if needed without causing a page reload
                if (needsUpdate) {
                    window.history.replaceState({}, '', currentUrl.toString());
                }
            }
            
            // All dates button click event
            if (document.getElementById('allDatesBtn')) {
                document.getElementById('allDatesBtn').addEventListener('click', function() {
                    // Show loading state
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Loading...';
                    
                    // Reload the page with all_dates parameter
                    const url = new URL(window.location.href);
                    url.searchParams.delete('date'); // Remove date parameter if exists
                    url.searchParams.delete('page'); // Remove page parameter to start at page 1
                    url.searchParams.set('all_dates', '1');
                    
                    window.location.href = url.toString();
                });
            }
            
            // Filter by date button click event
            if (document.getElementById('filterByDateBtn')) {
                document.getElementById('filterByDateBtn').addEventListener('click', function() {
                    // Show loading state
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Loading...';
                    
                    // Enable the date input
                    const dateInput = document.getElementById('selectedDate');
                    dateInput.disabled = false;
                    
                    // Reload the page with the selected date parameter
                    const url = new URL(window.location.href);
                    url.searchParams.delete('all_dates'); // Remove all_dates parameter
                    url.searchParams.delete('page'); // Remove page parameter to start at page 1
                    url.searchParams.set('date', dateInput.value);
                    window.location.href = url.toString();
                });
            }
            
            // Setup search and filter functionality
            const searchInput = document.getElementById('orderSearchInput');
            const statusFilter = document.getElementById('orderStatusFilter');
            
            // Debounce function to prevent too many filters while typing
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }
            
            // Search input input event with debounce
            if (searchInput) {
                searchInput.addEventListener('input', debounce(function(e) {
                    applySearchAndFilter();
                }, 500)); // 500ms delay
            }
            
            // Status filter change event
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    applySearchAndFilter();
                });
            }
            
            // Function to apply search and filter
            function applySearchAndFilter() {
                // Get the current data and re-filter it
                const date = document.getElementById('selectedDate').value;
                const isAllDates = new URLSearchParams(window.location.search).has('all_dates');
                const statusFilter = document.getElementById('orderStatusFilter');
                
                // Show loading indicator
                const tableBody = document.querySelector('.orders-table tbody');
                if (tableBody) {
                    tableBody.innerHTML = '<tr><td colspan="6" class="text-center"><i class="fas fa-spinner fa-spin me-2"></i> Loading...</td></tr>';
                }
                
                // Build query parameters
                let params = new URLSearchParams();
                if (isAllDates) {
                    params.append('all_dates', '1');
                } else if (date) {
                    params.append('date', date);
                }
                
                // Add search term if exists
                const searchTerm = document.getElementById('orderSearchInput').value.trim();
                if (searchTerm) {
                    params.append('search', searchTerm);
                }
                
                // Add status filter if selected
                if (statusFilter && statusFilter.value) {
                    params.append('status', statusFilter.value);
                }

                // Fetch updated data
                fetch(`/admin/api/dashboard-data?${params.toString()}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            throw new Error(data.message || 'Server returned an error');
                        }
                        
                        // Update the table with filtered data
                        updateRecentOrdersTable(data.recent_orders);
                        
                        // Update pagination UI if pagination data is available
                        if (data.pagination) {
                            updatePaginationUI(data.pagination);
                            attachPaginationListeners();
                        }
                        
                        // Set the status filter to match current selection
                        if (statusFilter && data.selected_status) {
                            statusFilter.value = data.selected_status;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching dashboard data:', error);
                        if (tableBody) {
                            tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Error loading data: ${error.message || 'Unknown error'}. Please try again.</td></tr>`;
                        }
                    });
            }
            
            // Check if we're on the all_dates view and update UI accordingly
            if (new URLSearchParams(window.location.search).has('all_dates')) {
                document.querySelectorAll('.card-period').forEach(el => {
                    el.textContent = 'All Time';
                });
                
                // Disable date input when viewing all dates, but don't hide it
                const dateInput = document.getElementById('selectedDate');
                if (dateInput) {
                    dateInput.disabled = true;
                }
            }
            
            // Function to attach event listeners to pagination links
            function attachPaginationListeners() {
                document.querySelectorAll('.custom-pagination .page-link').forEach(link => {
                    // Remove any existing click listeners to prevent duplicates
                    link.removeEventListener('click', handlePaginationClick);
                    link.addEventListener('click', handlePaginationClick);
                });
            }

            // Handler function for pagination clicks
            function handlePaginationClick(e) {
                e.preventDefault();
                
                // Skip if this is a disabled link or we're already on this page
                if (this.parentElement.classList.contains('disabled') || 
                    this.parentElement.classList.contains('active')) {
                    return;
                }
                
                // Instead of AJAX, just navigate directly to the page
                window.location.href = this.href;
            }
        });
        
        // Helper function to fetch with retry logic
        function fetchWithRetry(url, maxRetries) {
            return new Promise((resolve, reject) => {
                let retries = 0;
                
                function attempt() {
                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                throw new Error(data.message || 'Server returned an error');
                            }
                            
                            // Validate data structure to ensure it has the expected format
                            if (!data || !data.recent_orders) {
                                throw new Error('Invalid data format received from server');
                            }
                            
                            // Make sure pagination data is properly structured
                            if (!data.pagination) {
                                console.warn('Server response missing pagination data, creating default pagination');
                                data.pagination = {
                                    current_page: 1,
                                    last_page: 1,
                                    per_page: data.recent_orders.length,
                                    total: data.recent_orders.length
                                };
                            }
                            
                            // Log for debugging
                            console.log('Received data:', {
                                total_orders: data.recent_orders.length,
                                current_page: data.pagination.current_page,
                                total_pages: data.pagination.last_page
                            });
                            
                            resolve(data);
                        })
                        .catch(error => {
                            retries++;
                            console.warn(`Fetch attempt ${retries} failed:`, error);
                            
                            if (retries < maxRetries) {
                                // Exponential backoff: wait longer between each retry
                                setTimeout(attempt, Math.min(1000 * Math.pow(2, retries - 1), 5000));
                            } else {
                                // After max retries, show "No orders found" instead of error
                                const tableBody = document.querySelector('.orders-table tbody');
                                if (tableBody) {
                                    tableBody.innerHTML = '<tr><td colspan="6" class="text-center">No orders found. Please try refreshing the page.</td></tr>';
                                }
                                
                                // Provide a partial resolution with empty data rather than rejecting
                                resolve({
                                    recent_orders: [],
                                    pagination: {
                                        current_page: parseInt(new URLSearchParams(window.location.search).get('page') || '1'),
                                        last_page: 1,
                                        per_page: 10,
                                        total: 0
                                    }
                                });
                            }
                        });
                }
                
                attempt();
            });
        }
        
        // Function to update pagination UI
        function updatePaginationUI(pagination) {
            const paginationContainer = document.querySelector('.custom-pagination');
            if (!paginationContainer) return;
            
            // Preserve existing parameters
            const currentUrl = new URL(window.location.href);
            const urlParams = {};
            
            // Preserve existing parameters
            for (const [key, value] of currentUrl.searchParams.entries()) {
                if (key !== 'page') {
                    urlParams[key] = value;
                }
            }
            
            // Create new pagination HTML with simple links for direct page refreshes
            let paginationHtml = '<ul class="pagination">';
            
            // Previous page link
            if (pagination.current_page > 1) {
                const prevPageUrl = new URL(window.location.href);
                prevPageUrl.searchParams.set('page', pagination.current_page - 1);
                for (const [key, value] of Object.entries(urlParams)) {
                    prevPageUrl.searchParams.set(key, value);
                }
                
                paginationHtml += `<li class="page-item">
                    <a class="page-link" href="${prevPageUrl.toString()}" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>`;
            } else {
                paginationHtml += `<li class="page-item disabled">
                    <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                </li>`;
            }
            
            // Simple page numbers - show up to 5 pages around current page
            const totalPages = pagination.last_page;
            const currentPage = pagination.current_page;
            
            // Always show at least 5 pages if available
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);
            
            // Adjust start page if we're near the end
            if (endPage - startPage < 4 && totalPages > 5) {
                startPage = Math.max(1, endPage - 4);
            }
            
            // Page numbers
            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) {
                    paginationHtml += `<li class="page-item active" aria-current="page">
                        <span class="page-link">${i}</span>
                    </li>`;
                } else {
                    const pageUrl = new URL(window.location.href);
                    pageUrl.searchParams.set('page', i);
                    for (const [key, value] of Object.entries(urlParams)) {
                        pageUrl.searchParams.set(key, value);
                    }
                    
                    paginationHtml += `<li class="page-item">
                        <a class="page-link" href="${pageUrl.toString()}">${i}</a>
                    </li>`;
                }
            }
            
            // Next page link
            if (currentPage < totalPages) {
                const nextPageUrl = new URL(window.location.href);
                nextPageUrl.searchParams.set('page', currentPage + 1);
                for (const [key, value] of Object.entries(urlParams)) {
                    nextPageUrl.searchParams.set(key, value);
                }
                
                paginationHtml += `<li class="page-item">
                    <a class="page-link" href="${nextPageUrl.toString()}" rel="next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>`;
            } else {
                paginationHtml += `<li class="page-item disabled">
                    <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                </li>`;
            }
            
            paginationHtml += '</ul>';
            
            // Replace pagination HTML - use a try-catch to handle any potential errors
            try {
                paginationContainer.innerHTML = paginationHtml;
            } catch (error) {
                console.error('Error updating pagination UI:', error);
            }
        }

        // Apply filters and reload dashboard data
        function applyFilters() {
            const selectedDate = document.getElementById('selectedDate').value;
            const isAllDates = new URLSearchParams(window.location.search).has('all_dates');
            
            // Update the card period text
            document.querySelectorAll('.card-period').forEach(el => {
                el.textContent = isAllDates ? 'All Time' : 'Selected Date';
            });
            
            // Fetch dashboard data with filters
            fetchDashboardData(selectedDate, isAllDates);
            
            // Update URL with selected date (without reloading the page)
            const url = new URL(window.location.href);
            if (isAllDates) {
                url.searchParams.delete('date');
                url.searchParams.set('all_dates', '1');
            } else if (selectedDate) {
                url.searchParams.delete('all_dates');
                url.searchParams.set('date', selectedDate);
            } else {
                url.searchParams.delete('date');
                url.searchParams.delete('all_dates');
            }
            window.history.replaceState({}, '', url);
        }

        // Update the fetchDashboardData function to accept date parameter
        function fetchDashboardData(date = null, isAllDates = false) {
            // Build query parameters
            let params = new URLSearchParams();
            if (isAllDates) {
                params.append('all_dates', '1');
            } else if (date) {
                params.append('date', date);
            }
            
            const url = `/admin/api/dashboard-data?${params.toString()}`;
            
            // Show loading indicator in the table
            const tableBody = document.querySelector('.orders-table tbody');
            if (tableBody) {
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center"><i class="fas fa-spinner fa-spin me-2"></i> Loading...</td></tr>';
            }
            
            // Fetch data with filters
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.message || 'Server returned an error');
                    }
                    
                    // Update the dashboard cards
                    document.querySelector('.dashboard-card:nth-child(1) .card-value').textContent = 
                        'IDR ' + formatNumber(data.total_sales);
                    document.querySelector('.dashboard-card:nth-child(1) .progress-percentage').textContent = 
                        data.sales_percentage + '%';
                    document.querySelector('.dashboard-card:nth-child(1) svg circle:nth-child(2)').setAttribute(
                        'stroke-dashoffset', 220 - (data.sales_percentage * 2.2));

                    // Update total orders explicitly
                    const totalOrdersElement = document.querySelector('.dashboard-card:nth-child(2) .card-value');
                    totalOrdersElement.textContent = data.total_orders;
                    
                    document.querySelector('.dashboard-card:nth-child(2) .progress-percentage').textContent = 
                        data.orders_percentage + '%';
                    document.querySelector('.dashboard-card:nth-child(2) svg circle:nth-child(2)').setAttribute(
                        'stroke-dashoffset', 220 - (data.orders_percentage * 2.2));

                    // Update recent orders table
                    updateRecentOrdersTable(data.recent_orders);
                    
                    // Update pagination UI if pagination data is available
                    if (data.pagination) {
                        updatePaginationUI(data.pagination);
                        // Re-attach event listeners to pagination links
                        attachPaginationListeners();
                    }
                    
                    // Update card period text based on filter
                    document.querySelectorAll('.card-period').forEach(el => {
                        if (data.show_all_dates) {
                            el.textContent = 'All Time';
                        } else {
                            const formattedDate = new Date(data.date).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });
                            el.textContent = formattedDate;
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching dashboard data:', error);
                    if (tableBody) {
                        tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Error loading data: ${error.message || 'Unknown error'}. Please try again.</td></tr>`;
                    }
                });
        }

        // Function to update the recent orders table
        function updateRecentOrdersTable(orders) {
            const tableBody = document.querySelector('.orders-table tbody');
            if (!tableBody) return;
            
            // Clear existing rows
            tableBody.innerHTML = '';
            
            // Check if orders is undefined or not an array
            if (!orders || !Array.isArray(orders) || orders.length === 0) {
                const emptyRow = document.createElement('tr');
                emptyRow.innerHTML = '<td colspan="6" class="text-center">No orders found</td>';
                tableBody.appendChild(emptyRow);
                return;
            }
            
            // Apply search and filter if they exist
            const searchTerm = document.getElementById('orderSearchInput').value.toLowerCase();
            const statusFilter = document.getElementById('orderStatusFilter').value.toLowerCase();
            
            // Filter orders based on search term and status filter
            const filteredOrders = orders.filter(order => {
                // Skip null or undefined orders
                if (!order) return false;
                
                // Check if order matches the status filter
                if (statusFilter && order.status && order.status.toLowerCase() !== statusFilter) {
                    return false;
                }
                
                // If no search term, return true
                if (!searchTerm) return true;
                
                // Check if order matches the search term
                const productName = (order.product_name || '').toLowerCase();
                const productNumber = (order.product_number || '').toLowerCase();
                
                // Get expedition name
                let expeditionName = 'N/A';
                if (order.shipping_info && order.shipping_info.expedition) {
                    const expedition = order.shipping_info.expedition.toLowerCase();
                    switch(expedition) {
                        case 'jne':
                            expeditionName = 'JNE';
                            break;
                        case 'jnt':
                            expeditionName = 'J&T Express';
                            break;
                        case 'sicepat':
                            expeditionName = 'SiCepat';
                            break;
                        case 'pos':
                            expeditionName = 'POS Indonesia';
                            break;
                        case 'tiki':
                            expeditionName = 'TIKI';
                            break;
                        default:
                            expeditionName = order.shipping_info.expedition.toUpperCase();
                    }
                    
                    // Add service name if available
                    if (order.shipping_info.service) {
                        expeditionName += ` - ${order.shipping_info.service}`;
                    }
                }
                
                expeditionName = expeditionName.toLowerCase();
                
                // Check if any field matches the search term
                return productName.includes(searchTerm) || 
                       productNumber.includes(searchTerm) || 
                       expeditionName.includes(searchTerm);
            });
            
            if (filteredOrders.length === 0) {
                const emptyRow = document.createElement('tr');
                emptyRow.innerHTML = '<td colspan="6" class="text-center">No orders found</td>';
                tableBody.appendChild(emptyRow);
                return;
            }
            
            // Add new rows
            filteredOrders.forEach(order => {
                try {
                    const row = document.createElement('tr');
                    
                    // Safety checks for required properties
                    const productName = order.product_name || 'N/A';
                    const productNumber = order.product_number || 'N/A';
                    const status = order.status || 'pending';
                    const total = order.total || 0;
                    const orderId = order.id || '';
                    const orderNumber = order.order_number || '';
                    
                    // Format the status badge
                    const statusClass = `status-badge status-${status.toLowerCase()}`;
                    const statusText = status.charAt(0).toUpperCase() + status.slice(1);
                    
                    // Determine expedition name with error handling
                    let expeditionName = 'N/A';
                    if (order.shipping_info && order.shipping_info.expedition) {
                        const expedition = order.shipping_info.expedition.toLowerCase();
                        switch(expedition) {
                            case 'jne':
                                expeditionName = 'JNE';
                                break;
                            case 'jnt':
                                expeditionName = 'J&T Express';
                                break;
                            case 'sicepat':
                                expeditionName = 'SiCepat';
                                break;
                            case 'pos':
                                expeditionName = 'POS Indonesia';
                                break;
                            case 'tiki':
                                expeditionName = 'TIKI';
                                break;
                            default:
                                expeditionName = order.shipping_info.expedition.toUpperCase();
                        }
                        
                        // Add service name if available
                        if (order.shipping_info.service) {
                            expeditionName += ` - ${order.shipping_info.service}`;
                        }
                    }
                    
                    row.innerHTML = `
                        <td>${productName}</td>
                        <td>${productNumber}</td>
                        <td>${expeditionName}</td>
                        <td>IDR ${formatNumber(total)}</td>
                        <td><span class="${statusClass}">${statusText}</span></td>
                        <td class="action-buttons">
                            <button class="action-btn details-btn" data-order-id="${orderId}">Details</button>
                            <button class="action-btn edit-btn" data-order-id="${orderId}" 
                                    data-bs-toggle="modal" data-bs-target="#editOrderModal" 
                                    data-order-number="${orderNumber}"
                                    data-order-status="${status}">Edit</button>
                        </td>
                    `;
                    
                    tableBody.appendChild(row);
                } catch (error) {
                    console.error('Error processing order:', error, order);
                }
            });
            
            // Re-attach event listeners for the new buttons
            try {
                document.querySelectorAll('.details-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const orderId = this.getAttribute('data-order-id');
                        if (orderId) {
                            fetchOrderDetails(orderId);
                        }
                    });
                });
                
                // Attach event listeners to edit buttons
                document.querySelectorAll('.edit-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const orderId = this.getAttribute('data-order-id');
                        const orderNumber = this.getAttribute('data-order-number');
                        const orderStatus = this.getAttribute('data-order-status');
                        
                        // Populate the edit modal
                        if (document.getElementById('editOrderId')) {
                            document.getElementById('editOrderId').value = orderId;
                        }
                        if (document.getElementById('orderNumber')) {
                            document.getElementById('orderNumber').value = orderNumber;
                        }
                        if (document.getElementById('orderStatus')) {
                            document.getElementById('orderStatus').value = orderStatus;
                        }
                    });
                });
            } catch (error) {
                console.error('Error attaching event listeners to buttons:', error);
            }
        }

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
                        // Preserve the all_dates parameter if it exists
                        const url = new URL(window.location.href);
                        const hasAllDates = url.searchParams.has('all_dates');
                        window.location.href = hasAllDates ? '/admin?all_dates=1' : '/admin';
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
                        csrfInput.value = '{{ csrf_token() }}';
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

        // Set up action buttons for order details
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('details-btn')) {
                const orderId = e.target.getAttribute('data-order-id');
                // Fetch order details and show modal
                fetchOrderDetails(orderId);
            }
        });

        // Fetch order details from the server
        function fetchOrderDetails(orderId) {
            // Ensure we're using a numeric ID for the API request
            if (!orderId) {
                console.error('No order ID provided');
                return;
            }
            
            // Make the API request with the ID
            fetch(`/admin/api/orders/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayOrderDetails(data.order);
                        // Show the modal after data is loaded
                        const orderDetailsModal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
                        orderDetailsModal.show();
                    } else {
                        alert('Failed to fetch order details: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                    // For demo purposes, we'll use mock data if the API isn't implemented yet
                    displayMockOrderDetails(orderId);
                    // Show the modal after mock data is loaded
                    const orderDetailsModal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
                    orderDetailsModal.show();
                });
        }

        // Display order details in the modal
        function displayOrderDetails(order) {
            // Fill in order information
            document.getElementById('detailOrderNumber').textContent = order.order_number;
            document.getElementById('detailOrderDate').textContent = new Date(order.created_at).toLocaleDateString();
            
            // Set status with appropriate badge
            const statusBadge = document.createElement('span');
            statusBadge.className = `status-badge status-${order.status.toLowerCase()}`;
            statusBadge.textContent = capitalizeFirstLetter(order.status);
            document.getElementById('detailOrderStatus').innerHTML = '';
            document.getElementById('detailOrderStatus').appendChild(statusBadge);
            
            // Customer information
            document.getElementById('detailCustomerName').textContent = 
                `${order.shipping_info.firstName} ${order.shipping_info.lastName}`;
            document.getElementById('detailCustomerEmail').textContent = order.shipping_info.email || 'N/A';
            
            // Format and display phone number
            let phoneDisplay = 'N/A';
            if (order.shipping_info.phoneNumber) {
                // If country code exists, format with it
                if (order.shipping_info.countryCode) {
                    phoneDisplay = `+${order.shipping_info.countryCode} ${order.shipping_info.phoneNumber}`;
                } else {
                    phoneDisplay = order.shipping_info.phoneNumber;
                }
            }
            document.getElementById('detailCustomerPhone').textContent = phoneDisplay;
            
            // Shipping address and expedition
            let expeditionInfo = '';
            if (order.shipping_info.expedition) {
                let expeditionName = '';
                switch(order.shipping_info.expedition) {
                    case 'jne':
                        expeditionName = 'JNE';
                        break;
                    case 'jnt':
                        expeditionName = 'J&T Express';
                        break;
                    case 'sicepat':
                        expeditionName = 'SiCepat';
                        break;
                    case 'pos':
                        expeditionName = 'POS Indonesia';
                        break;
                    case 'tiki':
                        expeditionName = 'TIKI';
                        break;
                    default:
                        expeditionName = order.shipping_info.expedition.toUpperCase();
                }
                
                // Add service if available
                if (order.shipping_info.service) {
                    expeditionName += ` - ${order.shipping_info.service}`;
                }
                
                expeditionInfo = `<br><strong>Shipping Method:</strong> ${expeditionName}`;
            }
            
            document.getElementById('detailShippingAddress').innerHTML = 
                `${order.shipping_info.firstName} ${order.shipping_info.lastName}<br>
                ${order.shipping_info.address}<br>
                ${order.shipping_info.city || ''} ${order.shipping_info.postalCode || ''}${expeditionInfo}`.trim();
            
            // Order summary
            document.getElementById('detailSubtotal').textContent = `IDR ${formatNumber(order.subtotal)}`;
            document.getElementById('detailShipping').textContent = `IDR ${formatNumber(order.shipping_cost)}`;
            document.getElementById('detailTotal').textContent = `IDR ${formatNumber(order.total)}`;
            
            // Set invoice download link - hanya tampilkan jika status pembayaran sudah berhasil
            const invoiceButtonContainer = document.getElementById('invoiceButtonContainer');
            invoiceButtonContainer.innerHTML = '';
            
            // Status yang dianggap sudah melakukan pembayaran
            const paidStatuses = ['success', 'confirmed', 'packing', 'shipped', 'delivered', 'completed'];
            
            if (paidStatuses.includes(order.status.toLowerCase())) {
                const invoiceButton = document.createElement('a');
                invoiceButton.href = `/admin/invoice/download/${order.id}`;
                invoiceButton.className = 'btn btn-primary';
                invoiceButton.target = '_blank';
                invoiceButton.style.textDecoration = 'none';
                invoiceButton.textContent = 'Download Invoice';
                invoiceButtonContainer.appendChild(invoiceButton);
            }
            
            // Products list
            const productsList = document.getElementById('orderProductsList');
            productsList.innerHTML = '';
            
            order.cart_items.forEach(item => {
                const productItem = document.createElement('div');
                productItem.className = 'product-item d-flex align-items-center border-bottom pb-3 mb-3';
                productItem.innerHTML = `
                    <div class="product-image me-3">
                        <img src="${item.image}" alt="${item.name}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                    </div>
                    <div class="product-details flex-grow-1">
                        <h6 class="mb-1">${item.name}</h6>
                        <div class="d-flex align-items-center">
                            <span class="me-3">Size: ${item.size}</span>
                            <span class="me-3">Quantity: ${item.quantity}</span>
                            <span>Price: IDR ${formatNumber(item.price)} per item</span>
                        </div>
                    </div>
                    <div class="product-total">
                        <strong>IDR ${formatNumber(item.price * item.quantity)}</strong>
                    </div>
                `;
                productsList.appendChild(productItem);
            });
        }

        // Mock data for demo purposes if API isn't ready
        function displayMockOrderDetails(orderId) {
            const mockOrder = {
                id: orderId,
                order_number: 'ORD-6832E' + orderId.toString().padStart(4, '0'),
                created_at: new Date().toISOString(),
                status: 'pending',
                shipping_info: {
                    firstName: 'John',
                    lastName: 'Doe',
                    email: 'john.doe@example.com',
                    countryCode: '62',
                    phoneNumber: '812-3456-7890',
                    address: 'Jl. Sudirman No. 123',
                    city: 'Jakarta',
                    postalCode: '12345',
                    expedition: 'jne'
                },
                subtotal: 849999,
                shipping_cost: 15000,
                total: 864999,
                cart_items: [
                    {
                        name: 'Kaos Hitam',
                        size: 'XL',
                        quantity: 2,
                        price: 200000,
                        image: '/images/products/product-1.jpg'
                    },
                    {
                        name: 'Celana Jeans',
                        size: '32',
                        quantity: 1,
                        price: 449999,
                        image: '/images/products/product-2.jpg'
                    }
                ]
            };
            
            displayOrderDetails(mockOrder);
        }

        // Initialize edit order modal
        const editOrderModal = document.getElementById('editOrderModal');
        if (editOrderModal) {
            editOrderModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const orderId = button.getAttribute('data-order-id');
                const orderNumber = button.getAttribute('data-order-number');
                const orderStatus = button.getAttribute('data-order-status');
                
                document.getElementById('editOrderId').value = orderId;
                document.getElementById('orderNumber').value = orderNumber;
                
                // Set the current status in the dropdown
                const statusSelect = document.getElementById('orderStatus');
                for (let i = 0; i < statusSelect.options.length; i++) {
                    if (statusSelect.options[i].value === orderStatus.toLowerCase()) {
                        statusSelect.selectedIndex = i;
                        break;
                    }
                }
                
                // Fetch order details to get the last note
                fetch(`/admin/api/orders/${orderId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Set the current status in case it wasn't set correctly from the button attribute
                            for (let i = 0; i < statusSelect.options.length; i++) {
                                if (statusSelect.options[i].value === data.order.status.toLowerCase()) {
                                    statusSelect.selectedIndex = i;
                                    break;
                                }
                            }
                            
                            // Clear the note field initially
                            document.getElementById('orderNote').value = '';
                            
                            // Get the last note for the current status if it exists
                            if (data.order.notes && data.order.notes.length > 0) {
                                const currentStatusNotes = data.order.notes.filter(note => 
                                    note.admin === true && note.status === data.order.status
                                );
                                
                                if (currentStatusNotes.length > 0) {
                                    // Sort by date descending and get the latest note
                                    currentStatusNotes.sort((a, b) => 
                                        new Date(b.date) - new Date(a.date)
                                    );
                                    document.getElementById('orderNote').value = currentStatusNotes[0].message;
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching order details:', error);
                    });
            });
            
            // Add event listener to reset note field when status changes
            document.getElementById('orderStatus').addEventListener('change', function() {
                document.getElementById('orderNote').value = '';
            });
        }

        // Save order status changes
        document.getElementById('saveOrderStatus').addEventListener('click', function() {
            const orderId = document.getElementById('editOrderId').value;
            const status = document.getElementById('orderStatus').value;
            const note = document.getElementById('orderNote').value;
            
            // Ensure we have a valid ID
            if (!orderId) {
                console.error('No order ID provided');
                alert('Error: No order ID provided');
                return;
            }
            
            // Call API to update order status
            fetch(`/admin/api/orders/${orderId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    status: status,
                    note: note
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    bootstrap.Modal.getInstance(editOrderModal).hide();
                    
                    // Update the status in the table
                    const statusCell = document.querySelector(`button[data-order-id="${orderId}"]`).closest('tr').querySelector('.status-badge');
                    statusCell.className = `status-badge status-${status.toLowerCase()}`;
                    statusCell.textContent = capitalizeFirstLetter(status);
                    
                    // Show success message
                    alert('Order status updated successfully' + (note ? ' with note to customer' : ''));
                } else {
                    alert('Failed to update order status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error saving order status:', error);
                alert('Failed to update order status. Please try again.');
            });
        });
        
        // Helper function to format numbers with commas
        function formatNumber(number) {
            // Convert to integer first to remove decimal places
            number = Math.round(Number(number));
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        // Helper function to capitalize first letter
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
    <style>
    /* Filter section styles */
    .date-selector {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .date-input {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 14px;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
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

    /* Status badge styles */
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }
    
    /* Pagination styles */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }
    
    .pagination .page-item {
        list-style: none;
    }
    
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 38px;
        min-width: 38px;
        padding: 0 10px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        color: #14387F;
        background-color: #fff;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #14387F;
        border-color: #14387F;
        color: white;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
    
    .pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #0e2b63;
        z-index: 2;
    }
    
    /* Previous/Next buttons */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 16px;
        font-weight: bold;
    }
    
    /* Search and Filter Bar Styles */
    .search-filter-bar {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .search-filter-bar .form-control,
    .search-filter-bar .form-select {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 14px;
        height: 42px;
    }
    
    .search-filter-bar .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        color: #6c757d;
    }
    
    .search-filter-bar .input-group .form-control {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    
    /* Status Badge Colors */
    .status-badge.status-pending {
        background-color: #ffc107;
        color: #212529;
    }
    
    .status-badge.status-confirmed {
        background-color: #17a2b8;
        color: white;
    }
    
    .status-badge.status-packing {
        background-color: #6610f2;
        color: white;
    }
    
    .status-badge.status-shipped {
        background-color: #007bff;
        color: white;
    }
    
    .status-badge.status-delivered {
        background-color: #28a745;
        color: white;
    }
    
    .status-badge.status-completed {
        background-color: #20c997;
        color: white;
    }
    
    .status-badge.status-rejected {
        background-color: #dc3545;
        color: white;
    }
    </style>
</body>
</html>