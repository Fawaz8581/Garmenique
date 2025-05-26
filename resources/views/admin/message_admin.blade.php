<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Garmenique - Messages</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Messages">
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
        .user-avatar {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #495057;
            font-size: 16px;
        }

        .user-item {
            cursor: pointer;
            transition: background-color 0.2s;
            position: relative;
        }

        .user-item:hover {
            background-color: #f8f9fa;
        }

        .user-item.active {
            background-color: #e9ecef;
        }
        
        /* User info styles - align text to left */
        .user-info {
            width: 100%;
            text-align: left;
        }
        
        .user-info h6 {
            text-align: left;
        }
        
        .user-info p {
            text-align: left;
        }
        
        /* Badge positioning */
        .badge {
            position: absolute;
            right: 15px;
            margin-top: 0;
        }

        /* Chat Area Styles */
        .chat-area {
            height: calc(100vh - 300px);
            overflow-y: auto;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message {
            max-width: 70%;
            margin-bottom: 10px;
            clear: both;
        }

        .message.incoming {
            float: left;
            align-self: flex-start;
        }

        .message.outgoing {
            float: right;
            align-self: flex-end;
        }

        .message-content {
            padding: 12px 16px;
            border-radius: 15px;
            font-size: 14px;
            line-height: 1.4;
        }

        .message.incoming .message-content {
            background-color: #e9ecef;
            color: #212529;
            border-top-left-radius: 5px;
        }

        .message.outgoing .message-content {
            background-color: #0d6efd;
            color: white;
            border-top-right-radius: 5px;
        }

        .message-time {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
            text-align: right;
        }

        .message.incoming .message-time {
            text-align: left;
        }

        /* Message Input Styles */
        .card-footer {
            border-top: 1px solid #dee2e6;
            padding: 15px;
        }

        .message-form .input-group {
            background-color: #fff;
            border-radius: 25px;
            overflow: hidden;
        }

        .message-form .form-control {
            border: none;
            padding: 12px 20px;
        }

        .message-form .form-control:focus {
            box-shadow: none;
        }

        .message-form .btn {
            padding: 0 20px;
            border: none;
            border-radius: 0;
        }

        /* Scrollbar Styles */
        .chat-area::-webkit-scrollbar {
            width: 6px;
        }

        .chat-area::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-area::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .chat-area::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* User list styling */
        .users-list {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
        
        /* Force text to be left-aligned */
        .text-left {
            text-align: left !important;
        }
        
        /* Make sure flex doesn't center content */
        .d-flex.align-items-center.p-3 {
            justify-content: flex-start;
        }
        
        /* Give user info proper width */
        .user-info.ms-3 {
            max-width: calc(100% - 55px); /* 40px avatar + 15px margin */
            overflow: hidden;
        }
        
        /* Ensure text doesn't overflow */
        .user-info h6, 
        .user-info p {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
            <div class="brand-logo">
                <img src="{{ asset('images/icons/GarmeniqueLogo.png') }}" alt="Garmenique Logo" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
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
            <li class="menu-item">
                <i class="fas fa-tags"></i>
                <span>Categories</span>
            </li>
            <li class="menu-item">
                <i class="fas fa-ruler"></i>
                <span>Sizes</span>
            </li>
            <li class="menu-item active">
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
            <div class="d-flex align-items-center">
                <h1 class="page-title">Messages</h1>
            </div>
            
            <div class="user-section">
                <div class="user-info">
                    <h4 class="user-name">Garmenique</h4>
                    <p class="user-role">Admin</p>
                </div>
            </div>
        </div>
        
        <!-- Messages Section -->
        <div class="messages-section">
            <div class="container-fluid">
                <div class="row">
                    <!-- Users List -->
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Chats</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="users-list">
                                    @foreach($users as $user)
                                    <div class="user-item d-flex align-items-center p-3 border-bottom {{ $loop->first ? 'active' : '' }}" 
                                         data-user-id="{{ $user->id }}">
                                        <div class="user-avatar">
                                            <div class="avatar-placeholder">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="user-info ms-3">
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <p class="small text-muted mb-0">
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Area -->
                    <div class="col-md-8 col-lg-9">
                        <div class="card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar">
                                        <div class="avatar-placeholder" id="currentUserAvatar"></div>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0" id="currentUserName"></h5>
                                        <small class="text-muted" id="currentUserEmail"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body chat-area" id="chatArea">
                                <div class="chat-messages" id="chatMessages">
                                    <!-- Messages will be loaded here -->
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <form id="messageForm" class="message-form">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="messageInput" placeholder="Type a message...">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>
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

        document.addEventListener('DOMContentLoaded', function() {
            const users = @json($users);
            const userItems = document.querySelectorAll('.user-item');
            const chatMessages = document.getElementById('chatMessages');
            const messageForm = document.getElementById('messageForm');
            const messageInput = document.getElementById('messageInput');
            let currentUserId = null;

            function updateChatHeader(user) {
                document.getElementById('currentUserName').textContent = user.name;
                document.getElementById('currentUserEmail').textContent = user.email;
                document.getElementById('currentUserAvatar').textContent = user.name.charAt(0).toUpperCase();
            }

            function loadMessages(userId) {
                fetch(`/admin/messages/${userId}`)
                    .then(response => response.json())
                    .then(messages => {
                        chatMessages.innerHTML = '';
                        messages.forEach(message => {
                            const messageElement = createMessageElement(message);
                            chatMessages.appendChild(messageElement);
                        });
                        scrollToBottom();
                    })
                    .catch(error => {
                        console.error('Error loading messages:', error);
                    });
            }

            function createMessageElement(message) {
                const div = document.createElement('div');
                div.className = `message ${message.is_admin ? 'outgoing' : 'incoming'}`;
                div.innerHTML = `
                    <div class="message-content">${message.content}</div>
                    <div class="message-time">${message.created_at}</div>
                `;
                return div;
            }

            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Initialize with first user
            if (users.length > 0) {
                const firstUser = users[0];
                currentUserId = firstUser.id;
                updateChatHeader(firstUser);
                loadMessages(firstUser.id);
            }

            // User item click handler
            userItems.forEach(item => {
                item.addEventListener('click', function() {
                    const userId = this.dataset.userId;
                    const user = users.find(u => u.id == userId);
                    
                    userItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                    
                    currentUserId = userId;
                    updateChatHeader(user);
                    loadMessages(userId);
                });
            });

            // Send message handler
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!messageInput.value.trim() || !currentUserId) return;

                const formData = new FormData();
                formData.append('message', messageInput.value);
                formData.append('user_id', currentUserId);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                fetch('/admin/messages/send', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(message => {
                    const messageElement = createMessageElement({
                        id: message.id,
                        content: message.content,
                        is_admin: true,
                        created_at: message.created_at
                    });
                    chatMessages.appendChild(messageElement);
                    scrollToBottom();
                    messageInput.value = '';
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
            });

            // Poll for new messages every 3 seconds
            if (currentUserId) {
                setInterval(() => {
                    loadMessages(currentUserId);
                }, 3000);
            }
        });
    </script>
</body>
</html>