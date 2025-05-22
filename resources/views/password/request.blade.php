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
            height: 380px;
            background: rgba(255, 255, 255, 0.842);
            box-shadow: 0 0 20px 9px #6865641e;
            border-radius: 35px;
            position: relative;
            overflow: hidden;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
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
            margin-top: 20px;
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
    </style>
</head>
<body>
    <div class="main">
        <div class="form-box">
            <h2>Reset Password</h2>
            <p>Enter your email address and we'll send you a link to reset your password.</p>
            
            <form method="POST" action="#">
                @csrf
                <input type="email" name="email" class="input-field" placeholder="Email Address" required>
                <button type="submit" class="submit-btn">Send Password Reset Link</button>
            </form>
            
            <div class="back-link">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html> 