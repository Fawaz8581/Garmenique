// Register page functionality with AngularJS
var registerApp = angular.module('registerApp', []);

registerApp.controller('RegisterController', ['$scope', '$window', '$timeout', function($scope, $window, $timeout) {
    // Initialize elements
    var loginForm = document.getElementById('Login');
    var registerForm = document.getElementById('Register');
    var indicator = document.getElementById('btn');
    
    // Function to handle login animation and navigation
    $scope.login = function() {
        // Animate the transition
        angular.element(loginForm).css('left', '50px');
        angular.element(registerForm).css('left', '450px');
        angular.element(indicator).css('left', '0px');
        
        // Navigate to login page after animation
        $timeout(function() {
            $window.location.href = '/login';
        }, 600); // Delay for smooth animation
    };
    
    // Function to handle staying on register view
    $scope.register = function() {
        // Already on register, just reset the position
        angular.element(loginForm).css('left', '-400px');
        angular.element(registerForm).css('left', '50px');
        angular.element(indicator).css('left', '110px');
    };
    
    // Initialize the register view
    $scope.initRegisterPage = function() {
        // Set initial positions for register page
        angular.element(loginForm).css('left', '-400px');
        angular.element(registerForm).css('left', '50px');
        angular.element(indicator).css('left', '110px');
    };
    
    // Initialize on page load
    angular.element(document).ready(function() {
        // Force immediate positioning to prevent flashing of content
        if (loginForm && registerForm && indicator) {
            loginForm.style.left = '-400px';
            registerForm.style.left = '50px';
            indicator.style.left = '110px';
        }
        
        $scope.initRegisterPage();
    });
}]);

// Set up initial button state
document.addEventListener('DOMContentLoaded', function() {
    // The button is already positioned for register in CSS
    const btn = document.getElementById('btn');
    if (btn) {
        btn.style.left = "110px";
    }
}); 