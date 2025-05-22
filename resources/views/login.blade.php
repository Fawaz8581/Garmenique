<!DOCTYPE html>
<html lang="en" ng-app="loginApp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garmenique - Login</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique Login Page">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        /* Ensure correct initial positioning */
        #Login { left: 50px; }
        #Register { left: 450px; }
    </style>
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
            <form id="Login" class="input-group" action="{{ route('login') }}" method="POST">
                @csrf
                <input type="text" name="username" class="input-field" placeholder="Enter Email or Username" required>
                <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
                @if($errors->any())
                    <div style="color: red; font-size: 12px; margin-top: 5px;">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <a href="{{ route('password.request') }}">Lost Your Password? Click Here!</a>
                <button type="submit" class="submit-btn">Login</button>
            </form>
            <form id="Register" class="input-group" action="{{ route('register') }}" method="POST">
                @csrf
                <input type="text" name="username" class="input-field" placeholder="Enter Username" required>
                <input type="email" name="email" class="input-field" placeholder="Enter Email" required>
                <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
                <a href="#">By registering, you agree to the Terms, Data Policy and Cookies Policy.</a>
                <button type="submit" class="submit-btn">Register</button>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="{{ asset('js/login.js') }}"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>
</html> 