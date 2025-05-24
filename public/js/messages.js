// Messages page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    const mainNav = document.querySelector('.main-nav');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            this.classList.toggle('active');
        });
    }

    // Chat list functionality
    const chatItems = document.querySelectorAll('.chat-item');
    chatItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all items
            chatItems.forEach(chat => chat.classList.remove('active'));
            // Add active class to clicked item
            this.classList.add('active');
            
            // Get user ID from data attribute
            const userId = this.getAttribute('data-user-id');
            
            // Here you would typically load the chat messages for this user
            // For now, we'll just update the empty state
            const emptyState = document.querySelector('.empty-state');
            if (emptyState) {
                emptyState.style.display = 'none';
            }
            
            // Load chat messages for selected conversation
            loadChatMessages(userId);
        });
    });
});

function loadChatMessages(userId) {
    // Remove empty state if present
    const emptyState = document.querySelector('.empty-state');
    if (emptyState) {
        emptyState.style.display = 'none';
    }

    // Here you would typically make an AJAX call to load messages
    // For now we'll just show a loading state
    const chatContent = document.querySelector('.col-md-8');
    chatContent.innerHTML = '<div class="d-flex justify-content-center align-items-center h-100"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';

    // Simulate API call
    setTimeout(() => {
        // Replace with actual API call
        fetchMessages(userId);
    }, 500);
}

function fetchMessages(userId) {
    // Replace this with actual API endpoint
    fetch(`/api/messages/${userId}`)
        .then(response => response.json())
        .then(data => {
            displayMessages(data);
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
            // Show error state
            displayError();
        });
}

function displayMessages(messages) {
    const chatContent = document.querySelector('.col-md-8');
    // Implementation for displaying messages
    // This would be replaced with actual message display logic
}

function displayError() {
    const chatContent = document.querySelector('.col-md-8');
    chatContent.innerHTML = `
        <div class="error-state d-flex flex-column align-items-center justify-content-center h-100">
            <i class="fas fa-exclamation-circle text-danger mb-3" style="font-size: 3rem;"></i>
            <h4>Oops! Something went wrong</h4>
            <p class="text-muted">Unable to load messages. Please try again later.</p>
        </div>
    `;
}

// Sliding cart functionality
const cartPanel = document.querySelector('.sliding-cart');
const cartOverlay = document.querySelector('.cart-overlay');

function openCartPanel() {
    if (cartPanel && cartOverlay) {
        cartPanel.classList.add('active');
        cartOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeCartPanel() {
    if (cartPanel && cartOverlay) {
        cartPanel.classList.remove('active');
        cartOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Event listeners for cart
document.addEventListener('DOMContentLoaded', function() {
    const openCartBtn = document.querySelector('[ng-click="openCartPanel()"]');
    const closeCartBtn = document.querySelector('.close-cart');
    
    if (openCartBtn) {
        openCartBtn.addEventListener('click', openCartPanel);
    }
    
    if (closeCartBtn) {
        closeCartBtn.addEventListener('click', closeCartPanel);
    }
    
    if (cartOverlay) {
        cartOverlay.addEventListener('click', closeCartPanel);
    }
}); 