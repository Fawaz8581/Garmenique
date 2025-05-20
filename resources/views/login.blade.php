<!DOCTYPE html>
<html lang="en" ng-app="loginApp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <meta name="keyword" content="Emre Piriştine">
    <meta name="description" content="Emre Piriştine">
    <link rel="stylesheet" href="css/main.css">

    <!-- Tablet -->
    <!-- link rel="stylesheet" media="(max-width:768px)" href="css/tablet.css" -->
    <!-- Mobile -->
    <!-- link rel="stylesheet" media="(max-width:500px)" href="css/mobile.css" -->
    <style>
        .input-group {
            transition: left 0.5s ease;
        }
        #btn {
            transition: left 0.5s ease;
        }
        /* Initial positions for login page */
        #Login {
            left: 50px;
        }
        #Register {
            left: 450px;
        }
        #btn {
            left: 0px;
        }
    </style>
    <!-- Angular JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</head>
<body ng-controller="LoginController">
    <div class="main">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" ng-click="login()">Login</button>
                <button type="button" class="toggle-btn" ng-click="register()">Register</button>
            </div>
            <div class="social-icons">
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_3s913D.json"  background="transparent"  speed="1"    loop  autoplay></lottie-player>
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_OFBfKg.json"  background="transparent"  speed="1"    loop  autoplay></lottie-player>  
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_Joz0FE.json"  background="transparent"  speed="1"    loop  autoplay></lottie-player>
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_0Cm1Y2.json"  background="transparent"  speed="1"    loop  autoplay></lottie-player>
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_YGNGxq.json"  background="transparent"  speed="1"    loop  autoplay></lottie-player>           
            </div>
            <form id="Login" class="input-group">
                <input type="text" class="input-field" placeholder="Enter Username" required>
                <input type="password" class="input-field" placeholder="Enter Password" required>
                <a href="#">Lost Your Password</a>
                <button type="submit" class="submit-btn">Login</button>
            </form>
            <form id="Register" class="input-group">
                <input type="text" class="input-field" placeholder="Enter Username" required>
                <input type="password" class="input-field" placeholder="Enter Password" required>
                <input type="email" class="input-field" placeholder="Enter Email" required>
                <a href="#">By registering, you agree to the Terms, Data Policy and Cookies Policy.</a>
                <button type="submit" class="submit-btn">Register</button>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="/js/login.js"></script>
</body>
</html>