<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garmenique - Reset Password</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique Password Reset Page">
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .main{
            width: 100%;
            height: 100%;
            background-image: url('/LoginPage/images/people.jpg');
            position: absolute;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-box{
            width: 380px;
            height: 420px;
            background: rgba(255, 255, 255, 0.842);
            box-shadow: 0 0 20px 9px #6865641e;
            border-radius: 35px;
            position: relative;
            overflow: hidden;
            padding: 20px;
        }
        .social-icons{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .social-icons lottie-player{
            width: 40px;
            margin: 0px 12px;
            cursor: pointer;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 22px;
            font-weight: 600;
        }
        .input-field{
            width: 100%;
            padding: 10px 0px;
            border: none;
            margin: 15px 0;
            background: transparent;
            border-bottom: 1px solid grey;
            outline: none;
        }
        .submit-btn{
            display: block;
            width: 85%;
            padding: 10px;
            border: none;
            background: linear-gradient(to right, #1c1c2e, #087fce);
            border-radius: 35px;
            cursor: pointer;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            margin: 30px auto;
            outline: none;
        }
        p {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #777;
        }
        a {
            display: inline-block;
            text-decoration: none;
            color: #777;
            font-size: 12px;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            display: inline-block;
            text-decoration: none;
            color: #777;
            margin: 15px 0;
            font-size: 12px;
        }
        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="form-box">
            <h2>Reset Password</h2>
            <p>Set your new password below</p>
            
            <div class="social-icons">
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_3s913D.json"  background="transparent"  speed="1"    loop  autoplay></lottie-player>
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_OFBfKg.json"  background="transparent"  speed="1"    loop  autoplay></lottie-player>  
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_Joz0FE.json"  background="transparent"  speed="1"    loop  autoplay></lottie-player>
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_0Cm1Y2.json"  background="transparent"  speed="1"    loop  autoplay></lottie-player>
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_YGNGxq.json"  background="transparent"  speed="1"    loop  autoplay></lottie-player>           
            </div>
            
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <input type="password" name="password" class="input-field" placeholder="New Password" required>
                <input type="password" name="password_confirmation" class="input-field" placeholder="Confirm Password" required>
                <button type="submit" class="submit-btn">Reset Password</button>
            </form>
            
            <div class="back-link">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>
</html> 