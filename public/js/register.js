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
        }, 600);
    };
    
    // Function to handle staying on register view
    $scope.register = function() {
        // Already on register, do nothing
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
        $scope.initRegisterPage();
    });
}]); 