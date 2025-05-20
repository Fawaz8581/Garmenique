// Login page functionality with AngularJS
var loginApp = angular.module('loginApp', []);

loginApp.controller('LoginController', ['$scope', '$window', '$timeout', function($scope, $window, $timeout) {
    // Initialize elements
    var loginForm = document.getElementById('Login');
    var registerForm = document.getElementById('Register');
    var indicator = document.getElementById('btn');
    
    // Function to handle staying on login view
    $scope.login = function() {
        // Already on login, do nothing
    };
    
    // Function to handle register animation and navigation
    $scope.register = function() {
        // Animate the transition
        angular.element(loginForm).css('left', '-400px');
        angular.element(registerForm).css('left', '50px');
        angular.element(indicator).css('left', '110px');
        
        // Navigate to register page after animation
        $timeout(function() {
            $window.location.href = '/register';
        }, 600);
    };
    
    // Initialize the login view
    $scope.initLoginPage = function() {
        // Set initial positions for login page
        angular.element(loginForm).css('left', '50px');
        angular.element(registerForm).css('left', '450px');
        angular.element(indicator).css('left', '0px');
    };
    
    // Initialize on page load
    angular.element(document).ready(function() {
        $scope.initLoginPage();
    });
}]); 