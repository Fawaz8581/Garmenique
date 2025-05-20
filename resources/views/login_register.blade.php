<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garmenique - {{ Request::is('register') ? 'Register' : 'Login' }}</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Premium Clothing Brand">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/login_register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing.page.search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sliding-cart.css') }}">

    <!-- Tablet -->
    <!-- link rel="stylesheet" media="(max-width:768px)" href="css/tablet.css" -->
    <!-- Mobile -->
    <!-- link rel="stylesheet" media="(max-width:500px)" href="css/mobile.css" -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        .main {
            width: 100%;
            height: 100vh;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-box {
            width: 380px;
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }
        .button-box {
            width: 220px;
            margin: 0 auto 25px;
            position: relative;
            display: flex;
            background: #f1f1f1;
            border-radius: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        .toggle-btn {
            padding: 10px 0;
            flex: 1;
            cursor: pointer;
            border: none;
            outline: none;
            background: transparent;
            font-weight: 600;
            font-size: 14px;
            position: relative;
            z-index: 1;
            transition: color 0.4s;
            text-decoration: none;
            color: #555;
            text-align: center;
        }
        #btn {
            position: absolute;
            top: 0;
            left: {{ Request::is('register') ? '110px' : '0' }};
            width: 110px;
            height: 100%;
            background: #3b82f6;
            border-radius: 30px;
            transition: 0.5s;
        }
        .toggle-btn.active {
            color: white;
        }
        .social-icons {
            display: flex;
            justify-content: center;
            margin: 25px 0;
        }
        .social-icon {
            height: 40px;
            width: 40px;
            margin: 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #333;
            font-size: 18px;
            transition: all 0.3s;
        }
        .social-icon:hover {
            color: #3b82f6;
        }
        .input-group {
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
        }
        .input-field {
            width: 100%;
            padding: 10px 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            font-size: 14px;
        }
        .input-field:focus {
            border-color: #3b82f6;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            margin: 15px 0;
        }
        .checkbox-group input {
            margin-right: 8px;
        }
        .checkbox-label {
            font-size: 14px;
            color: #666;
        }
        .forgotten-link {
            display: block;
            text-align: left;
            color: #666;
            font-size: 14px;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .forgotten-link:hover {
            color: #3b82f6;
        }
        .terms-text {
            font-size: 14px;
            color: #666;
            margin: 15px 0 20px;
            line-height: 1.5;
        }
        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s;
            margin-top: 15px;
        }
        .submit-btn:hover {
            background: #2563eb;
        }
        .text-danger {
            color: #dc3545;
            font-size: 12px;
            display: block;
            margin: 3px 0 5px;
        }
        @media (max-width: 480px) {
            .form-box {
                width: 90%;
                padding: 20px;
            }
            .input-group {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <a href="{{ route('login') }}" class="toggle-btn {{ !Request::is('register') ? 'active' : '' }}">Login</a>
                <a href="{{ route('register') }}" class="toggle-btn {{ Request::is('register') ? 'active' : '' }}">Register</a>
            </div>
            
            <!-- Social Icons -->
            <div class="social-icons">
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
            </div>
            
            @if(Request::is('register'))
            <!-- Register Form -->
            <form class="input-group" method="POST" action="{{ route('register') }}">
                @csrf
                <input type="text" name="name" class="input-field" placeholder="Enter Username" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                
                <input type="email" name="email" class="input-field" placeholder="Enter Email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                
                <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                
                <input type="password" name="password_confirmation" class="input-field" placeholder="Confirm Password" required>
                
                
                <button type="submit" class="submit-btn">Register</button>
            </form>
            @else
            <!-- Login Form -->
            <form class="input-group" method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" class="input-field" placeholder="Enter Email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                
                <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                
                <div class="checkbox-group">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" class="checkbox-label">Remember Me</label>
                </div>
                
                <a href="#" class="forgotten-link">Lost Your Password</a>
                
                <button type="submit" class="submit-btn">Sign In</button>
            </form>
            @endif
        </div>
    </div>
</body>
</html>