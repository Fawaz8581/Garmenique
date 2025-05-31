<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="garmeniqueApp">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Garmenique - Messages</title>
        <meta name="keyword" content="Garmenique">
        <meta name="description" content="Garmenique - Premium Clothing Brand">
        <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            /* Add space for fixed header */
            body {
                padding-top: 60px; /* Reduced from 80px to match other pages */
                background-color: #f5f5f5; /* Match admin background */
            }
            
            .messages-container {
                padding: 20px; /* Match admin padding */
                min-height: calc(100vh - 140px); /* Adjusted to account for smaller header */
                background-color: #f5f5f5; /* Match admin background */
            }

            .chat-container {
                max-width: 1000px;
                margin: 0 auto;
                background: white;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Match admin box-shadow */
            }

            .header {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 1000;
                background-color: #fff;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Match admin shadow */
                padding: 15px 0; /* Standard padding instead of fixed height */
                height: auto; /* Remove fixed height */
            }

            .chat-header {
                padding: 1rem;
                border-bottom: 1px solid #dee2e6;
                background-color: white;
                border-radius: 10px 10px 0 0;
            }

            .admin-info {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .admin-avatar {
                width: 40px;
                height: 40px;
                background-color: #e9ecef;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                color: #495057;
            }

            .admin-details h5 {
                margin: 0;
                font-size: 1rem;
                color: #212529;
            }

            .admin-details p {
                margin: 0;
                font-size: 0.875rem;
                color: #6c757d;
            }

            .chat-area {
                height: 500px;
                overflow-y: auto;
                padding: 1.5rem;
                background-color: #f8f9fa;
            }

            .chat-messages {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .message {
                max-width: 70%;
                margin-bottom: 0.5rem;
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
                padding: 0.75rem 1rem;
                border-radius: 15px;
                font-size: 0.9375rem;
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
                font-size: 0.75rem;
                color: #6c757d;
                margin-top: 0.25rem;
            }

            .message.incoming .message-time {
                text-align: left;
            }

            .message.outgoing .message-time {
                text-align: right;
            }

            .chat-footer {
                padding: 1rem;
                background-color: white;
                border-top: 1px solid #dee2e6;
                border-radius: 0 0 10px 10px;
            }

            .message-form .input-group {
                background-color: #f8f9fa;
                border-radius: 25px;
                padding: 0.25rem;
            }

            .message-form .form-control {
                border: none;
                padding: 0.75rem 1rem;
                background: transparent;
            }

            .message-form .form-control:focus {
                box-shadow: none;
            }

            .message-form .btn {
                padding: 0.5rem 1.25rem;
                border-radius: 20px;
                margin-left: 0.5rem;
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

            @media (max-width: 768px) {
                body {
                    padding-top: 50px; /* Smaller padding for mobile */
                }
                
                .messages-container {
                    padding: 10px; /* Smaller padding for mobile */
                }
                
                .chat-container {
                    border-radius: 0;
                }

                .chat-area {
                    height: calc(100vh - 360px);
                }
                
                .container.nav-container {
                    padding: 0 20px; /* Reduced side padding for mobile */
                }
            }

            /* Make sure container has proper spacing */
            .container.nav-container {
                padding: 0 40px; /* Match admin pages padding */
                height: auto; /* Remove fixed height */
                display: flex;
                align-items: center;
            }
        </style>
    </head>
    <body>
        <!-- Header Section -->
        <header class="header" ng-controller="HeaderController">
            <div class="container nav-container">
                <div class="logo-container">
                    <a href="/" class="logo">GARMENIQUE</a>
                </div>
                
                <nav class="main-nav" ng-class="{'active': isNavActive}">
                    <ul>
                        <li><a href="/" class="nav-item">HOME</a></li>
                        <li><a href="/catalog" class="nav-item">CATALOG</a></li>
                        <li><a href="/blog" class="nav-item">BLOG</a></li>
                        <li><a href="/about" class="nav-item">ABOUT</a></li>
                        <li><a href="/contact" class="nav-item">CONTACT</a></li>
                    </ul>
                </nav>
                
                <div class="nav-icons">
                    <a href="{{ route('user.messages') }}" class="nav-icon active"><i class="fas fa-envelope"></i></a>
                    @include('partials.account-dropdown')
                    <a href="javascript:void(0)" class="nav-icon" ng-click="openCartPanel()"><i class="fas fa-shopping-cart"></i></a>
                </div>
                
                <button class="mobile-toggle" ng-click="toggleNav()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="messages-container">
            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <div class="chat-container">
                <!-- Chat Header -->
                <div class="chat-header">
                    <div class="admin-info">
                        <div class="admin-avatar">
                            A
                        </div>
                        <div class="admin-details">
                            <h5>Admin</h5>
                            <p>Garmenique Support</p>
                        </div>
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="chat-area">
                    <div class="chat-messages" id="chatMessages">
                        <!-- Messages will be loaded here -->
                    </div>
                </div>

                <!-- Chat Footer -->
                <div class="chat-footer">
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
        </main>

        <!-- Include Sliding Cart Partial -->
        @include('partials.sliding-cart')

        <!-- Footer -->
        @include('partials.footer')

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        <script src="{{ asset('js/landingpage.js') }}"></script>
        <script src="{{ asset('js/cart.js') }}"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const chatMessages = document.getElementById('chatMessages');
                const messageForm = document.getElementById('messageForm');
                const messageInput = document.getElementById('messageInput');

                function loadMessages() {
                    fetch('/messages/admin')
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
                    div.className = `message ${message.is_admin ? 'incoming' : 'outgoing'}`;
                    div.innerHTML = `
                        <div class="message-content">${message.content}</div>
                        <div class="message-time">${message.created_at}</div>
                    `;
                    return div;
                }

                function scrollToBottom() {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }

                // Load initial messages
                loadMessages();

                // Send message handler
                messageForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (!messageInput.value.trim()) return;

                    const formData = new FormData();
                    formData.append('message', messageInput.value);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                    fetch('/messages/send', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(message => {
                        const messageElement = createMessageElement({
                            id: message.id,
                            content: message.content,
                            is_admin: false,
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
                setInterval(loadMessages, 3000);
            });
        </script>
    </body>
</html> 