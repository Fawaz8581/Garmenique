angular.module('garmeniqueApp')
.controller('MessageAdminController', ['$scope', '$http', function($scope, $http) {
    $scope.messages = {};
    $scope.selectedUserId = null;
    $scope.selectedUserMessages = [];
    $scope.replyMessage = '';

    // Load all messages
    function loadMessages() {
        $http.get('/admin/messages/data').then(function(response) {
            $scope.messages = response.data;
            
            // If there's a selected user, update their messages
            if ($scope.selectedUserId) {
                $scope.showMessages($scope.selectedUserId);
            }
        });
    }

    // Show messages for selected user
    $scope.showMessages = function(userId) {
        $scope.selectedUserId = userId;
        $scope.selectedUserMessages = $scope.messages[userId] || [];
        
        // Mark user as active
        angular.element('.user-item').removeClass('active');
        angular.element(`.user-item[ng-click="showMessages(${userId})"]`).addClass('active');
        
        // Scroll to bottom
        setTimeout(function() {
            const chatMessages = document.getElementById('chatMessages');
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }, 100);
    };

    // Send reply
    $scope.sendReply = function(event) {
        event.preventDefault();
        
        if (!$scope.selectedUserId || !$scope.replyMessage) return;

        const data = {
            user_id: $scope.selectedUserId,
            message: $scope.replyMessage,
            _token: document.querySelector('input[name="_token"]').value
        };

        $http.post('/admin/messages/reply', data).then(function(response) {
            if (response.data.success) {
                // Clear input
                $scope.replyMessage = '';
                
                // Reload messages
                loadMessages();
            }
        });
    };

    // Initialize
    loadMessages();

    // Auto-refresh messages every 30 seconds
    setInterval(loadMessages, 30000);
}]); 