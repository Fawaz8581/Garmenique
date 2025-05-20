<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garmenique - Admin Login</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Admin Login">
    <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="main">
        <div class="form-box">
            <div class="logo-section">
                <img src="{{ asset('images/icons/GarmeniqueLogo.png') }}" alt="Garmenique Logo" class="login-logo">
                <h1 class="login-title">Admin Login</h1>
            </div>
            
            <!-- Login Form -->
            <form class="input-group" method="POST" action="{{ route('admin.login') }}">
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
                
                <button type="submit" class="submit-btn">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>